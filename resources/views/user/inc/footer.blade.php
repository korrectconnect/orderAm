<footer class="footer-wrapper-area">

    <!-- start footer area -->
    <div class="footer-area-content">
        <!-- Newsletter -->
        <div id="footer-newsletter" class="pt-40 pb-40">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3><i class="fa fa-envelope-o"></i>Keep in touch, Subscribe to our newsletter</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-md-offset-3">
                        <div class="newsletter-02">
                            <div class="form-group">
                                <input class="form-control" placeholder="enter your email ">
                                <button class="btn btn-primary">subscribe</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Newsletter -->

        <div class="container">
            <div class="footer-wrapper style-3">
                <footer class="type-1">
                    <div class="footer-columns-entry">
                        <div class="row">
                            
                            <div class="col-md-3 col-sm-3">
                                <h3 class="column-title">Popular Areas</h3>
                                <ul class="column">
                                    @if ($lgas->count() >= 1)
                                        @foreach ($lgas as $lga)
                                            <li><a href="#">Food delivery {{$lga->name}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="clear"></div>
                            </div>

                            <div class="col-md-3 col-sm-3">
                                <h3 class="column-title">Categories</h3>
                                <ul class="column">
                                    @if ($states->count() >= 1)
                                        @foreach ($categories as $category)
                                            <li><a href="#">{{$category->name}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="clear"></div>
                            </div>

                            <div class="col-md-3 col-sm-3">
                                <h3 class="column-title">{{env('APP_NAME')}}</h3>
                                <ul class="column">
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">News</a></li>
                                    <li><a href="#">Terms and conditions</a></li>
                                    <li><a href="#"> Privacy policy</a></li>
                                    <li><a href="#">TheFoody free App for Android and iPhone</a></li>
                                    <li><a href="#">Careers</a></li>

                                </ul>
                                <div class="clear"></div>
                            </div>

                            <div class="col-md-3 col-sm-3">
                                <h3 class="column-title">Popular cities</h3>
                                <ul class="column">
                                    @if ($states->count() >= 1)
                                        @foreach ($states as $state)
                                            <li><a href="#">Food delivery {{$state->name}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>


    </div>
    <!-- footer area end -->

    <div class="bottom-footer">

        <div class="container">

            <div class="row">

                <div class="col-sm-4 col-md-4">

                    <p class="copy-right">&#169; Copyright {{date('Y')}} {{env('APP_NAME')}}</p>

                </div>

                <div class="col-sm-4 col-md-4">

                    <ul class="bottom-footer-menu">
                        <li><a href="#">Cookies</a></li>
                        <li><a href="#">Policies</a></li>
                        <li><a href="#">Terms</a></li>
                        <li><a href="#">Blogs</a></li>
                    </ul>

                </div>

                <div class="col-sm-4 col-md-4">
                    <ul class="bottom-footer-menu for-social">
                        <li><a href="#"><i class="ri ri-twitter" data-toggle="tooltip" data-placement="top" title="twitter"></i></a></li>
                        <li><a href="#"><i class="ri ri-facebook" data-toggle="tooltip" data-placement="top" title="facebook"></i></a></li>
                        <li><a href="#"><i class="ri ri-google-plus" data-toggle="tooltip" data-placement="top" title="google plus"></i></a></li>
                        <li><a href="#"><i class="ri ri-youtube-play" data-toggle="tooltip" data-placement="top" title="youtube"></i></a></li>
                    </ul>
                </div>

            </div>

        </div>

    </div>

</footer>
