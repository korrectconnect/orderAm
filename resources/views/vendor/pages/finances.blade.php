@extends('vendor.base')

@section('content')

    <div class="admin-container-wrapper">

        <div class="container">

            <div class="GridLex-gap-15-wrappper">

                <div class="GridLex-grid-noGutter-equalHeight">

                    @include('vendor.inc.menu')

                    <div class="GridLex-col-9_sm-8_xs-12">

                        <div class="admin-content-wrapper">

                            <h2>Finances</h2>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-secondary">
                                        <div class="orderMenuBtn" data-href="{{route('vendor.transaction.today')}}" >
                                            <i class="fa fa-clock"></i> Today's Transaction
                                        </div>
                                        <div class="orderMenuBtn" data-href="{{route('vendor.transaction.filter')}}" >
                                            <i class="fa fa-filter"></i> Filter
                                        </div>
                                        <div class="orderMenuBtn" data-href="{{route('vendor.transaction.funding')}}" >
                                            <i class="fa fa-clock"></i> Funding
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-sm">
                                    <div style="padding-right: 20px; color:#333; padding-top: 10px; margin-bottom: -15px; text-align:right;">
                                        Balance:
                                        @if ($account < 0)
                                            <span class="text-danger" style="font-size: 30px;">&#8358;{{$account}}</span>
                                        @else
                                            <span class="text-success" style="font-size: 30px;">&#8358;{{$account}}</span>
                                        @endif
                                    </div>

                                <div class="orderListDiv">
                                    <center><i class='fa fa-spin fa-circle-notch fa-2x'></i></center>
                                </div>
                            </div><br>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
