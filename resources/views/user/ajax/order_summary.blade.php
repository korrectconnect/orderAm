<h3>Order Summary</h3>
<div class="myscrollW" style="width: auto; height:auto; max-height:100px; overflow:auto; margin-bottom:15px;">

    @if ($carts->count() >= 1)
        @foreach ($carts as $cart)
            <div class="order-summary-list">
                <span class="cart-product-name">{{$cart->name}}</span> &nbsp; &nbsp;
                <span>Qty: <b>{{$cart->quantity}}</b></span>
            </div>
        @endforeach

        <div class="cart-amount">
            Order Amount : <span>&#8358 {{$order_total}} </span>
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
        {{$address->address}}<br>
        {{$address->lga." (".$address->state.")"}}<br>
        @if ($address->description !== NULL)
            <small>({{$address->description}})</small><br>
        @endif
    </div>
</div>

<div>
    @if ($type == "card")
        Pay Online(PayStack) <i class="fa fa-credit-card"></i>
    @else
        Pay on delivery <i class="fa fa-handshake"></i>
    @endif

    @if ($coupon != NULL)
        <b class="f-r">Coupon : {{$coupon->code}} </b>
    @endif
</div><br>

<div>
    <form action="{{route('user.order.place')}}" method="POST" id="placeOrderForm">
        @csrf
        <input type="hidden" name="address" id="placeOrderAddress" value="{{$address->id}}">
        <input type="hidden" name="vendor" id="placeOrderVendor" value="{{$vendor->id}}">
        @if ($coupon != NULL)
            <input type="hidden" name="coupon" id="placeOrderCoupon" value="{{$coupon->code}}">
        @else
            <input type="hidden" name="coupon" id="placeOrderCoupon" value="{{$coupon}}">
        @endif
        <input type="hidden" name="payment_type" id="placeOrderPaymentType" value="{{$type}}">
        <input type="hidden" name="transaction" id="placeOrderTransactionId" value="">
    </form>

    <b class="f-l">Total: &#8358;{{$total}}</b>
    @if ($type == "cash")
        <button class="btn btn-sm btn-primary" id="btncCashPlaceOrder" style="float: right;">Place Order</button>
    @else
        <button class="btn btn-sm btn-primary" id="btnCardPlaceOrder" style="float: right;">Place Order</button>
    @endif
</div>

<script>
    $('#btncCashPlaceOrder').click(function() {
            $("#btncCashPlaceOrder").prop('disabled', true);
            $("#placeOrderForm").submit();
    });

    $('#btnCardPlaceOrder').click(function() {
        $("#btnCardPlaceOrder").prop('disabled', true);
        alert("Payment Gateway API is called");
    });
</script>
