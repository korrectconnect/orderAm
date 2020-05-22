@extends('admin.base')

@section('content')

<div class="col-lg-12">
    <div class="card">
      <div class="card-header"><i class="fa fa-align-justify"></i> <b>All Vendors</b></div>
      <div class="card-body">
        <table class="table table-responsive-sm table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Type</th>
              <th>Date registered</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($query as $each)
                <tr id="vendor_{{$each->id}}">
                    <td>{{ $each->name }}</td>
                    <td>{{ $each->type }}</td>
                    <td>{{ date('H:m, d/m/Y',strtotime($each->updated_at)) }}</td>
                    <td>
                        @if($each->status == 1)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Suspended</span>
                        @endif
                    </td>
                    <td style="font-size:12px;">
                        <a href="javascript:void()" data-toggle="modal" data-target="#myModal" id="view_btn_{{$each->id}}" data-id="{{$each->id}}">View</a> / <a href="#">Edit</a> / <a href="javascript:void()" data-toggle="modal" data-target="#deleteModal" id="delete_vendor_{{$each->id}}" data-id="{{$each->id}}">Delete</a>

                        <script>

                            $("#view_btn_{{$each->id}}").click(function() {
                                $(".vendor-modal-title").html("{{$each->name}}");
                                $(".vendor-modal-body").html("<center><i class='fa fa-spinner fa-2x fa-spin'></i></center>");
                                $("#moreVendorID").val("{{$each->id}}");
                                var id = $(this).data('id');
                                $.ajax({
                                    url: "ajax/viewVendor/" + id,
                                    method: 'get',
                                    success: function(data) {
                                        $(".vendor-modal-body").html(data);
                                    }
                                });
                            });

                            $("#delete_vendor_{{$each->id}}").click(function() {
                                $("#deleteVendorName").html("{{$each->name.'('.$each->lga.')'}}");
                                $("#delete_vendor_link").val("{{route('admin.vendor.delete',['id' => $each->id])}}");
                                $("#delete_vendor_id").val("{{$each->id}}");
                            });

                        </script>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        @if ($query->count() >= 10)

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

  <script src="{{asset('js/req.js')}}"></script>

@endsection

@section('javascript')

@endsection
