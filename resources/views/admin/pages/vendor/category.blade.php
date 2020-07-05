@extends('admin.base')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form action="" method="POST" id="vendorCategoryForm">
                    <div class="card">
                        <div class="card-header">
                            <strong>Add Vendor Category</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="vendor-category-upload-image"></div>
                                    <input type="file" name="cover" id="vendor-category-file" style="display:none;">
                                    <small>Click the above box to select file</small>
                                </div>

                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input name="name" class="form-control" id="name" type="text" placeholder="Eg. Supermarket,Restaurant">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input name="description" class="form-control" id="description" type="text" placeholder="Eg. Foods you love">
                                    </div>
                                    <div class="form-group">
                                        <label for="commission">Commission (%)</label>
                                        <input name="commission" class="form-control" id="commission" type="number" placeholder="Eg. 7">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary btn-sm vendorCategoryBtn" style="float: right;">Continue</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Categories</strong>
                    </div>
                    <div class="card-body refreshVendorCategoryDiv">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
