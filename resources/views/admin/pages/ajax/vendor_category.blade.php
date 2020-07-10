@if ($categories->count() >= 1)
                            @foreach ($categories as $category)
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="vendor-category-image-div" style="background-image: url('{{$category->image}}')"></div>
                                    </div>
                                    <div class="col-sm-8">
                                        <br>
                                        <span style="font-size: 18px; color:rgb(243, 177, 54);"><strong>{{$category->name}}</strong></span><br>
                                        <span style="font-size: 13px;">{{$category->description}}</span>
                                        <button class="btn btn-sm btn-link" id="deleteVendorCategoryBtn" data-id="{{$category->id}}" style="margin-top:-40px; float:right;"><i class="fa fa-trash fa-1x text-danger"></i></button>
                                    </div>
                                </div><br>
                            @endforeach
                        @else
                            <div class="alert alert-danger">
                                <small>You have not added any category for vendors <i class="fa fa-exclamation"></i></small>
                            </div>
                        @endif
