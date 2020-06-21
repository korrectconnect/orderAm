<h3>Order Summary</h3>
<div class="myscrollW" style="width: auto; height:auto; max-height:100px; overflow:auto; margin-bottom:15px;">

    @if ($order_items->count() >= 1)
        @foreach ($order_items as $order_item)
            <div class="order-summary-list">
                <span class="cart-product-name">
                    <div style="margin-left: -10px; margin-top:-17px; margin-right:10px; color:#fff; padding:3px 6px 2px 6px; background-color:rgb(31, 143, 106); display: inline-block; "><i class="fa fa-hamburger"></i></div>
                     {{$order_item->name}}</span> &nbsp; &nbsp;
                <span>Qty: <b>{{$order_item->quantity}}</b></span>
            </div>
        @endforeach

        <div class="cart-amount">
            Order Amount : <span>&#8358 {{$order->total - $vendor->delivery_charge - ($vendor->vendor_charge + $vendor->tax)}} </span>
        </div>
        <div class="cart-amount">
            Delivery Charge : <span>&#8358 {{$vendor->delivery_charge}}</span>
        </div>
        <div class="cart-amount">
            Tax : <span>&#8358 {{$vendor->vendor_charge + $vendor->tax}}</span>
        </div>
        @if ($coupon != NULL)
        <div class="cart-amount" style="color: rgb(0, 200, 0);" >
            Coupon : <span>&#8358 -{{$coupon->amount}} </span>
        </div>
        @endif
    @endif

</div>

<div class="myscrollW" style="width: auto; height:auto; max-height:150px; overflow:auto; margin-bottom:15px;">
    <div class="siteColor" style="font-size:15px; margin-bottom:4px; font-weight:bold;"><i class="fa fa-location-arrow"></i> Deliver to</div>
    <div style="font-size: 12px;">
        {{$user->firstname." ".$user->lastname}}<br>
        {{$address->address}}<br>
        {{$address->lga." (".$address->state.")"}}<br>
        @if ($address->description !== NULL)
            <small>({{$address->description}})</small><br>
        @endif
    </div>
</div>

<div>
    @if ($order->payment_mode == "card")
        Pay Online(PayStack) <i class="fa fa-credit-card"></i>
    @else
        Pay on delivery <i class="fa fa-handshake"></i>
    @endif

    @if ($coupon != NULL)
        <b class="f-r">Coupon : {{$coupon->code}} </b>
    @endif
</div>
<div style="font-size: 12px; margin: 5px 0px 5px 0px; font-weight:bold;">Delivery time :
    @if ($order->delivery_time == NULL)
        <span class="text-danger">As soon as possible</span>
    @else
        <span class="text-success">{{$order->delivery_time}}</span>
    @endif
</div>

<div>

    <b class="f-l">Total: &#8358;{{$order->total}}</b>
    @if ($order->status == 0 && $order->cancelled == 0)
        <div class="f-r" style="display:inline-block;">
            <button class="btn btn-xs btn-success" id="confirmOrderBtn" data-href="{{route('vendor.order.confirm', ['order_no' => $order->order_no])}}">Confirm</button>
            <button class="btn btn-xs btn-danger" id="declineOrderBtn" data-href="{{route('vendor.order.decline', ['order_no' => $order->order_no])}}">Decline</button>
        </div>
    @endif

</div>
