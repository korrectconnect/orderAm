
<div class="card-header">
    <strong>
        @if ($cancelled == 1)
            <i class="siteColor fa fa-times-circle"></i> Cancelled Orders
        @else
            @if ($status == 0)
                <i class="siteColor fa fa-list"></i> Incoming Orders
            @elseif($status == 1)
                <i class="siteColor fa fa-biking"></i> Pending Delivery
            @elseif($status == 2)
                <i class="siteColor fa fa-check-circle"></i> Delivered
            @endif
        @endif
    </strong>
</div>

<div class="card-body">
    @if ($orders->count() >= 1)
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><i class="fa fa-clock"></i></th>
                    <th>Order no.</th>
                    <th>Payment Mode</th>
                    <th>Total</th>
                    <th>Delivery Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            @foreach ($orders as $order)

                <tr>
                    <td>{{$order->created_at}}</td>
                    <td>{{$order->order_no}}</td>
                    <td>{{$order->payment_mode}}</td>
                    <td>&#8358;{{$order->total}}</td>
                    <td>
                        @if ($order->delivery_time == NULL)
                            As  soon as possible
                        @else
                            {{$order->delivery_time}}
                        @endif
                    </td>
                    <td><a data-href="{{route('vendor.ajax.order', ['order_no' => $order->order_no])}}" href="javascript:void()" id="view_order">View</a></td>
                </tr>

            @endforeach

            </tbody>
        </table>
    </div>
    @else
        <center>
            <p><i class="fa fa-search"></i>&nbsp; No order here</p>
        </center>
    @endif

</div>
