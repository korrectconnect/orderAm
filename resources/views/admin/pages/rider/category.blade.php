@extends('admin.base')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form data-href="{{route('admin.rider.category')}}" method="POST" id="riderCategoryForm">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <strong>Add Riders Category</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <input name="category" class="form-control" id="category" type="text" placeholder="Eg. Bike, Bus">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary btn-sm " id="riderCategoryFormBtn" style="float: right;"><i class='fa fa-plus-circle'></i> Add</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Categories</strong>
                    </div>
                    <div class="card-body refreshRidersCategoryDiv">
                        @if ($categories->count() >= 1)
                            @foreach ($categories as $category)
                                <div style="font-size: 15px; font-weight:bold; padding: 10px 20px; background-color:#eee; margin-bottom:10px;">
                                    {{$category->category}}
                                    <div style="display: inline-block; float:right;">
                                        <small>
                                            <a href="javascript:void();" data-href="{{route('admin.rider.category.delete', ['id' => $category->id])}}" class="text-danger" id="deleteRiderCategoryBtn"><i class="fa fa-trash"></i> Delete</a>
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-danger">
                                <small>You have not added any category for Riders <i class="fa fa-exclamation"></i></small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
