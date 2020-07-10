
<div class="card-header">
    <strong>
        Transactions from <i>{{$start}}</i> to <i>{{$end}}</i>
    </strong>
</div>

<div class="card-body">
    @if ($orders->count() >= 1)
    <div class="row">
        <div class="col-md-3">
            <div style="float: left; display:inline-block">
                <span>Todays Balance :</span><br>
                @if ($total > 0)
                <span class="text-success" style="font-size: 32px;">&#8358;{{$total}}</span>
                @else
                <span class="text-danger" style="font-size: 32px;">&#8358;{{$total}}</span>
                @endif
            </div>
        </div>

        <div class="col-md-3">
            <div style="float: left; display:inline-block">
                <span>Commission :</span><br>
                <span class="text-danger" style="font-size: 32px;">&#8358;{{$commission}}</span>
            </div>
        </div>

        <div class="col-md-3">
            <div style="float: left; display:inline-block">
                <span>Real Profit :</span><br>
                @if ($profit > 0)
                <span class="text-success" style="font-size: 32px;">&#8358;{{$profit}}</span>
                @else
                <span class="text-danger" style="font-size: 32px;">&#8358;{{$profit}}</span>
                @endif
            </div>
        </div>

        <div class="col-md-3">
            <div style="float: left; display:inline-block">
                <span>Total Order :</span><br>
                <span style="font-size: 32px;">{{$orders->count()}}</span>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><i class="fa fa-clock"></i></th>
                    <th>Order no.</th>
                    <th>Payment Mode</th>
                    <th>Total</th>
                    <th>Commission</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            @foreach ($orders as $order)

                <tr>
                    <td>{{$order->updated_at}}</td>
                    <td>{{$order->order_no}}</td>
                    <td>{{$order->payment_mode}}</td>
                    <td>&#8358;{{($order->total - $order->delivery_charge)}}</td>
                    <td>{{$order->commission}}% (&#8358;{{(($order->total - $order->delivery_charge) * $order->commission)/100}})</td>
                    <td><a data-href="{{route('vendor.ajax.order', ['order_no' => $order->order_no])}}" href="javascript:void()" id="view_order">View</a></td>
                </tr>

            @endforeach

            </tbody>
        </table>
    </div>
    @else
        <center>
            <p><i class="fa fa-list"></i>&nbsp; No order here</p>
        </center>
    @endif

</div>
