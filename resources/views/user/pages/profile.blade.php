@extends('user.base')

@section('content')

<div class="breadcrumb-wrapper">

    <div class="container">

        <ol class="breadcrumb-list booking-step">
            <li><a href="#">Home</a></li>
            <li><span>User Profile</span></li>
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
                            <li class="active">
                                <a href="{{route('user.profile')}}"><i class="fa fa-user"></i> Profile</a>
                            </li>
                            <li>
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

                            <h2>Profile</h2>

                        </div>

                        <form id="editProfleForm" data-href="{{route('user.profile.edit')}}">

                            <div class="row gap-20">

                                <div class="col-sm-6 col-md-4">

                                    <div class="form-group bootstrap-fileinput-style-01">
                                        <label>Photo</label>
                                        <input type="file" name="file" id="form-register-photo">
                                        <span class="font12 font-italic">** photo must not bigger than 2MB</span>
                                    </div>



                                </div>

                                <div class="clear"></div>

                                <div class="col-sm-6 col-md-4">

                                    <div class="form-group">
                                        <label>First Name*</label>
                                        <input type="text" name="firstname" class="form-control" value="{{auth()->user()->firstname}}">
                                    </div>

                                </div>

                                <div class="col-sm-6 col-md-4">

                                    <div class="form-group">
                                        <label>Last Name*</label>
                                        <input type="text" name="lastname" class="form-control" value="{{auth()->user()->lastname}}">
                                    </div>

                                </div>

                                <div class="clear"></div>

                                <div class="col-sm-6 col-md-4">

                                    <div class="form-group">
                                        <label>Phone*</label>
                                        <input type="text" name="phone" class="form-control" value="{{auth()->user()->phone}}">
                                    </div>

                                </div>

                                <div class="clear"></div>

                                <div class="col-sm-12 mt-10">
                                    <button type="submit" class="btn btn-primary" id="editProfileFormBtn">Save</button>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
