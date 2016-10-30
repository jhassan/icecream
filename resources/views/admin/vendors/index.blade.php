@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Vendors
          </h1>
          <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/vendors/add">Add Vendors</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr class="filters">
                            <th>Vendor Name</th>
                            <th>Vendor Address</th>
                            <th>Vendor Phone</th>
                            <th>Is Active</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($vendors as $vendor)
                    	<tr id="row_{{{ $vendor->vendor_id }}}">
                    		<td>{{{ $vendor->vendor_name }}}</td>
                				<td>{{{ $vendor->vendor_address }}}</td>
                				<td>{{{ $vendor->vendor_phone }}}</td>
                				<td>@if($vendor->is_active == 0) {{ 'Disable' }} @else {{ 'Enable' }} @endif</td> 
                        <td>{{{ $vendor->created_at }}}</td> 
                				<td><a href="{{ route('vendors.update', $vendor->vendor_id) }}"><img src="{{asset("dist/img/edit.gif")}}" ></a>
                						<a id="{{ $vendor->vendor_id }}" class="deleteRecord" style="cursor:pointer;"><img src="{{asset("dist/img/delete.png")}}" ></a>
                        </td>
            			</tr>
                    @endforeach
                        <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <div id="dialog-confirm-delete" title="Delete Reocrs" style="display:none;">Do you want to delete this record?</div>
     @stop 

     @section('footer_scripts')
     <script src="{{asset('../../plugins/datatables/jquery.dataTables.min.js')}}"></script>
      <script src="{{asset('../../plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
      
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
    </script>
    <script src="{{asset('../../dist/js/jquery.ui.dialog.js')}}"></script>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/ui-lightness/jquery-ui.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
     <script type="text/javascript">
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
                title: 'Delete Vendor',
                buttons: {
                  Delete: function() {
                    jQuery(this).dialog('close');
                    $.ajax({
                          type: "GET",
                              url: '/admin/vendors/delete_vendor',
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
     </script>
     @stop
