<h4>Create New Account</h4>
<!-- Border -->
<div class="bor bg-orange"></div>
<!-- Form -->
<form class="form" role="form" method="POST" id="authRegisterForm">
	<!-- Form Group -->
	<div class="form-group">
		<!-- Label -->
		<label class="control-label">First name</label>
		<!-- Input -->
		<input type="text" name="firstname" class="form-control"  placeholder="Enter First name">
    </div>

    <div class="form-group">
		<!-- Label -->
		<label class="control-label">Last name</label>
		<!-- Input -->
		<input type="text" name="lastname" class="form-control"  placeholder="Enter Last name">
    </div>

	<div class="form-group">
		<label class="control-label">Email</label>
		<input type="email" name="email" class="form-control" placeholder="Enter Email">
    </div>

    <div class="form-group">
		<!-- Label -->
		<label class="control-label">Phone</label>
		<!-- Input -->
		<input type="text" name="phone" class="form-control"  placeholder="Enter Phone">
    </div>

	<div class="form-group">
		<label class="control-label">Password</label>
		<input type="password" name="password" class="form-control" placeholder="Enter Password">
	</div>
	<div class="form-group">
		<label class="control-label">Confirm Password</label>
		<input type="password" name="password_confirmation" class="form-control" placeholder="Re-type password again">
    </div>

	<div class="form-group">
		<!-- Checkbox -->
		<div class="checkbox">
			<label>
				<input name="terms" type="checkbox"> By register, I read & accept  <a href="#">the terms</a>
			</label>
		</div>
	</div>
	<div class="form-group">
		<!-- Buton -->
		<button type="submit" class="btn btn-primary" id="authRegisterFormBtn" data-href="{{route('user.register')}}">Submit</button>
	</div>
</form>
