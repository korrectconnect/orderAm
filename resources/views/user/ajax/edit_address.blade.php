
<h3 class="siteColor">Hi {{auth()->user()->firstname}},</h3>
<h4>Edit address</h4>
	<!-- Border -->
	<div class="bor bg-orange"></div>
	<!-- Form -->
	<form class="form" role="form" id="editAddressForm" method="POST" data-href="{{route('user.address.edit')}}">
        <!-- Form Group -->
        <input type="hidden" name="id" value="{{$address->id}}">
		<div class="form-group">
			<!-- Label -->
			<label class="control-label">City*</label>
			<!-- Input -->
			<select class="form-control" disabled name="state">
                <option selected>{{$address->state}}</option>
            </select>
		</div>
		<div class="form-group">
			<!-- Label -->
			<label class="control-label">Area*</label>
			<!-- Input -->
			<select class="form-control" disabled name="lga">
                <option selected>{{$address->lga}}</option>
            </select>
        </div>
        <div class="form-group">
            <!-- Label -->
            <label class="control-label">Address*</label>
            <!-- Input -->
            <textarea type="text" name="address" class="form-control" rows="2"  placeholder="Enter address">{{$address->address}}</textarea>
        </div>
        <div class="form-group">
            <!-- Label -->
            <label class="control-label">Description</label>
            <!-- Input -->
            <input type="text" name="description" class="form-control"  placeholder="Eg. Black gate, 2nd floor etc" value="{{$address->description}}">
        </div>
        <div class="form-group">
            <!-- Label -->
            <label class="control-label">Default Phone</label>
            <!-- Input -->
            <input type="text" class="form-control"  value="{{auth()->user()->phone}}" disabled>
        </div>

        <div class="form-group">
            <!-- Label -->
            <label class="control-label">Other Phone</label>
            <!-- Input -->
            <input type="text" onkeypress="return isNumberKey(event)" name="phone" class="form-control"  placeholder="" value="{{$address->phone}}">
        </div>

		<div class="form-group">
			<!-- Button -->
			<button type="submit" class="btn btn-primary" id="editAddressFormBtn">Submit</button>
		</div>
	</form>
