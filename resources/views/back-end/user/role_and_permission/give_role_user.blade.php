@extends('back-end.admin')

@section('title')
    Give User Roles
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

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Given Roles List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Serial</th>
                                        <th>User Name</th>
                                        <th>Roles Name</th>
                                        {{-- <th style="width: 20%">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $serial = ($users->currentpage() - 1) * $users->perpage() + 1;
                                    @endphp
                                    @foreach ($users as $user)

                                        <tr>
                                            <td>{{ $serial++ }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td> <span
                                                    class="badge badge-success">{{ $user->getRoleNames()->count() > 0 ? $user->getRoleNames()[0] : '' }}</span>
                                            </td>
                                            {{-- <td>
                                                <button
                                                    class="btn btn-primary btn-sm rounded-pill btn-rounded text-light editModal"
                                                    data-toggle="modal" data-target=".editData"
                                                    data-user_id="{{ $user->id }}"
                                                    data-role_id="{{ $user->roles->count() > 0 ? $user->roles->first()->id : '' }}"><i
                                                        class="fas fa-edit"></i>
                                                    Edit</button>
                                                {{-- <a href="{{ url('role-permission-list/' . $role->id) }}"
                                            class="btn btn-info btn-sm rounded-pill btn-rounded text-light">Show
                                            Permission</a> 
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="float-right">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Give User Role Form</h3>
                        </div>
                        <form action="{{ route('update-given-user-role') }}" method="POST">
                            @csrf
                            <input type="hidden" name="without_ajax" value="1">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="user_id">Select User</label>
                                    <select class="form-control select2" name="user_id" id="user_id"
                                        data-placeholder="Select User">
                                        <option selected>Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="role_id">Select Role</label>
                                    <select class="form-control select2" name="role_id" id="role_id"
                                        data-placeholder="Select Role">
                                        <option selected>Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="footer">
                                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal -->
    <div class="modal fade editData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Given User Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="user_id_edit">Select User</label>
                                <select class="form-control select2" name="user_id" id="user_id_edit"
                                    data-placeholder="Select User">
                                    <option selected>Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger" id="msg_user_id"></div>
                            </div>
                            <div class="form-group">
                                <label for="role_id_edit">Select Role</label>
                                <select class="form-control select2" name="role_id" id="role_id_edit"
                                    data-placeholder="Select Role">
                                    <option selected>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-danger" id="msg_role_id"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.editModal').click(function(e) {
                e.preventDefault();
                $('#msg_user_id').text('');
                $('#msg_role_id').text('');

                $('#user_id_edit').val($(this).data('user_id')).trigger('change');
                $('#role_id_edit').val($(this).data('role_id')).trigger('change');
            });


            $("form#editForm").submit(function(e) {
                e.preventDefault();
                var formData = new FormData($("#editForm")[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ route('update-given-user-role') }}",
                    // dataType: "json",
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

                        $('#msg_user_id').text('');
                        $('#msg_role_id').text('');

                        $.each(error.responseJSON.errors, function(field_name, error) {
                            if (field_name == 'user_id') {
                                $('#msg_user_id').text(error);
                                toastr.error(error)

                            } else if (field_name == 'role_id') {
                                $('#msg_role_id').text(error);
                                toastr.error(error)

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
