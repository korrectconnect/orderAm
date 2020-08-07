@extends('user.base')

@section('content')


    <!-- start hero-header -->
			<div class="breadcrumb-wrapper">

				<div class="container">

					<ol class="breadcrumb-list booking-step">
						<li><a href="{{route('user.home')}}">Home</a></li>
                        <li><span>Order</span></li>
                        <li><span> &nbsp; / &nbsp; Cart</span></li>
					</ol>

				</div>

			</div>
			<!-- end hero-header -->

			<div class="section sm">

				<!-- Content Start -->
				<!-- Start order-online-->
				<div id="order-process">
					<div class="container">



						<div class="order-inner-content">
							<div class="row">
								<div class="col-md-9">
                                    <h4>{{$vendor->name}}</h4>

                                    <div class="alert alert-secondary" style="margin-bottom: 30px;">

                                        <span style="font-size:14px; color:rgb(255, 136, 0);">
                                            <i class="fa fa-location-arrow"></i> Location
                                        </span> &nbsp; &nbsp;
                                        <span style="font-size:14px; font-weight:bold;">
                                            {{$vendor->state." , ".$vendor->lga}}
                                        </span>

                                    </div>

                                    <h4>Delivery Address &nbsp; <a href="javascript:void()" data-href="{{route('user.address')}}" id="addAddressBtn" style="font-size: 12px;"><i class="fa fa-pen"></i> Add</a></h4>

                                    <div class="row">
                                        <input type="hidden" id="addressHidden" value="@if ($defaultAddress != null){{$defaultAddress->id}}@endif">
                                        @if ($defaultAddress != null)
                                            <div class="col-md-4">
                                                <div data-id="{{$defaultAddress->id}}" class="card shadow-sm addressDiv addressDivActive" >
                                                    <div class="card-body">
                                                        <div class="defaultAddress">Default</div>
                                                        <div class="activeAddressTag siteColor"><i class="fa fa-check-circle"></i></div>
                                                        <small>{{$defaultAddress->address}}</small><br>
                                                        <small>{{auth()->user()->phone}}</small><br>
                                                        @if(($defaultAddress->phone != NULL))
                                                            <small>{{$defaultAddress->phone}}</small><br>
                                                        @endif
                                                        <span>{{$defaultAddress->lga." (".$defaultAddress->state.")"}}</span>
                                                        <div class="addressAction">
                                                            <a href="javascript:void()" id="editAddress" data-href="{{route('user.address.edit.form', ['id'=>$defaultAddress->id])}}"><i class="fa fa-pen"></i> Edit</a>
                                                            <a href="javascript:void()" id="deleteAddress" data-href="{{route('user.address.delete', ['id'=>$defaultAddress->id])}}"><i class="fa fa-trash"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </div><br>
                                            </div>
                                        @endif
                                        @if ($addresses->count() >= 1)
                                            @foreach ($addresses as $address)
                                                <div class="col-md-4">
                                                    <div data-id="{{$address->id}}" class="card shadow-sm addressDiv" >
                                                        <div class="card-body">
                                                            <div class="activeAddressTag siteColor"><i class="fa fa-check-circle"></i></div>
                                                            <small>{{$address->address}}</small><br>
                                                            <small>{{auth()->user()->phone}}</small><br>
                                                            @if($address->phone != NULL)
                                                                <small>{{$address->phone}}</small><br>
                                                            @endif
                                                            <span>{{$address->lga." (".$address->state.")"}}</span>
                                                            <div class="addressAction">
                                                                <a href="javascript:void()" id="makeDefaultAddress" data-href="{{route('user.address.default', ['id'=>$address->id])}}">Default</a>
                                                                <a href="javascript:void()" id="editAddress" data-href="{{route('user.address.edit.form', ['id'=>$address->id])}}"><i class="fa fa-pen"></i> Edit</a>
                                                                <a href="javascript:void()" id="deleteAddress" data-href="{{route('user.address.delete', ['id'=>$address->id])}}"><i class="fa fa-trash"></i> Delete</a>
                                                            </div>
                                                        </div>
                                                    </div><br>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <h4>Payment Type</h4>

                                    <div class="row">
                                        <div class="col-sm-3"><input type="radio" name="pay" id="payOnDeviveryRadio" checked> Pay on delivery</div>
                                        <div class="col-sm-3"><input type="radio" name="pay" id="payOnlineRadio" > Pay online (PayStack)</div>
                                    </div><br><br>
								</div>
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

                                                <div class="cart-amount" id="couponDiv" >
                                                    Coupon : <span>&#8358 <span id="couponSpan"></span> </span>
                                                </div>
                                                <hr>

                                                <div class="cart-amount">
                                                    <b>Total</b> : <span>&#8358
                                                        @if (auth()->user())
                                                            @if ($carts->count() >= 1)
                                                                <span id="orderTotal">{{$total}}</span>
                                                            @else
                                                                0
                                                            @endif
                                                        @else
                                                            0
                                                        @endif
                                                    </span>
                                                </div>
                                                <input type="hidden" id="orderTotalHidden" value="{{$total}}">
                                                <input type="hidden" id="mCoupon" value="">
                                            </div>

                                            <form id="checkCouponForm">
                                                <div class="row">
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="coupon" id="orderCoupon" placeholder="Coupon Code">
                                                        <input type="hidden" name="vendor" value="{{$vendor->id}}">
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <button type="submit" class="btn btn-sm btn-warning" id="couponCheckBtn">Update</button>
                                                    </div>
                                                </div><br>
                                            </form>
                                            <!-- Order Item Total Ends -->
                                            <div class="cfo-checkoutarea">
                                                @if (auth()->user())
                                                    @if ($carts->count() >= 1)
                                                        <button name="a" id="order-checkout-btn" data-vendor="{{$vendor->id}}" class="btn btn-primary btn-block custom-checkout">Proceed to Checkout</button>
                                                    @else
                                                        <button name="a" id="order-checkout-btn" data-vendor="{{$vendor->id}}" class="btn btn-primary btn-block custom-checkout" disabled="true">Proceed to Checkout</button>
                                                    @endif
                                                @else
                                                    <button name="a" id="order-checkout-btn" data-vendor="{{$vendor->id}}" class="btn btn-primary btn-block custom-checkout" disabled="true">Proceed to Checkout</button>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- Order Content Ends -->
									</div>
									<!-- Your Order Ends -->
									<div id="ad-wrapper">

										{{-- <img class="img-responsive" src="{{asset('images/add-banner/add-banner.png')}}" alt=""> --}}

									</div>
								</div>
								<!-- Sidearea Ends -->
							</div>
						</div>
					</div>
					<!--.container-->
				</div>
				<!--#order-online-->
				<!--end order-online-->
				<!-- Content End -->

			</div>


@endsection
