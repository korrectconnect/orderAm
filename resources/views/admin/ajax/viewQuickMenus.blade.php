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

                                            deleteMenu(link,"{{$menu->vendor_id}}");
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
