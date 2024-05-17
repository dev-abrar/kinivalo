@extends('back-end.admin')

@section('title')
    Permission
@endsection


@section('content')
    <section class="content">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb ">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addNew">
                    Create Permission
                </button>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Child Permissions List For <strong>{{ $permission->display_name }}</strong></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">Serial</th>
                                            <th>Display Permission Name</th>
                                            <th>Permission Name</th>
                                            <th style="width: 20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableData">
                                        @php
                                            if (method_exists($permission->children, 'links')) {
                                                $serial = ($permission->children->currentpage() - 1) * $permission->children->perpage() + 1;
                                            } else {
                                                $serial = 1;
                                            }
                                        @endphp
                                        @forelse ($permission->children as $child_permission)
                                            <tr class="rowSort" id="{{ $child_permission->id }}">
                                                <td>{{ $serial++ }}</td>
                                                <td>
                                                    <span class="text-success">{{ $child_permission->display_name }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-success">{{ $child_permission->name }}</span>
                                                </td>
                                                <td>
                                                    <button
                                                        class="btn btn-primary btn-sm rounded-pill btn-rounded text-light editModal"
                                                        data-toggle="modal" data-target=".editForm"
                                                        data-permission="{{ $child_permission }}"><i class="fas fa-edit"></i>
                                                        Edit
                                                    </button>
                                                    <a href="{{ url('child-permission/' . $child_permission->id) }}"
                                                        class="btn btn-info btn-sm rounded-pill btn-rounded text-light">Show
                                                        Permission</a>
                                                </td>
                                            </tr>
                                        @empty
                                        <tr class="text-center">
                                            <td colspan="4" class="text-danger">Data Not Found!</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    {{-- modal edit --}}
                    <div class="modal fade editForm">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit Permission</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <!-- form start -->
                                <form id="EditForm">
                                    <div class="card-body">
                                        <!-- form start -->
                                        <div class="card-body">
                                            <input type="hidden" class="form-control" name="id" id="id">
                                            <div class="form-group">
                                                <label for="display_name">Display Name</label>
                                                <input type="text"
                                                    class="form-control display_name @error('display_name') is-invalid @enderror"
                                                    name="display_name" placeholder="Enter Permission Display Name">
                                            </div>
                                            <strong class="validation text-danger" data-filed="display_name"></strong>

                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text"
                                                    class="form-control name @error('name') is-invalid @enderror"
                                                    name="name" placeholder="Enter Permission Name">
                                            </div>
                                            <strong class="validation text-danger" data-filed="name"></strong>

                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger rounded-pill btn-rounded"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit"
                                            class="btn btn-primary rounded-pill btn-rounded">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>

            </div>


            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewLabel">Create Permission</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="addForm" role="form">
                            <div class="card-body">
                                <!-- form start -->
                                <div class="card-body">
                                    <input type="hidden" name="parent_id" id="parent_id" value="{{ $permission->id }}">
                                    <div class="form-group">
                                        <label for="display_name">Display Name</label>
                                        <input type="text"
                                            class="form-control display_name @error('display_name') is-invalid @enderror"
                                            name="display_name" placeholder="Enter Permission Display Name">
                                    </div>
                                    <strong class="validation text-danger" data-filed="display_name"></strong>

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text"
                                            class="form-control name @error('name') is-invalid @enderror" name="name"
                                            placeholder="Enter Permission Name" readonly>
                                    </div>
                                    <strong class="validation text-danger" data-filed="name"></strong>

                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger rounded-pill btn-rounded"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary rounded-pill btn-rounded">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endsection
    @section('js')
        <script>
            $(document).ready(function() {
                //slug generator
                $('.display_name').on('keyup', function() {
                    convertToSlug($(this).val());
                });

                function convertToSlug(title) {
                    var slug = title.toLowerCase()
                        .replace(/[^\u0980-\u09FFa-z0-9-]+/g, '-') // Include Bangla characters in the regex
                        .replace(/^\-+|\-+$/g, ''); // Remove leading and trailing hyphens
                    $('.name').val(slug);
                }

                //value pass for edit
                $('.editModal').click(function(e) {
                    e.preventDefault();
                    $('.validation').text('');

                    //fill the role form
                    $('#id').val($(this).data('permission').id);
                    $('.display_name').val($(this).data('permission').display_name);
                    $('.name').val($(this).data('permission').name);
                });
                //add form
                $("form#addForm").submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData($("#addForm")[0]);

                    $.ajax({
                        type: "POST",
                        url: "{{ route('create-permission') }}",
                        contentType: false,
                        processData: false,
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.success);
                            } else if (response.error) {
                                toastr.error(response.error);
                            }
                        },
                        error: function(error) {
                            $('.validation').text('');
                            $.each(error.responseJSON.errors, function(field_name, error) {
                                const errorElement = $('.validation[data-filed="' +
                                    field_name + '"]');
                                if (errorElement.length > 0) {
                                    errorElement.text(error[0]);
                                    toastr.error(error);
                                }
                            });

                        },

                        complete: function(done) {
                            if (done.status == 200) {
                                window.location.reload();
                            }
                        }
                    });
                });


                //update ajax request
                $("#EditForm").on('submit', function(e) {
                    e.preventDefault();
                    var formData = new FormData($("#EditForm")[0]);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('update-permission') }}",
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.success);
                            } else if (response.error) {
                                toastr.error(response.error);
                            }
                        },
                        error: function(error) {
                            $('.validation').text('');
                            $.each(error.responseJSON.errors, function(field_name, error) {
                                const errorElement = $('.validation[data-filed="' +
                                    field_name + '"]');
                                if (errorElement.length > 0) {
                                    errorElement.text(error[0]);
                                    toastr.error(error);
                                }
                            });

                        },

                        complete: function(done) {
                            if (done.status == 200) {
                                window.location.reload();
                            }
                        }
                    });
                });
            });
        </script>
    @endsection
