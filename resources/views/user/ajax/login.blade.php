<img src="{{asset('images/pizza.png')}}" alt="PIZZA" style="width: 120px; position: absolute; right:-50px; top:-40px; transform:rotate(330deg);">
<img src="{{asset('images/burger.png')}}" alt="PIZZA" style="width: 160px; position: absolute; right:-50px; bottom:-60px; transform:rotate(10deg);">

<h4>Sign In to your Account</h4>
	<!-- Border -->
	<div class="bor bg-orange"></div>
	<!-- Form -->
    <form class="form" role="form" id="authLoginForm" method="POST" data-href="{{route('user.login')}}">
        @csrf
		<!-- Form Group -->
		<div class="form-group">
			<!-- Label -->
			<label class="control-label">Email</label>
			<!-- Input -->
			<input type="email" name="email" class="form-control" placeholder="Enter Email">
		</div>
		<div class="form-group">
			<label class="control-label">Password</label>
			<input type="password" name="password" class="form-control" placeholder="Enter Password">
		</div>
		<div class="form-group">
			<!-- Button -->
			<button type="submit" class="btn btn-primary" id="authLoginFormBtn" >Sign In</button>
		</div>
		<div class="form-group">
			<a href="javascript:void()" class="black">Forget Password ?</a>
		</div>
	</form>
