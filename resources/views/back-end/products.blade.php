@extends('back-end.admin')

@section('title')
    Products
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Products</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <table class="table table-bordered table-hover dataTable" role="grid"
                                    aria-describedby="products">
                                    <thead>
                                        <tr>
                                            <th>SL#</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>R.Price</th>
                                            <th>S.Price</th>
                                            <th>App Price</th>
                                            <th>Sold Qty</th>
                                            <th>Av.Qty</th>
                                            <th>Publish Date</th>
                                            <th style="width:150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $serials = ($products->currentpage() - 1) * $products->perpage() + 1;
                                        @endphp
                                        @forelse ($products as $product)
                                            <tr>
                                                <td>{{ $serials++ }}</td>
                                                <td>
                                                    <img src="{{ URL::to("/image/product_image/$product->img1") }}"
                                                        width='70' />
                                                </td>
                                                <td>
                                                    {{ $product->title }} <br>
                                                    <small>Item code: {{ $product->pcode }}</small> <br>
                                                    <span>Status: <span class="badge badge-success">{{ $product->status }}</span></span>
                                                </td>
                                                <td>{{ $product->rprice }}</td>
                                                <td>
                                                    {{ $product->sprice }}
                                                    ({{ round((($product->rprice - $product->sprice) / $product->rprice) * 100) }}%Off)
                                                </td>
                                                <td>{{ $product->appprice }}</td>
                                                <td class="text-danger">{{ $product->order_details->sum('product_qty') }}</td>
                                                <td>{{ $product->qty }}</td>
                                                <td>{{ $product->pdate }}</td>
                                                <td class="flex">
                                                    <a href="{{ url('product/' . $product->slug) }}" title="View"
                                                        class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ url('/products/edit/' . $product->id) }}" title="Edit"
                                                        class="btn btn-secondary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="{{ url('products/delete/' . $product->id) }}" id="delete" title="Delete"
                                                        class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                                                    <a href="{{ url('/dynamic-ajax/change_product_sts/'. $product->id) }}"
                                                        class="btn btn-{{ $product->sts == 1 ? 'secondary':"info" }} btn-sm">{{ $product->sts == 1 ?'Deactive':"Active" }}</a>
                                                    <a href="{{ url('/product-gallary/'. $product->id) }}" title="Gallary"
                                                        class="btn btn-warning btn-sm"><i class="fas fa-images"></i></a>
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
                                            <th>Title</th>
                                            <th>R.Price</th>
                                            <th>S.Price</th>
                                            <th>App Price</th>
                                            <th>Sold Qty</th>
                                            <th>Av.Qty</th>
                                            <th>Publish Date</th>
                                            <th style="width:150px;">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div>
                                {{ $products->links() }}
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>
            </div>
        </div><!--/. container-fluid -->
        <div class="modal fade" id="modal-delete">
            <div class="modal-dialog">
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Confirm</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete the item?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                        <form action="" method="post" id="deleteform">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-outline-light">Yes</button>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

    </section>
@endsection

@section('script')
    @foreach (['success', 'error'] as $type)
        @if (Session::has('msg-' . $type))
            toastr.{{ $type }}('{{ Session::get('msg-' . $type) }}');
        @endif
    @endforeach
    $(document).ready(function(){
    $("#products").DataTable({
    pageLength: 25,
    processing: true,
    serverSide: true,
    ajax:{
    url: "{{ url('/admin/products') }}",
    },
    columns:[
    {
    data: 'DT_RowIndex',
    name: 'DT_RowIndex'
    },
    {
    data: 'img1',
    name: 'img1',
    render: function(data,type,full,meta){
    return "<img src={{ URL::to('/') }}/image/product_image/"+data+" width='70' />";
    },
    orderable: false
    },
    {
    data: 'title',
    name: 'title',
    render: function(data,type,full,meta){
    var code = "";
    var sts = parseInt(full['sts']);
    if(sts === 1) sts = `Status: <span class="p_sts badge badge-success">Active</span>`; else sts = `Status: <span
        class="p_sts badge badge-danger">Deactive</span>`;
    if(full['pcode'] !== "") code = `<br>Item code: ${full['pcode']}`;
    var data = `${data}<small>${code}</small><br>${sts}`;
    return data;
    },
    },
    {
    data: 'rprice',
    name: 'rprice',
    render: function(data,type,full,meta){
    var price = numeral(data).format('0,0.00');
    return price;
    },
    },
    {
    data: 'sprice',
    name: 'sprice',
    render: function(data,type,full,meta){
    var rprice = parseInt(full['rprice']);
    var sprice = parseInt(data);
    var off = "";
    if(full['rprice']) off = parseInt(((rprice-sprice)/sprice)*100);
    if(off !== 0) off = `(${off}% off)`;
    var data = `${numeral(data).format('0,0.00')} ${off}`;
    return data;
    },
    },
    {
    data: 'appprice',
    name: 'appprice',
    render: function(data,type,full,meta){
    var price = numeral(data).format('0,0.00');
    return price;
    },
    },
    {
    data: 'sold_qty',
    name: 'sold_qty',
    render: function(data,type,full,meta){
    if(data === null || data <= 0){ data=0; return `<span style='color:red;'>${data}</span>`;
        } else {
        return data;
        }
        },
        },
        {
        data: 'qty',
        name: 'qty',
        render: function(data,type,full,meta){
        if(data === null || data == 0){
        data = 0;
        return `<span style='color:red;'>${data}</span>`;
        } else if(data < 0){ return `<span style='color:red;'>${data}</span>`;
            } else {
            return data;
            }
            },
            },
            {
            data: 'pdate',
            name: 'pdate'
            },
            {
            data: 'action',
            name: 'action',
            orderable: false
            }
            ]
            });
            $('#products tbody').on( 'click', '.sts_a', function () {
            var btn = $(this);
            var id = $(this).attr('data-id');
            var currentRow = $(this).closest("tr");
            currentRow.find(".p_sts").text("Deactive").css({'background':'red'});
            $(this).removeClass("sts_a btn-secondary");
            $(this).addClass("sts_d btn-success");
            $(this).html("Active");
            change_sts(id, btn);
            });
            $('#products tbody').on( 'click', '.sts_d', function () {
            var btn = $(this);
            var id = $(this).attr('data-id');
            var currentRow = $(this).closest("tr");
            currentRow.find(".p_sts").text("Active").css({'background':'green'});
            $(this).removeClass("sts_d btn-success");
            $(this).addClass("sts_a btn-secondary");
            $(this).html("Deactive");
            change_sts(id, btn);
            });
            $('#products tbody').on( 'click', '.edit', function () {
            var id = $(this).attr('data-id');
            window.location.href = "{{ url('admin/product/edit') }}/"+id;
            });
            $('#products tbody').on( 'click', '.view', function () {
            var id = $(this).attr('data-id');
            var slug = $(this).attr('data-slug');
            window.open(
            "{{ url('product/') }}/"+id+"/"+slug,
            '_blank'
            );
            });
            $('#products tbody').on( 'click', '.delete', function () {
            var id = $(this).attr('data-id');
            var action = "{{ url('admin/product/delete') }}/"+id;
            $("#deleteform").attr("action",action);
            });

            function change_sts(id, btn){
            $.ajax({
            method: "POST",
            url: "{{ url('/admin/ajax/change_product_sts') }}",
            data: { _token: "{{ csrf_token() }}", id: id },
            beforeSend: function() {
            btn.prop('disabled',true);
            },
            complete: function(){
            btn.prop('disabled',false);
            },
            success: function(data) {
            console.log(data);
            }
            })
            }
            });
        @endsection
