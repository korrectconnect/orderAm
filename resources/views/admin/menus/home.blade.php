@extends('admin.base')

@section('content')

<div class="row null" >

<div class="col-md-6">
    <div class="card">
      <div class="card-header"><i class="fa fa-align-justify"></i> <b>Choose Vendor</b></div>
      <div class="card-body">

            <input type="text" id="vendor-search" oninput="searchVendor(this)" class="form-control search-vendor" placeholder="Search Vendors">
        <div class="menuSearchDiv card-overflow" style="width:100%; height:auto;">
        @foreach ($vendors as $vendor)

            <div class="menu-vendor-div">
                <div class="row null">
                    <div class="col-sm-4">
                        <div class="menu-vendor-image" style="background-image:url({{asset('storage/vendor/'.$vendor->image)}});"></div>
                    </div>
                    <div class="col-sm-8">
                        <div class="menu-vendor-txt">
                            <b>{{$vendor->name}}</b><br>
                            <small>Rating - 0</small><br>

                            <span style="font-size:12px;">
                                {{$vendor->lga." . ".$vendor->type}}
                            </span>

                            <div style="display:inline-block; float:right; font-size:13px;">
                                <a href="#" id="add_btn_{{$vendor->id}}" data-toggle="modal" data-target="#AddMenuFormModal" data-id="{{$vendor->id}}">Add Menu</a> | <a href="menus/view/{{$vendor->id}}">View Menu</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>

                $("#add_btn_{{$vendor->id}}").click(function() {
                    $("#menu-category").html("");
                    $("#menu_category_loader").html("<i class='fa fa-spin fa-spinner'></i> Fetching Categories");
                    $.ajax({
                        url:"ajax/getMenuCategoryList/{{$vendor->id}}",
                        type: "GET",
                        success: function(e) {
                            $("#menu-category").html(e);
                            if(e == "false") {
                                $("#menu_category_loader").html("<i class='fa fa-check text-success'></i> No category found");
                            }else {
                                $("#menu_category_loader").html("<i class='fa fa-check text-success'></i> Categories Fetched");
                            }
                        }
                    });
                    $(".modal-title").html("{{$vendor->name}} &nbsp; &nbsp; <span style='font-size:12px;'>{{$vendor->type.' . '.$vendor->lga}}</span>");
                    //$(".modal-body").html("<center><i class='fa fa-spinner fa-2x fa-spin'></i></center>");
                    var id = $(this).data('id');
                    $("#vendor_id").val(id);

                });

            </script>

        @endforeach
      </div>

      </div>
    </div>
</div>

<div class="col-md-6">
    <div class="card">
        <div class="card-header"><i class="fa fa-align-justify"></i> <b>Menu</b></div>
        <div class="card-body">
          Recently added &nbsp; <a href="javascript:void()" id="refreshMenuBtn" onclick="refreshMenus();">Refresh</a><br><br>
          <div style="width:100%; height:auto;" class="refreshMenuDiv card-overflow">
            @if ($menus->count() >= 1)
                @foreach ($menus as $menu)
                <div class="menu-vendor-div">
                    <div class="row null">
                        <div class="col-sm-4">
                            {{-- <div class="menu-vendor-image" style="background-image:url({{asset('storage/vendor/'.$menu->image)}});"></div> --}}
                            <img src="{{asset('storage/menu/'.$menu->image)}}" style="width:80px; height:80px; border-radius:10px;" alt="">
                        </div>
                        <div class="col-sm-8">
                            <div class="menu-vendor-txt">
                                <b>{{$menu->menu}}</b><br>

                                <span style="font-size:12px;">
                                    {{$menu->name}}
                                </span><br>

                                <small>{{$menu->category." . ".$menu->description}}</small><br>

                                <div style="display:inline-block; float:right; font-size:13px; color:rgb(0, 0, 150); margin-top:-60px;">
                                     &#8358; {{$menu->price}}
                                </div>

                                <div style="display:inline-block; float:right; font-size:12px; margin-top:-20px;">
                                    <a href="javascript:void()" id="deleteMenu_{{$menu->id}}" data-id="{{$menu->id}}" data-link="{{route('admin.menu.delete',['id' => $menu->id])}}" style="color:rgb(150, 0, 0);"><i class='fa fa-trash'></i> Delete</a>
                                    <script>
                                        $("#deleteMenu_{{$menu->id}}").click(function() {
                                            var link = $(this).data("link");
                                            $("#deleteMenu_{{$menu->id}}").html("<i class='fa fa-spin fa-spinner'></i>");

                                            deleteMenu(link);
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
            <div style="font-size: 14px; width: 100%; height:auto; text-align:center; padding-top:13px;" >No Menu Added<br><p><small>Click on a vendor to add menu</small></p></div>
            @endif
          </div>
        </div>
    </div>
</div>

</div>

  <script>

  </script>

  {{-- <script src="{{asset('js/req.js')}}"></script> --}}

@endsection

@section('javascript')

@endsection
