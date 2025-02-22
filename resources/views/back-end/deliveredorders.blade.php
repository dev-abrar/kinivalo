@extends('back-end.admin')

@section('title')
    Delivered Orders
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Delivered Orders</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <table id="orders" class="table table-bordered table-striped dataTable" role="grid"
                                    aria-describedby="products">
                                    <thead>
                                        <tr>
                                            <th style="width:5%">SL#</th>
                                            <th style="width:10%">Order Date</th>
                                            <th>Customer Name</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Delivery Cost</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Delivery Status</th>
                                            <th>Order Number</th>
                                            <th style="width:10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $serials = ($orders->currentpage() - 1) * $orders->perpage() + 1;
                                        @endphp
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td>{{ $serials++ }}</td>
                                                <td>{{ $order->order_date }}</td>
                                                <td>
                                                    <span>{{ $order->customer_name }}</span><br>
                                                </td>
                                                <td>{{ $order->customer_phone }}</td>
                                                <td>{{ $order->delivery_address }}</td>
                                                <td>{{ $order->deliver_cost }}</td>
                                                <td>{{ $order->total_cost }}</td>
                                                <td><span class="badge badge-success">{{ $order->delivery_status }}</span>
                                                </td>
                                                <td><span class="badge badge-success">{{ $order->delivery_status }}</span>
                                                </td>
                                                <td>{{ $order->tracking_no }}</td>
                                                <td>
                                                    <a href="{{ url('orders/' . $order->id) }}"
                                                        class="btn btn-primary">View</a>
                                                </td>
                                            </tr>

                                        @empty
                                            <tr class="text-center">
                                                <td colspan="10" class="text-danger">No data found!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div>
                              {{ $orders->links() }}
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
                        <h4 class="modal-title">Cancel Order</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to cancel the order?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                        <form action="" method="post" id="deleteform">
                            @csrf
                            @method('put')
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

    $("#orders").DataTable({
    pageLength: 25,
    processing: true,
    serverSide: true,
    ajax:{
    url: "{{ url('/admin/orders/filter/delivered') }}",
    },
    columns:[
    {
    data: 'DT_RowIndex',
    name: 'DT_RowIndex'
    },
    {
    data: 'order_date',
    name: 'order_date'
    },
    {
    data: 'customer_name',
    name: 'customer_name'
    },
    {
    data: 'customer_phone',
    name: 'customer_phone'
    },
    {
    data: 'delivery_address',
    name: 'delivery_address'
    },
    {
    data: 'deliver_cost',
    name: 'deliver_cost'
    },
    {
    data: 'total_cost',
    name: 'total_cost'
    },
    {
    data: 'status',
    name: 'status',
    render: function(data,type,full,meta){
    var status = data;
    if(data == 'Pending')
    status = '<span style="color:#fff;background: black;padding: 3px;border: 1px solid #827d7d;">'+data+'</span>';
    else if(data == 'Received')
    status = '<span style="color:#fff;background: green;padding: 3px;border: 1px solid #827d7d;">'+data+'</span>';
    else if(data == 'Canceled')
    status = '<span style="color:#fff;background: red;padding: 3px;border: 1px solid red;">'+data+'</span>';
    return status;
    }
    },
    {
    data: 'delivery_status',
    name: 'delivery_status',
    render: function(data,type,full,meta){
    var status = data;
    if(data == 'Pending')
    status = '<span style="color:red;padding: 3px;border: 1px solid #827d7d;">'+data+'</span>';
    else if(data == 'Processing')
    status = '<span style="color:green;padding: 3px;border: 1px solid #827d7d;">'+data+'</span>';
    else if(data == 'Delivered')
    status = '<span style="color:green;padding: 3px;border: 1px solid #827d7d;">'+data+'</span>';
    else if(data == 'Canceled')
    status = '<span style="color:red;padding: 3px;border: 1px solid #827d7d;">'+data+'</span>';
    return status;
    }
    },
    {
    data: 'tracking_no',
    name: 'tracking_no'
    },
    {
    data: 'action',
    name: 'action',
    orderable: false
    }
    ]
    });
    $('#orders tbody').on( 'click', '.view', function () {
    var id = $(this).attr('id');
    window.location.href = "{{ url('admin/orders/') }}/"+id;
    });
    $('#orders tbody').on( 'click', '.delete', function () {
    var id = $(this).attr('id');
    var action = "{{ url('admin/orders/canceled') }}/"+id;
    $("#deleteform").attr("action",action);
    });
@endsection
