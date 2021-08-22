@extends('layouts.app')
@section('title','Employees')
@section('top_scripts')
@endsection
@section('style')
<style>
  .inputname{
    display:inline-block;
  }
</style>
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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Employees</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <button type="button" data-toggle="modal" data-target="#employees" class="btn btn-block btn-outline-info btn-sm col-2">Add Employee</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                  <div class="row">
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-6"></div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
                        <thead>
                          <tr role="row">
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending">Name</th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Email</th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">Phone</th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending">Company</th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if($employees)
                          @foreach($employees as $emp)
                          <tr class="odd">
                            <td class="dtr-control sorting_1" tabindex="0">{{$emp->frist_name}}&nbsp;{{$emp->last_name}}</td>
                            <td>{{$emp->email}}</td>
                            <td>{{$emp->phone}}</td>
                            <td>{{$emp->company->name}}</td>
                            <td><a class="editcolor" href="{{Route('employees.show',$emp->id)}}">view <i class="fa fa-eye" aria-hidden="true"></i></a></td>
                          </tr>
                          @endforeach
                          @else
                          <tr> No Data..</tr>
                          @endif
                        </tbody>
                      </table>
                      
                      <div style="margin-top: 15px;" class="d-flex justify-content-center" >
                                        {!! $employees->links() !!}
                                        </div>
                    </div>
                  </div>
                 
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->


          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->
  @include('admin.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>


<!-- Modal -->
<div class="modal fade" id="employees" tabindex="-1" aria-labelledby="employeeLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="EmployeeForm">
        <div class="card-body ">
          <div class="row">
          <div class="form-group col-6 inputname" >
            <label for="name">First Name*</label>
            <input type="text" class="form-control" id="" name="FirstName" value="" >
            <span class="text-danger error-text FirstName_error"></span>
          </div>

          <div class="form-group col-6 inputname">
            <label for="name">Last Name*</label>
            <input type="text" class="form-control" id="" name="LastName" value="" >
            <span class="text-danger error-text LastName_error"></span>
          </div>
          
          <div class="form-group col-6 inputname">
            <label for="Email">Email address*</label>
            <input type="email" class="form-control" id="" name="Email" placeholder="Enter email">
            <span class="text-danger error-text Email_error"></span>
          </div>
          <div class="form-group col-6 inputname">
            <label for="indusrty">Phone</label>
            <input type="text" class="form-control" name="Phone" value="" id="" >
          </div>
          </div>
          <div class="form-group">
            <label for="">Company</label>
            <select class="form-control" name="Company" id="">
            
              @foreach($companies as $company)
              <option value="{{$company->id}}">{{$company->name}}</option>
              @endforeach

            </select>
            <span class="text-danger error-text Company_error"></span>
          </div>
         
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
</form>
    </div>
  </div>
</div>
@endsection
@section('bottom_scripts')
<script>
    $(document).ready(function() {
        $("#EmployeeForm").submit(function(stay) {

            stay.preventDefault();
            var formData =  $("#EmployeeForm").serialize();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{route('employees.store')}}",
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
               
            });
        });
    });
</script>
@endsection