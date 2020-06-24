@extends('user.base')

@section('content')

<div class="breadcrumb-wrapper">

    <div class="container">

        <ol class="breadcrumb-list booking-step">
            <li><a href="#">Home</a></li>
            <li><span>Address Book</span></li>
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
                            <li>
                                <a href="{{route('user.orders')}}"><i class="fa fa-list"></i> My Orders</a>
                            </li>
                            <li>
                                <a href="{{route('user.address.book')}}"><i class="fa fa-book"></i> Address Book</a>
                            </li>
                            <li class="active">
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

                            <h2>Favourite Vendors</h2>

                        </div>

                        <div class="company-grid-wrapper top-company-2-wrapper">

                            <div class="GridLex-gap-30">

                                <div class="GridLex-grid-noGutter-equalHeight">

                                    @if ($vendors->count() >= 1)

                                        @foreach ($vendors as $vendor)

                                        <div class="GridLex-col-3_sm-4_xs-6_xss-12">

                                            <div class="top-company-2">
                                                <a href="{{route('user.vendor', ['id' => $vendor->id, 'name' => $vendor->type])}}">

                                                    <div class="image">
                                                        <img src="{{$vendor->image}}" alt="image" />
                                                    </div>

                                                    <div class="content">
                                                        <h5 class="heading text-primary font700">{{$vendor->name}}</h5>
                                                        <p class="texting font600">Fresh baked/cooked meal and much more...</p>
                                                        <p class="mata-p clearfix"><span class="text-primary font700">&#8358; {{$vendor->price}}</span> <span class="font13">min order</span> <span class="pull-right icon"><i class="fa fa-long-arrow-right"></i></span></p>

                                                    </div>


                                                </a>

                                            </div>

                                        </div>

                                        @endforeach

                                    @else

                                        <center>
                                            <h2 style="color: rgb(100, 100, 100)"><i class="fa fa-heart"></i></h2>
                                            <h3>You have not added any vendor to your favourites</h3>
                                            <div>
                                                Click the button below to browse the best vendors near by<br><br>

                                                <a href="{{route('user.vendors.home')}}" class="btn btn-primary btn-md">Browse Vendors</a>
                                            </div>
                                        </center>

                                    @endif

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
