@extends('dashboard.base')

@section('content')

<div class="col-sm-6">
    <div class="card">
      <div class="card-header"><strong>Add Menu</strong></div>
      <div class="card-body">
        <div class="form-group">
          <label for="company">Name</label>
          <input class="form-control" id="company" type="text" placeholder="Menu Title">
        </div>
        <div class="form-group">
          <label for="vat">Description</label>
          <input class="form-control" id="vat" type="text" placeholder="Menu Description">
        </div>
        <div class="form-group">
            <label for="street">category</label>
            <input class="form-control" id="street" type="text" placeholder="Category">
          </div>
          <div class="form-group">
            <label for="street">Price</label>
            <input class="form-control" id="street" type="text" placeholder="Eg 99.99">
          </div>
      </div>
    </div>
  </div>

@endsection

@section('javascript')

@endsection
