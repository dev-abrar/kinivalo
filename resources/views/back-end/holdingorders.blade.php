@extends('back-end.admin')

@section('title')
Holding Orders
@endsection

@section('content')

<section class="content">
  <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">

          <div class="card">
              <div class="card-header">
                <h3 class="card-title">Holding Orders</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <div class="dataTables_wrapper dt-bootstrap4">
                  <table id="orders" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="products">
                    <thead>
                      <tr>
                        <th style="width:50px;">SL#</th>
                        <th style="width:65px;">Order Date</th>
                        <th>Customer Details</th>
                        <th>D.Cost</th>
                        <th>T.Amount</th>
                        <th>Sts</th>
                        <th>D.Status</th>
                        <th>Order Number</th>
                        <th style="width:150px;">Action</th>
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
                                    <span>{{ $order->customer_phone }}</span><br>
                                    <span>{{ $order->delivery_address }}</span>
                                </td>
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
                                    <a href="{{ url('orders/delete/' . $order->id) }}" id="delete"
                                        class="btn btn-success">Delete</a>
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
              </div>
              <!-- /.card-body -->
            </div>

        </div>
      </div>
  </div><!--/. container-fluid -->

  <div class="modal fade" id="modal-cancel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h4 class="modal-title">Cancel Order</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure to cancel the order?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          <form action="" method="post" id="cancelform">
            @csrf
            @method('put')
            <button type="submit" class="btn btn-default">Yes</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->


  <div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
      <div class="modal-content bg-danger">
        <div class="modal-header">
          <h4 class="modal-title">Delete Order</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure to delete the order?</p>
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

@foreach(['success','error'] as $type)
    @if(Session::has('msg-'.$type))
      toastr.{{ $type }}('{{ Session::get('msg-'.$type) }}');
    @endif
@endforeach

$("#orders").DataTable({
  pageLength: 25,
  hold: true,
  serverSide: true,
  ajax:{
    url: "{{ url('/admin/orders/filter/hold') }}",
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
      name: 'customer_name',
      render: function(data,type,full,meta){
        var data = `${data}<br>${full['customer_phone']}<br>${full['delivery_address']}`;
        return data;
      }
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
$('#orders tbody').on( 'click', '.cancel', function () {
  var id = $(this).attr('data-id');
  var action = "{{ url('admin/orders/canceled') }}/"+id;
  $("#cancelform").attr("action",action);
});
$('#orders tbody').on( 'click', '.delete', function () {
  var id = $(this).attr('data-id');
  var action = "{{ url('admin/orders/delete') }}/"+id;
  $("#deleteform").attr("action",action);
});
@endsection
