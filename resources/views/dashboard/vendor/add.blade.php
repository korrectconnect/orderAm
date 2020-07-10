@extends('dashboard.base')

@section('content')

<div class="col-sm-6">
    <div class="card">
      <div class="card-header"><strong>Add Vendors</strong></div>
      <div class="card-body">
        <div class="form-group">
          <label for="company">Name</label>
          <input class="form-control" id="company" type="text" placeholder="Enter your company name">
        </div>
        <div class="form-group">
          <label for="vat">Email</label>
          <input class="form-control" id="vat" type="text" placeholder="PL1234567890">
        </div>
        <div class="form-group">
            <label for="street">Address</label>
            <input class="form-control" id="street" type="text" placeholder="Enter street name">
          </div>
          <div class="form-group">
            <label for="street">Contact Info</label>
            <input class="form-control" id="street" type="text" placeholder="Enter street name">
          </div>
        <div class="form-group">
            <label for="street">State</label>
            <input class="form-control" id="street" type="text" placeholder="Enter street name">
          </div>
        <div class="row">
          <div class="form-group col-sm-8">
            <label for="city">LGA</label>
            <input class="form-control" id="city" type="text" placeholder="Enter your city">
          </div>
          <div class="form-group col-sm-4">
            <label for="postal-code">Postal Code</label>
            <input class="form-control" id="postal-code" type="text" placeholder="Postal Code">
          </div>
        </div>
        <!-- /.row-->
        <div class="form-group">
          <label for="country">Country</label>
          <input class="form-control" id="country" type="text" placeholder="Country name">
        </div>
      </div>
    </div>
  </div>

@endsection

@section('javascript')

@endsection
