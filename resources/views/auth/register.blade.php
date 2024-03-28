<x-app-layout>
<style>
.login-wrapper .loginbox {
    max-width: 400px;
    width: 100%
}

</style>
<div class="main-wrapper login-body">
            <div class="login-wrapper">
            	<div class="container">
                	<div class="loginbox">
                    	<!--<div class="login-left">
							<img class="img-fluid" src="assets/img/logo-white.png" alt="Logo">
                        </div>-->
                        <div class="login-right">
							<div class="login-right-wrap">
								<h1>Register</h1>
								<p class="account-subtitle">Access to our dashboard</p>
								<div id="errors-list"></div>
								<!-- Form -->
								<form action="{{ route('register') }}" id="registerForm">
								@csrf
									<div class="form-group">
										<input class="form-control" name="first_name" type="text" placeholder="First Name">
									</div>
									<div class="form-group">
										<input class="form-control" name="last_name" type="text" placeholder="Last Name">
									</div>
									<div class="form-group">
										<input class="form-control" type="text" name="email" id="email" placeholder="Email">
									</div>
									<div class="form-group">
										<input class="form-control" type="text" name="mobile" id="mobile" placeholder="Mobile">
									</div>
									<div class="form-group">
										<input class="form-control" type="password" name="password" id="password" placeholder="Password">
									</div>
									<div class="form-group">
										<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
									</div>
									<div class="form-group mb-0">
										<button class="btn btn-primary w-100" type="submit">Register</button>
									</div>
								</form>
								<!-- /Form -->
								<div class="text-center dont-have">Already have an account? <a href="{{ route('login') }}">Login</a></div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- /Main Wrapper -->

		@section('javascript')
		<script type="text/javascript">
      		  $(function() {
		   $(document).on("submit", "#registerForm", function() {
			var e = this;
			$(this).find("[type='submit']").html("Register in process...");
			$.ajax({
				url: $(this).attr('action'),
				data: $(this).serialize(),
				type: "POST",
				dataType: 'json',
				success: function (data) {
	
				  $(e).find("[type='submit']").html("Register");
	
				  if (data.status) {
					  window.location = data.redirect;
				  }else{
					  $(".alert").remove();
					  $.each(data.errors, function (key, val) {
						  $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
					  });
				  }
				 
				}
			});
	
			return false;
		});
	
	  });
	
      	</script>
		@endsection
		
</x-app-layout>