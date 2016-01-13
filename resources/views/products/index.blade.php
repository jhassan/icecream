@extends('/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Products
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Products</a></li>
            <li class="active">Products</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
		@if(session('message'))
  		 <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('message') !!}</em></div>
		@endif
          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">User</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            
             <div class="box box-primary">
             	
              	<table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr class="filters">
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th>Product Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                    	<tr>
                    		<td>{{{ $product->product_name }}}</td>
                        <td>{{{ $product->product_code }}}</td>
                				<td>{{{ $product->product_price }}}</td>
            				<td> <a href="{{ route('products.update', $product->id) }}"><img src="{{asset("dist/img/edit.gif")}}" ></a>
							<a href="{{ route('confirm-delete/user', $product->id) }}"><img src="{{asset("dist/img/delete.png")}}" ></a>
                            </td>
            			</tr>
                    @endforeach
                        
                    </tbody>
                </table>
                
              </div> 

            <!--<div class="box-footer">
              Footer
            </div>--><!-- /.box-footer-->
          </div>
          <!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      @stop
     