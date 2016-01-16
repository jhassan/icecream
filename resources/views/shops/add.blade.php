@extends('/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Shop
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ URL::to('/shops/show') }}">View Shops</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Shop</h3>
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
                  <div class="box-body">
                      <label for="shop_address">Shop Name</label>
                      <input type="text" class="form-control" id="shop_name" placeholder="Shop Name" name="shop_name">
                    </div>
                    <div class="box-body">
                      <label for="shop_address">Shop Address</label>
                      <input type="text" class="form-control" id="shop_address" placeholder="Shop Address" name="shop_address">
                    </div>
                    <div class="box-body">
                      <label for="shop_code">Shop Code</label>
                      <input type="text" class="form-control" id="shop_code" maxlength="3" placeholder="Shop Code" name="shop_code" >
                    </div>
                    <div class="box-body">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="is_active" id="is_active"> Enable/Disable
                      </label>
                    </div>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
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
      