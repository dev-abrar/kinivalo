@extends('front-end.master')

@section('title')
{{ $page->title }}
@endsection

@section('content')

<section class="best_seller_product page_header" id="main_content_area">

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 first_col">
                <div class="panel panel-success">
                    <div class="panel-heading"><strong><i class="fa fa-info-circle"> </i> {{ $page->title }} </strong></div>
                    <div class="panel-body">
                        {!! $page->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
