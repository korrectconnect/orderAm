@foreach ($vendors as $vendor)

            <div class="menu-vendor-div">
                <div class="row null">
                    <div class="col-sm-4">
                        <div class="menu-vendor-image" style="background-image:url({{$vendor->image}});"></div>
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
