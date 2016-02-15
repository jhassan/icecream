@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add COA
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ URL::to('/accounts/view_coa') }}">View COA</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">COA</h3>
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
                  <div class="dropdown">
                    <label for="gender">COA</label>
                        <select class="form-control" title="Select Parent COA" name="parent_id">
                         <option value="">Select COA</option>
                        @foreach($arrayCOA as $coa)
	                       @if($coa->coa_id == $EditCOA->coa_id)
                          			<option selected="selected" value='{{ $coa->coa_id }}'>{{ $coa->coa_account }}&nbsp;&nbsp;{{ $coa->coa_code }}</option>
                             @else
                             <option value='{{ $coa->coa_id }}'>{{ $coa->coa_account }}&nbsp;&nbsp;{{ $coa->coa_code }}</option>
                         @endif    
		                      @endforeach   
                        </select>
			                </div>
                    </div>
                    <div class="box-body">
                      <label for="shop_address">COA Code</label>
                      <input type="text" class="form-control" id="coa_code" placeholder="COA Code" maxlength="6" name="coa_code" value="{{ $EditCOA->coa_code }}">
                    </div>
                    <div class="box-body">
                      <label for="shop_address">COA Descriptions</label>
                      <input type="text" class="form-control" id="coa_account" placeholder="COA Code" name="coa_account" value="{{ $EditCOA->coa_account }}">
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
      