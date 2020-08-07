@extends('user.base')

@section('content')

<!-- start hero-header -->
<div class="breadcrumb-wrapper">

    <div class="container">

        <ol class="breadcrumb-list booking-step">
            <li><a href="{{route('user.home')}}">Home</a></li>
            <li><span>Vendors</span></li>
        </ol>

    </div>

</div>
<!-- end hero-header -->

<div class="section sm">

    <div class="container">

        <div class="container">

            <h2 style="color: #000000">Select vendor location, lets browse&nbsp; <i class="fa fa-smile" aria-hidden="true"></i></h2>

            <div style="font-size:18px; color:rgb(255, 136, 0); margin-bottom:10px;">
                <i class="fa fa-location-arrow"></i> Delivering to
            </div>
            <form action="" method="POST" id="vendorLocationForm">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="state">&nbsp; <b>City</b></label>
                            <select name="state" id="state" class="form-control" style="font-weight: bold;">
                                @if ($states->count() >= 1)
                                    @foreach ($states as $state)
                                        <option>{{$state->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="area">&nbsp; <b>Area</b></label>
                            <select name="area" id="area" class="form-control" style="font-weight: bold;">
                                @if ($lgas->count() >= 1)
                                    @foreach ($lgas as $lga)
                                        <option>{{$lga->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            <h4><b>Select Service</b></h4><br>
            <input type="hidden" id="loadVendorByLocation" value="">

            <div class="vendor_service">
                <div class="row">
                    @if ($categories->count() >= 1)
                        @foreach ($categories as $category)
                            <div class="col-md-3">
                                <div class="card shadow-sm rounded" id="selectServiceBtn" data-load="{{$category->name}}">
                                    <div class="card-body">
                                        <img src="{{$category->image}}" alt="{{$category->name}}" style="width: 50px;"><br>
                                        <span style="color:rgb(255, 136, 0);"><b>{{$category->name}}</b></span><br>
                                        <small>{{$category->description}}</small>
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

@endsection
