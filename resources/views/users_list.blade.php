<x-app-layout>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Users</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('users.list') }}">Users</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-sm-12">
                   @if(session('success'))
                   <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Users</h4>
                        <p style="text-align:right;"><a href="{{ route('user.create') }}" class="btn btn-primary"><i class="fe fe-layout"></i> <span>Create User</span></a></p>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="datatable table table-stripped" id="user-list-ajax">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Hobbies</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>          
</div>
<!-- /Main Wrapper -->

</x-app-layout>


<script type="text/javascript">
    var oTable = $('#user-list-ajax').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        searching: true,
        "order": [[0, "desc"]],
        ajax: {
            url: "{{ route('users.data') }}",
            data: function (d) {
                //d.fromDt = $('#fromDt').val();
                //.toDt = $('#toDt').val();
                //d.filter_hospital_id = $('#filter_hospital_id').val();
            }
        }, columns: [
            {data: 'id', name: 'id'},
            {data: 'first_name', name: 'first_name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'hobbies', name: 'hobbies'},
            {data: 'action', name: 'action'}
            ]
    });

   /* $('#fromDt').on('change', function (e) {
        oTable.draw();
    });
    $('#toDt').on('change', function (e) {
        oTable.draw();
    });
    $('#paymentStatus').on('change', function (e) {
        oTable.draw();
    });
    $('#filter_hospital_id').on('change', function (e) {
        oTable.draw();
    });*/

</script>
