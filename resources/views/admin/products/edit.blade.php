@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Edit Products
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Products</a></li>
            <li class="active">Edit Product</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Product</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            
             <div class="box box-primary">
             	<div class="has-error">
                  {!! $errors->first('product_name', '<span class="help-block">:message</span>') !!}
                  {!! $errors->first('product_price', '<span class="help-block">:message</span>') !!}
                 
              </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="" method="POST">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <div class="box-body">
                    <div class="form-group">
                      <label for="first_name">Product Name *</label>
                      <input type="text" name="product_name" class="form-control" id="product_name" placeholder="Product Name" value="{{{ $products->product_name }}}">
                    </div>
                    <div class="form-group">
                      <label for="last_name">Product Code </label>
                      <input type="text" class="form-control" id="product_code" placeholder="Product Code" name="product_code" value="{{{ $products->product_code }}}">
                    </div>
                    <div class="form-group">
                      <label for="login_name">Product Price  *</label>
                      <input type="text" class="form-control" id="product_price" placeholder="Product Price" name="product_price" value="{{{ $products->product_price }}}">
                    </div>
                    <div class="form-group">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="is_active" id="is_active" @if($products->is_active == 1) checked="checked" @endif > Enable/Disable
                      </label>
                    </div>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <input type="submit" class="btn btn-primary" value="Edit">
                  </div>
                </form>
              </div> 

            <!--<div class="box-footer">
              Footer
            </div>--><!-- /.box-footer-->
          </div>
          <!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      @stop