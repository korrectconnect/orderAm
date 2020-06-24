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
                            <li class="active">
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

                            <h2>Address Book</h2>

                        </div>

                            <div class="row ">

                                <h4><a href="javascript:void()" data-href="{{route('user.address')}}" id="addAddressBtn" style="font-size: 12px;"><i class="fa fa-pen"></i> Add to address book</a></h4><br><br>

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

                            </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
