
@extends('back-end.admin')
@section('title', 'Add SEO Content')
@section('content')
    <div class="content">
        <!-- Content Header (Page header) -->
        <div class="content">
            <div class="container-fluid">
                <div class="mb-2 row">
                    <div class="col-sm-6">
                        <h1 class="m-0">Pages List</h1>

                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Update SEO Content</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header">SEO Content Table</div>
                        <div class="body">
                            <div class="card-body">
                                <form method="POST" action="{{ route('update-seo-content') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $page->id }}">
                                    <div class="modal-body row">
                                        <div class="form-group col-md-4">
                                            <label for="slug">Slug</label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                placeholder="Enter Slug" value="{{ $page->slug }}" readonly>

                                            @error('slug')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                placeholder="Enter Title" value="{{ $page->title }}">

                                            @error('title')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="author">Author</label>
                                            <input type="text" class="form-control" id="author" name="author"
                                                placeholder="Enter Author" value="{{ $page->author }}">

                                            @error('author')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="keywords">Keywords</label>
                                            <div class="myContainer"></div>
                                            <input type="text" class="form-control inputTags" hidden id="keywords"
                                                name="keywords" placeholder="Enter Keywords" value="{{ $page->keywords }}">
                                            <p>{{ $page->keywords }}</p>
                                            @error('keywords')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="published_time">Published Time</label>
                                            <input type="datetime-local" class="form-control" id="published_time"
                                                name="published_time" placeholder="Enter Published Time"
                                                value="{{ $page->published_time }}">

                                            @error('published_time')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="modified_time">Modified Time</label>
                                            <input type="datetime-local" class="form-control" id="modified_time"
                                                name="modified_time" placeholder="Enter Modified Time"
                                                value="{{ $page->modified_time }}">

                                            @error('modified_time')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="expiration_time">Expiration Time</label>
                                            <input type="datetime-local" class="form-control" id="expiration_time"
                                                name="expiration_time" placeholder="Enter Expiration Time"
                                                value="{{ $page->expiration_time }}">

                                            @error('expiration_time')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="section">Section</label>
                                            <input type="text" class="form-control" id="section" name="section"
                                                placeholder="Enter Section" value="{{ $page->section }}">

                                            @error('section')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="canonical">Canonical</label>
                                            <input type="text" class="form-control" id="canonical" name="canonical"
                                                placeholder="Enter Canonical" value="{{ $page->canonical }}">

                                            @error('canonical')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="og_locale">Og Locale</label>
                                            <input type="text" class="form-control" id="og_locale" name="og_locale"
                                                placeholder="Enter Og Locale" value="{{ $page->og_locale }}">

                                            @error('og_locale')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="og_url">Og Url</label>
                                            <input type="text" class="form-control" id="og_url" name="og_url"
                                                placeholder="Enter Og Url" value="{{ $page->og_url }}">

                                            @error('og_url')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="og_type">Og Type</label>
                                            <input type="text" class="form-control" id="og_type" name="og_type"
                                                placeholder="Enter Og Type" value="{{ $page->og_type }}">

                                            @error('og_type')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>



                                        <div class="form-group col-md-4">
                                            <label for="image_url">Image Url</label>
                                            <input type="text" class="form-control" id="image_url" name="image_url"
                                                placeholder="Enter Image Url" value="{{ $page->image_url }}">

                                            @error('image_url')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="link_img_size">Link Image Size</label>
                                            <input type="number" class="form-control" id="link_img_size"
                                                name="link_img_size" placeholder="Enter Link Image Size"
                                                value="{{ $page->link_img_size }}">

                                            @error('link_img_size')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="image_height">Image Height</label>
                                            <input type="number" class="form-control" id="image_height"
                                                name="image_height" placeholder="Enter Image Height"
                                                value="{{ $page->image_height }}">

                                            @error('image_height')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="image_width">Image Width</label>
                                            <input type="number" class="form-control" id="image_width"
                                                name="image_width" placeholder="Enter Image Width"
                                                value="{{ $page->image_width }}">

                                            @error('image_width')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="twitter_side">Twitter Side</label>
                                            <input type="text" class="form-control" id="twitter_side"
                                                name="twitter_side" placeholder="Enter Twitter Side"
                                                value="{{ $page->twitter_side }}">

                                            @error('twitter_side')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>




                                        <div class="form-group col-md-4">
                                            <label for="image">Image</label>
                                            <input type="file" class="form-control photoUpload" id="image"
                                                name="image" placeholder="Choose Image" value="{{ old('image') }}">

                                            @error('image')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div>
                                                <img src="{{ asset($page->image) }}" width="100px"
                                                    class="previewHolder" alt="">
                                            </div>
                                        </div>


                                        <div class="form-group col-md-12">
                                            <label for="ckeditor">Description</label>
                                            <textarea type="text" class="form-control textEditor" rows="10" name="description"
                                                placeholder="Enter Description">{{ $page->description }}</textarea>

                                            @error('description')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary  btn-block">Update</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
@include('components.ckeditor')
    <script>
        $(document).ready(function() {
                    ckeditor('ckeditor');
            $('.myContainer').TagsInput({
                tagInputPlaceholder: 'Enter Your Tag Name ',
                tagHiddenInput: $('.inputTags'),
                tagContainerBorderColor: '#d3d3d3',
                tagBackgroundColor: '#222',
                tagColor: '#fff',
                tagBorderColor: '#688eac'
            });
        });
    </script>

@endsection
