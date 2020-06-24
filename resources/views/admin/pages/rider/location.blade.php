@extends('admin.base')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Locations</strong>
                    </div>
                    <div class="card-body " style="max-height: 400px; overflow:auto;">
                        @if ($locations->count() >= 1)
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Location</th>
                                        <th>Assigned Riders</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($locations as $location)
                                        <tr>
                                            <td>{{$location->name}}</td>
                                            <td>{{$location->location_assigned}}</td>
                                            <td><a href="javascript:void();"  data-href="{{route('admin.rider.location.assign', ['location' => $location->name])}}" id="viewRiderAssignBtn">View</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-secondary">
                                    No rider has been assigned to any location yet
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Rider List</strong>
                    </div>
                    <div class="card-body" id="viewRiderAssignDiv">
                        <i>Click on <b>view</b> to see list of riders assigned to a location here</i>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
