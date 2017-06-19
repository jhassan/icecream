@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            List of Transections
          </h1>
          <ol class="breadcrumb hide">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/shops/add">Add Shop</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <div class="col-md-3"><h3 class="box-title">All Vouchers</h3></div>
                    <div class="form-inline col-md-12">
                        <!-- Search: <input type="text" class="form-control" id="search_value" name="search_value" />
                        <button type="button" class="btn btn-small btn-default search-post">Go</button> -->
                        <div class="box-body col-sm-3">
                          <label for="shop_address">Start Date</label>
                          <input type="text" class="date-pick form-control" id="start_date" placeholder="Start Date" name="start_date">
                        </div>
                        <div class="box-body col-sm-3">
                          <label for="shop_address">End Date</label>
                          <input type="text" class="date-pick form-control" id="end_date" placeholder="End Date" name="end_date">
                        </div>
                        <div class="box-body col-sm-4">
                          <div class="dropdown">
                          <label for="shop" >Shop</label>
                            <select class="form-control" title="Select Shop..." name="shop_id" id="shop_id">
                                <option value="">Select</option>
                                @foreach ($shops as $shop)
                                <option value="{{{ $shop->shop_id}}}"  >{{{ $shop->shop_name}}}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>
                      <div class="box-footer">
                        <button type="button" id="search_data" class="btn btn-primary">Search</button>
                      </div>
                    </div>
                </div>
                <div class="box-body" id="tableBody">
                  @include('admin.tables.all_vouchers_table')
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <div class="modal fade" tabindex="-1" role="dialog" id="view_dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">View Transection</h4>
      </div>
      <div class="modal-body ShowData">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="dialog-confirm-delete" title="Delete Reocrs" style="display:none;">Do you want to delete this record?</div>
    @stop 
    @section('footer_scripts')
    <script src="{{asset('../../dist/js/jquery.ui.dialog.js')}}"></script>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/ui-lightness/jquery-ui.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
     <script type="text/javascript">
					$.ajaxSetup({
								headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
					});
     $(document).on('click','.ShowVoucherDetails',function(e){
					var ID = $(this).attr("id");
							$.ajax({
							type: 'GET',
							url: 'view_vouchers',
							data: {'ID' : ID},
							success: function(result)
							{
								if(result){
									$(".ShowData").html(result);
									$("#view_dialog").modal('show');
								}
							}
						})
			});	 
			jQuery(document).on('click','.deleteRecord',function(e){
				var DelID = jQuery(this).attr("id");
				var action = "VoucherDelete";
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
                      				url: 'delete_vouchers',
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
						<script>
      $(document).ready(function() {
        $('div#thedialog').dialog({ autoOpen: false })
        $('#thelink').click(function(){ $('div#thedialog').dialog('open'); });
        // Search
        $(document).on('click', '.pagination li a', function(e){
            var shop_id     = $("#shop_id").val();
            var start_date  = $("#start_date").val();
            var end_date    = $("#end_date").val();
            //e.preventDefault();
            //alert(start_date);
            $.ajax({
                url: '/admin/accounts/all_vouchers/?page='+$(this).attr('href').split('page=')[1]+'&start_date='+start_date+'&end_date='+end_date,
                type: 'GET',
                data: {shop_id: shop_id, start_date: start_date, end_date: end_date},
                success: function(response){
                  //console.log(response); //return false;
                   $("#tableBody").html(response);
                }
            });
        });
        $("#search_data").click(function(){
            var shop_id     = $("#shop_id").val();
            var start_date  = $("#start_date").val();
            var end_date    = $("#end_date").val();
            if(shop_id != ''){
                $.ajax({
                    url: '/admin/accounts/all_vouchers',
                    type: 'GET',
                    data: {shop_id: shop_id, start_date: start_date, end_date: end_date},
                    success: function(response){
                      //console.log(response); return false;
                        $("#tableBody").html(response);
                    }
                });
            }
        });
      });
    </script>
     @stop 
     
     
     