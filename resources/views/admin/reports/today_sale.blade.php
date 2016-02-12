@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Today Sale
          </h1>
          <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
                  <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="filters">
                            <th>Product Price</th>
                            <th>Product Quantity</th>
                            <th>Product Name</th>
                            <th>Date</th>
                            <th>Employee</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($detail_sale as $detail)
                    <tr>
                      <td>{{ $detail->product_price }}</td>
                      <td>{{ $detail->product_qty }}</td>
                      <td>{{ $detail->product_name }}</td>
                      <td>{{ date("d-M-Y",strtotime($detail->created_at)) }}</td>
                      <td>{{ $detail->first_name }}</td>
                    </tr>
                    @endforeach
                        
                    </tbody>
                  </table>
                  <table class="table table-striped m-b-0">
                  <thead>
                    <tr>
                      <td style="width:162px; font-weight:bold;">Total Sale : {{ $TotalSale }}</td>
                      <td style="font-weight:bold;">Total Quantity : {{ $TotalQty }}</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </thead>
               </table>
			            {!! $detail_sale->render() !!}
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
     @stop 

     @section('footer_scripts')
     
     @stop