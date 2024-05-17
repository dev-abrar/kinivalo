@extends('back-end.admin')

@section('title')
Payment Configuration
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
  
      <div class="row">
        <div class="col-md-6">
        <form class="form-horizontal" method="POST" action="{{ url('dynamic-payment_update') }}" accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="bkash" name="payment_method">
            <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Bkash Configuration </h3>
                </div>
                <!-- /.card-header -->
                  <div class="card-body">
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Bkash Activation <span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        @if ($bkash->activity == 1)
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
                      <label class="col-sm-3 control-label">BKASH USER NAME<span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="user_name" value="{{ $bkash->user_name }}" required placeholder="BKASH USER NAME">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">BKASH PASSWORD<span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="user_password" value="{{ $bkash->user_password }}" required placeholder="BKASH PASSWORD">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">BKASH APP KEY<span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="user_app_key" value="{{ $bkash->user_app_key }}" required placeholder="BKASH APP KEY">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">BKASH SECRET KEY<span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="user_app_secret" value="{{ $bkash->user_app_secret }}" required placeholder="BKASH SECRET KEY">
                      </div>
                    </div>
                    
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                  </div>
            </div>
            </form>
        </div>
        
        
        <div class="col-md-6">
        <form class="form-horizontal" method="POST" action="{{ url('dynamic-payment_update') }}" accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="aamarpay" name="payment_method">
            <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Aamarpay Configuration </h3>
                </div>
                  <div class="card-body">
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">Aamarpay Activation<span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        @if ($aamarpay->activity == 1)
                            <div class="toggle-container">
                                <input type="checkbox" checked value="0" name="activity" class="toggle-checkbox" id="smsToggle2">
                                <label class="toggle-label" for="smsToggle2"></label>
                            </div>
                        @else
                            <div class="toggle-container">
                                <input type="checkbox" value="1" name="activity" class="toggle-checkbox" id="smsToggle2">
                                <label class="toggle-label" for="smsToggle2"></label>
                            </div>
                        @endif
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">STORE ID<span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="store_id" value="{{ $aamarpay->store_id }}" required placeholder="STORE ID">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 control-label">SIGNATURE KEY<span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="signature_key" value="{{ $aamarpay->signature_key }}" required placeholder="SIGNATURE KEY">
                      </div>
                    </div>
                    
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                  </div>
            </div>
            </form>
        </div>
        
        <div class="col-md-6">
        <form class="form-horizontal" method="POST" action="{{ url('dynamic-payment_update') }}" accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="cod" name="payment_method">
            <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Cash on Delivery</h3>
                </div>
                  <div class="card-body">
                    <div class="form-group row">
                      <label class="col-sm-4 control-label">Cash on Delivery Activation <span style="color:red;">*</span></label>
                      <div class="col-sm-8">
                        @if ($cod->activity == 1)
                            <div class="toggle-container">
                                <input type="checkbox" checked value="0" name="activity" class="toggle-checkbox" id="smsToggle1">
                                <label class="toggle-label" for="smsToggle1"></label>
                            </div>
                        @else
                            <div class="toggle-container">
                                <input type="checkbox" value="1" name="activity" class="toggle-checkbox" id="smsToggle1">
                                <label class="toggle-label" for="smsToggle1"></label>
                            </div>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                  </div>
            </div>
            </form>
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
