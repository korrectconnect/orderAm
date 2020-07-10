@extends('vendor.base')

@section('content')

    <div class="admin-container-wrapper">

        <div class="container">

            <div class="GridLex-gap-15-wrappper">

                <div class="GridLex-grid-noGutter-equalHeight">

                    @include('vendor.inc.menu')

                    <div class="GridLex-col-9_sm-8_xs-12">

                        <div class="admin-content-wrapper">

                            <h2>Orders</h2>

                            <!-- {{route('vendor.ajax.orders', ['status' => 0, 'cancelled' => 0])}} -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-secondary">
                                        <div class="orderMenuBtn" data-href="{{route('vendor.ajax.orders', ['status' => 0, 'cancelled' => 0])}}" >
                                            <i class="fa fa-list"></i> Incoming Order
                                        </div>
                                        <div class="orderMenuBtn" data-href="{{route('vendor.ajax.orders', ['status' => 1, 'cancelled' => 0])}}" >
                                            <i class="fa fa-biking"></i> Pending Delivery
                                        </div>
                                        <div class="orderMenuBtn" data-href="{{route('vendor.ajax.orders', ['status' => 2, 'cancelled' => 0])}}" >
                                            <i class="fa fa-check-circle"></i> Delivered
                                        </div>
                                        <div class="orderMenuBtn" data-href="{{route('vendor.ajax.orders', ['status' => 0, 'cancelled' => 1])}}" >
                                            <i class="fa fa-times-circle"></i> Cancelled
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-sm orderListDiv">
                                <center><i class='fa fa-spin fa-circle-notch fa-2x'></i></center>
                            </div><br>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
