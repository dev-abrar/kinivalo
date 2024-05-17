@extends('back-end.admin')

@section('title')
SMS Configuration
@endsection

@section('style')

@endsection

@section('content')
<style>
.toggle-container {
    display: inline-block;
    position: relative;
    width: 60px;
    height: 34px;
}

.toggle-checkbox {
    display: none;
}

.toggle-label {
    display: block;
    position: absolute;
    cursor: pointer;
    width: 100%;
    height: 100%;
    background-color: #ccc;
    border-radius: 34px;
    transition: background-color 0.3s;
}

.toggle-label::before {
    content: "";
    position: absolute;
    left: 2px;
    top: 2px;
    width: 30px;
    height: 30px;
    background-color: #fff;
    border-radius: 50%;
    transition: transform 0.3s;
}

.toggle-checkbox:checked + .toggle-label {
    background-color: #4CAF50; /* Green when activated */
}

.toggle-checkbox:checked + .toggle-label::before {
    transform: translateX(26px);
}
</style>
<section class="content">
  <div class="container-fluid">
  <!-- form start -->
  <form class="form-horizontal" method="POST" action="{{ url('dynamic-sms_update') }}" accept-charset="utf-8" enctype="multipart/form-data">
    @csrf
      <div class="row">
        <div class="col-md-9">

            <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">SMS Configuration </h3>
                </div>
                <!-- /.card-header -->
                  <div class="card-body">
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">SMS Activation <span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        @if ($api_info->activity == 1)
                            <div class="toggle-container">
                                <input type="checkbox" checked value="0" name="activity" class="toggle-checkbox" id="smsToggle">
                                <label class="toggle-label" for="smsToggle"></label>
                            </div>
                        @else
                            <div class="toggle-container">
                                <input type="checkbox" value="1" name="activity" class="toggle-checkbox" id="smsToggle">
                                <label class="toggle-label" for="smsToggle"></label>
                            </div>
                        @endif
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Sender ID <span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="sender_id" value="{{ $api_info->sender_id }}" placeholder="Sender ID">
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">API Key <span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control @error('api_key') is-invalid @enderror" id="api_key" name="api_key" value="{{ $api_info->api_key }}" required placeholder="API Key">
                        @error('api_key')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">API URL <span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control @error('api_url') is-invalid @enderror" id="api_url" name="api_url" value="{{ $api_info->api_url }}" required placeholder="API URL">
                        @error('api_url')
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

@endsection
