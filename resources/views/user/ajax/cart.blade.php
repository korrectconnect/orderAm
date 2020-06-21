@if (!auth()->user())
    <div class="alert alert-secondary">
        <small><b>Login to view cart</b></small>
    </div>
@else
    @if ($carts->count() >= 1)
        @foreach($carts as $cart)
            <div class="clearfix cart-items">
                <div class="pull-left">
                <div class="update-product">
                    <a title="Increase item quantity" href="javascript:void()" id="increase-cart-btn" data-id="{{$cart->id}}"><i class="fa fa-plus-circle"></i></a>
                    <a title="Decrease item quantity" href="javascript:void()" id="decrease-cart-btn" data-id="{{$cart->id}}"><i class="fa fa-minus-circle"></i></a>
                </div>
                </div>
                    <div class="cart-product-name pull-left">{{$cart->name}}</div>
                    <span class="cart-product-price pull-right text-spl-color pull-left">Qty: {{$cart->quantity}}</span>
                    <div class="cart-product-price pull-right text-spl-color f-r"><b>&#8358; {{$cart->price*$cart->quantity}}</b></div>
                    <div class="remove-cart-btn" ><a title="delete item from cart" id="remove-cart-btn" data-id="{{$cart->id}}" href="javascript:void()"><i class="fa fa-trash"></i></a></div>
                </div>
        @endforeach
    @else
        <div class="alert alert-secondary">
            <small><b><i class="fa fa-shopping-cart"></i> cart for this vendor is empty</b></small>
        </div>
    @endif
@endif
<hr>

<div class="cart-amount">
    Order Amount : <span>&#8358
        @if (auth()->user())
            @if ($carts->count() >= 1)
                {{$order_total}}
            @else
                0
            @endif
        @else
            0
        @endif
    </span>
</div>
<div class="cart-amount">
    Delivery Charge : <span>&#8358
        @if (auth()->user())
            @if ($carts->count() >= 1)
                {{$vendor->delivery_charge}}
            @else
                0
            @endif
        @else
            0
        @endif
    </span>
</div>
<div class="cart-amount">
    Tax : <span>&#8358
        @if (auth()->user())
            @if ($carts->count() >= 1)
                {{$vendor->vendor_charge + $vendor->tax}}
            @else
                0
            @endif
        @else
            0
        @endif
    </span>
</div>

<div class="cart-amount" id="couponDiv" >
    Coupon : <span>&#8358 <span id="couponSpan"></span> </span>
</div>
<hr>

<div class="cart-amount">
    <b>Total</b> : <span>&#8358
        @if (auth()->user())
            @if ($carts->count() >= 1)
            <span id="orderTotal">{{$total}}</span>
            @else
                0
            @endif
        @else
            0.00
        @endif
    </span>
</div>
<input type="hidden" id="orderTotalHidden" value="{{$total}}">
<input type="hidden" id="mCoupon" value="">
