@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View COA
          </h1>
          <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/accounts/index_coa">Add COA</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr class="filters">
                            <th>COA</th>
                            <th>COA Descriptions</th>
                            <th>COA Debit</th>
                            <th>COA Credit</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                      if(Auth::check())
                      {
                        $user_permission = Auth::user()->user_permission;
                        $array_permission = explode(',',$user_permission);
                      } 
                      ?>
                    @foreach ($arrayCOA as $coa)
                    	<tr id="row_{{{ $coa->coa_id }}}">
                        <td>{{{ $coa->coa_code }}}</td>
                        <td>{{{ $coa->coa_account }}}</td>
                        <td>{{{ number_format($coa->coa_debit) }}}</td>
                        <td>{{{ number_format($coa->coa_credit) }}}</td>
								        <td> 
                          <?php if ( in_array("28", $array_permission)) { ?>
                          <a href="{{ route('coa.update', $coa->coa_id) }}"><img src="{{asset("dist/img/edit.gif")}}" ></a>
                          <?php } if ( in_array("29", $array_permission)) { ?>
                          <a id="{{ $coa->coa_id }}" class="deleteRecord" style="cursor:pointer;"><img src="{{asset("dist/img/delete.png")}}" ></a>
                          <?php } ?>
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
       <!-- <script src="{{asset('../../dist/js/jquery.ui.dialog.js')}}"></script> -->
      <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/ui-lightness/jquery-ui.css" />
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      
      <script>
      $(function () {
        $("#example1").DataTable();
        // $('#example1').DataTable({
        //   "paging": true,
        //   "lengthChange": false,
        //   "searching": false,
        //   "ordering": true,
        //   "info": true,
        //   "autoWidth": false
        // });
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
                              url: 'delete_coa',
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