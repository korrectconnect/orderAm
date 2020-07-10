@extends('admin.base')

@section('content')

<div class="col-lg-12">
    <div class="card">
      <div class="card-header"><i class="fa fa-align-justify"></i> <b>All Riders</b></div>
      <div class="card-body">
        <table class="table table-responsive-sm table-striped">
          <thead>
            <tr>
              <th>Date registered</th>
              <th>Fullname</th>
              <th>City</th>
              <th>Status</th>
              <th>Location assigned</th>
              <th>Pending Orders</th>
              <th>company</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if ($riders->count() >= 1)

                @foreach ($riders as $rider)
                    <tr id="rider_{{$rider->id}}">
                        <td>{{ $rider->created_at }}</td>
                        <td>{{ $rider->firstname }} {{ $rider->lastname }}</td>
                        <td>{{ $rider->state }}</td>
                        <td>
                            @if($rider->active == NULL || $rider->active == 0)
                                <span class="badge badge-danger">Inactive</span>
                            @else
                                <span class="badge badge-success">Active</span>
                            @endif
                        </td>
                        <td>
                            @if ($rider->location_assigned == NULL)
                                <span class="text-danger">
                                    Unassigned
                                </span>
                            @else
                                {{$rider->location_assigned}}
                            @endif
                        </td>
                        <td><a href="javascript:void()" id="viewRiderOrdersBtn" data-href="{{route('admin.ajax.rider.orders', ['id' => $rider->id])}}"><small>(click to view)</small></a></td>
                        <td>
                            @if ($rider->company == NULL)
                                <span class="text-warning">None</span>
                            @else
                                <span class="text-warning">{{$rider->company}}</span>
                            @endif
                        </td>
                        <td style="font-size:12px;">

                            <a href="{{route('admin.rider.single', ['id' => $rider->id])}}">View</a> &nbsp; / &nbsp;
                            <a href="javascript:void()" id="assignRiderBtn" data-href="{{route('admin.rider.assign', ['id' => $rider->id])}}">Assign Location</a> &nbsp; / &nbsp;
                            <a href="{{route('admin.rider.edit.form', ['id' => $rider->id])}}">Edit</a>

                        </td>
                    </tr>

                @endforeach
            @endif
          </tbody>
        </table>
        @if ($riders->count() >= 10)

            <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Prev</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>

        @endif
      </div>
    </div>
  </div>

@endsection

@section('javascript')

@endsection
