@extends('layout.app')

@section('title', 'Home')

@section('content')
  <section class="stars">
    <div class="container-fluid">
      <div class="grid">
        <div class="grid-sizer"></div>
        <div class="grid-item span-columns">
          <div class="pod open-pod p-3">
            <div class="row star-detailz">
              <div class="col-lg-9">
                <img class="person-icon" src="{{ $instagramMediaAccountInfo->getProfilePicUrl() }}" alt="_person">
                <p><strong>{{ $instagramMediaAccountInfo->getFullName() }}</strong> <small> @instagram {{ $instagramMediaAccountInfo->getUsername() }} </small></p>
              </div>
              <div class="col-lg-3" style="padding:0px;">
                <button type="button" class="btn btn-outline-secondary megaphone"><i class="fas fa-bullhorn"></i></button>
                <button type="button" class="btn btn-outline-secondary"><img src="{{ asset('/images/user.svg') }}" alt="user"> フォロー</button>
                <button type="button" class="btn btn-outline-secondary gift"><i class="fas fa-gift"></i> プレゼントする</button>
              </div>
            </div>
            <div class="row descript">
              <div class="col-lg-6">
                <img src="{{ $instagramMedia->getImageThumbnailUrl() }}">
                <p>{{ $instagramMedia->getCaption() }}</p>
              </div>
              <div class="col-lg-6">
                <div class="row">
                  @foreach($userMedia as $key => $value)
                    <div class="col-6 {{ ($loop->last)? 'offset-md-6 offset-sm-3 mt-2 mb-5' : '' }}">
                      <a href="{{ route('starIndivisual', $value->getShortCode()) }}">
                        <div class="pod inner-pod">
                          <img src="{{ $value->getImageThumbnailUrl() }}" class="img-fluid" alt="grid_1">
                          <div class="person-content">
                            <div class="upper">
                              <img src="{{ $instagramMediaAccountInfo->getProfilePicUrl() }}" alt="">
                              <p>{{ $instagramMediaAccountInfo->getFullName() }}<br> <small>@instagram {{ $instagramMediaAccountInfo->getUsername() }}</small> </p>
                            </div>
                            <div class="middle">
                              <p>{{ substr(strip_tags($value->getCaption()), 0, 50) }} </p>
                            </div>
                            <div class="lower">
                              <p> <i class="fas fa-comment"></i> {{ $value->getCommentsCount() }} </p>
                            </div>
                          </div>
                        </div>
                      </a>
                    </div>
                  @endforeach
                </div>
              </div>
              <div class="social-btns ml-auto">
                <ul>
                  <li><button class="btn btn-default twt_btn"> <i class="fab fa-twitter"></i>Twitter </button></li>
                  <li><a href="javascript:void(0)"><img class="insta_btn" src="{{ asset('images/insta_btn.png') }}" alt=""> </a></li>
                  <li><button class="btn btn-default fb_btn"> <i class="fab fa-facebook-f"></i> Facebook</button></li>
                  <li><a href="javascript:void(0)"><img class="brand_img" src="{{ asset('images/footer_logo.png') }}" alt=""> </a></li>
                  <li><a href="javascript:void(0)"><img class="pink-btn" src="{{ asset('images/pink_btn.png') }}" alt=""></a> </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        @foreach($userMediaAll as $key => $value)
          <div class="grid-item">
            <a href="{{ route('starIndivisual', $value->getShortCode()) }}">
              <div class="pod">
                <img src="{{ $value->getImageThumbnailUrl() }}" class="img-fluid" alt="grid_1">
                <div class="item-content">
                  <p>{{ $value->getCaption() }}</p>
                  <time>{{ date('Y.m.d', $value->getCreatedTime()) }}</time>
                  <span class="badge">New</span>
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    </div>
  </section>
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
@endsection

@section('script')
    <script src="{{ asset('js/owl.js') }}"></script>
    <script src="{{ asset('js/masonry.min.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function() {
           $('.grid').masonry({
        itemSelector: '.grid-item',
        columnWidth: '.grid-sizer',
        percentPosition: true
        });

          var bigimage = $("#big");
          var thumbs = $("#thumbs");
          //var totalslides = 10;
          var syncedSecondary = true;

          bigimage.children().each( function( index ) {
            $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
          });
          thumbs.children().each( function( index ) {
            $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
          });

          bigimage.owlCarousel({
            items: 3,
            center:true,
            slideSpeed: 2000,
            nav: false,
            autoplay: true,
            autoplayHoverPause: true,
            dots: false,
            touchDrag  : false,
            mouseDrag  : false,
            loop: true,
            responsiveRefreshRate: 200,
            navText: [
              '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
              '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
            ]
          })
            .on("changed.owl.carousel", syncPosition);

          thumbs.on("initialized.owl.carousel", function() {
            thumbs.find(".owl-item")
              .eq(0)
              .addClass("current");
          })
          .owlCarousel({
            items: 18,
            dots: false,
            nav: false,
            touchDrag  : false,
            mouseDrag  : false,
            navText: [
              '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
              '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
            ],
            smartSpeed: 200,
            slideSpeed: 500,
            slideBy: 1,
            responsiveRefreshRate: 100
          }) .on("changed.owl.carousel", syncPosition2);

          function syncPosition(el) {
            //if loop is set to false, then you have to uncomment the next line
            //var current = el.item.index;

            //to disable loop, comment this block
            var count = el.item.count - 1;
            var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

            if (current < 0) {
              current = count;
            }
            if (current > count) {
              current = 0;
            }
            //to this
            thumbs.find(".owl-item")
              .removeClass("current")
              .eq(current)
              .addClass("current");
            var onscreen = thumbs.find(".owl-item.active").length - 1;
            var start = thumbs
            .find(".owl-item.active")
            .first()
            .index();
            var end = thumbs
            .find(".owl-item.active")
            .last()
            .index();

            if (current > end) {
              thumbs.data("owl.carousel").to(current, 100, true);
            }
            if (current < start) {
              thumbs.data("owl.carousel").to(current - onscreen, 100, true);
            }
          }

          function syncPosition2(el) {
            if (syncedSecondary) {
              var number = el.item.index;
              bigimage.data("owl.carousel").to(number, 100, true);
            }
          }

          thumbs.on("click", ".owl-item", function(e) {
            e.preventDefault();
            var number = $(this).index();
            bigimage.data("owl.carousel").to(number, 300, true);
          });

          $(document).on('click', '.owl-item>div', function() {
            bigimage.trigger('to.owl.carousel', $(this).data( 'position' ) );
          });
          $(document).on('click', '.current>div', function() {
            thumbs.trigger('to.owl.carousel', $(this).data( 'position' ) );
          });

        });
  </script>
@endsection
