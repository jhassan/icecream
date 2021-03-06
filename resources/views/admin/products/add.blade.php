@extends('admin/layout/default')

{{-- Page content --}}
@section('content')
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Product
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Products</a></li>
            <li class="active">Add Products</li>
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
              <h3 class="box-title">Product</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            
             <div class="box box-primarry">
             	<!-- <div class="has-error">
                  {!! $errors->first('product_name', '<span class="help-block">:message</span>') !!}
                  {!! $errors->first('product_price', '<span class="help-block">:message</span>') !!}
                 
              </div> -->
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="" method="POST">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <div class="box-body">
                    <div class="form-group col-sm-4">
                      <label for="first_name">Product Name *</label>
                      <input type="text" name="product_name" class="form-control" id="product_name" placeholder="Product Name" value="{{{ Input::old('product_name') }}}">
                    </div>
                    <div class="form-group col-sm-4">
                      <div class="dropdown">
                      <label for="shop" >Select Category</label>
                        <select class="form-control" title="Select Category..." name="category_id">
                            <option value="">Select Category</option>
                            <option value="1">Icecream Flavours</option>
                            <option value="2">Purchase Items</option>
                        </select>
                      </div>
                  </div>
                    <div class="form-group col-sm-4">
                      <label for="last_name">Product Code </label>
                      <input type="text" class="form-control" id="product_code" placeholder="Product Code" name="product_code" value="{{{ Input::old('product_code') }}}">
                    </div>
                    <div class="clear"></div>
                    <div class="form-group col-sm-4">
                      <label for="login_name">Product Price  *</label>
                      <input type="text" class="form-control" id="product_price" placeholder="Product Price" name="product_price" value="{{{ Input::old('product_price') }}}">
                    </div>
                    <div class="dropdown col-sm-4">
                    <label for="shop" >Shop</label>
                      <select class="form-control" title="Select Shop..." name="shop_id">
                          <option value="">Select</option>
                          @foreach ($shops as $shop)
                          <option value="{{{ $shop->shop_id}}}"  >{{{ $shop->shop_name}}}</option>
                          @endforeach
                      </select>
                  </div>
                    <div class="clear"></div>
                    <div class="form-group col-sm-4">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="is_active" id="is_active"> Enable/Disable
                      </label>
                    </div>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer clear">
                    <input type="submit" class="btn btn-primary" value="Save">
                  </div>
                </form>
              </div> 

            <!--<div class="box-footer">
              Footer
            </div>--><!-- /.box-footer-->
          </div>
          <!-- /.box -->

        </section><!-- /.content -->
      </div>
      @stop