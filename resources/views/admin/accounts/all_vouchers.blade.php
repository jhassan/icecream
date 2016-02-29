@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View All Vouchers
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
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr class="filters">
                            <th>Voucher Type</th>
                            <th>Voucher Date</th>
                            <th>Voucher Amount</th>
                            <th>Voucher Descriptions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($arrayVouchers as $voucher)
                    	<tr>
                        <td>{{{ $voucher->vm_type }}}</td>
                        <td>{{{ $voucher->vm_date }}}</td>
                        <td>{{{ $voucher->vm_amount }}}</td>
                        <td>{{{ $voucher->vm_desc }}}</td>
                        <td> <a id="{{ $voucher->vm_id }}" class="ShowVoucherDetails" style="cursor:pointer;">View</a>
                                    </td>
            			</tr>
                    @endforeach
                        <meta name="_token" content="{!! csrf_token() !!}"/>
                    </tbody>
                  </table>
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
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body ShowData">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
      <div id="thedialog" title="Download complete">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
        Your files have downloaded successfully into the My Downloads folder.
    </p>
    <p>
        Currently using <b>36% of your storage space</b>.
    </p>
</div>
<a href="#" id="thelink">Clickme</a>
     

    @stop 
    @section('footer_scripts')
    <script src="{{asset('../../dist/js/jquery.ui.dialog.js')}}"></script>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/ui-lightness/jquery-ui.css" />
     <script type="text/javascript">
					$.ajaxSetup({
								headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
					});
     $(document).on('click','.ShowVoucherDetails',function(e){
					var ID = $(this).attr("id");
							$.ajax({
							type: 'GET',
							url: '/admin/accounts/view_vouchers',
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
     </script>
						<script>
      $(document).ready(function() {
$('div#thedialog').dialog({ autoOpen: false })
$('#thelink').click(function(){ $('div#thedialog').dialog('open'); });
})
    </script>
     @stop 
     
     
     