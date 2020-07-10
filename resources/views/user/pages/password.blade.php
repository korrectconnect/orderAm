@extends('user.base')

@section('content')

<div class="breadcrumb-wrapper">

    <div class="container">

        <ol class="breadcrumb-list booking-step">
            <li><a href="{{route('user.home')}}">Home</a></li>
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

                            @if ($user->image != NULL)
                                <div class="image" style="background-image: url('{{$user->image}}')"></div>
                            @else
                                <div class="image" style="background-image: url('{{asset('images/man/01.jpg')}}')"></div>
                            @endif

                            <h4>{{$user->firstname." ".$user->lastname}}</h4>
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
                            <li>
                                <a href="{{route('user.vendor.favourite')}}"><i class="fa fa-heart"></i> Favourite Vendors</a>
                            </li>
                            <li class="active">
                                <a href="{{route('user.password.change')}}"><i class="fa fa-key"></i> Change Password</a>
                            </li>

                        </ul>

                    </div>

                </div>

                <div class="GridLex-col-9_sm-8_xs-12">

                    <div class="admin-content-wrapper">

                        <div class="admin-section-title">

                            <h2>Change Password</h2>

                        </div>

                        <form id="changePasswordForm" data-href="{{route('user.password.change')}}">

                            <div class="col-md-6">
                                <div class="row gap-20">

                                    <div class="clear"></div>

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label>Old password*</label>
                                            <input type="password" name="old" class="form-control" >
                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label>New password*</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label>Confirm new password*</label>
                                            <input type="password" name="password_confirmation" class="form-control">
                                        </div>

                                    </div>

                                    <div class="clear"></div>

                                    <div class="col-sm-12 mt-10">
                                        <button type="submit" class="btn btn-primary" id="changePasswordFormBtn">SUBMIT</button>
                                    </div>

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
