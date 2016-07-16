 @extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Return Invoice
            <small></small>
          </h1>
          <ol class="breadcrumb hide">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ URL::to('/shops/show') }}">View Shops</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Return Invoice</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            
             <div class="box box-primary">
               @if($errors->has())
              @foreach ($errors->all() as $error)
                  <div style='color:red; margin-left:13px !important;'>{{ $error }}</div>
              @endforeach
              @endif
              @if(Session::has('message'))
              <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
              @endif
                <!-- /.box-header -->
                <!-- form start -->
                <form action="search_return_invoice" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="box-body col-sm-4">
                      <label for="shop_address">Invoice #</label>
                      <input type="text" class="form-control" id="invoice_id" placeholder="Enter Invoice #" name="invoice_id">
                    </div>
                    <div class="box-body col-sm-4">
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
                  <div class="box-body col-sm-4">
                      <label for="shop_address">Date</label>
                      <input type="text" class="date-pick form-control" id="return_invoice_date" placeholder="Date" name="return_invoice_date">
                    </div>
                  <div class="box-footer">
                    <button type="submit" style='margin-top:23px;' class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div> 

            <!--<div class="box-footer">
              Footer
            </div>--><!-- /.box-footer-->
          </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      @stop
      