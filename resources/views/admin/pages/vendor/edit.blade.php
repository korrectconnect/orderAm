@extends('admin.base')

@section('content')

<form data-href="{{route('admin.vendor.edit')}}" enctype="multipart/form-data" id="editVendorForm" >
    @csrf

    <input type="hidden" name="id" value="{{$vendor->id}}">

<div class="row" style="margin: 0px !important; padding: 0px !important;">

<div class="col-sm-6">
    <div class="card">
      <div class="card-header"><strong>Edit Vendors</strong></div>
      <div class="card-body">
        <div class="form-group">
          <label for="name">Name</label>
          <input name="name" class="form-control" id="name" type="text" value="{{$vendor->name}}">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input name="email" class="form-control" id="email" type="text" value="{{$vendor->email}}">
        </div>
        <div class="form-group">
            <label for="description">Short description</label>
            <input name="description" class="form-control" id="description" type="text" value="{{$vendor->description}}">
          </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" class="form-control" id="type">
                        <option value="{{$vendor->type}}">{{$vendor->type}}</option>
                        @foreach ($categories as $category)
                            @if ($category->name != $vendor->type)
                                <option>{{$category->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tax">Tax</label>
                    <input name="tax" class="form-control" id="tax" type="text" value="{{$vendor->tax}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="delivery_charge">Delivery Charge</label>
                    <input name="delivery_charge" class="form-control" id="delivery_charge" type="text" value="{{$vendor->delivery_charge}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="vendor_charge">Vendor Charge</label>
                    <input name="vendor_charge" class="form-control" id="vendor_charge" type="text" value="{{$vendor->vendor_charge}}">
                </div>
            </div>
        </div>
          <div class="form-group">
            <label for="street">Contact Info</label>
            <input name="contact" class="form-control" id="street" type="text" value="{{$vendor->contact}}">
          </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="state">State</label>
                <select name="state" class="form-control" id="state">
                    <option value="{{$vendor->state}}">{{$vendor->state}}</option>
                    @foreach ($states as $state)
                        @if($state->name != $vendor->state)
                            <option>{{$state->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-6">
                <label for="country">Country</label>
                <select name="country" class="form-control" id="country">
                   <option value="Nigeria">Nigeria</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="city">LGA</label>
                <select name="lga" class="form-control" id="lga">
                    <option value="{{$vendor->lga}}">{{$vendor->lga}}</option>
                    @foreach ($lgas as $lga)
                        @if($lga->name != $vendor->lga)
                            <option>{{$lga->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="area">Area</label>
                    <select name="area" class="form-control" id="area">
                        <option value="{{$vendor->area}}">{{$vendor->area}}</option>
                        @foreach ($areas as $area)
                            @if($area->name != $vendor->area)
                                <option>{{$area->name}}</option>
                            @endif
                        @endforeach
                    </select>
                  </div>
            </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-8">
                <label for="street">Address</label>
                <input name="address" class="form-control" id="street" type="text" value="{{$vendor->address}}">
          </div>
          <div class="form-group col-sm-4">
            <label for="postal-code">Postal Code</label>
            <input name="zip" class="form-control" id="postal-code" type="text" value="{{$vendor->zip}}">
          </div>
        </div>
        <!-- /.row-->

        <div class="row">
          <div class="form-group col-sm-6">
            <label for="open">Opening Hours</label>
            <input name="open" class="form-control" id="open" type="text" value="{{$vendor->opening}}">
          </div>
          <div class="form-group col-sm-6">
            <label for="close">Closing Hours</label>
            <input name="close" class="form-control" id="close" type="text" value="{{$vendor->closing}}">
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="col-sm-6">
      <div class="card">

          <div class="card-header">
              Upload Image/Cover
          </div>

          <div class="card-body">

            <div class="form-group">
               <label for="vendor-image">Image</label>
               <div class="vendor-image-container">
                    <div class="vendor-image" style="background-image: url('{{$vendor->image}}')" data-init="{{$vendor->image}}"></div>
                    <div class="vendor-image-txt">Click here to select image from file</div>
                </div>
               <input name="vendor-image" class="form-control" style="display:none;" id="vendor-image-file" type="file">
            </div><br>

            <div class="form-group">
                <label for="cover">Cover</label>
                <div class="cover-container">
                     <div class="cover-image" style="background-image: url('{{$vendor->cover}}')" data-init="{{$vendor->cover}}"></div>
                     <div class="cover-txt">Click here to select image from file</div>
                 </div>
                <input name="cover" class="form-control" style="display:none;" id="cover-file" type="file">
             </div>
            <div class="form-group">
               <label for="send"></label>
               <button id="send" class="btn btn-sm btn-danger form-control " id="editVendorFormBtn" type="submit">Save edit & Upload</button>
            </div>
          </div>

      </div>
  </div>

</div>
</form>

@endsection

@section('javascript')

@endsection
