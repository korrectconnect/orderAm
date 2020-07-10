@extends('user.base')

@section('content')

<div id="order-page-title" class="vendor-cover-div" style="background: url('{{$vendor->image}}');">
<div class="vendor-cover-div-wrap">

    <div class="container inner-img">
        <div class="order-top-section">
            <div class="Page-title">

                <div class="row single-restaurant-top-section">

                    <div class="col-md-8">
                        <div class="res-short-info">
                            <h2>{{$vendor->name}}</h2>
                            <ul class="list-unstyled">
                                <li>
                                    <span class="glyphicon glyphicon-cutlery"></span>
                                    Type: {{$vendor->type}}
                                </li>
                                <li><span class="fa fa-lock"></span> Min. Order &#8358; {{$single->price}}</li>
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="restaurant-opening-info">

                            <div class="res-rating-all">
                                <ul class="list-unstyled">
                                    <li>
                                        <div class="res-opening-time"><i class="fa fa-clock"></i>
                                            <?php
                                                if($vendor->opening >= 12 && $vendor->opening < 13) {
                                                    echo $open_time = $vendor->opening." pm" ;
                                                }else {
                                                    if ($vendor->opening >= 13) {
                                                        echo $open_time = ($vendor->opening - 12)." pm" ;
                                                    }else {
                                                        echo $open_time = $vendor->opening." am" ;
                                                    }
                                                }
                                            ?> -
                                            <?php
                                                if($vendor->closing >= 12 && $vendor->closing < 13) {
                                                    echo $close_time = $vendor->closing." pm" ;
                                                }else {
                                                    if ($vendor->closing >= 13) {
                                                        echo $close_time = ($vendor->closing - 12)."0 pm" ;
                                                    }else {
                                                        echo $close_time = $vendor->closing." am" ;
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ui-res-rating">
                                            <span class="glyphicon glyphicon-star" style="color: #E64D64;"></span>
                                            <span class="glyphicon glyphicon-star" style="color: #E64D64;"></span>
                                            <span class="glyphicon glyphicon-star" style="color: #E64D64;"></span>
                                            <span class="glyphicon glyphicon-star" style="color: #CCCCCC;"></span>
                                            <span class="glyphicon glyphicon-star" style="color: #CCCCCC;"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ui-rating-text">
                                            3.2 Rating
                                        </div>
                                    </li>
                                    <div class="clearfix"></div>
                                </ul>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- start hero-header -->
<div class="breadcrumb-wrapper">

    <div class="container">

        <ol class="breadcrumb-list booking-step">
            <li><a href="index.html">Home</a></li>
            <li><span>{{$vendor->type}}</span></li>
        </ol>

    </div>

</div>
<!-- end hero-header -->


<div class="section sm">

    <!-- Content Start -->
    <!-- Start order-online-->
    <div id="order-online" style="margin-top: -10px;" >
        <div class="container">


            <!-- Nested Row Starts -->
            <div class="row">
                <!-- Mainarea Starts -->
                <div class="col-md-9 col-xs-12">
                    <!-- Menu Tabs Starts -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <strong>Address & Reviews</strong>
                                </div>
                                <div class="card-body">
                                    <?php
                                        if(date("H.i") >= $vendor->opening && date("H.i") < $vendor->closing ) {
                                            echo "<div class='operationOpen'>Vendor is open</div>";
                                        }else {
                                            echo "<div class='operationClose'>Vendor is closed</div>";
                                        }
                                    ?>
                                    @if (auth()->user())
                                        @if ($fav != NULL)
                                            <div class="favoriteVendor" data-href="{{route('user.vendor.favourite.toggle', ['id' => $vendor->id])}}">
                                                <i class="fa fa-heart siteColor"></i>
                                            </div>
                                        @else
                                            <div class="favoriteVendor" data-href="{{route('user.vendor.favourite.toggle', ['id' => $vendor->id])}}">
                                                <i class="fa fa-heart"></i>
                                            </div>
                                        @endif
                                    @endif
                                    <br>
                                    <span style="font-size:12px;">Ratings: <i class="fa fa-star siteColor"></i><i class="fa fa-star siteColor"></i><i class="fa fa-star siteColor"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span><br>
                                     <br>
                                    <span style="font-size:12px">
                                        <strong>Address :</strong> {{$vendor->address}}
                                    </span>
                                </div>
                            </div><br>
                        </div>

                        <div class="col-md-9">
                            <div class="alert alert-secondary">
                                @foreach ($menu_categories as $menu_category)
                                    <div class="menuCategoryBtn" data-vendor="{{$vendor->id}}" data-category="{{$menu_category->category}}">
                                        {{$menu_category->category}}
                                    </div>
                                @endforeach
                            </div>

                            <div class="card shadow-sm menuListDiv">
                                <center><i class='fa fa-spin fa-circle-notch fa-2x'></i></center>
                            </div><br>
                        </div>
                    </div>
                </div>
                <!-- Mainarea Ends -->
                <!-- Sidearea Starts -->
                <div class="col-md-3 col-xs-12">
                    <!-- Spacer Starts -->
                    <div class="spacer-1 medium hidden-lg hidden-md"></div>
                    <!-- Spacer Ends -->
                    <!-- Your Order Starts -->
                    <div class="side-block-order border-radius-4">
                        <!-- Heading Starts -->
                        <h5 class="text-center"><i class="fa fa-shopping-basket"></i> Your Orders</h5>
                        <!-- Heading Ends -->
                        <!-- Order Content Starts -->
                        <div class="side-block-order-content">
                            <!-- Order Item List Starts -->
                            <div id="cart-div">
                                @if (!auth()->user())
                                    <div class="alert alert-secondary">
                                        <small><b>Login to view cart</b></small>
                                    </div>
                                @else
                                    @if ($carts->count() >= 1)
                                        @foreach($carts as $cart)
                                            <div class="clearfix cart-items">
                                                <div class="pull-left">
                                                <div class="update-product">
                                                    <a title="Increase item quantity" href="javascript:void()" id="increase-cart-btn" data-id="{{$cart->id}}"><i class="fa fa-plus-circle"></i></a>
                                                    <a title="Decrease item quantity" href="javascript:void()" id="decrease-cart-btn" data-id="{{$cart->id}}"><i class="fa fa-minus-circle"></i></a>
                                                </div>
                                                </div>
                                                    <div class="cart-product-name pull-left">{{$cart->name}}</div>
                                                    <span class="cart-product-price pull-right text-spl-color pull-left">Qty: {{$cart->quantity}}</span>
                                                    <div class="cart-product-price pull-right text-spl-color f-r"><b>&#8358; {{$cart->price*$cart->quantity}}</b></div>
                                                    <div class="remove-cart-btn" ><a title="delete item from cart" id="remove-cart-btn" data-id="{{$cart->id}}" href="javascript:void()"><i class="fa fa-trash"></i></a></div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-secondary">
                                            <small><b><i class="fa fa-shopping-cart"></i> cart for this vendor is empty</b></small>
                                        </div>
                                    @endif
                                @endif
                            <hr>

                            <div class="cart-amount">
                                Order Amount : <span>&#8358
                                    @if (auth()->user())
                                        @if ($carts->count() >= 1)
                                            {{$order_total}}
                                        @else
                                            0
                                        @endif
                                    @else
                                        0
                                    @endif
                                </span>
                            </div>
                            <div class="cart-amount">
                                Delivery Charge : <span>&#8358
                                    @if (auth()->user())
                                        @if ($carts->count() >= 1)
                                            {{$vendor->delivery_charge}}
                                        @else
                                            0
                                        @endif
                                    @else
                                        0
                                    @endif
                                </span>
                            </div>
                            <div class="cart-amount">
                                Tax : <span>&#8358
                                    @if (auth()->user())
                                        @if ($carts->count() >= 1)
                                            {{$vendor->vendor_charge + $vendor->tax}}
                                        @else
                                            0
                                        @endif
                                    @else
                                        0
                                    @endif
                                </span>
                            </div>
                            <hr>

                            <div class="cart-amount">
                                <b>Total</b> : <span>&#8358
                                    @if (auth()->user())
                                        @if ($carts->count() >= 1)
                                            {{$total}}
                                        @else
                                            0
                                        @endif
                                    @else
                                        0
                                    @endif
                                </span>
                            </div>
                            </div>
                            <!-- Order Item Total Ends -->
                            <div class="cfo-checkoutarea">
                                @if (auth()->user())
                                    @if ($carts->count() >= 1)
                                        <button onclick="window.location = '{{route('user.order.process', ['id' => $vendor->id])}}'" name="a" id="cart-checkout-btn" class="btn btn-primary btn-block custom-checkout">Proceed to Checkout</button>
                                    @else
                                        <button onclick="window.location = '{{route('user.order.process', ['id' => $vendor->id])}}'" name="a" id="cart-checkout-btn" class="btn btn-primary btn-block custom-checkout" disabled="true">Proceed to Checkout</button>
                                    @endif
                                @else
                                    <button onclick="window.location = '{{route('user.order.process', ['id' => $vendor->id])}}'" name="a" id="cart-checkout-btn" class="btn btn-primary btn-block custom-checkout" disabled="true">Proceed to Checkout</button>
                                @endif
                            </div>
                        </div>
                        <!-- Order Content Ends -->
                    </div>
                    <!-- Your Order Ends -->


                    <!-- start add wrapper -->
                    <div id="ad-wrapper">

                        <img class="img-responsive" src="{{asset('images/add-banner/add-banner.png')}}" alt="">

                    </div>
                    <!-- end add wrapper -->

                </div>
                <!-- Sidearea Ends -->
            </div>
            <!-- Nested Row Ends -->
        </div>
        <!--.container-->
    </div>
    <!--#order-online-->
    <!--end order-online-->
    <!-- Content End -->

    <!-- start mobile footer nav -->
    <nav class="navbar navbar-default navbar-fixed-bottom visible-xs visible-sm mobile-cart-nav">
        <div class="mobile-cart-inner-content">
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <div class="mobile-cart-item">
                        <a id="mobileCartToggle" href="#"><i class="fa fa-shopping-basket"></i><span id="cart-item"> 10</span></a>
                    </div>
                </div>
                <div class="col-md-4 col-xs-4">
                    <div class="mobile-total-amount">Total: &pound;<span id="total-cart-amount">50</span></div>
                </div>
                <div class="col-md-4 col-xs-4">
                    <a href="#" class="btn mobile-btn-checkout">Checkout</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- end mobile footer nav -->

</div>

@endsection
