.@extends('layouts.app')
@section('title','Dashboard')
@section('top_scripts')
@endsection
@section('style')
@endsection
@section('content')
<div class="wrapper">
    <!-- Navbar -->
    @include('admin.navbar')
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    @include('admin.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Employee</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">

                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('assets/dist/img/user4-128x128.jpg')}}" alt="User profile picture">
                       
                    </div>

                    <h3 class="profile-username text-center">{{$employee->first_name}}&nbsp;{{$employee->last_name}}</h3>

                    <p class="text-muted text-center">{{$employee->company->name}}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Email Adress</b> <a class="float-right">{{$employee->email}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Phone</b> <a class="float-right">{{$employee->phone}}</a>
                        </li>

                    </ul>

                    <a onclick="edit({{$employee->id}});" class="btn btn-primary btn-block col-2"><b>Edit</b></a>
                    <a onclick="com_delete({{$employee->id}});" class="btn btn-danger btn-block col-2"><b>Delete</b></a>
                </div>
                <!-- /.card-body -->
            </div>
        </section>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('admin.footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>


<div class="modal fade" id="employees" tabindex="-1" aria-labelledby="employeeLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">UpdateEmployee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="UpdateEmployeeForm">
        <div class="card-body ">
          <div class="row">
              <input type="hidden" name="id" id="id">
          <div class="form-group col-6 inputname" >
            <label for="name">First Name*</label>
            <input type="text" class="form-control" id="FirstName" name="FirstName" value="" >
            <span class="text-danger error-text FirstName_error"></span>
          </div>

          <div class="form-group col-6 inputname">
            <label for="name">Last Name*</label>
            <input type="text" class="form-control" id="LastName" name="LastName" value="" >
            <span class="text-danger error-text LastName_error"></span>
          </div>
          
          <div class="form-group col-6 inputname">
            <label for="Email">Email address*</label>
            <input type="email" class="form-control" id="Email" name="Email" placeholder="Enter email">
            <span class="text-danger error-text Email_error"></span>
          </div>
          <div class="form-group col-6 inputname">
            <label for="indusrty">Phone</label>
            <input type="text" class="form-control" name="Phone" value="" id="Phone" >
          </div>
          </div>
          <div class="form-group">
            <label for="">Company</label>
            <select class="form-control" name="Company" id="Company">
              <option>Choose Your Company..</option>
              @foreach($companies as $company)
              <option value="{{$company->id}}">{{$company->name}}</option>
              @endforeach

            </select>
          </div>
         
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </div>
</form>
    </div>
  </div>
</div>
@endsection
@section('bottom_scripts')
<script>
    function edit(id) {
        var url = '{{ route("employees.edit", ":id") }}';
        url = url.replace(':id', id);
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $('.modal').modal('show');
                $('#id').val(data.data.id);
                $('#FirstName').val(data.data.first_name);
                $('#LastName').val(data.data.last_name);
                $('#Email').val(data.data.email);
                $('#Phone').val(data.data.phone);
                $('#Company').val(data.data.company_id).attr('selected', true); 
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        $("#UpdateEmployeeForm").submit(function(stay) {

            stay.preventDefault();
            var formData = $("#UpdateEmployeeForm").serialize();
            var id = $('#id').val();
            var url = '{{ route("employees.update", ":id") }}';
            url = url.replace(':id', id);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'PUT',
                url: url,
                data: formData,
                cache: false,
                processData: false,
                dataType: 'json',
                // contentType: false,
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {

                            $('span.' + prefix + '_error').text(val[0]);
                        });

                    } else {
                        alert(data.msg);
                        $('.modal').modal('hide');
                        window.location.reload();
                    }
                },
                errors: function(e) {
                    alert(e.error);
                },
            });
        });
    });
</script>
<script>
    function com_delete(id) {
        confirm('Are you sure want to remove the Employee?');
        var url = '{{ route("employees.destroy", ":id") }}';
        var redirect = '{{ route("employees.index") }}';
        url = url.replace(':id', id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if (confirm) {
            $.ajax({
                type: 'DELETE',
                url: url,
                success: function(data) {

                    alert(data.msg);
                    window.location.href = redirect;
                }
            });
        }
    }
</script>
@endsection