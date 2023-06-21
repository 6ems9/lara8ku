@extends('layouts.sbadmin.main', ['title' => 'All Category'])
@push('styles')
    <!-- Custom styles for this page -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">All Category</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>{{ session('error') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 card">
                <h6 class="m-0">
                    <a class="btn btn-sm btn-primary btn-icon-split add">
                        <span class="text font-weight-bold">Create New Category</span>
                        <span class="icon text-white-75">
                            <i class="fas fa-plus"></i>
                        </span>
                    </a>
                </h6>
            </div>
            <div class="card-body" id="dataPage">
                <div class="d-flex justify-content-center mt-3">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Add -->
        <div class="modal fade" id="ModalAdd" tabindex="-1" aria-labelledby="titleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modaltitle">Create New Category</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-add" action="#" method="POST">
                            @csrf
                            <input id="idEdit" name="idEdit" hidden />
                            <div class="form-group">
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Category Name" required />
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" id="add_category_btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
        $(function() {

            // add ajax request
            $(document).on('click', '.add', function(e) {
                e.preventDefault();
                $("#ModalAdd").modal('show');
                $("#form-add")[0].reset();
                $("#modaltitle").text('Create New Category');
                $("#add_category_btn").text('Submit');
            });

            $("#form-add").submit(function(e) {
                e.preventDefault();
                const dataForm = new FormData(this);
                $.ajax({
                    url: '{{ route('category.store') }}',
                    method: 'POST',
                    data: dataForm,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            swal({
                                title: "Success!",
                                text: "Category has been saved!",
                                icon: "success",
                                button: "Close",
                            });
                            fetch();
                            $("#form-add")[0].reset();
                        } else {

                        }
                        $("#ModalAdd").modal('hide');
                    },
                    error: function(response) {
                        swal({
                            title: "Error!",
                            text: "The given data was invalid.",
                            icon: "error",
                            button: "Close",
                        });
                        console.log(response.message);
                    }
                });
            });

            // delete ajax request
            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this record!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: id,
                                method: 'DELETE',
                                data: {
                                    id: id,
                                    _token: csrf
                                },
                                success: function(response) {
                                    if (response.status == 200) {
                                        swal({
                                            title: "Success!",
                                            text: "Category has been deleted!",
                                            icon: "success",
                                            button: "Close",
                                        });
                                        fetch();
                                    } else {
                                        swal({
                                            title: "Error!",
                                            text: "Someting Wrong",
                                            icon: "error",
                                            button: "Close",
                                        });
                                    }
                                }
                            });
                        } else {

                        }
                    });
            });

            // edit ajax request
            $(document).on('click', '.edit', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: id,
                    method: 'GET',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $("#ModalAdd").modal('show');
                        $("#form-add")[0].reset();
                        $("#modaltitle").text('Update Category');
                        $("#add_category_btn").text('Update');
                        $("#name").val(response.name);
                        $("#idEdit").val(response.id);
                    },
                    error: function(response) {
                        swal({
                            title: "Error!",
                            text: "The given data was invalid.",
                            icon: "error",
                            button: "Close",
                        });
                        console.log(response.message);
                    }
                });
            });

            //get record
            fetch();

            function fetch() {
                $.ajax({
                    url: '{{ route('category.show','all') }}',
                    method: 'GET',
                    success: function(response) {
                        $("#dataPage").html(response);
                        $("table").DataTable({});
                    }
                });
            }
        });
    </script>
@endpush