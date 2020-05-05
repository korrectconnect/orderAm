@extends('admin.base')

@section('content')

<form action="{{route('admin.vendor.add')}}" method="POST" enctype="multipart/form-data" id="addVendor" >
    @csrf

<div class="row" style="margin: 0px !important; padding: 0px !important;">

<div class="col-sm-6">
    <div class="card">
      <div class="card-header"><strong>Add Vendors</strong></div>
      <div class="card-body">
        <div class="form-group">
          <label for="company">Name</label>
          <input name="name" class="form-control" id="company" type="text" placeholder="Enter your company name">
        </div>
        <div class="form-group">
          <label for="vat">Email</label>
          <input name="email" class="form-control" id="vat" type="text" placeholder="Eg a@b.com">
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <input name="type" class="form-control" id="type" type="text" placeholder="Eg Resturants/Groceries">
          </div>
        <div class="form-group">
            <label for="street">Address</label>
            <input name="address" class="form-control" id="street" type="text" placeholder="Ful address">
          </div>
          <div class="form-group">
            <label for="street">Contact Info</label>
            <input name="contact" class="form-control" id="street" type="text" placeholder="Eg +2348120198238">
          </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="street">State</label>
                <input name="state" class="form-control" id="street" type="text" placeholder="State">
            </div>
            <div class="form-group col-sm-6">
                <label for="country">Country</label>
                <input name="country" class="form-control" id="country" type="text" placeholder="Country name">
            </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-8">
            <label for="city">LGA</label>
            <input name="lga" class="form-control" id="city" type="text" placeholder="Enter your city">
          </div>
          <div class="form-group col-sm-4">
            <label for="postal-code">Postal Code</label>
            <input name="zip" class="form-control" id="postal-code" type="text" placeholder="Postal Code">
          </div>
        </div>
        <!-- /.row-->

        <div class="row">
          <div class="form-group col-sm-6">
            <label for="open">Opening Hours</label>
            <input name="open" class="form-control" id="open" type="text" placeholder="Eg 08.05">
          </div>
          <div class="form-group col-sm-6">
            <label for="close">Closing Hours</label>
            <input name="close" class="form-control" id="close" type="text" placeholder="Eg 18.00">
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="col-sm-6">
      <div class="card">

          <div class="card-header">
              Upload Cover
          </div>

          <div class="card-body">

            <div class="form-group">
               <label for="cover">Cover</label>
               <div class="cover-container">
                    <div class="cover-image"></div>
                    <div class="cover-txt">Click here to select image from file</div>
                </div>
               <input name="cover" class="form-control" style="display:none;" id="cover-file" type="file">
            </div>
            <div class="form-group">
               <label for="send"></label>
               <button id="send" class="btn btn-sm btn-danger form-control uploadVendorBtn" type="submit">Save & Upload</button>
            </div>
          </div>

      </div>
  </div>

</div>
</form>

@endsection

@section('javascript')

@endsection
