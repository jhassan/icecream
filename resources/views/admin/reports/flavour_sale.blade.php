@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Sale Flavour
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
                <form action="" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="box-body col-sm-3">
                      <label for="shop_address">Date</label>
                      <input type="text" class="date-pick form-control" id="start_date" placeholder="Start Date" name="start_date">
                    </div>
                    <div class="box-body col-sm-3">
                      <div class="dropdown">
                      <label for="shop" >Shop</label>
                        <select class="form-control" title="Select Shop..." name="shop_id">
                            <option value="">Select</option>
                            @foreach ($shops as $shop)
                            <option value="{{{ $shop->shop_id}}}"  >{{{ $shop->shop_name}}}</option>
                            @endforeach
                        </select>
                      </div>
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
                  <h2>{{ $shop_name }} @if($today_date != "") /{{ date("d-m-Y", strtotime($today_date)) }} @endif</h2>
                  <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="filters">
                            <th>Flavour Name</th>
                            <th>Sale Quantity</th>
                            <th>Date Sale</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($all_flavour as $flavour)
                    	<tr>
                        <td>{{{ $flavour->product_name }}}</td>
                        <td style="font-weight: bold">{{{ number_format($flavour->TotalQty) }}}</td>
								        <td>{{{ date("d-m-Y", strtotime($flavour->created_at)) }}}</td>
            			</tr>
                    @endforeach
                    <tr class="filters">
                            <th>Total:</th>
                            <th>{{ number_format($flavour_sum_qty) }}</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
     @stop 

     