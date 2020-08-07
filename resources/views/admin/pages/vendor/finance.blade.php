@extends('admin.base')

@section('content')

<div class="container">
    <div class="col-md-12">
        <div class="alert alert-secondary">
            <div>
                <div style="display:inline-block; float:left; font-weight:bold; font-size:20px;">{{$vendor->name}}</div>
                <div style="display:inline-block; float:right; ">
                    Balance : <span style="font-size:20px;">&#8358;{{$auth->account}}</span>
                </div>
            </div><br><br>
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
