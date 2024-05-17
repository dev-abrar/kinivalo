@extends('back-end.admin')

@section('title')
Categories
@endsection

@section('content')

<section class="content">
  <div class="container-fluid">
      <div class="row">
        <div class="col-md-5">

            <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Add Variation Option</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ url('variation/save_option') }}">
                  @csrf
                  <div class="card-body">
                    <div class="form-group row">
                      <label for="option" class="col-sm-3 control-label">Option Name</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control @error('option') is-invalid @enderror" id="option" name="option" value="{{ old('option') }}" required placeholder="Enter option name">
                        @error('option')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="variation_id" class="col-sm-3 control-label">Variation Name</label>
                      <div class="col-sm-9">
                        <select class="form-control @error('variation_id') is-invalid @enderror" name="variation_id" required>
                          <option disabled selected value="">Select</option>
                          @foreach($variations as $variation)
                            <option value="{{ $variation->id }}">{{ $variation->name }}</option>
                          @endforeach
                        </select>
                        @error('variation_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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

        <div class="col-md-7">

          <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Variations</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th style="width:80px;">SL#</th>
                      <th>Name</th>
                      <th style="width:150px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $sl = 1 @endphp
                      @foreach($variations as $variation)
                      <tr>
                        <td>{{ $sl }}</td>
                        <td style="display:none;">{{ $variation->id }}</td>
                        <td>{{ $variation->name }}</td>
                        <td>

                        </td>
                      </tr>
                        @foreach(App\VariationsOption::where('variation_id',$variation->id)->orderBy('id')->get() as $option)
                        <tr>
                          <td></td>
                          <td style="display:none;">{{ $option->id }}</td>
                          <td style="display:none;">{{ $option->option }}</td>
                          <td style="display:none;">{{ $option->variation_id }}</td>
                          <td><i class="fas fa-arrow-right"></i> {{ $option->option }}</td>
                          <td>
                            <div class="col-md-12">
                              <button type="button" class="editsub btn btn-success btn-xs col-sm-12" data-toggle="modal" data-target="#editsubModal">Edit</button>
                            </div>
                          </td>
                        </tr>
                        @endforeach

                        @php $sl++ @endphp
                      @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>

        </div>
      </div>
  </div><!--/. container-fluid -->

    <!----  edit Model ----->
    <div class="modal fade" id="editsubModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Variation Option</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- form start -->
                    <form role="form" action="{{ url('variation/editsub') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label>Option Name</label>
                                <input type="text" class="form-control @error('edit_opt_name') is-invalid @enderror" id="edit_opt_name" name="edit_opt_name" value="{{ old('edit_opt_name') }}" autocomplete="off" required>
                                <input type="hidden" class="form-control" id="edit_opt_id" name="edit_opt_id" value="{{ old('edit_opt_id') }}" required>
                                @error('edit_opt_name')
                                <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Variation Name</label>
                                <select class="form-control @error('edit_var') is-invalid @enderror" id="edit_var" name="edit_var" required>
                                    <option disabled selected value="">Select</option>
                                    @foreach($variations as $variation)
                                        <option value="{{ $variation->id }}">{{ $variation->name }}</option>
                                    @endforeach
                                </select>
                                @error('edit_var')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!----- end models ----->


</section>

@endsection

@section('script')
  @foreach(['success','error'] as $type)
      @if(Session::has('msg-'.$type))
        toastr.{{ $type }}('{{ Session::get('msg-'.$type) }}');
      @endif
  @endforeach

  $(document).ready(function() {

    @if($errors->has('edit_name'))
      $('#editModal').modal('show');
    @endif
    @if($errors->has('edit_opt_name') || $errors->has('edit_var'))
      $('#editsubModal').modal('show');
      var mctg = {{ old('edit_var') }};
      $("#edit_var").val(mctg);
    @endif

    $(".editsub").click(function() {           
      var currentRow=$(this).closest("tr");             
      var id = currentRow.find("td:eq(1)").text();           
      var name = currentRow.find("td:eq(2)").text();     
      var mctg = currentRow.find("td:eq(3)").text();          
            
       $("#edit_opt_id").val(id);           
       $("#edit_opt_name").val(name);           
       $("#edit_var").val(mctg);
           

    });
  });

@endsection
