
@if ($menus->count() >= 1)

<form action="" method="POST" id="addToCartForm">
    @csrf
    <input type="hidden" name="menu_id" value="" id="inputCartMenuID">
    <input type="hidden" name="vendor_id" value="{{$vendor_id}}" id="inputCartVendorID">
</form>

    @foreach ($menus as $menu)

        <div class="row menuListWrap">
            <div class="col-sm-3">
                <div class="menuListImage" style="background-image:url('{{$menu->image}}');"></div>
            </div>
            <div class="col-sm-9">
                <span class="siteColor"><b>{{$menu->menu}}</b></span><br>
                <small>{{$menu->description}}</small><br>
                <span class="text-success"><b>&#8358; {{$menu->price}}</b></span>
                @if ($menu->stock == 1)
                    <div class="addToCartBtn" id="cart_btn_{{$menu->id}}" data-menu="{{$menu->id}}"><i class="fa fa-plus"></i> Add <i class="fa fa-shopping-cart"></i></div>
                @else
                    <div class="outOfStockBtn">Out of stock</div>
                @endif
            </div>
        </div>

    @endforeach

@else
    Oops No Menu here
@endif
