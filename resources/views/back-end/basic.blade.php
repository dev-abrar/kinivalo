@extends('back-end.admin')

@section('title')
Basic Info
@endsection

@section('style')

@endsection

@section('content')

<section class="content">
  <div class="container-fluid">
  <!-- form start -->
  <form class="form-horizontal" method="POST" action="{{ url('dynamic-info/update') }}" accept-charset="utf-8" enctype="multipart/form-data">
    @csrf
    @method('put')
      <div class="row">
        <div class="col-md-9">

            <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Update Basic info</h3>
                </div>
                <!-- /.card-header -->
                  <div class="card-body">
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Name <span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $info->name }}" required placeholder="Enter name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Contact Numbers <span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control @error('contact_no') is-invalid @enderror" id="contact_no" name="contact_no" value="{{ $info->contact_no }}" required placeholder="Enter contact numbers">
                        @error('contact_no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Help Line <span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ $info->phone }}" required placeholder="Enter contact numbers">
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Email <span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control @error('email_address') is-invalid @enderror" id="email_address" name="email_address" value="{{ $info->email_address }}" required placeholder="Enter Email address">
                        @error('email_address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Marchant Bkash Number <span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control @error('bkas') is-invalid @enderror" id="bkas" name="bkas" value="{{ $info->bkas }}" required placeholder="Enter contact numbers">
                        @error('bkas')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Facebook</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="facebook" value="{{ $info->facebook }}" placeholder="Facebook Page Link">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Twitter</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="twitter" value="{{ $info->twitter }}" placeholder="Twitter Page Link">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Instagram</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="instagram" value="{{ $info->instagram }}" placeholder="Instagram Page Link">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Youtube</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="youtube" value="{{ $info->youtube }}" placeholder="Youtube Page Link">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Linkedin</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="linkedin" value="{{ $info->linkedin }}" placeholder="Linkedin Page Link">
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Address</label>
                      <div class="col-sm-9">
                          <textarea class="form-control" name="address" rows="3" placeholder="Enter you address. This address will be used in invoice.">{{ $info->address }}</textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Logo <span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <div class="input-group">
                          <div class="custom-file @error('logo') is-invalid @enderror">
                            <input type="file" name="logo" class="custom-file-input"  onchange="readURL(this);">
                            <label class="custom-file-label">Choose file</label>
                            <input type="hidden" name="preLogo" class="form-control" value="{{ $info->logo }}">
                          </div>
                        </div>
                        @error('logo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    
                    
                    
                      <div class="form-group">
                          <img id="logo" src="{{ url('/'.$info->logo) }}" class="col-md-4 mt-4">
                      </div>
                      <br>
                      <br>
                       
                      <br>
                      <br>
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Footer Logo <span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <div class="input-group">
                          <div class="custom-file @error('f_logo') is-invalid @enderror">
                            <input type="file" name="f_logo" class="custom-file-input"  onchange="readURL2(this);">
                            <label class="custom-file-label">Choose file</label>
                            <input type="hidden" name="preLogo_f" class="form-control" value="{{ $info->f_logo }}">
                          </div>
                        </div>
                        @error('f_logo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    
                    
                    
                      <div class="form-group">
                          <img id="f_logo" src="{{ url('/'.$info->f_logo) }}" class="col-md-4 mt-4">
                      </div>
                      <br>
                      <br>
                       
                      <br>
                      <br>
                    <div class="form-group row">

                        <label for="pcode" class="col-sm-3 control-label">Footer Section Details </label>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <textarea class="textarea" name="footer_details" placeholder="Place some text here" style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;"></textarea>
                            </div>
                        </div>
                        <textarea id="des" style="display:none;">{{ $info->footer_details }}</textarea>
                    </div>

                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                  </div>
            </div>

        </div>

      </div>
    </form>
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
    $(function () {
      // Summernote
      var des = $("#des").val();
      $('.textarea').summernote({
        height: 300
      });
      $('.textarea').summernote('code', des);
    });

  });

  
  function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#logo').attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
      }
  }

  function readURL2(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#f_logo').attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
      }
  }

@endsection
