<div class="cover-image" style="background-image:url({{asset('storage/vendor/'.$query->image)}});">

</div>

<small>Opening Hour : {{$query->opening}} | Closing Hour : {{$query->closing}} </small><br><br>


<div class="row">
    <div class="col-sm-6">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td><b>Name</b></td>
                    <td>{{ $query->name }}</td>
                </tr>
                <tr>
                    <td><b>Type</b></td>
                    <td>{{ $query->type }}</td>
                </tr>
                <tr>
                    <td><b>Email</b></td>
                    <td>{{ $query->email }}</td>
                </tr>
                <tr>
                    <td><b>Contact</b></td>
                    <td>{{ $query->contact }}</td>
                </tr>
                <tr>
                    <td><b>Status</b></td>
                    <td>
                        @if($query->status == 1)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Suspended</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="col-sm-6">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td><b>Address</b></td>
                    <td>{{ $query->address }}</td>
                </tr>
                <tr>
                    <td><b>LGA</b></td>
                    <td>{{ $query->lga }}</td>
                </tr>
                <tr>
                    <td><b>Zip</b></td>
                    <td>{{ $query->zip }}</td>
                </tr>
                <tr>
                    <td><b>State</b></td>
                    <td>{{ $query->state }}</td>
                </tr>
                <tr>
                    <td><b>Country</b></td>
                    <td>{{ $query->country }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
