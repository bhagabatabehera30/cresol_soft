<x-app-layout>
<style>
.login-wrapper .loginbox {
    max-width: 400px;
    width: 100%
}

</style>
<x-auth-session-status class="mb-4" :status="session('status')" />
<div class="main-wrapper login-body">
            <div class="login-wrapper">
            	<div class="container">
                	<div class="loginbox">
                    	<!--<div class="login-left">
							<img class="img-fluid" src="assets/img/logo-white.png" alt="Logo">
                        </div>-->
                        <div class="login-right">
							<div class="login-right-wrap">
								<h1>Login</h1>
								<p class="account-subtitle">Access to our dashboard</p>
								<div id="errors-list"></div>
								<!-- Form -->
								<form action="{{ route('login') }}" method="post" id="loginForm">
								@csrf
									<div class="form-group"> 
										<input class="form-control" type="text" name="email" id="email" placeholder="Email">
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
									<div class="form-group">
										<input class="form-control" type="password" name="password" id="password" placeholder="Password">
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
									
									<div class="form-group mb-0">
										<button class="btn btn-primary w-100" type="submit">Login</button>
									</div>
								</form>
								<!-- /Form -->
								<div class="text-center dont-have">If you do not have an account? <a href="{{ route('register') }}">Register</a></div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- /Main Wrapper -->

		@section('javascript')
        @if(Auth::check()) 
		<script type="text/javascript">
      	</script>
        @endif
		@endsection
		
</x-app-layout>