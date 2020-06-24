@extends('admin.base')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form action="" method="POST" id="addLocationForm">
                    <div class="card">
                        <div class="card-header">
                            <strong>Add Location</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="type">Name</label>
                                <select name="type" id="type" class="form-control">
                                    <option selected>State</option>
                                    <option>Lga</option>
                                    <option>area</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Location</label>
                                <input name="name" class="form-control" id="name" type="text" placeholder="Eg. Benin, Nigeria, Lekki">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary btn-sm addLocationBtn" style="float: right;">Continue</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Recently Added Locations</strong>
                    </div>
                    <div class="card-body refreshVendorLocationDiv">
                        @if ($locations->count() >= 1)
                            @foreach ($locations as $location)
                                <div class="alert alert-secondary">
                                    <i class="fa fa-location-arrow fa-2x"></i> &nbsp; {{$location->type." : ".$location->name}}
                                    <button class="btn btn-sm btn-link" id="deleteVendorLocationBtn" data-id="{{$location->id}}" style="margin-top:0px; float:right;"><i class="fa fa-trash fa-1x text-danger"></i></button>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-danger">
                                <small>You have not added any location for vendors <i class="fa fa-exclamation"></i></small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
