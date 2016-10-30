@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Employee Commision
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Commision</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            @if (count($errors) > 0)
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
          @if(session('message'))
            <div class="alert alert-success">
                  <ul>
            <li>{{session('message')}}</li>
            </ul>
              </div>
          @endif
          @if(session('message_error'))
            <div class="alert alert-danger">
                  <ul>
            <li>{{session('message_error')}}</li>
            </ul>
              </div>
          @endif
          
             <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <form action="save_commision" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="vm_type" value="BP" />
                    
                    <div class="box-body col-sm-4">
                      <div class="dropdown">
                      <label for="shop" >Select Employee</label>
                        <select class="form-control" title="Select Employee..." name="user_id">
                            <option value="">Select</option>
                            @foreach ($arrayUsers as $user)
                            <option value="{{{ $user->id}}}"  >{{{ $user->first_name}}} {{{ $user->last_name}}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                  <div class="box-body col-sm-4">
                      <label for="shop_address">Total Count</label>
                      <input type="text" class="form-control" id="total_count" placeholder="Total Count" name="total_count">
                    </div>  
                  <div class="box-body col-sm-4">
                      <label for="shop_address">Date</label>
                      <input type="text" class="date-pick form-control" id="vm_date" placeholder="Date" name="vm_date">
                    </div>
                  
                  </div><!-- /.box-body -->

                  <div class="box-footer clear" style="clear:both !important;">
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
      <style type="text/css">
      option.bold-text { font-weight:bold !important; text-shadow: 0px 0px 0px black !important; }
      </style>
      