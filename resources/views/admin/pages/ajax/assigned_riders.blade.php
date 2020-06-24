

@if ($riders->count() >= 1)

<div class="alert alert-secondary" style="font-weight: bold;"><i class="fa fa-location-arrow"></i> . {{$location}}</div>

<table class="table table-responsive-sm table-striped">
    <thead>
        <tr>
            <th>Fullname</th>
            <th>Category</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($riders as $rider)
            <tr>
                <td><a href="{{route('admin.rider.single', ['id' => $rider->id])}}">{{$rider->firstname." ".$rider->lastname}}</a></td>
                <td>{{$rider->category}}</td>
                <td>{{$rider->location_description}}</td>
                <td><a href="javascript:void();" data-href="{{route('admin.rider.unassign', ['id' => $rider->id])}}" id="unassignRiderBtn">Unassign</a></td>
            </tr>
        @endforeach
    </tbody>
</table>

@else
    <div class="alert alert-secondary">
        No Rider has been assigned to <b>{{$location}}</b>
    </div>
@endif
