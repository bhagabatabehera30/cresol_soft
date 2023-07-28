<x-app-layout>

	<!-- Page Wrapper -->
	<div class="page-wrapper">
		<div class="content container-fluid">

			<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col">
						<h3 class="page-title">Create User</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ route('users.list') }}">Users</a></li>
							<li class="breadcrumb-item active">Create User</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /Page Header -->

			<div class="row">
				<div class="col-lg-12">

					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif

					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Create User</h4>
						</div>
						<div class="card-body">
							<form method="post" action="{{ route('user.store') }}" enctype='multipart/form-data'>
								@csrf
								<div class="form-group row">
									<label class="col-form-label col-md-2">First Name</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-md-2">Last Name</label>
									<div class="col-md-10">
										<input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" required>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-form-label col-md-2">Hobbies</label>
									<div class="col-md-10">
										@foreach($hobbies as $key => $hobby)
										<div class="checkbox">
											<label>
												<input type="checkbox" name="user_hobbies[]" value="{{ $hobby->id }}"> {{ $hobby->hobbie_name }}
											</label>
										</div>
										@endforeach
									</div>
								</div>
								<button type="submit" class="btn btn-primary">Submit</button>

							</form>
						</div>
					</div>
					
				</div>
			</div>

		</div>			
	</div>
	<!-- /Main Wrapper -->
</x-app-layout>