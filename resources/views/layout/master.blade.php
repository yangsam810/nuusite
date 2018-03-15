<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>場地租借系統</title>
        <meta name="description" content="GARO is a real-estate template">
        <meta name="author" content="Kimarotec">
        <meta name="keyword" content="html5, css, bootstrap, property, real-estate theme , bootstrap template">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>

        <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon-16x16.png">

        <link rel="stylesheet" href="/assets/css/normalize.css">
        <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="/assets/css/fontello.css">
        <link href="/assets/fonts/icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet">
        <link href="/assets/fonts/icon-7-stroke/css/helper.css" rel="stylesheet">
        <link href="/assets/css/animate.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="/assets/css/bootstrap-select.min.css"> 
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/icheck.min_all.css">
        <link rel="stylesheet" href="/assets/css/price-range.css">
        <link rel="stylesheet" href="/assets/css/owl.carousel.css">  
        <link rel="stylesheet" href="/assets/css/owl.theme.css">
        <link rel="stylesheet" href="/assets/css/owl.transitions.css">
        <link rel="stylesheet" href="/assets/css/style.css">
        <link rel="stylesheet" href="/assets/css/responsive.css">

    </head>
    <body style="background-color: #FCFCFC;">

        <div id="preloader">
            <div id="status">&nbsp;</div>
        </div>
        <!-- Body content -->

        <nav class="navbar navbar-default ">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="/site"><img src="/assets/img/nuu.jpg" height="55px"></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse yamm" id="navigation">
                    <ul class="main-nav nav navbar-nav navbar-right">
						
						<li class="wow fadeInDown" data-wow-delay="0.1s"><a class="" href="/site/{{ $unit }}/rule">場地說明</a></li>
						<li class="dropdown ymm-sw" data-wow-delay="0.1s">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="200">場地查詢 <b class="caret"></b></a>
							<ul class="dropdown-menu navbar-nav">
								<li>
									<a href="/site/{{ $unit }}/1/search">二坪校區</a>
								</li>
								<li>
									<a href="/site/{{ $unit }}/2/search">八甲校區</a>
								</li>
							</ul>
						</li>
						@if(session()->has('userLogin'))
							<li class="dropdown ymm-sw" data-wow-delay="0.1s">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="200">場地借用 <b class="caret"></b></a>
								<ul class="dropdown-menu navbar-nav">
									<li>
										<a href="/site/{{ $unit }}/state">借用情況</a>
									</li>
									<li>
										<a href="/site/{{ $unit }}/apply">場地申請</a>
									</li>
									<li>
										<a href="/site/{{ $unit }}/history">歷史紀錄</a>
									</li>
								</ul>
							</li>
						@endif
						
						@if(session()->has('adminLogin') && session()->get('adminUnit') == $unit)
							<li class="dropdown ymm-sw" data-wow-delay="0.1s">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="200">場地管理 <b class="caret"></b></a>
								<ul class="dropdown-menu navbar-nav">
									<li>
										<a href="/site/{{ $unit }}/check">場地審核</a>
									</li>
									<li>
										<a href="/site/{{ $unit }}/allhistory">所有紀錄</a>
									</li>
								</ul>
							</li>
						@endif
						
						@if(session()->has('adminLogin') || session()->has('userLogin'))
							<li class="wow fadeInDown" data-wow-delay="0.1s"><a class="" href="/site/{{ $unit }}/user/logout">登出</a></li>
						@else
							<li class="wow fadeInDown" data-wow-delay="0.1s"><a class="" href="/site/{{ $unit }}/login">登入</a></li>
						@endif
						
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <!-- End of nav bar -->
                <!-- property area -->
        <div class="content-area submit-property">&nbsp;
            <div class="container">
				<div class="row">
				
                    @yield('content')
					
                </div>
            </div>
        </div>

		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        
		<script src="/assets/js/modernizr-2.6.2.min.js"></script>

        <script src="/assets/js/jquery-1.10.2.min.js"></script> 
        <script src="/bootstrap/js/bootstrap.min.js"></script>
        <script src="/assets/js/bootstrap-select.min.js"></script>
        <script src="/assets/js/bootstrap-hover-dropdown.js"></script>

        <script src="/assets/js/easypiechart.min.js"></script>
        <script src="/assets/js/jquery.easypiechart.min.js"></script>

        <script src="/assets/js/owl.carousel.min.js"></script>
        <script src="/assets/js/wow.js"></script>

        <script src="/assets/js/icheck.min.js"></script>
        <script src="/assets/js/price-range.js"></script>

        <script src="/assets/js/main.js"></script>

    </body>
	
</html>