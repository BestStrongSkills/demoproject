<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\InstagramController;

class HomeController extends Controller
{
    public function index()
    {
    	$media = new InstagramController;
    	$data = $media->topMedia();
    	return view('welcome', ['instagramMedia' => $data]);
    }

    public function starIndivisual($shortCode)
    {
    	$instagram = new InstagramController();
    	$mediaDetail = $instagram->starIndivisual($shortCode);
    	$userAccountDetail = $mediaDetail->getOwner();
    	$userMedia = $instagram->mediaByUsername($userAccountDetail->getUsername(), 3);
    	$userMediaAll = $instagram->mediaByUsername($userAccountDetail->getUsername(), 50);
		return view('starIndivisual', ['instagramMedia' => $mediaDetail, 'instagramMediaAccountInfo' => $userAccountDetail, 'userMedia' => $userMedia, 'userMediaAll' => $userMediaAll]);	
    }

    public function mediaPaginator(Request $request)
    {
		$media = new InstagramController;
		$data = $media->mediaPaginator($request->input('tag'), $request->input('next'));
    	return response()->json( ['html' => view('mediaPostList', ['instagramMedia' => $data['medias']])->render(), 'hasNextPage' => $data['hasNextPage'], 'maxId' => $data['maxId']]);
    }
}
