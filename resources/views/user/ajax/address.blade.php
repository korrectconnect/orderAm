
<h3 class="siteColor">Hi {{auth()->user()->firstname}},</h3>
<h4>Add new address</h4>
	<!-- Border -->
	<div class="bor bg-orange"></div>
	<!-- Form -->
	<form class="form" role="form" id="addAddressForm" method="POST" data-href="{{route('user.address')}}">
		<!-- Form Group -->
		<div class="form-group">
			<!-- Label -->
			<label class="control-label">City*</label>
			<!-- Input -->
			<select class="form-control" name="state">
                @if ($states->count() >= 1)
                    @foreach ($states as $state)
                        <option>{{$state->name}}</option>
                    @endforeach
                @endif
            </select>
		</div>
		<div class="form-group">
			<!-- Label -->
			<label class="control-label">Area*</label>
			<!-- Input -->
			<select class="form-control" name="lga">
                @if ($lgas->count() >= 1)
                    @foreach ($lgas as $lga)
                        <option>{{$lga->name}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="form-group">
            <!-- Label -->
            <label class="control-label">Address*</label>
            <!-- Input -->
            <textarea type="text" name="address" class="form-control" rows="2"  placeholder="Enter address"></textarea>
        </div>
        <div class="form-group">
            <!-- Label -->
            <label class="control-label">Description</label>
            <!-- Input -->
            <input type="text" name="description" class="form-control"  placeholder="Eg. Black gate, 2nd floor etc">
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
            <input type="text" onkeypress="return isNumberKey(event)" name="phone" class="form-control"  placeholder="">
        </div>

		<div class="form-group">
			<!-- Button -->
			<button type="submit" class="btn btn-primary" id="addAddressFormBtn">Submit</button>
		</div>
	</form>
