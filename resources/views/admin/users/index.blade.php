@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            User
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Users</a></li>
            <li class="active">User</li>
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
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>User E-mail</th>
                            <th>City</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                    	<tr id="row_{{{ $user->id }}}">
                            <td>{{{ $user->id }}}</td>
                    		<td>{{{ $user->first_name }}}</td>
            				<td>{{{ $user->last_name }}}</td>
            				<td>{{{ $user->email }}}</td>
            				<td>{{{ $user->city }}}</td>
            				<td>{{{ $user->created_at }}}</td> 
            				<td> <a href="{{ route('users.update', $user->id) }}"><img src="{{asset("dist/img/edit.gif")}}" ></a>
							<a id="{{ $user->id }}" class="deleteRecord" style="cursor:pointer;"><img src="{{asset("dist/img/delete.png")}}" ></a>
                            </td>
            			</tr>
                    @endforeach
                    <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                    <div id="dialog-confirm-delete" title="Delete Reocrs" style="display:none;">Do you want to delete this record?</div>    
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

      @section('footer_scripts')
     <script src="{{asset('../../plugins/datatables/jquery.dataTables.min.js')}}"></script>
      <script src="{{asset('../../plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
      <script src="{{asset('../../dist/js/jquery.ui.dialog.js')}}"></script>
      <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/ui-lightness/jquery-ui.css" />
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      
      <script>
      $(function () {
        //$("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
      $(document).ready(function () {
        $.ajaxSetup({
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
          });
        jQuery(document).on('click','.deleteRecord',function(e){
        var DelID = jQuery(this).attr("id");
        var token = $('input[name="_token"]').val();
        jQuery("#dialog-confirm-delete").dialog({
                resizable: false,
                height:170,
                width: 400,
                modal: true,
                title: 'Delete Voucher',
                buttons: {
                  Delete: function() {
                    jQuery(this).dialog('close');
                    $.ajax({
                          type: "GET",
                              url: 'users/delete_user',
                          data: { DelID: DelID }
                      }).done(function( msg ) {
                          //alert( msg+'ttttt' );
                          if(msg == "delete")
                            $("#row_"+DelID).remove();
                      });
                  },
                  Cancel: function() {
                     jQuery(this).dialog('close');
                  }
                }
              });
                     
            return false;
            });
      });

    </script>
     @stop
     