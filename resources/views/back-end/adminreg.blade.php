@extends('back-end.admin')

@section('title')
Categories
@endsection

@section('content')

<style>
.col-md-5.p-from {
    margin-left: 90px;
}
</style>

<section class="content">
  <div class="container-fluid">
      <div class="row">
        <div class="col-md-5 p-from">

            <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Add Employee</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="GET" action="{{ url('/admin/reg/save') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="card-body">
                    <div class="form-group row">
                     
                      <div class="col-sm-12">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="Enter name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      
                      <div class="col-sm-12">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="Enter email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      
                      <div class="col-sm-12">
                        <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="Enter phone">
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      
                      <div class="col-sm-12">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}" required placeholder="Enter password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      
                      <div class="col-sm-12">
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" required placeholder="Enter address">
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    
                    
                    <div class="input-group mb-3">
                        
                        <div class="col-12">
                            <select name="role" class="form-select" aria-label="Default select example">
                                <option>Choose Role</option>
                                @foreach ($role as $row)
                                <option value="{{ $row->id }}">{{ $row->role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                  </div>
                  <!-- /.card-footer -->
                </form>
            </div>

            

        </div>

        
      </div>
  </div><!--/. container-fluid -->

</section>

@endsection

