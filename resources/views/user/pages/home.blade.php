<!doctype html>
<html lang="en">


<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Title Of Site -->
	<title>{{env('APP_NAME')}}</title>
	<meta name="description" content="OrderAm is a food ordering platform which brings restaurants and food lovers together. Food ordering online is easier than any other platforms.">
	<meta name="keywords" content="food, order online, restaurant, reservation, book a table, foodies, cafe, recipes, menu, dishes, chefs and cooking experts ">
	<meta name="author" content="Korrectconnect">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link href="{{ asset('css/u/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/u/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/u/component.css') }}" rel="stylesheet">
    <link href="{{ asset('css/u/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/u/custom.css') }}" rel="stylesheet">

    <script src="{{ asset('jquery/dist/jquery-2.2.2.min.js') }}"></script>
    <link href="{{ asset('css/pace.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.css') }}">

</head>


<body class="home">

	<div id="introLoader" class="introLoading"></div>

	<!-- start Container Wrapper -->
	<div class="container-wrapper">

		<!-- start Header -->
		@include('user.inc.header')
		<!-- end Header -->

		<!-- start Main Wrapper -->
		<div class="main-wrapper" style="margin-top: 0px !important;">

			<!-- start hero-header -->
			<div class="hero" style="background-image:url({{asset('images/bander2.png')}}); background-size:cover;">
				<div class="container">

					<h1>tickle your tastebuds</h1>
					<p>Find amazing selection of local restaurant delivering food to your door</p>

					<div class="main-search-form-wrapper">

						<form>

							<div class="form-holder">
								<div class="row gap-0">

									<div class="col-xss-6 col-xs-6 col-sm-6">
										<input class="form-control" placeholder="e.g. SW6 6LG / SW6 / London" />
									</div>

									<div class="col-xss-6 col-xs-6 col-sm-6">
										<input class="form-control" placeholder="Find a restaurant" />
									</div>

								</div>

							</div>

							<div class="btn-holder">
								<button class="btn"><i class="ion-android-search"></i></button>
							</div>

						</form>

					</div>


				</div>

			</div>
			<!-- end hero-header -->

			<div class="post-hero">

				<div class="container">

					<div class="row">

						<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

							<div class="ticker-wrapper">

								<div class="latest-job-ticker ticker-inner">


									<ul class="ticker-list">
										<li>
											<a href="#">
												<span class="labeling">Get Offer</span>
												View amazing offers - <span class="font-italic">shop from amazing stores near you</span>
											</a>
										</li>

									</ul>
								</div>
							</div>


						</div>

					</div>

				</div>

			</div>

			<!-- start order process -->
			<div class="order-process-step bg-light pt-80 pb-80">
				<div class="container frontend">

					<div class="clearfix"></div>

					<!--Facts-->

					<!--Process Block-->

					<div class="block process-block">
						<!--<h2>The process</h2>
                            <h5>4 Steps for Success</h5>-->

						<div class="text-center">
                            <!-- style="width:100% !important;" -->
							<ol class="row process" >
								<li class="col-md-3 col-sm-6 col-xs-6"><i class="fa fa-building" aria-hidden="true"></i>
									<h4>Pick a restaurant</h4>

								</li>
								<li class="col-md-3 col-sm-6 col-xs-6"> <i class="fa fa-biking"></i>
									<h4>Order a takeaway</h4>

								</li>
								<li class="col-md-3 col-sm-6 col-xs-6"> <i class="fa fa-beer"></i>
									<h4>Your food is delivered</h4>

								</li>
								<li class="col-md-3 col-sm-6 col-xs-6"> <i class="fa fa-smile"></i>
									<h4>Happy, enjoy</h4>

								</li>
							</ol>
						</div>

						<div class="clearfix"></div>
					</div>
					<!--/Process Block-->
					<div class="clearfix"></div>

					<!--/Facts-->

				</div>
			</div>
			<!-- end order process -->

			<div class="pt-80 pb-80">

				<div class="container">

				<div class="row">

                    <div class="col-md-7">

						<div class="section-title">

							<h2 class="text-left text-center-sm">top seller</h2>

						</div>

						<div class="restaurant-common-wrapper">
                            @if ($tops->count() >= 1)
                            @foreach ($tops as $top)

                                <a href="#" class="restaurant-common-wrapper-item highlight clearfix">
                                    <div class="GridLex-grid-middle">
                                        <div class="GridLex-col-6_xs-12">
                                            <div class="restaurant-type">
                                                <div class="image">
                                                    <img src="{{$top->image}}" alt="{{$top->name}}" />
                                                </div>
                                                <div class="content">
                                                    <h4>{{$top->name}}</h4>
                                                        <p>{{$top->type}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="GridLex-col-4_xs-8_xss-12 mt-10-xss">
                                            <div class="job-location">
                                                <i class="fa fa-map-marker text-primary"></i> {{$top->state}} , {{$top->lga}}
                                            </div>
                                        </div>
                                        <div class="GridLex-col-2_xs-4_xss-12">
                                            <div style="color: #fff !important;" onclick="window.location = '{{route('user.vendor', ['id' => $top->id, 'name' => $top->type])}}'" class="res-btn label label-danger">
                                                Place Order
                                            </div>
                                            {{-- <span class="font12 block spacing1 font400 text-center">{{$top->min}}</span> --}}
                                        </div>
                                    </div>
                                </a>

                            @endforeach
                            @endif
                        </div>

                    </div>



					<div class="col-md-5 mt-50-sm">

						<div class="section-title">

							<h2 class="text-left text-center-sm">Featured Restaurant</h2>

						</div>

						<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                              @if ($randoms->count() >= 1)
                                <?php
                                    $i = 0 ;
                                    foreach ($randoms as $random) {
                                        if($i == 0) {
                                            ?>
                                            <div onclick="window.location = '{{route('user.vendor', ['id' => $top->id, 'name' => $top->type])}}'" class="carousel-item active">
                                                <div class="card shadow">
                                                    <img class="d-block w-100 card-img-top" src="{{$random->cover}}" alt="First slide"><br>
                                                    <div class="card-body">
                                                        <div style="margin-top: -30px;">
                                                            <b>{{$random->name}} - {{$random->lga}},{{$random->state}}</b><br>
                                                            <span>
                                                                {{$random->description}}
                                                            </span><br>
                                                            <div class="badge badge-secondary">Min Order</div> &#8358;{{$random->price}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $i++ ;
                                        }else {
                                            ?>
                                            <div onclick="window.location = '{{route('user.vendor', ['id' => $top->id, 'name' => $top->type])}}'" class="carousel-item ">
                                                <div class="card shadow">
                                                    <img class="d-block w-100 card-img-top" src="{{$random->cover}}" alt="First slide"><br>
                                                    <div class="card-body">
                                                        <div style="margin-top: -30px;">
                                                            <b>{{$random->name}} - {{$random->lga}},{{$random->state}}</b><br>
                                                            <span>
                                                                {{$random->description}}
                                                            </span><br>
                                                            <div class="badge badge-secondary">Min Order</div> &#8358;{{$random->price}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                ?>
                              @endif
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="sr-only">Next</span>
                            </a>
                          </div>

					</div>

				</div>

				</div>

			</div>

			<!-- start banner section -->
			<div class="bt-block-home-parallax pt-80 pb-80" style="background-image:url({{asset('images/bander2.png')}});">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="lookbook-product">
								<h2>Delicious food is just a click away! Explore our enlisted restaurants – we believe, you will love them. </h2>

							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end banner section -->

			<div class="container pt-80 pb-80">

				<div class="row">

					<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

						<div class="section-title">

							<h3>discover new restaurant &amp; book now </h3>

						</div>

					</div>

				</div>

				<div class="row gap-40">

					@if ($randoms->count() >= 1)
                        @foreach ($randoms as $random)
                            <div class="col-xs-4 col-sm-2 mb-20">
                                <a href="#"><img src="{{$random->image}}" alt="image" /></a>
                            </div>
                        @endforeach
                    @endif

				</div>


			</div>


			<!-- Download App Start -->
			<div class="download-app-area">
				<div class="download-app-sec" style="background:url(images/bander2.png) bottom center no-repeat fixed;
        background-size:cover;">
					<div class="mask">
						<div class="container">

							<div class="col-md-4 ">
								<div class="left-area visible-lg">
									<img src="{{asset('images/mobilev2.png')}}" alt="">
								</div>
                            </div>

                            <div class="col-md-8 left-container">
								<div class="app-content row">
									<div class="inner">
										<h2 class="logo-content">{{env('APP_NAME')}} in your pocket!</h2>
										<h4 class="logo-subtitle">Get our app, it's the fastest way to order food on the go.</h4>
										<!--<p class="content">
                                            Keep an eye on Thefoody, it is already on your way. Come back here for checkout the latest updates.
                                        </p>-->
										<ul class="list-inline appstore-buttons">
											<li><a href="#" class="btn-store btn-appstore">App Store</a></li>
											<li><a href="#" class="btn-store btn-googleplay">Google Play</a></li>
										</ul>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<!--Download App End -->

			@include('user.inc.footer')
			<!-- end footer -->

		</div>
		<!-- end Main Wrapper -->

	</div> <!-- / .wrapper -->
	<!-- end Container Wrapper -->


<!-- start Back To Top -->
<div id="back-to-top">
   <a href="#"><i class="ion-ios-arrow-up"></i></a>
</div>
<!-- end Back To Top -->


<!-- JS -->
<script type="text/javascript" src="{{ asset('js/u/jquery-migrate-1.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/bootstrap-modalmanager.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('js/u/bootstrap-modal.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('js/u/smoothscroll.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery.easing.1.3.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery.waypoints.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery.slicknav.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery.placeholder.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/bootstrap-tokenfield.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/typeahead.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery-filestyle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/ion.rangeSlider.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/handlebars.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery.countimator.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery.countimator.wheel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/slick.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/easy-ticker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery.introLoader.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery.responsivegrid.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/customs.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/req.js') }}"></script>
    <script src="{{ asset('js/pace.js') }}"></script>

    <script>
      @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
      @endif
    </script>


</body>



</html>
