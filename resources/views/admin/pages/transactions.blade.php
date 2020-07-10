@extends('admin.base')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>Transactions</strong>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-md-3">
                            <div style="float: left; display:inline-block">
                                <span>Total Profit (Commission) :</span><br>
                                @if ($profit > 0)
                                <span class="text-success" style="font-size: 32px;">&#8358;{{$profit}}</span>
                                @else
                                <span class="text-danger" style="font-size: 32px;">&#8358;{{$profit}}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div style="float: left; display:inline-block">
                                <span>Total Sale :</span><br>
                                @if ($total > 0)
                                <span class="text-warning" style="font-size: 32px;">&#8358;{{$total}}</span>
                                @else
                                <span class="text-danger" style="font-size: 32px;">&#8358;{{$total}}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div style="float: left; display:inline-block">
                                <span>Total Order :</span><br>
                                <span style="font-size: 32px;">{{$transactions->count()}}</span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div style="float: left; display:inline-block">
                                <span>Delivered :</span><br>
                                <span style="font-size: 32px;">{{$delivered}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Order no.</th>
                                    <th>Total</th>
                                    <th>Commission</th>
                                    <th>Vendor</th>
                                    <th>Payment Mode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($transactions->count() >= 1)
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>{{$transaction->created_at}}</td>
                                            <td>{{$transaction->order_no}}</td>
                                            <td>&#8358; {{$transaction->total}}</td>
                                            <td><span class="text-success">{{$transaction->commission}}% (&#8358;{{(($transaction->total - $transaction->delivery_charge) * $transaction->commission)/100}})</span></td>
                                            <td>{{$transaction->name." (".$transaction->lga.")"}}</td>
                                            <td>{{$transaction->payment_mode}}</td>
                                            <td>
                                                @if ($transaction->cancelled == 0)
                                                    <span class="text-success">Delivered</span>
                                                @else
                                                    <span class="text-danger">Cancelled</span>
                                                @endif
                                            </td>
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
