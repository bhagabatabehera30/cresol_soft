<x-app-layout>
    <!-- Page Wrapper -->
<div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col">
								<h3 class="page-title">Ajax File Upload</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
									<li class="breadcrumb-item active">Ajax File Upload</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Ajax File Upload</h4>
								</div>
								<div class="card-body">
									<form action="{{ route('ajax-file-upload-post')}}" method="post" enctype="multipart/form-data" id="fileUpload">
                                    @csrf

									 <div id="errors-list">
									</div>
										<div class="form-group row">
										<div class="col-md-4" id="previewImage">

										</div>
											<label class="col-form-label col-md-2">Image</label>
											<div class="col-md-6">
												<input class="form-control" type="file" name="image">
											</div>
										</div>
                                        <div class="" style="text-align: right;">
										<button type="submit" class="btn btn-primary" id="upload-image">Upload</button>
                                        </div>
									</form>
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
		   $('#fileUpload').submit(function(e) {
			e.preventDefault();
            var formData = new FormData($(this)[0]);
			formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
			$("#upload-image").html("Upload is in process...");
			$.ajax({
				url: $(this).attr('action'),
				data: formData,
				type: "POST",
				//headers : {'X-CSRF-TOKEN': },
				async: false,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
				success: function (data) {
				  $("#upload-image").html("Upload");
				  if (data.status) {
					if(data.fileData.file_name!=''){
					$('#previewImage').html(`
					<img width="180px" height="180px" src="{{ asset('images') }}/${data.fileData.file_name}" 
					alt="No image present">`);
					$("#fileUpload")[0].reset();
					}else{
						$('#previewImage').html('<p>No image available.</p>');
					}
					  console.log(data);
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


		
        
		