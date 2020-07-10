@extends('admin.base')

@section('content')

<div class="row null" >

<div class="col-md-6">
    <div class="card">
      <div class="card-header"><i class="fa fa-align-justify"></i> &nbsp; <b>{{$rider->firstname." ".$rider->lastname}} (Rider)</b></div>
      <div class="card-body">

        <center>
            <div class="passport-container">
                <div class="cover-image" style="background-image:url('{{$rider->image}}');"></div>
            </div>
        </center>
        <div style="margin-top: 20px;">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td><b>Status</b></td>
                        <td>
                            @if($rider->active != NULL)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">inActive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><b>Username</b></td>
                        <td>{{ $rider->username}}</td>
                    </tr>
                    <tr>
                        <td><b>Category</b></td>
                        <td>
                            @if ($rider->category == "Bike")
                                <i class="fa fa-biking"></i> &nbsp;
                            @endif
                            @if ($rider->category == "Car")
                                <i class="fa fa-car"></i> &nbsp;
                            @endif
                            @if ($rider->category == "Bus")
                                <i class="fa fa-bus"></i> &nbsp;
                            @endif

                            {{ $rider->category }}
                        </td>
                    </tr>
                    <tr>
                        <td><b>Location Assigned</b></td>
                        <td>
                            @if ($rider->location_assigned == NULL)
                                <span class="text-danger">Unassigned</span>
                            @else
                                {{ $rider->location_assigned }}
                                @if ($rider->location_description !== NULL)
                                    - <small>{{$rider->location_description}}</small>
                                @endif
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><b>Vehicle Plate</b></td>
                        <td>{{ $rider->plate_number }}</td>
                    </tr>
                    <tr>
                        <td><b>Company</b></td>
                        <td>{{ $rider->company }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

      </div>
    </div><br>
</div>

<div class="col-md-6">
    <div class="card">
      <div class="card-header"><i class="fa fa-align-justify"></i> <b>More</b></div>
      <div class="card-body">
        <div style="margin-top: 0px;">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td><b>Email</b></td>
                        <td>{{ $rider->email }}</td>
                    </tr>
                    <tr>
                        <td><b>Fullname</b></td>
                        <td>{{$rider->firstname." ".$rider->lastname}}</td>
                    </tr>
                    <tr>
                        <td><b>Contact</b></td>
                        <td>{{ $rider->phone }}</td>
                    </tr>
                    <tr>
                        <td><b>Address</b></td>
                        <td>{{ $rider->address }}</td>
                    </tr>
                    <tr>
                        <td><b>LGA</b></td>
                        <td>{{ $rider->lga }}</td>
                    </tr>
                    <tr>
                        <td><b>State</b></td>
                        <td>{{ $rider->state }}</td>
                    </tr>
                    <tr>
                        <td><b>Country</b></td>
                        <td>{{ $rider->country }}</td>
                    </tr>
                    <tr>
                        <td><b>Date Of Birth</b></td>
                        <td>{{ $rider->date_of_birth }}</td>
                    </tr>
                    <tr>
                        <td><b>Spouse Name</b></td>
                        <td>
                            {{$rider->spouse_name}}
                        </td>
                    </tr>
                    <tr>
                        <td><b>Spouse Phone</b></td>
                        <td>
                            {{$rider->spouse_phone}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

      </div>
    </div>
</div>

</div>

@endsection

@section('javascript')

@endsection
