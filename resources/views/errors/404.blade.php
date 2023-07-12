<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@lang('webtags.company_name') | @lang('Under Construction...')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    {{-- Bootstrap CSS--}}
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/cm_tufanofullmoda_css.css" rel="stylesheet">
    {{-- Google fonts - Roboto for copy, Montserrat for headings--}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    {{-- theme stylesheet--}}
    <link rel="stylesheet" href="css/under-constr/style.default.css" id="theme-stylesheet">
    {{-- Custom stylesheet - for your changes--}}
    <link rel="stylesheet" href="css/under-constr/custom.css">
    {{-- Favicon--}}
    <link rel="icon" type="image/png" href="img/tufanofullmoda_logo_mini.png"/>
    {{-- Tweaks for older IEs--}}{{--[if lt IE 9]--}}
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]--}}
  </head>
  <body>
    <div class="container-fluid">
      <div class="row min-vh-100">
        <div class="col-xl-5 col-lg-6 col-md-8 p-5 p-lg-4 mx-auto d-flex align-items-center">
          <div>
            <p> <img src="img/tufanofullmoda_login_logo.png" width="190" height="190" alt="Template Logo"></p>
            <h1 class="text-uppercase">@lang('Under Construction...')</h1>
            <p class="lead">@lang('We are working hard to bring to you the best of this section.')</p>
            <p>@lang('Don’t despair, it will take less time than you expect, it’s just a matter of more coffee turned into a website.')</p>
            {{-- <p class="social"><a href="#" class="external facebook"><i class="fab fa-facebook-f"></i></a><a href="#" class="external youtube"><i class="fab fa-youtube"></i></a><a href="#" class="external twitter"><i class="fab fa-twitter"></i></a><a href="#" title="" class="external instagram"><i class="fab fa-instagram"></i></a><a href="#" class="email"><i class="fa fa-envelope"> </i></a></p> --}}
            <a href="javascript:history.back()" class="btn btn-primary dropdown"><i class="fas fa-arrow-circle-left fa-sm"></i> @lang('Go Back')</a>
            {{-- Footer --}}
            <footer class="credit">
                <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>@lang('All rights reserved.') &copy; @lang('webtags.company_name') 2022 | 
                    @lang('Web Site Developed By:') <a href="https://caelumdev.com" class="cm-a-clr" target="_blank"> @lang('webtags.caelumdev')</a></span>
                </div>
                </div>
            </footer>
            {{-- End of Footer --}}
          </div>
        </div>
        <div style="background-image: url('img/under-constr/pexels-photo-40120.jpg');" class="col-xl-6 col-lg-5 col-md-4 intro-right"></div>
      </div>
    </div>
    {{-- JavaScript files--}}
    <script src="vendor/under-constr/jquery/jquery.min.js"></script>
    <script src="vendor/under-constr/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/under-constr/front.js"></script>
    {{-- FontAwesome CSS - loading as last, so it doesn't block rendering--}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  </body>
</html>