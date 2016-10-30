@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Employee Commisions
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
                <form action="frm_view_commision" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="box-body col-sm-3">
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
                            <th style="font-size:16px; color: red">{{ date("d-M-Y", strtotime($start_date)) }} TO {{ date("d-M-Y", strtotime($end_date)) }}</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr class="filters">
                            <th>Employee Name</th>
                            <th>Total Count</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($arrayCommision as $commision)
                    	<tr>
                        <td>{{{ $commision->first_name }}} {{{ $commision->last_name }}}</td>
                        <td>{{{ number_format($commision->total_count) }}}</td>
								        <td>{{{ date("d-M-Y", strtotime($commision->created_at)) }}}</td>
            			</tr>
                    @endforeach
                    <tr class="filters">
                            <th>Total:</th>
                            <th>{{ number_format($arrayCounts) }}</th>
                            <th></th>
                        </tr>  
                    </tbody>
                  </table>
                  {!! $arrayCommision->render() !!}
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
     @stop 

     