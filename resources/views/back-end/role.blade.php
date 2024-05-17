@extends('back-end.admin')

@section('title')
Role
@endsection

@section('content')

<style>
.row.card-row {
    margin-left: 50px;
}
</style>
<section class="section">
    <div class="row card-row">
        <div class="card">
            <div class="card-body">
                {{-- Role Form Header Start --}}
                <li class="card-list-group-item d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Role List</h5>
                    <a href=""><span class="badge bg-primary rounded-pill">Create Role</span></a>
                </li>{{-- Role Form Header End --}}

                {{-- Role Data Table Start --}}
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Role Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($role as $row)
                        <tr>
                            <td>{{ $row->role_name }}</td>
                            <td>
                                <a title="Edit" href=""><span class="badge btn-info"><i class="ri-edit-box-line"></i></span></a>
                                <a title="Delete" href=""><span class="badge btn-danger"><i class="ri-close-circle-line"></i></span></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>{{-- Role Data Table End --}}

            </div>
        </div>
    </div>

</section>


@endsection
