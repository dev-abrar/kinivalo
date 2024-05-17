@extends('back-end.admin')

@section('title')
HomePage Setup
@endsection

@section('content')

<section class="content">
  <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              <div class="card card-info">
                  <div class="card-header">
                      <h3 class="card-title">Manage Home Page Sections</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="form-horizontal" method="POST" action="{{ url('admin/home_setup/save') }}">
                      @csrf
                      <div class="card-body">
                          <div class="col-md-5">

                              <div class="card card-info">
                                  <!-- form start -->
                                      <div class="card-body">
                                          <div class="form-group row">
                                              <div class="col-sm-offset-2 col-sm-10">
                                                  <div class="form-check">
                                                      <input type="checkbox" name="hotdeal" class="form-check-input" id="hotdeals" @if( $options->hotdeals ) checked @endif>
                                                      <label class="form-check-label" for="hotdeals">Show Hotdeal section</label>
                                                  </div>
                                              </div>
                                          </div>

                                      </div>
                                      <!-- /.card-body -->
                              </div>

                              <div class="card card-info">
                                  <div class="card-header">
                                      <h3 class="card-title">Section 1 <small>(This is the latest items section)</small></h3>
                                  </div>
                                  <!-- /.card-header -->
                                  <!-- form start -->
                                      <div class="card-body">
                                          <div class="form-group row">
                                              <label for="section_name_1" class="col-sm-6 control-label">Section Title</label>
                                              <div class="col-sm-6">
                                                  <input type="text" class="form-control @error('section_name_1') is-invalid @enderror" id="section_name_1" name="section_name_1" value="{{ $options->section_name_1 }}">
                                                  @error('section_name_1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                  @enderror
                                              </div>
                                          </div>
                                          <div class="form-group row">
                                              <div class="col-sm-offset-2 col-sm-10">
                                                  <div class="form-check">
                                                      <input type="checkbox" name="section_1" class="form-check-input" id="section_1" @if( $options->section_1 ) checked @endif>
                                                      <label class="form-check-label" for="section_1">Yes, show this section on homepage.</label>
                                                  </div>
                                              </div>
                                          </div>

                                      </div>
                                      <!-- /.card-body -->
                              </div>

                              <div class="card card-info">
                                  <div class="card-header">
                                      <h3 class="card-title">Section 2</h3>
                                  </div>
                                  <!-- /.card-header -->
                                  <!-- form start -->
                                  <div class="card-body">
                                      <div class="form-group row">
                                          <label for="section_name_2" class="col-sm-6 control-label">Section Title</label>
                                          <div class="col-sm-6">
                                              <input type="text" class="form-control @error('section_name_2') is-invalid @enderror" id="section_name_2" name="section_name_2" value="{{ $options->section_name_2 }}">
                                              @error('section_name_2')
                                              <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                              @enderror
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label for="section_ctg_2" class="col-sm-6 control-label">Select Category</label>
                                          <div class="col-sm-6">
                                              <select class="form-control @error('section_ctg_2') is-invalid @enderror" name="section_ctg_2">
                                                  <option disabled selected value="">Select</option>
                                                  @foreach($categories as $category)
                                                      @if($category->id == $options->section_ctg_2)
                                                          <option selected value="{{ $category->id }}">{{ $category->name }}</option>
                                                      @else
                                                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                      @endif
                                                  @endforeach
                                              </select>
                                              @error('section_ctg_2')
                                              <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                              @enderror
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <div class="col-sm-offset-2 col-sm-10">
                                              <div class="form-check">
                                                  <input type="checkbox" name="section_2" class="form-check-input" id="section_2" @if( $options->section_2 ) checked @endif>
                                                  <label class="form-check-label" for="section_2">Yes, show this section on homepage.</label>
                                              </div>
                                          </div>
                                      </div>

                                  </div>
                                  <!-- /.card-body -->
                              </div>

                              <div class="card card-info">
                                  <div class="card-header">
                                      <h3 class="card-title">Section 3</h3>
                                  </div>
                                  <!-- /.card-header -->
                                  <!-- form start -->
                                  <div class="card-body">
                                      <div class="form-group row">
                                          <label for="section_name_3" class="col-sm-6 control-label">Section Title</label>
                                          <div class="col-sm-6">
                                              <input type="text" class="form-control @error('section_name_3') is-invalid @enderror" id="section_name_3" name="section_name_3" value="{{ $options->section_name_3 }}">
                                              @error('section_name_3')
                                              <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                              @enderror
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label for="section_ctg_3" class="col-sm-6 control-label">Select Category</label>
                                          <div class="col-sm-6">
                                              <select class="form-control @error('section_ctg_3') is-invalid @enderror" name="section_ctg_3">
                                                  <option disabled selected value="">Select</option>
                                                  @foreach($categories as $category)
                                                      @if($category->id == $options->section_ctg_3)
                                                          <option selected value="{{ $category->id }}">{{ $category->name }}</option>
                                                      @else
                                                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                      @endif
                                                  @endforeach
                                              </select>
                                              @error('section_ctg_3')
                                              <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                              @enderror
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <div class="col-sm-offset-2 col-sm-10">
                                              <div class="form-check">
                                                  <input type="checkbox" name="section_3" class="form-check-input" id="section_3" @if( $options->section_3 ) checked @endif>
                                                  <label class="form-check-label" for="section_3">Yes, show this section on homepage.</label>
                                              </div>
                                          </div>
                                      </div>

                                  </div>
                                  <!-- /.card-body -->
                              </div>

                              <div class="card card-info">
                                  <div class="card-header">
                                      <h3 class="card-title">Section 4</h3>
                                  </div>
                                  <!-- /.card-header -->
                                  <!-- form start -->
                                  <div class="card-body">
                                      <div class="form-group row">
                                          <label for="section_name_4" class="col-sm-6 control-label">Section Title</label>
                                          <div class="col-sm-6">
                                              <input type="text" class="form-control @error('section_name_4') is-invalid @enderror" id="section_name_4" name="section_name_4" value="{{ $options->section_name_4 }}">
                                              @error('section_name_4')
                                              <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                              @enderror
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label for="section_ctg_4" class="col-sm-6 control-label">Select Category</label>
                                          <div class="col-sm-6">
                                              <select class="form-control @error('section_ctg_4') is-invalid @enderror" name="section_ctg_4">
                                                  <option disabled selected value="">Select</option>
                                                  @foreach($categories as $category)
                                                      @if($category->id == $options->section_ctg_4)
                                                          <option selected value="{{ $category->id }}">{{ $category->name }}</option>
                                                      @else
                                                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                      @endif
                                                  @endforeach
                                              </select>
                                              @error('section_ctg_4')
                                              <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                              @enderror
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <div class="col-sm-offset-2 col-sm-10">
                                              <div class="form-check">
                                                  <input type="checkbox" name="section_4" class="form-check-input" id="section_4" @if( $options->section_4 ) checked @endif>
                                                  <label class="form-check-label" for="section_4">Yes, show this section on homepage.</label>
                                              </div>
                                          </div>
                                      </div>

                                  </div>
                                  <!-- /.card-body -->
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
    @if($errors->has('edit_sub_name') || $errors->has('edit_mctg'))
      $('#editsubModal').modal('show');
      var mctg = {{ old('edit_mctg') }};
      $("#edit_mctg").val(mctg);
    @endif

    $(".editmctg").click(function() {           
      var currentRow=$(this).closest("tr");             
      var id = currentRow.find("td:eq(1)").text();           
      var position = currentRow.find("td:eq(2)").text();           
      var sts = currentRow.find("td:eq(3)").text();           
      var name = currentRow.find("td:eq(4)").text();     

       console.log(id);               
       $("#edit_id").val(id);           
       $("#edit_name").val(name);           
       $("#edit_pos").val(position);

       if(sts == 1){
            $("#edit_sts").prop("checked", true);
        } else if(sts == 0){
            $("#edit_sts").prop("checked", false);
        }           

    });

    $(".editsub").click(function() {           
      var currentRow=$(this).closest("tr");             
      var id = currentRow.find("td:eq(1)").text();           
      var name = currentRow.find("td:eq(2)").text();     
      var mctg = currentRow.find("td:eq(3)").text();           
      var sts = currentRow.find("td:eq(4)").text();           
            
       $("#edit_sub_id").val(id);           
       $("#edit_sub_name").val(name);           
       $("#edit_mctg").val(mctg);

       if(sts == 1){
            $("#edit_sub_sts").prop("checked", true);
        } else if(sts == 0){
            $("#edit_sub_sts").prop("checked", false);
        }           

    });
  });

@endsection
