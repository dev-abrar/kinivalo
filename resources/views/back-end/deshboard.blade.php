@extends('back-end.admin')

@section('title')
Deshboard
@endsection

@section('content')

<section class="content">
  <div class="container-fluid">
    @can('report-tablet')
    
    <!-- Info boxes -->
    <div class="row">
      <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ url('/products') }}" style="color:#000 !important;">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fab fa-product-hunt"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Products</span>
              <span class="info-box-number">
                {{ $totalproduct }}
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Total Customers</span>
            <span class="info-box-number">{{ $totalcustomer }}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->

      <!-- fix for small devices only -->
      <div class="clearfix hidden-md-up"></div>

      <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ url('categories') }}" style="color:#000 !important;">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Categories</span>
              <span class="info-box-number">{{$totalctg}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </a>
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Available Qty</span>
              <span class="info-box-number">{{$totalqty}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->


    <!-- Info boxes -->
    <div class="row">
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Total Sales</span>
            <span class="info-box-number">৳ {{$totalsales}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ url('/orders') }}" style="color:#000 !important;">
          <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Orders</span>
              <span class="info-box-number">
                {{ \App\Order::all()->count() }}
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </a>
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ url('/orders/filter/pending') }}" style="color:#000 !important;">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Pending Orders</span>
              <span class="info-box-number">{{ \App\Order::where('delivery_status', 'pending')->count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </a>
      </div>
      <!-- /.col -->

      <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ url('/orders/filter/processing') }}" style="color:#000 !important;">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Processing Orders</span>
              <span class="info-box-number">{{ \App\Order::where('delivery_status', 'processing')->count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </a>
      </div>
      <!-- /.col -->
      
       <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ url('/orders/filter/hold') }}" style="color:#000 !important;">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Hold Orders</span>
              <span class="info-box-number">{{ \App\Order::where('delivery_status', 'hold')->count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </a>
      </div>

      <!-- fix for small devices only -->
      <div class="clearfix hidden-md-up"></div>

      <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ url('/orders/filter/delivered') }}" style="color:#000 !important;">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Delivered Orders</span>
              <span class="info-box-number">{{ \App\Order::where('delivery_status', 'delivered')->count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </a>
      </div>
      <!-- /.col -->
      
      <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ url('/orders/filter/complete') }}" style="color:#000 !important;">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Complete Orders</span>
              <span class="info-box-number">{{ \App\Order::where('delivery_status', 'complete')->count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </a>
      </div>
      
      
      <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ url('/orders/filter/cancel') }}" style="color:#000 !important;">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Canceled Orders</span>
              <span class="info-box-number">{{ \App\Order::where('delivery_status', 'cancel')->count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </a>
      </div>
      
      
        <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ url('/orders/filter/shipping') }}" style="color:#000 !important;">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Shipping Orders</span>
              <span class="info-box-number">{{ \App\Order::where('delivery_status', 'shipping')->count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </a>
      </div>
      
      <!-- /.col -->
    </div>
    <!-- /.row -->

    @endcan

    @can('monthly-orders-report')
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Monthly Orders Report</h5>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                {!! $chart->container() !!}
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- ./card-body -->

        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    @endcan

    <!-- /.row -->

    <!-- Main row -->

    <!-- /.row -->
  </div><!--/. container-fluid -->
</section>

@endsection
@section('links')
{!! $chart->script() !!}
@endsection
