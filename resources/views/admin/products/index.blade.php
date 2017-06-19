@extends('admin/layout/default')

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
          <ol class="breadcrumb hide">
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
              <h3 class="box-title">All Products</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            
              <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr class="filters">
                            <th>Product Name</th>
                            <th>Category Name</th>
                            <th>Shope Name</th>
                            <th>Product Code</th>
                            <th>Product Price</th>
                            <th>Enable/Disable</th>
                            <th>Action</th>
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
                    @foreach ($products as $product)
                      <tr id="row_{{ $product->id }}">
                        <td>{{{ $product->product_name }}}</td>
                        <td>
                          @if($product->category_id == 1) 
                            {{'Icecream Flavour'}}
                          @elseif($product->category_id == 2)  
                            {{'Purchase Item'}}
                          @endif  
                        </td>
                        <td>{{{ $product->shop_name }}}</td>
                        <td>{{{ $product->product_code }}}</td>
                        <td>{{{ $product->product_price }}}</td>
                        <td>@if($product->is_active == 1) Enable @else Disable @endif</td>
                    <td> 
                      <?php if ( in_array("18", $array_permission)) { ?>
                      <a href="{{ route('products.update', $product->id) }}"><img src="{{asset("dist/img/edit.gif")}}" ></a>
                      <?php } if ( in_array("19", $array_permission)) { ?>
                      <a id="{{ $product->id }}" class="deleteRecord"><img  alt="Delete" style="cursor:pointer;" src="{{asset("dist/img/delete.png")}}" ></a>
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
            <!--<div class="box-footer">
              Footer
            </div>--><!-- /.box-footer-->
          </div>
          <!-- /.box -->

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
        $("#example1").DataTable();
        // $('#example2').DataTable({
        //   "paging": true,
        //   "lengthChange": false,
        //   "searching": false,
        //   "ordering": true,
        //   "info": true,
        //   "autoWidth": false
        // });
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
                              url: 'products/delete_product',
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