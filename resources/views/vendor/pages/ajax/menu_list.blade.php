@if ($menus->count() >= 1)

    @foreach ($menus as $menu)

        <div class="row menuListWrap">
            <div class="col-sm-3">
                <div class="menuListImage" style="background-image:url('{{$menu->image}}');"></div>
            </div>
            <div class="col-sm-9">
                <span class="siteColor"><b>{{$menu->menu}}</b></span><br>
                <small>{{$menu->description}}</small><br>
                <span class="text-success"><b>&#8358; {{$menu->price}}</b></span><br>
                <small>
                    <a href="javascript:void()" data-href="{{route('vendor.menu.edit.form', ['id' => $menu->id])}}" id="editMenuBtn">Edit</a> &nbsp; / &nbsp;
                    <a href="javascript:void()" data-href="{{route('vendor.menu.delete', ['id' => $menu->id])}}" id="deleteMenuBtn">Delete</a> &nbsp;
                    @if ($menu->category != NULL)
                    / &nbsp;
                    @if ($menu->stock == 0)
                        <a href="javascript:void()" id="toggleMenuStock" data-href="{{route('vendor.menu.stock', ['id' => $menu->id])}}">Add to stock</a>
                    @else
                        <a href="javascript:void()" id="toggleMenuStock" data-href="{{route('vendor.menu.stock', ['id' => $menu->id])}}">Remove from stock</a>
                    @endif
                    @endif
                </small>
            </div>
        </div>

    @endforeach

@else
    <div class="alert alert-secondary">Oops No Menu here</div>
@endif
