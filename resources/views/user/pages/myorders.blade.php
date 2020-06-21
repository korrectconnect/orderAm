@extends('user.base')

@section('content')

<div class="breadcrumb-wrapper">

    <div class="container">

        <ol class="breadcrumb-list booking-step">
            <li><a href="#">Home</a></li>
            <li><span>My Orders</span></li>
        </ol>

    </div>

</div>
<!-- end breadcrumb -->

<div class="admin-container-wrapper">

    <div class="container">

        <div class="GridLex-gap-15-wrappper">

            <div class="GridLex-grid-noGutter-equalHeight">

                <div class="GridLex-col-3_sm-4_xs-12">

                    <div class="admin-sidebar">

                        <div class="admin-user-item">

                            @if (auth()->user()->image != NULL)
                                <div class="image" style="background-image: url('{{auth()->user()->image}}')"></div>
                            @else
                                <div class="image" style="background-image: url('{{asset('images/man/01.jpg')}}')"></div>
                            @endif

                            <h4>{{auth()->user()->firstname." ".auth()->user()->lastname}}</h4>
                            <p class="user-role">{{auth()->user()->email}}</p>

                        </div>

                        <div class="admin-user-action text-center">

                            <a class="btn btn-primary btn-sm" href="javascript:void()" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i class="fa fa-door-open"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </div>

                        <ul class="admin-user-menu clearfix">
                            <li>
                                <a href="{{route('user.profile')}}"><i class="fa fa-user"></i> Profile</a>
                            </li>
                            <li class="active">
                                <a href="{{route('user.orders')}}"><i class="fa fa-list"></i> My Orders</a>
                            </li>
                            <li>
                                <a href="{{route('user.address.book')}}"><i class="fa fa-book"></i> Address Book</a>
                            </li>
                            <li>
                                <a href="{{route('user.vendor.favourite')}}"><i class="fa fa-heart"></i> Favourite Vendors</a>
                            </li>
                            <li>
                                <a href="{{route('user.password.change')}}"><i class="fa fa-key"></i> Change Password</a>
                            </li>
                        </ul>

                    </div>

                </div>

                <div class="GridLex-col-9_sm-8_xs-12">

                    <div class="admin-content-wrapper">

                        <div class="admin-section-title">

                            <h2>My Orders</h2>
                            <p>View all orders and track running orders.</p>

                        </div>

                        <div>
                            @if ($orders->count() >= 1)

                                @foreach ($orders as $order)

                                    <div class="col-md-6">
                                        <div class="order-list" id="order_list" data-href="{{route('user.myorder', ['no' => $order->order_no])}}">
                                            <div class="siteColor"><b>{{$order->order_no}}</b></div>
                                            <div>{{$order->created_at}}</div>

                                            <div><small>
                                                @if ($order->cancelled == 1)
                                                    <i class="fa fa-times-circle"></i> Cancelled
                                                @else
                                                    @if ($order->status == 0)
                                                        <i class="fa fa-spin fa-spinner"></i> Pending confirmation
                                                    @elseif($order->status == 1)
                                                        <i class="fa fa-biking"></i> Confirmed, Pending Delivery
                                                    @elseif($order->status == 2)
                                                        <i class="fa fa-check-circle"></i> Delivered
                                                    @endif
                                                @endif
                                            </small></div>

                                            <div class="order-list-price">&#8358 {{$order->total}}</div>
                                            <div class="ordder_rating"></div>
                                        </div>
                                    </div>

                                @endforeach

                            @else
                                <center>
                                    <h2 style="color: rgb(100, 100, 100)"><i class="fa fa-th-list"></i></h2>
                                    <h3>You don't have any order yet</h3>
                                    <div>
                                        Click the button below to browse the best vendors near by<br><br>

                                        <a href="{{route('user.vendors.home')}}" class="btn btn-primary btn-md">Browse Vendors</a>
                                    </div>
                                </center>
                            @endif
                        </div><br><br><br><br><br>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
