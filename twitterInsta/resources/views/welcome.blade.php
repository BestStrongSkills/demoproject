@extends('layout.app')

@section('title', 'Home')

@section('content')
    <!--  Gallary Slider Start   -->
    <section class="gallary">
      <div class="container-fluid">
        <div id="big" class="owl-carousel owl-theme">
          @foreach($instagramMedia as $key => $value)
            <div class="item">
              <img src="{{ $value['thumbnail'] }}" alt="">
            </div>
          @endforeach
        </div>
        <div id="thumbs" class="owl-carousel owl-theme">
          @foreach($instagramMedia as $key => $value)
            <div class="item">
              <img src="{{ $value['thumbnail'] }}" alt="">
            </div>
          @endforeach
        </div>
      </div>
    </section>
    <!--  Gallary Slider End   -->


    <!-- Grid Start -->
    <section class="cards">
      <div class="container-fluid">
        <div class="masonry" id="mediaPostList">
          @foreach($instagramMedia as $key => $value)
            <div class="item">
              <a href="{{ route('starIndivisual', $value['shortCode']) }}">
                <img src="{{ $value['thumbnail'] }}" class="img-fluid" alt="grid_1">
                <div class="item-content">
                  <p>{{ $value['caption'] }}</p>
                  <time>{{ date('Y.m.d', $value['createdAt']) }}</time>
                  <span class="badge">New</span>
                </div>
              </a>
            </div>
          @endforeach
        </div>
        <div class="actions">
          <a href="#none" class="button" id="moreMedia">
            <img src="{{ asset('images/btn.png') }}" alt="_btn">
            <img src="{{ asset('images/loader.gif') }}" alt="_btn" style="display: none;">
          </a>
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
    <script type="text/javascript">
        var taglist = ['fashion', 'art', 'color', 'mark'];
        var tagListnext = ['', '', '', ''];
        var count = 0;
        $(document).ready(function() {

          $('#moreMedia').click(function () {
            if(taglist[count] == undefined){
              count = 0;
            }
            $('#moreMedia img:nth-child(1)').hide();
            $('#moreMedia img:nth-child(2)').show();
            $.get('{{ route('mediaPaginator') }}'+'?tag='+taglist[count]+'&next='+tagListnext[count], function (data) {
              $('#mediaPostList').append(data.html);
              tagListnext[count] = data.maxId;
              count++;
              $('#moreMedia img:nth-child(2)').hide();
              $('#moreMedia img:nth-child(1)').show();
            });
          });


          var bigimage = $("#big");
          var thumbs = $("#thumbs");
          //var totalslides = 10;
          var syncedSecondary = true;

          bigimage.children().each( function( index ) 
          {
            $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
          });
          thumbs.children().each( function( index ) 
          {
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
