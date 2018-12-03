<!DOCTYPE html>
<html lang="en">
  <head>
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
    @yield('style')
  </head>
  <body>
    <nav class="navbar navbar-expand-md">
      <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">
          <img src="{{ asset('images/logo.png') }}" alt="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
          <ul class="navbar-nav ml-auto">
            <form class="form-inline" action="/action_page.php">
              <div class="input-group">
                <input type="text" class="form-control">
                <div class="input-group-append">
                  <button class="btn btn-dark" type="submit"><i class="fas fa-search"></i> Search</button>
                </div>
              </div>
            </form>
            <li class="nav-item">
              <a class="nav-link" href="#"><img src="{{ asset('images/redo.svg') }}" alt=""> </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!--  Navigation End   -->

    <!--  Breadcrumb Start   -->
      <section class="container-fluid breadcrumb_wrapper">
     <ul dir="rtl" class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">ログイン</a></li>
        @yield('breadcrumb')
     </ul>
   </section>

    <!--  Breadcrumb End   -->

    @yield('content')

    <footer>
     <ul>
       <li><a href="#">ご利用にあたって</a></li>
       <li><a href="#">お問い合わせ </a></li>
       <li><a href="#">会社概要</a></li>
       <li><a href="#">よくある質問</a></li>
       <li><a href="#">特定商取引法に基づく表記 </a></li>
       <li><a href="#">プライバシーポリシー</a></li>
     </ul>
     <div class="website-brand">
        <a href="{{ route('home') }}">
          <img src="{{ asset('images/footer_logo.png') }}" alt="">
        </a>
      </div>
    </footer>

    <!-- Grid Enter -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    @yield('script')
  </body>
</html>
