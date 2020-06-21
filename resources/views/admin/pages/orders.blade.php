@extends('admin.base')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>Orders</strong>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Order no.</th>
                                    <th>Total</th>
                                    <th>Vendor</th>
                                    <th>Payment Mode</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($orders->count() >= 1)
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{$order->created_at}}</td>
                                            <td>{{$order->order_no}}</td>
                                            <td>&#8358; {{$order->total}}</td>
                                            <td>{{$order->name." (".$order->lga.")"}}</td>
                                            <td>{{$order->payment_mode}}</td>
                                            <td><a href="#">View</a> / <a href="javascript:void()" id="cancelOrder" data-href="{{route('admin.order.cancel', ['id' => $order->id])}}">Cancel</a></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
