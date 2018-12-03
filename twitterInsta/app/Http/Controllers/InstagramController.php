<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \InstagramScraper\Instagram;
use Illuminate\Support\Facades\Storage;
use Image;

class InstagramController extends Controller
{
    public function topMedia()
    {
		if (Storage::exists('instagramMedia.json') && date('Y-m-d H:i:s', strtotime(Storage::get('instagramMediaGenerateTime.txt'))) > date('Y-m-d H:i:s')) {
			return json_decode(Storage::get('instagramMedia.json'), true);
		}else{
			return $this->instagramTopMedia();
		}
    }

    public function starIndivisual($shortCode)
    {
    	$instagram = new Instagram();
    	return $instagram->getMediaByCode($shortCode);
    }

    public function mediaByUsername($username, $count)
    {
    	$instagram = new Instagram();
    	return $instagram->getMedias($username, $count);
    }

    public function mediaPaginator($tag, $maxId)
    {
    	$data = array();
		$instagram = new Instagram();
		if ($maxId != '') {
			$medias = $instagram->getPaginateMediasByTag($tag, $maxId);
		}else{
			$medias = $instagram->getPaginateMediasByTag($tag);
		}
		foreach ($medias['medias'] as $key => $media) {
			$medias['medias'][$key] = array( 'id'=>$media->getId(), 'createdAt'=>$media->getCreatedTime(), 'caption'=>$media->getCaption(), 'noOfComments'=>$media->getCommentsCount(), 'noOfLikes'=>$media->getLikesCount(), 'image'=>$media->getImageHighResolutionUrl(), 'thumbnail'=>$media->getImageThumbnailUrl(), 'mediaType'=>$media->getType(), 'shortCode'=>$media->getShortCode() );
		}

		return $medias;
    }

    private function instagramTopMedia()
    {
    	$data = array();
		$instagram = new Instagram();
		$medias['fashion'] = $instagram->getCurrentTopMediasByTagName('fashion');
		$medias['color'] = $instagram->getCurrentTopMediasByTagName('color');
		$medias['art'] = $instagram->getCurrentTopMediasByTagName('art');
		$medias['mark'] = $instagram->getCurrentTopMediasByTagName('mark');
		
		foreach ($medias as $key => $value) {
			foreach ($value as $key => $media) {
				$data[] = array( 'id'=>$media->getId(), 'createdAt'=>$media->getCreatedTime(), 'caption'=>$media->getCaption(), 'noOfComments'=>$media->getCommentsCount(), 'noOfLikes'=>$media->getLikesCount(), 'image'=>$media->getImageHighResolutionUrl(), 'thumbnail'=>$media->getImageThumbnailUrl(), 'mediaType'=>$media->getType(), 'shortCode'=>$media->getShortCode() );
			}
		}

		Storage::put('instagramMedia.json', json_encode($data));
		Storage::put('instagramMediaGenerateTime.txt', date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s').'+55 Minutes')));

		return $data;
    }
}
