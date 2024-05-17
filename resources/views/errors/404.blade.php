@extends('front-end.master')

@section('title')
@endsection

@section('content')
    @push('css')
        <style>
            /* Add some basic styles for your table */
            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #ccc;
                padding: 8px;
                text-align: left;
            }

            /* Apply responsive styles using media queries */
            @media screen and (max-width: 600px) {
                table {
                    border: none;
                    * Remove borders at smaller screen sizes */
                }

                tr {
                    border-bottom: solid 1px #806d6d !important;
                    padding: 8px;
                }

                th,
                td {
                    display: block;
                    /* Make table cells stack on top of each other */
                    width: 100%;
                    /* Expand cells to full width */
                    border: none !important;
                }

                tr,
                td {
                    display: block;
                    /* Make table cells stack on top of each other */
                    width: 100%;
                    /* Expand cells to full width */

                }

                .hnone {
                    display: none;
                }

                .tdwidth {
                    display: revert;
                    border-left: 1px solid #ccc !important;
                    /*padding: 5px !important;*/
                }


            }
        </style>
        <style>
            .btn-success1 {
                font-size: 21px;
                margin-bottom: 20px;
                width: 100% !important;
                border-radius: 10px !important;
                border: 1px solid #e62e04;
                background: #e62e04;
                color: #fff;
            }

            .btn-success1:hover {
                font-size: 21px;
                margin-bottom: 20px;
                width: 100% !important;
                border: 1px solid #000;
                border-radius: 10px !important;
                background: #000;
                color: #fff;
            }

            .btn-info1 {
                font-size: 21px;
                margin-bottom: 20px;
                width: 100% !important;
                border-radius: 10px !important;
                border: 1px solid #000;
                background: #000;
                color: #fff;
            }

            .btn-info1:hover {
                font-size: 21px;
                margin-bottom: 20px;
                width: 100% !important;
                border-radius: 10px !important;
                border: 1px solid #e62e04;
                background: #e62e04;
                color: #fff;
            }

            .form-horizontal .form-group {
                margin-right: -15px;
                margin-left: -15px;
            }

            .form-group.margintop {
                margin-top: 20px;
            }

            .panel-heading {
                padding: 1px 1px;
                border-bottom: 1px solid transparent;
                border-top-left-radius: 3px;
                border-top-right-radius: 3px;
            }

            .table>tbody>tr>td,
            .table>tbody>tr>th,
            .table>tfoot>tr>td,
            .table>tfoot>tr>th,
            .table>thead>tr>td,
            .table>thead>tr>th {
                padding: 8px;
                line-height: 1.42857143;
                vertical-align: center !important;
                border-top: 1px solid #ddd;
                text-align: left;
                display: revert;
            }

            td.ctable {
                padding: 10px !important;
                text-align: left;
                font-size: 16px;
                font-weight: bold;
            }

            section.details_section {
                margin-top: 20px;
            }

            .panel-info>.panel-heading {
                color: #000;
                background-color: #fff;
                border-color: #ccc;
                padding: 10px;
            }

            .col-lg-12.col-md-12.col-sm-12.rs_product {

                padding: 0px;
                margin-bottom: 20px;

            }
        </style>

        <style>
            @media (max-width: 768px) {
                .responsive-table {
                    overflow-x: auto;
                    display: block;
                    border: 1px solid #ccc;
                }

                .tdwidth {
                    display: revert;
                    border-right: 1px solid #ccc !important;
                    padding: 3px !important;
                }

                .table thead,
                .table tbody tr {
                    display: block;
                }

                .table thead {
                    position: absolute;
                    top: -9999px;
                    left: -9999px;
                }

                .table tr {
                    margin-bottom: 10px;
                    border: 1px solid #ccc;
                }

                .table td {
                    display: block;
                    text-align: right;
                    font-size: 14px;
                    border-top: none;
                }

                th,
                td {
                    padding: 15px;
                    border: 1px solid #ccc;
                }

                .table td:before {
                    content: attr(data-label);
                    float: left;
                    font-weight: bold;
                    padding-right: 10px;
                }

                .table td.tdwidth,
                .table th.tdwidth {
                    padding-left: 0;
                    padding-right: 0;
                    border: 1px solid #ccc;
                }
            }

            .radio-container {
                display: flex;
            }

            .radio-input {
                display: none;
            }

            .radio-label {
                margin-right: 10px;
                cursor: pointer;
                position: relative;
            }

            /* Style for the unchecked radio button */
            .radio-label:before {
                content: "";
                display: none;
                width: 20px;
                height: 20px;
                border: 2px solid #333;
                border-radius: 50%;
                margin-right: 5px;
                vertical-align: middle;
            }

            /* Style for the checked radio button */
            .radio-input:checked+.radio-label:before {
                background-color: #3498db;
                border-color: #3498db;
            }

            /* Additional style for the selected border around the image */
            .radio-input:checked+.radio-label img {
                border: 2px solid #3498db;
            }

            /* Hide the default radio button icon */
            .radio-input:checked+.radio-label img::before {
                content: none;
            }

            .rbimg {
                border: solid 2px #e5d5d5;
                border-radius: 5px;
                padding: 5px;
                width: 100%;
                height: 70px;
            }
        </style>
        <style>
            @media only screen and (max-width: 600px) {
                .tdwidth {
                    text-align: center;
                }

                .quantity-container {
                    float: none;
                    text-align: center;
                    margin-bottom: 10px;
                    /* Adjust the margin as needed */
                    width: auto !important;
                }

                .quantity-container div {
                    float: none;
                    display: inline-block;
                    margin: 0 2px;
                    /* Adjust the margin as needed */
                }
            }
        </style>
    @endpush
    <section class="best_seller_product" style="background-color: #fff;padding-bottom: 10px" id="main_content_area">
        <section class="details_section">
            <div class="container" style="padding-right: 0  !important;">

                <div class="row" style="margin: 20px 0;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left: 5px;padding-right: 5px">
                        <center> <img src="{{ asset('/') }}image/no-product.jpg" class="img-responsive">
                            <h3> কোন পণ্য পাওয়া যায়নি !!</h3>
                            <a href="{{ url('/') }}" class="btn btn-info">কেনাকাটা করুন</a>
                        </center>
                    </div>
                </div>
        </section>
    </section>
@endsection
