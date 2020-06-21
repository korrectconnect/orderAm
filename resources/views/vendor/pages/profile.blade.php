@extends('vendor.base')

@section('content')

    <div class="admin-container-wrapper">

        <div class="container">

            <div class="GridLex-gap-15-wrappper">

                <div class="GridLex-grid-noGutter-equalHeight">

                    @include('vendor.inc.menu')

                    <div class="GridLex-col-9_sm-8_xs-12">

                        <div class="admin-content-wrapper">

                            <h2>Profile</h2>

                            <div class="profile-cover" style="background-image: url('{{$vendor->cover}}');"></div>

                            <div class="profile-image shadow" style="background-image: url('{{$vendor->image}}');"></div>

                            <br>

                            <div class="row">
                                <div class="col-md-3"></div>

                                <div class="col-md-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <div>
                                                Name : <b>{{$vendor->name}}</b>
                                            </div>
                                            <div>
                                                Type : <b>{{$vendor->type}}</b>
                                            </div>
                                            <div>
                                                Address : <b>{{$vendor->address}}</b>
                                            </div>
                                            <div>
                                                Location : <b>{{$vendor->lga.", ".$vendor->state}}</b>
                                            </div>
                                            <div>
                                                Operation time : <b>
                                                    <?php
                                                        if($vendor->opening >= 12 && $vendor->opening < 13) {
                                                            echo $open_time = $vendor->opening." pm" ;
                                                        }else {
                                                            if ($vendor->opening >= 13) {
                                                                echo $open_time = ($vendor->opening - 12)." pm" ;
                                                            }else {
                                                                echo $open_time = $vendor->opening." am" ;
                                                            }
                                                        }
                                                    ?> -
                                                    <?php
                                                        if($vendor->closing >= 12 && $vendor->closing < 13) {
                                                            echo $close_time = $vendor->closing." pm" ;
                                                        }else {
                                                            if ($vendor->closing >= 13) {
                                                                echo $close_time = ($vendor->closing - 12)."0 pm" ;
                                                            }else {
                                                                echo $close_time = $vendor->closing." am" ;
                                                            }
                                                        }
                                                    ?>
                                                </b>
                                            </div>
                                            <div>
                                                About : <b>{{$vendor->description}}</b>
                                            </div>
                                            <div>
                                                Delivery Charge : <b>{{$vendor->delivery_charge}}</b>
                                            </div>
                                        </div>
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
