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
                        <h1 class="m-0">Company</h1>
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

                        @if($company->logo)

                        <img class="profile-user-img img-fluid img-circle" src="{{ route('displayimage',$company->logo)}}" alt="User profile picture">
                        @else
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('assets/dist/img/user4-128x128.jpg')}}" alt="User profile picture">
                        @endif
                    </div>

                    <h3 class="profile-username text-center">{{$company->name}}</h3>

                    <p class="text-muted text-center">{{$company->industry}}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Email Adress</b> <a class="float-right">{{$company->email}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Website URL</b> <a class="float-right">{{$company->website_url}}</a>
                        </li>

                    </ul>

                    <a onclick="edit({{$company->id}});" class="btn btn-primary btn-block col-2"><b>Edit</b></a>
                    <a onclick="com_delete({{$company->id}});" class="btn btn-danger btn-block col-2"><b>Delete</b></a>
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


<div class="modal fade" id="company" tabindex="-1" aria-labelledby="companyLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="UpdateCompanyForm">
                <div class="modal-body">
                    <div class="card-body">
                        <input type="hidden" name="id" value="" id="id">
                        <div class="form-group">
                            <label for="name">Name*</label>
                            <input type="text" class="form-control" id="Name" name="Name" value="" placeholder="Enter Company Name">
                            <span class="text-danger error-text Name_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="Email">Email address*</label>
                            <input type="email" class="form-control" id="Email" name="Email" placeholder="Enter email">
                            <span class="text-danger error-text Email_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="indusrty">Industry</label>
                            <input type="text" class="form-control" name="Industry" value="" id="Industry" placeholder="Industry">
                        </div>
                        <div class="form-group">
                            <label for="">Website URL</label>
                            <input type="text" class="form-control" name="url" value="" id="url" placeholder="Enter Website URL">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Logo</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" value="@isset($company->logo){{$company->logo}}@endisset" name="Logo" id="logo">
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
        var url = '{{ route("companies.edit", ":id") }}';
        url = url.replace(':id', id);
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $('.modal').modal('show');
                $('#id').val(data.data.id);
                $('#Name').val(data.data.name);
                $('#Email').val(data.data.email);
                $('#Industry').val(data.data.industry);
                $('#url').val(data.data.website_url);



            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        $("#UpdateCompanyForm").submit(function(stay) {

            stay.preventDefault();
            var formData = $("#UpdateCompanyForm").serialize();
            var id = $('#id').val();
            var url = '{{ route("companies.update", ":id") }}';
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
        confirm('Are you sure want to remove the Company?');
        var url = '{{ route("companies.destroy", ":id") }}';
        var redirect = '{{ route("companies.index") }}';
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