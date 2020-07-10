@extends('admin.base')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>Pending Deliveries </strong>
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
                                    <th>Rider Status</th>
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
                                            <td>
                                                @if ($order->confirm == 0)
                                                    <span class="text-danger">Not confirmed</span>
                                                @else
                                                    <span class="text-success">Confirmed</span>
                                                @endif
                                            </td>
                                            <td><a href="javascript:void()" id="viewPendingDeliveryBtn" data-href="{{route('admin.pending.delivery', ['id' => $order->id])}}">View</a> / <a href="javascript:void()" data-order="{{$order->order_no}}" data-href="{{route('admin.order.confirm.assign', ['id' => $order->id])}}" id="confirmOrderBtn">Re-assign</a></td>
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
