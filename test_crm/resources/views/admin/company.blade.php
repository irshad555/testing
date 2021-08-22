@extends('layouts.app')
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
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Companies</h1>
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
                                <button type="button" data-toggle="modal" data-target="#company" class="btn btn-block btn-outline-info btn-sm col-2">Add Company</button>
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
                                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Company Name: activate to sort column descending">Company Name</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email Adress: activate to sort column ascending">Email Adress</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="WebSite URL: activate to sort column ascending">WebSite URL</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Industry: activate to sort column ascending">Industry</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Logo: activate to sort column ascending">Logo</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($companies)
                                                    @foreach($companies as $company)
                                                    <tr class="odd">
                                                        <td class="dtr-control sorting_1" tabindex="0">{{$company->name}}</td>
                                                        <td>{{$company->email}}</td>
                                                        <td>{{$company->website_url}}</td>
                                                        <td>{{$company->industry}}</td>
                                                        <td>@if($company->logo)
                                                            <img src="{{ route('displayimage',$company->logo)}}" style="height:auto;width:30%;">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a class="editcolor" href="{{Route('companies.show',$company->id)}}">view <i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    <tr class="odd"> No data... </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                            <div style="margin-top: 15px;" class="d-flex justify-content-center" >
                                        {!! $companies->links() !!}
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
<div class="modal fade" id="company" tabindex="-1" aria-labelledby="companyLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="CompanyForm">
                <div class="modal-body">
                    <div class="card-body">
                    
                        <div class="form-group">
                            <label for="name">Name*</label>
                            <input type="text" class="form-control" id="" name="Name" value="" placeholder="Enter Company Name">
                            <span class="text-danger error-text Name_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="Email">Email address*</label>
                            <input type="email" class="form-control" id="" name="Email" placeholder="Enter email">
                            <span class="text-danger error-text Email_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="indusrty">Industry</label>
                            <input type="text" class="form-control" name="Industry" value="" id="" placeholder="Industry">
                        </div>
                        <div class="form-group">
                            <label for="">Website URL</label>
                            <input type="text" class="form-control" name="url" value="" id="" placeholder="Enter Website URL">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Logo</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="Logo" id="logo">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                            <span class="text-danger error-text Logo_error"></span>
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
        $("#CompanyForm").submit(function(stay) {

            stay.preventDefault();
            var formData = new FormData(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{route('companies.store')}}",
                data: formData,
                cache: false,
                processData: false,
                dataType: 'json',
                contentType: false,
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

@endsection