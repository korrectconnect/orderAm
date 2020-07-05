@extends('admin.base')

@section('content')

<div class="row null" >

<div class="col-md-6">
    <div class="card">
      <div class="card-header"><i class="fa fa-align-justify"></i> <b>{{$vendor->name." . ".$vendor->lga}}</b></div>
      <div class="card-body">

        <div class="vendor-image" style="background-image:url('{{$vendor->image}}');"></div>
        <div class="table-responsive" style="max-height: 400px; overflow:auto;">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td><b>Name</b></td>
                        <td>{{ $vendor->name }}</td>
                    </tr>
                    <tr>
                        <td><b>Type</b></td>
                        <td>{{ $vendor->type }}</td>
                    </tr>
                    <tr>
                        <td><b>Email</b></td>
                        <td>{{ $vendor->email }}</td>
                    </tr>
                    <tr>
                        <td><b>Contact</b></td>
                        <td>{{ $vendor->contact }}</td>
                    </tr>
                    <tr>
                        <td><b>Address</b></td>
                        <td>{{ $vendor->address }}</td>
                    </tr>
                    <tr>
                        <td><b>LGA</b></td>
                        <td>{{ $vendor->lga }}</td>
                    </tr>
                    <tr>
                        <td><b>Zip</b></td>
                        <td>{{ $vendor->zip }}</td>
                    </tr>
                    <tr>
                        <td><b>State</b></td>
                        <td>{{ $vendor->state }}</td>
                    </tr>
                    <tr>
                        <td><b>Country</b></td>
                        <td>{{ $vendor->country }}</td>
                    </tr>
                    <tr>
                        <td><b>Status</b></td>
                        <td>
                            @if($vendor->status == 1)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Suspended</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

      </div>
    </div>
</div>

<div class="col-md-6">
    <div class="card">
        <div class="card-header"><i class="fa fa-align-justify"></i> <b>Menu List</b>
            <a href="#" style="float:right;" id="add_menu_btn" data-toggle="modal" data-target="#AddMenuFormModal" data-id="{{$vendor->id}}">Add Menu</a>
        </div>
        <div class="card-body">
            <a href="javascript:void()" id="refreshMenuBtn" onclick="refreshMenu('{{route('admin.refreshMenu', ['id' => $vendor->id])}}')">Refresh</a><br><br>
            <div style="width:100%; height:auto;" class="refreshMenuDiv card-overflow">
              @if ($menus->count() >= 1)
                  @foreach ($menus as $menu)
                  <div class="menu-vendor-div">
                      <div class="row null">
                          <div class="col-sm-4">
                              {{-- <div class="menu-vendor-image" style="background-image:url({{asset('storage/vendor/'.$menu->image)}});"></div> --}}
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

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    category
                    <button class="btn btn-sm btn-link addCategoryLink" data-id="{{$vendor->id}}" style="float:right;" data-toggle="modal" data-target="#menuCategoryModal">Add</button>
                </h4>

                <div class="card-text">
                    @if ($categories->count() >= 1)
                        @foreach ($categories as $category)
                            <div class="category-label bg-info" style="margin-bottom: 3px;">{{$category->category}} &nbsp; <button class="btn btn-sm btn-link deleteMenuCategory" data-href="{{route('admin.menu.category.delete', ['id' => $category->id])}}" style="color:#fff; margin-top:-4px;"><i class='fa fa-times-circle'></i></button></div>
                        @endforeach
                    @else
                        <center>Opps no category added yet. <a href="javascript:void()" data-toggle="modal" data-target="#menuCategoryModal" class="addCategoryLink" data-id="{{$vendor->id}}">Add Category</a></center>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    Authenticator

                    @if ($auth != NULL)
                        <button class="btn btn-sm btn-link" style="float:right;" id="authVendorResetBtn" >Reset</button>
                    @else
                        <button class="btn btn-sm btn-link" style="float:right;" id="authVendorBtn" >Authenticate</button>
                    @endif
                </h4>

                <form action="{{route('admin.vendor.auth')}}" method="POST" id="authVendorForm">
                    @csrf
                    <input type="hidden" name="id" value="{{$vendor->id}}">
                </form>

                @if ($auth != NULL)
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td><b>Account ID</b></td>
                                <td>{{ $auth->account_id }}</td>
                            </tr>
                            <tr>
                                <td><b>SuperAdmin Secret</b></td>
                                <td>{{ decrypt($auth->secret) }}</td>
                            </tr>
                        </tbody>
                    </table>
                @else

                    <div class="alert alert-secondary" style="font-size: 12px;">
                        Authentication ID has not been assigned to this vendor.<br> <button class="btn btn-sm btn-link" id="authVendorBtn" >Authenticate</button>
                    </div>

                @endif
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
