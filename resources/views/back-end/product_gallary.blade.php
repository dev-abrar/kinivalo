@extends('back-end.admin')

@section('title')
    {{ $product->title }}'s multiple images
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                        Add New Image
                    </button>

                    <div class="card mt-2">
                        <div class="card-header">
                            <h3 class="card-title">{{ $product->title }}'s multiple images</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <table class="table table-bordered table-hover dataTable" role="grid"
                                    aria-describedby="products">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">SL#</th>
                                            <th style="width: 50%">Image</th>
                                            <th style="width:20%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $serials = ($multiple_images->currentpage() - 1) * $multiple_images->perpage() + 1;
                                        @endphp
                                        @forelse ($multiple_images as $image)
                                            <tr>
                                                <td>{{ $serials++ }}</td>
                                                <td>
                                                    <img src="{{ URL::to("/image/product_image/$image->image") }}"
                                                        width='70' />
                                                </td>
                                                <td class="flex">
                                                    <a href="{{ url('/product-gallary/edit/' . $image->id) }}"
                                                        title="Edit" data-toggle="modal" data-target="#editModal" data-image="{{ URL::to("/image/product_image/$image->image") }}"
                                                        class="btn btn-secondary btn-sm editModal"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                    <a href="{{ url('product-gallary/delete/' . $image->id) }}"
                                                        id="delete" title="Delete" class="btn btn-danger btn-sm"><i
                                                            class="fas fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="text-center">
                                                <td colspan="10" class="text-danger">No data found!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>SL#</th>
                                            <th>Image</th>
                                            <th style="width:150px;">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div>
                                {{ $multiple_images->links() }}
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>
            </div>
        </div>


        <!--add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="addData" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <label for="addImage">Image</label>
                                <input type="file" class="form-control" id="addImage" name="image">

                                <strong class="text-danger validate" data-field="image"></strong>
                                <div>
                                    <img src="" id="preview" width="200" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--add Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editData" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="id" id="id_e" value="">
                                <label for="editImage">Image</label>
                                <input type="file" class="form-control" id="editImage" name="image">

                                <strong class="text-danger validate" data-field="image"></strong>
                                <div>
                                    <img src="" id="preview1" width="200" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @push('js')
        <script>
            $(document).ready(function() {

                $("#addImage").change(function(e) {
                    e.preventDefault();
                    pleasePreview(this, "preview")
                });

                $("#editImage").change(function(e) {
                    e.preventDefault();
                    pleasePreview(this, "preview1")
                });

                $(".editModal").click(function (e) { 
                    e.preventDefault();
                    $("#preview1").attr('src', $(this).data('image'));
                    $("#id_e").val($(this).data('image'));
                });

            $("#addData").submit(function(e) {
                e.preventDefault();

                var formdata = new FormData($("#addData")[0]);
                $.ajax({
                    type: "POST",
                    url: "{{ url('product-gallary/add') }}",
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

            $("#editData").submit(function(e) {
                e.preventDefault();

                var formdata = new FormData($("#editData")[0]);
                $.ajax({
                    type: "POST",
                    url: "{{ url('product-gallary/update') }}",
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
    @endpush
@endsection
