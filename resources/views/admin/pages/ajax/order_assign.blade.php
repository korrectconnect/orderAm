@if ($riders->count() >= 1)
    @foreach ($riders as $rider)

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location Assigned</th>
                    <th>Assigned Orders</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riders as $rider)

                    <tr>
                        <td>{{$rider->firstname}} {{$rider->lastname}}</td>
                        <td>
                            @if ($rider->location_assigned != NULL)
                                <span class="text-primary">{{$rider->location_assigned}}</span>
                            @else
                                <span class="text-danger">Unassigned</span>
                            @endif
                        </td>
                        <td>{{$rider->order_no}}</td>
                        <td>
                            @if($rider->active == NULL || $rider->active == 0)
                                <span class="badge badge-danger">Inactive</span>
                            @else
                                <span class="badge badge-success">Active</span>
                            @endif
                        </td>
                        <td><a href="javascript:void()" data-href="{{route('admin.order.confirm', ['id' => $rider->id, 'order' => $order->id])}}" id="confirmAssignOrderBtn">Assign Order</a></td>
                    </tr>

                @endforeach
            </tbody>
        </table>
    </div>

    @endforeach
@else
    <div class="alert alert-warning">
        No Rider has been assigned to vendors location<br><br>
        <b>City : {{$order->state}}<br>
        Lga : {{$order->lga}}</b>
    </div><br>

    <b>Select rider from other areas in {{$order->state}}</b>
    <div class="alert alert-secondary">

        @if ($other_riders->count() >= 1)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Location Assigned</th>
                            <th>Assigned Orders</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($other_riders as $other_rider)

                            <tr>
                                <td>{{$other_rider->firstname}} {{$other_rider->lastname}}</td>
                                <td>
                                    @if ($other_rider->location_assigned != NULL)
                                        <span class="text-primary">{{$other_rider->location_assigned}}</span>
                                    @else
                                        <span class="text-danger">Unassigned</span>
                                    @endif
                                </td>
                                <td>{{$other_rider->order_no}}</td>
                                <td>
                                    @if($other_rider->active == NULL || $other_rider->active == 0)
                                        <span class="badge badge-danger">Inactive</span>
                                    @else
                                        <span class="badge badge-success">Active</span>
                                    @endif
                                </td>
                                <td><a href="javascript:void()" data-href="{{route('admin.order.confirm', ['id' => $other_rider->id, 'order' => $order->id])}}" id="confirmAssignOrderBtn">Assign Order</a></td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-warning">There are no registered riders in <b>{{$order->state}}</b></div>
        @endif
    </div>
@endif
