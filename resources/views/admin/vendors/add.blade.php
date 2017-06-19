@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Vendors
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ URL::to('admin/vendors') }}">View Vendors</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (Session::has('message'))
               <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Vendors</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            
             <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <form action="" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <div class="box-body col-sm-4">
                      <label for="shop_address">Vendor Name</label>
                      <input type="text" class="form-control" id="vendor_name" placeholder="Vendor Name" name="vendor_name">
                    </div>
                    <div class="box-body col-sm-4">
                      <label for="shop_address">Vendor Address</label>
                      <input type="text" class="form-control" id="vendor_address" placeholder="Vendor Address" name="vendor_address">
                    </div>
                    <div class="box-body col-sm-4">
                      <label for="shop_code">Vendor Phone</label>
                      <input type="text" class="form-control" id="vendor_phone" maxlength="15" placeholder="Vendor Phone" name="vendor_phone" >
                    </div>
                    <div class="box-body col-sm-4">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="is_active" id="is_active"> Enable/Disable
                      </label>
                    </div>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="clear"></div>  
                  <div class="box-footer" style="clear:both !important;">
                    <button type="submit" class="btn btn-primary">Save</button>
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
      