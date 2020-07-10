@extends('admin.base')

@section('content')

<form data-href="{{route('admin.rider.edit')}}" enctype="multipart/form-data" id="editRiderForm" >
    @csrf

    <input type="hidden" name="id" value="{{$rider->id}}">

<div class="row" style="margin: 0px !important; padding: 0px !important;">

<div class="col-sm-6">
    <div class="card">
      <div class="card-header"><strong>Edit Rider</strong></div>
      <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="firstname">Firstname*</label>
                    <input name="firstname" class="form-control" id="firstname" type="text" value="{{$rider->firstname}} ">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lastname">Lastname*</label>
                    <input name="lastname" class="form-control" id="lastname" type="text" value="{{$rider->lastname}} ">
                  </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
              <label for="spouse_name">Spouse Fullname</label>
              <input name="spouse_name" class="form-control" id="spouse_name" type="text" value="{{$rider->spouse_name}}">
            </div>
            <div class="form-group col-sm-6">
              <label for="spouse_phone">Spouse contact</label>
              <input name="spouse_phone" class="form-control" id="spouse_phone" type="text" value="{{$rider->spouse_phone}}">
            </div>
          </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category">Category*</label>
                    <select name="category" class="form-control" id="category">
                        @foreach ($categories as $category)
                            <option>{{$category->category}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="company">Company</label>
                    <input name="company" class="form-control" id="company" type="text" value="{{$rider->company}}">
                </div>
            </div>
        </div>
          <div class="form-group">
            <label for="street">Contact Info*</label>
            <input name="phone" class="form-control" id="street" type="text" value="{{$rider->phone}}">
          </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="state">State*</label>
                <input name="state" class="form-control" id="state" type="text" value="{{$rider->state}}">
            </div>
            <div class="form-group col-sm-6">
                <label for="country">Country*</label>
                <input name="country" class="form-control" id="country" type="text" value="{{$rider->country}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="lga">LGA*</label>
                <input name="lga" class="form-control" id="lga" type="text" value="{{$rider->lga}}">
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="dob">Date of birth*</label>
                    <input name="dob" class="form-control" id="dob" type="date" value="{{$rider->date_of_birth}}">
                  </div>
            </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-8">
                <label for="address">Address*</label>
                <input name="address" class="form-control" id="address" type="text" value="{{$rider->address}}">
          </div>
          <div class="form-group col-sm-4">
            <label for="plate">Plate Number*</label>
            <input name="plate" class="form-control" id="plate" type="text" value="{{$rider->plate_number}}">
          </div>
        </div>
        <!-- /.row-->

      </div>
    </div>
  </div>

  <div class="col-sm-6">
      <div class="card">

          <div class="card-header">
              Upload Photo/Passport
          </div>

          <div class="card-body">

            <div class="form-group">
                <label for="cover">Photo*</label>
                <div class="passport-container">
                     <div class="cover-image" style="background-image: url('{{$rider->image}}')" data-init="{{$rider->image}}"></div>
                     <div class="cover-txt">Click here to select image from file</div>
                 </div>
                <input name="photo" class="form-control" style="display:none;" id="cover-file" type="file">
             </div>
            <div class="form-group">
               <label for="send">*</label>
               <button id="editRiderFormBtn" class="btn btn-sm btn-danger form-control" type="submit">Save edit & Upload</button>
            </div>
          </div>

      </div>
  </div>

</div>
</form>

@endsection

@section('javascript')

@endsection
