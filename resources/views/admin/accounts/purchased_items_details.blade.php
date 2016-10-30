@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Purchase Items
          </h1>
          <ol class="breadcrumb hide">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/accounts/index_coa">Add COA</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <form action="frm_purchased_items_details" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="box-body col-sm-3">
                      <label for="shop_address">Start Date</label>
                      <input type="text" class="date-pick form-control" id="start_date" placeholder="Start Date" name="start_date">
                    </div>
                    <div class="box-body col-sm-3">
                      <label for="shop_address">End Date</label>
                      <input type="text" class="date-pick form-control" id="end_date" placeholder="End Date" name="end_date">
                    </div>
                  <div class="box-footer">
                    <button type="submit" style='margin-top:23px;' class="btn btn-primary">Search</button>
                  </div>
                </form>
              </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
                  <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="filters">
                            <th>Item Name</th>
                            <th>Item Price</th>
                            <th>Item Quantity</th>
                            <th>Total Amount</th>
                            <th>Vendor Name</th>
                            <th>Date Purchase</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($get_items as $item)
                    	<tr>
                        <td>{{{ $item->product_name }}}</td>
                        <td>{{{ number_format($item->item_amount) }}}</td>
                        <td>{{{ number_format($item->item_qty) }}}</td>
                        <td>{{{ number_format($item->item_amount * $item->item_qty) }}}</td>
                        <td>{{{ $item->vendor_name }}}</td>
								        <td>{{{ date("d-m-Y", strtotime($item->created_at)) }}}</td>
            			</tr>
                    @endforeach
                    <tr class="filters">
                            <th>Total:</th>
                            <th></th>
                            <th>{{ number_format($Total_Qty) }}</th>
                            <th>{{ number_format($Total_Balance) }}</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tbody>
                  </table>
                  {!! $get_items->render() !!}
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
     @stop 

     