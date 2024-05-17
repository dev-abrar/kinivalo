@extends('back-end.admin')

@section('title')
    Add New Product
@endsection

@section('css')
    <style>
        .imgDiv {
            width: 195px;
            height: 195px;
        }

        .images {
            width: 195px;
            height: 195px;
            padding: 5px;
        }

        .upload {
            width: 145px;
            height: 33px;
            opacity: 0;
            position: relative;
            left: 0;
            top: 0;
            z-index: 20;
        }

        ::-webkit-scrollbar {
            width: 15px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey;
            border-radius: 5px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #bec3bf;
            border-radius: 5px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #9fa2a0;
        }

        .thumbnail-container {
            margin: 5px;
            display: inline-block;
            position: relative;
        }

        .thumbnail {
            max-width: 200px;
            /* Set the maximum width to 200px */
            max-height: 100px;
            border: 1px solid #ddd;
            margin: 0;
        }

        .close-button {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #f00;
            color: #fff;
            border: none;
            padding: 2px 5px;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- form start -->
            <form class="form-horizontal" id="addData" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-9">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Add Product</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 control-label">Product Name <span
                                            style="color:red;">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}" required
                                            placeholder="Enter product name">

                                        <strong class="text-danger validate" data-field="name"></strong>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="slug" class="col-sm-3 control-label">Product Slug <span
                                            style="color:red;">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                            id="slug" name="slug" value="{{ old('slug') }}" required
                                            placeholder="Enter product slug">

                                        <strong class="text-danger validate" data-field="slug"></strong>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="pcode" class="col-sm-3 control-label">Product Code</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('pcode') is-invalid @enderror"
                                            id="pcode" name="pcode" value="{{ old('pcode') }}"
                                            placeholder="Enter product code">

                                        <strong class="text-danger validate" data-field="pcode"></strong>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-3 control-label">Phone number(s)</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone') }}"
                                            placeholder="Enter phone number(s) separated by commas(,)">

                                        <strong class="text-danger validate" data-field="phone"></strong>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <label for="bkash" class="col-sm-3 control-label">Bkash Marchent</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('bkash') is-invalid @enderror"
                                            id="bkash" name="bkash" value="{{ old('bkash') }}"
                                            placeholder="Enter bkash Marchent number">
                                        @error('bkash')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label">Product Video</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="product_video"
                                            placeholder="N3SFK9pXnSQ">
                                    </div>

                                    <strong class="text-danger validate" data-field="product_video"></strong>
                                </div>
                                <div class="form-group row">
                                    <label for="pcode" class="col-sm-3 control-label">Hot Deal</label>
                                    <div class="col-sm-offset-2 col-sm-9">
                                        <div class="form-check">
                                            <input type="checkbox" name="hot" class="form-check-input" id="hot"
                                                @if (old('hot')) checked @endif>
                                            <label class="form-check-label" for="hot">Add as Hot Deal item</label>
                                        </div>
                                    </div>

                                    <strong class="text-danger validate" data-field="hot"></strong>
                                </div>

                                <div class="form-group">
                                    <label for="thumbnail">Upload Thumbnail:</label>
                                    <input type="file" id="thumbnail" name="img1" accept="image/*">

                                    <strong class="text-danger validate" data-field="img1"></strong>
                                    <div>
                                        <img src="" id="preview" width="200" alt="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="files">Upload Multiple:</label>
                                    <input type="file" id="files" name="photos[]" multiple accept="image/*">

                                    <strong class="text-danger validate" data-field="photos"></strong>
                                </div>

                                <div class="form-group row" id="previewContainer">
                                    <!-- Images will be dynamically added here -->
                                </div>

                                <br />

                                <label for="pcode" class="control-label">Description <span
                                        style="color:red;">*</span></label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <textarea id="long_description" name="long_description" placeholder="Place some text here"
                                            style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;">{{ old('long_description') }}</textarea>
                                    </div>

                                    <strong class="text-danger validate" data-field="long_description"></strong>
                                </div>

                                <div class="form-group row">
                                    <label for="video" class="col-sm-3 control-label">Youtube embed Code
                                        (width="100%" height="550" ) </label>
                                    <div class="col-sm-9">
                                        <textarea type="text" class="form-control" id="video" name="video" rows="5"
                                            placeholder="Youtube embed Code"></textarea>

                                        <strong class="text-danger validate" data-field="video"></strong>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label>পন্যর কালার </label>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>কালার নাম</th>
                                                    <th>কালার ছবি</th>
                                                    <th>দাম </th>
                                                    <th>পরিমান </th>
                                                    <th>যোগ </th>
                                                </tr>
                                            </thead>
                                            @livewire('backend.product-color')
                                        </table>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="meta_title" class="col-sm-3 control-label">Meta Title <span
                                            style="color:red;">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                            class="form-control @error('meta_title') is-invalid @enderror" id="meta_title"
                                            name="meta_title" value="{{ old('meta_title') }}" required
                                            placeholder="Enter Meta Title">

                                        <strong class="text-danger validate" data-field="content"></strong>
                                    </div>
                                </div>


                                <label for="meta_description" class="control-label">Meta Description <span
                                        style="color:red;">*</span></label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <textarea id="meta_description" name="meta_description" class="form-control" rows="10"
                                            placeholder="Place some text here">{{ old('meta_description') }}</textarea>
                                    </div>

                                    <strong class="text-danger validate" data-field="content"></strong>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>

                    </div>

                    <div class="col-md-3">
                        <!-- /.card -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Price & Qty</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="rprice">Regular Price</label>
                                    <input type="number" class="form-control" id="rprice" name="rprice"
                                        value="{{ old('rprice') }}" placeholder="Regular Price">
                                    <strong class="text-danger validate" data-field="content"></strong>
                                </div>
                                <div class="form-group">
                                    <label for="sprice">Standard Price <span style="color:red;">*</span></label>
                                    <input type="number" class="form-control" id="sprice" name="sprice"
                                        value="{{ old('sprice') }}" placeholder="Standard Price">
                                    <strong class="text-danger validate" data-field="content"></strong>
                                </div>
                                <div class="form-group">
                                    <label for="sprice">App Price <span style="color:red;">*</span></label>
                                    <input type="number" class="form-control" id="appprice" name="appprice"
                                        value="{{ old('appprice') }}" placeholder="App Price">
                                    <strong class="text-danger validate" data-field="content"></strong>
                                </div>
                                <div class="form-group">
                                    <label for="qty">Qty <span style="color:red;">*</span></label>
                                    <input type="number" class="form-control" id="qty" name="qty"
                                        value="{{ old('qty') }}" placeholder="Available quantity">
                                    <strong class="text-danger validate" data-field="content"></strong>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Select Categories <span style="color:red;">*</span></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="height: 400px;overflow-y: auto;">
                                <table id="alldata" class="table table-striped table-sm" style="width:100%">
                                    <tbody>
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td style="display:none;">{{ $category->id }}</td>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <div class="form-check">
                                                            <label class="form-check-label" style="display: block;">
                                                                <input class="ctgs form-check-input" name="pr_ctg[]"
                                                                    value="{{ $category->id }}" type="checkbox" required>
                                                                {{ $category->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <strong class="text-danger validate" data-field="content"></strong>
                                            </tr>
                                            @foreach (App\Category::where('mctg', $category->id)->orderBy('id')->get() as $subctg)
                                                <tr>
                                                    <td style="display:none;">{{ $subctg->id }}</td>
                                                    <td style="display:none;">{{ $subctg->mctg }}</td>
                                                    <td style="display:none;">{{ $subctg->name }}</td>
                                                    <td>
                                                        <div class="form-group ml-4 mb-0">
                                                            <div class="form-check">
                                                                <label class="form-check-label" style="display: block;">
                                                                    <input class="ctgs form-check-input" name="pr_ctg[]"
                                                                        value="{{ $subctg->id }}" type="checkbox"
                                                                        required>
                                                                    {{ $subctg->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <strong class="text-danger validate"
                                                            data-field="content"></strong>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>

                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Select Variations</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="height: 400px;overflow-y: auto;">
                                <table id="alldata" class="table table-striped table-sm" style="width:100%">
                                    <tbody>
                                        @foreach ($variations as $variation)
                                            <tr>
                                                <td style="display:none;">{{ $variation->id }}</td>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <div class="form-check">
                                                            <label class="form-check-label" style="display: block;">
                                                                {{ $variation->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @foreach (App\VariationsOption::where('variation_id', $variation->id)->orderBy('id')->get() as $option)
                                                <tr>
                                                    <td style="display:none;">{{ $option->id }}</td>
                                                    <td>
                                                        <div class="form-group ml-4 mb-0">
                                                            <div class="form-check">
                                                                <label class="form-check-label" style="display: block;">
                                                                    <input class="ctgs form-check-input"
                                                                        name="variations[]" value="{{ $option->id }}"
                                                                        type="checkbox">
                                                                    {{ $option->option }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <strong class="text-danger validate" data-field="content"></strong>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>

                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <button type="submit" name="action" value="publish"
                                    class="btn btn-block bg-gradient-success btn-sm">Publish</button>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->

                </div>
            </form>
        </div><!--/. container-fluid -->

    </section>
@endsection

@section('js')
    <script>
        @foreach (['success', 'error'] as $type)
            @if (Session::has('msg-' . $type))
                toastr.{{ $type }}('{{ Session::get('msg-' . $type) }}');
            @endif
        @endforeach

        $(document).ready(function() {
            $(function() {
                $('#long_description').summernote({
                    height: 500
                });
                $('#long_description').summernote('code', "{!! json_encode(old('long_description')) !!}");
            });

            $(".ctgs").change(function() {
                var selected = 0;
                $(".ctgs").each(function() {
                    if ($(this).is(':checked')) {
                        selected = 1;
                    }

                });

                if (selected == 1) {
                    $(".ctgs").each(function() {
                        $(this).prop("required", false);
                    });
                } else {
                    $(".ctgs").each(function() {
                        $(this).prop("required", true);
                    });
                }

            });

            $("#thumbnail").change(function(e) {
                e.preventDefault();
                pleasePreview(this, "preview")
            });

            $('#name').on('keyup', function() {
                convertToSlug($(this).val());
            });

            function convertToSlug(title) {
                var slug = title.toLowerCase()
                    .replace(/[^\u0980-\u09FFa-z0-9-]+/g, '-') // Include Bangla characters in the regex
                    .replace(/^\-+|\-+$/g, ''); // Remove leading and trailing hyphens
                $('#slug').val(slug);
            }


            $("#addData").submit(function(e) {
                e.preventDefault();

                var formdata = new FormData($("#addData")[0]);
                $.ajax({
                    type: "POST",
                    url: "{{ url('products/save') }}",
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#preloader').fadeIn();
                        $('.wrapper,.main-footer').hide();
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formdata,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.success);
                        } else if (response.error) {
                            toastr.error(response.error);
                        }
                                    
                        $('#preloader').fadeOut();
                        $('.wrapper,.main-footer').show();
                    },
                    error: function(error) {
                        
                        $('#preloader').fadeOut();
                        $('.wrapper,.main-footer').show();
                        $('.validate').text('');
                        $.each(error.responseJSON.errors, function(field_name, error) {
                            const errorElement = $('.validate[data-field="' +
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

    <script>
        window.onload = function() {
            var filesInput = document.getElementById("files");
            var previewContainer = document.getElementById("previewContainer");

            filesInput.addEventListener("change", function(event) {
                var files = event.target.files;

                // Remove previous images in the container
                previewContainer.innerHTML = '';

                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    if (file.type.match('image')) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var img = document.createElement("img");
                            img.src = e.target.result;
                            img.className = "images img-fluid";

                            var card = document.createElement("div");
                            card.className = "col-md-3 mb-3";
                            card.innerHTML = '<div class="border imgDiv">' + img.outerHTML +
                                '<input type="button" style="float:left;margin-left:15px;padding: 4px 13px;" class="btn btn-sm btn-warning" value="x" onclick="removeImage(this)">' +
                                '</div>';

                            // Append the new card to the container
                            previewContainer.appendChild(card);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });
        };

        function removeImage(button) {
            // Remove the corresponding card when the remove button is clicked
            var card = button.closest('.col-md-3');
            card.parentNode.removeChild(card);
        }
    </script>
@endsection
