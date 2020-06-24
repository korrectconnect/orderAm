@extends('vendor.base')

@section('content')

    <div class="admin-container-wrapper">

        <div class="container">

            <div class="GridLex-gap-15-wrappper">

                <div class="GridLex-grid-noGutter-equalHeight">

                    @include('vendor.inc.menu')

                    <div class="GridLex-col-9_sm-8_xs-12">

                        <div class="admin-content-wrapper">

                            <h2>Menu List</h2>

                            <!-- {{route('vendor.ajax.orders', ['status' => 0, 'cancelled' => 0])}} -->
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="alert alert-secondary">
                                        @if ($menu_categories->count() >= 1)
                                            @foreach ($menu_categories as $menu_category)
                                                <div class="menuCategoryBtn" id="menuCategoryBtn_{{$menu_category->id}}" data-href="{{route('vendor.menu_list', ['category' => $menu_category->category])}}">
                                                    {{$menu_category->category}}
                                                </div>
                                            @endforeach
                                            <div class="menuCategoryBtn" style="margin-left: 30px !important;" id="menuCategoryBtn_unsorted" data-href="{{route('vendor.menu_list', ['category' => 'NULL'])}}">
                                                Unsorted
                                            </div>
                                        @else
                                                <small>No menu category added yet</small>
                                        @endif
                                    </div>

                                    <div class="card shadow-sm menuListDiv">

                                        <center><i class='fa fa-spin fa-circle-notch fa-2x'></i></center>

                                    </div><br>
                                </div>

                                <div class="col-md-3">
                                    @if ($auth == true)
                                        <a href="javascript:void()" id="addMenuBtn" data-href="{{route('vendor.menu.add')}}"><i class="fa fa-plus-circle"></i> Add Menu</a><br>
                                        <a href="javascript:void()" id="addMenuCategoryBtn" data-href="{{route('vendor.menu_category.add')}}"><i class="fa fa-plus-circle"></i> Add Menu Category</a><br><br>
                                        <div class="alert alert-secondary">
                                            <h3>Menu Categories</h3>
                                            @if ($menu_categories->count() >= 1)
                                                @foreach ($menu_categories as $menu_category)
                                                    <div style="font-size: 12px;">{{$menu_category->category}} &nbsp;
                                                        <a href="javascript:void()" id="editMenuCategoryBtn" data-href="{{route('vendor.menu_category.edit.form', ['id' => $menu_category->id])}}">Edit</a>/
                                                        <a href="javascript:void()" id="deleteMenuCategoryBtn" data-href="{{route('vendor.menu_category.delete', ['id' => $menu_category->id])}}">Delete</a></div>
                                                @endforeach
                                            @else
                                                    <small>No menu category added yet</small>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
