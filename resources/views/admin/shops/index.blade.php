@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Shops
          </h1>
          <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="shops/add">Add Shop</a></li>
          </ol>
        </section>

        <!-- Main content -->

        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              @if(session('message'))
                 <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('message') !!}</em></div>
              @endif
              <div class="box">
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr class="filters">
                            <th>ID</th>
                            <th>Shop Name</th>
                            <th>Shop Address</th>
                            <th>Shop Code</th>
                            <th>Created At</th>
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
                    @foreach ($shops as $shop)
                    	<tr id="row_{{ $shop->shop_id }}">
                      <td>{{{ $shop->shop_id }}}</td>
                    	<td>{{{ $shop->shop_name }}}</td>
              				<td>{{{ $shop->shop_address }}}</td>
              				<td>{{{ $shop->shop_code }}}</td>
              				<td>{{{ $shop->created_at }}}</td> 
              				<td> 
                        <?php if ( in_array("8", $array_permission)) { ?>
                        <a href="{{ route('shops.update', $shop->shop_id) }}"><img src="{{asset("dist/img/edit.gif")}}" ></a>
                        <?php } if ( in_array("9", $array_permission)) { ?>
  							        <a id="{{ $shop->shop_id }}" class="deleteRecord"><img  alt="Delete" style="cursor:pointer;" src="{{asset("dist/img/delete.png")}}" ></a>
                        <?php } ?>
                      </td>
            			</tr>
                    @endforeach
                        
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
     <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> 
      <script src="{{asset('../../dist/js/jquery.ui.dialog.js')}}"></script>
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
    <script type="text/javascript">
  $(document).ready(function() {
      $('#example').dataTable();
      $(document).on('click','.deleteRecord',function(e){
        var DelID = jQuery(this).attr("id");
        var token = $('input[name="_token"]').val();
        $("#dialog-confirm-delete").dialog({
                resizable: false,
                height:170,
                width: 400,
                modal: true,
                title: 'Delete Shop',
                buttons: {
                  Delete: function() {
                    $(this).dialog('close');
                    $.ajax({
                          type: "GET",
                              url: 'shops/delete_shop',
                          data: { DelID: DelID }
                      }).done(function( msg ) {
                          //alert( msg+'ttttt' );
                          if(msg == "delete")
                            $("#row_"+DelID).remove();
                      });
                  },
                  Cancel: function() {
                     $(this).dialog('close');
                  }
                }
              });
                     
            return false;
            });
  } );
  </script>
     @stop