<h3>Order Summary</h3>
<div class="myscrollW" style="width: auto; height:auto; max-height:100px; overflow:auto; margin-bottom:15px;">

    @if ($order_items->count() >= 1)
        @foreach ($order_items as $order_item)
            <div class="order-summary-list">
                <span class="cart-product-name">{{$order_item->name}}</span> &nbsp; &nbsp;
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
        {{auth()->user()->firstname." ".auth()->user()->lastname}}<br>
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
</div><br>

<div>

    <b class="f-r">Total: &#8358;{{$order->total}}</b>

</div>
