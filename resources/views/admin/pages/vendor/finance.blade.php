@extends('admin.base')

@section('content')

<div class="container">
    <div class="col-md-12">
        <div class="alert alert-secondary">
            <h3>{{$vendor->name}}</h3>
            <div class="orderMenuBtn" data-href="{{route('admin.vendor.transaction.today', ['vendor_id' => $vendor->id])}}" >
                <i class="fa fa-clock"></i> Today's Transaction
            </div>
            <div class="orderMenuBtn" data-href="{{route('admin.vendor.transaction.filter.form', ['vendor_id' => $vendor->id])}}" >
                <i class="fa fa-filter"></i> Filter
            </div>
        </div>

        <div class="card shadow-sm orderListDiv">
            <center><i class='fa fa-spin fa-circle-notch fa-2x'></i></center>
        </div><br>
    </div>
</div>

{{-- <script src="{{asset('js/req.js')}}"></script> --}}

@endsection

@section('javascript')

@endsection
