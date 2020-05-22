@extends('admin.base')

@section('content')

    <div class="row null">

        <div class="col-md-6">
            <div class="card">
            <div class="card-header"><i class="fa fa-align-justify"></i> <b>Menu List</b>
                <a href="javascript:void()" style="float:right;" id="add_menu_btn" data-toggle="modal" data-target="#AddMenuFormModal" data-id="{{$vendor->id}}">Add Menu</a>
            </div>
            <div class="card-body">
                <a href="javascript:void()" id="refreshMenuBtn" onclick="refreshMenu({{$vendor->id}});">Refresh</a><br><br>
                <div style="width:100%; height:auto;" class="refreshMenuDiv card-overflow">
                  @if ($menus->count() >= 1)
                      @foreach ($menus as $menu)
                      <div class="menu-vendor-div">
                          <div class="row null">
                              <div class="col-sm-4">
                                  {{-- <div class="menu-vendor-image" style="background-image:url({{$menu->image}});"></div> --}}
                                  <img src="{{$menu->image}}" style="width:80px; height:80px; border-radius:10px;" alt="">
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
                  <div style="font-size: 14px; width: 100%; height:auto; text-align:center; padding-top:13px;" >No Menu Added<br><p><a href="javascript:void()" id="add_menu_btn" data-toggle="modal" data-target="#AddMenuFormModal" data-id="{{$vendor->id}}">Add Menu</a></p></div>
                  @endif
                </div>
              </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
            <div class="vendor-image card-img-top" style="background-image:url({{$vendor->image}}); height:250px;"></div>
                <div class="card-body">
                    <b>{{$vendor->name." . ".$vendor->lga}}</b>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        category
                        <button class="btn btn-sm btn-link addCategoryLink" data-id="{{$vendor->id}}" style="float:right;" data-toggle="modal" data-target="#menuCategoryModal">Add</button>
                    </h4>

                    <div class="card-text">
                        @if ($categories->count() >= 1)
                            <form action="{{route('admin.menu_category.delete')}}" method="post" class="deleteMenuCategoryForm">
                                <input type="hidden" name="category_id" class="category_id" >
                            </form>
                            @foreach ($categories as $category)
                                <div class="category-label bg-info">{{$category->category}} &nbsp; <button data-id="{{$category->id}}" class="btn btn-sm btn-link deleteMenuCategory" style="color:#fff; margin-top:-4px;">X</button></div>
                            @endforeach
                        @else
                            <center>Opps no category added yet. <a href="javascript:void()" data-toggle="modal" data-target="#menuCategoryModal" class="addCategoryLink" data-id="{{$vendor->id}}">Add Category</a></center>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($categories->count() >= 1)
        @foreach ($categories as $category)
            <script>
                appendMenuCategory("{{$category->category}}");
            </script>
        @endforeach
    @endif

    <script>
        $("#add_menu_btn").click(function() {
            $(".modal-title").html("{{$vendor->name}} &nbsp; &nbsp; <span style='font-size:12px;'>{{$vendor->type.' . '.$vendor->lga}}</span>");
            //$(".modal-body").html("<center><i class='fa fa-spinner fa-2x fa-spin'></i></center>");
            var id = $(this).data('id');
            $("#vendor_id").val(id);
            $("#menu_refresh_id").attr("data-id","{{$vendor->id}}");
        });
    </script>

@endsection

@section('javascript')

@endsection
