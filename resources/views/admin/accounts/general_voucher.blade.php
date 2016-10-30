@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Journal Voucher
            <small></small>
          </h1>
          <ol class="breadcrumb hide">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
          </ol>
        </section>
        <?php
function COAComboWithoutTable($arrAcc, $strName, $nSelected = "")
{
		$bGroupOpen = false;
		$nResult = DB::table('coa')
                ->orderBy('coa_code', 'asc')
                ->get();
		echo "<select id=$strName name=$strName class='form-control'>\r\n";
		echo "<option value=''>Select COA</option>";
		foreach($nResult as $rstRow)
		{
			$strCode = $rstRow->coa_code;
			$strAcc = $rstRow->coa_account;
			
			if(substr($strCode, 3) == "000") // if this is control account
			{
				if($bGroupOpen) echo "</optgroup>";
			
				if(substr($strCode, 1) == "00000")
					echo "<optgroup label='--- $strAcc ---'>\r\n";
				else
					echo "<optgroup label='$strAcc'>\r\n";
				
				$bGroupOpen = true;
			}
			//else
				
				if($strCode == $nSelected)	// for default bank acc
					echo "<option selected value='$strCode'>$strAcc\r\n";
				else
					echo "<option value='$strCode'>$strAcc\r\n";
		}
		
		if($bGroupOpen) echo "</optgroup>\r\n";
		echo "</select>\r\n";
}
								?>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Journal Voucher</h3>
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
             <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <form action="save_general_voucher" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <div class="box-body col-sm-4">
                      <label for="shop_address">Date</label>
                      <input type="text" class="date-pick form-control" id="start_date" placeholder="Start Date" name="start_date">
                    </div>
                    <div class="box-body col-sm-4">
                      <div class="dropdown">
                      <label for="shop" >Voucher Type</label>
                        <select class="form-control" title="Select Shop..." name="vm_type">
                            <option value="">Select</option>
                            <option value="CP">Cash Pay</option>
                            <option value="CR">Cash Received</option>
                            <option value="BP">Bank Pay</option>
                            <option value="BR">Bank Received</option>
                            <option value="JV">Journal Voucher</option>
                        </select>
                      </div>
                  </div>
                  <div class="box-body col-sm-4">
                      <div class="dropdown">
                      <label for="shop" >Shop</label>
                        <select class="form-control" title="Select Shop..." name="shop_id">
                            <option value="">Select</option>
                            @foreach ($shops as $shop)
                            <option value="{{{ $shop->shop_id}}}"  >{{{ $shop->shop_name}}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                    <div class="clear"></div>
                      <div class="box-body col-sm-4">
                      <div class="dropdown">
                        <label for="gender">Debit Account</label>
                        <?php COAComboWithoutTable("", "coa_account_debit",""); ?>
    			                </div>
                      </div>
                      <div class="box-body col-sm-4">
                      <label for="shop_address">Debit</label>
                      <input type="text" class="form-control" id="d_amount_debit" placeholder="Debit Amount" name="d_amount_debit">
                    </div>
                    <div class="box-body col-sm-4">
                      <label for="shop_address">Credit</label>
                      <input type="text" class="form-control" id="d_amount_credit" placeholder="Credit Amount" name="d_amount_credit">
                    </div>
                    <div class="clear"></div>
                      <div class="box-body col-sm-4">
                      <div class="dropdown">
                        <label for="gender">Credit Account</label>
                        <?php COAComboWithoutTable("", "coa_account_credit",""); ?>
                          </div>
                      </div>
                      <div class="box-body col-sm-4">
                      <label for="shop_address">Debit</label>
                      <input type="text" class="form-control" id="c_amount_debit" placeholder="Debit Amount" name="c_amount_debit">
                    </div>
                    <div class="box-body col-sm-4">
                      <label for="shop_address">Credit</label>
                      <input type="text" class="form-control" id="c_amount_credit" placeholder="Credit Amount" name="c_amount_credit">
                    </div>
                    <div class="box-body col-sm-4">
                      <label for="shop_address">Descriptions</label>
                      <textarea type="text" class="form-control" id="vm_desc" placeholder="Descriptions" name="vm_desc"></textarea>
                    </div>
                  <!-- </div> --><!-- /.box-body -->

                  <div class="box-footer clear">
                    <button type="submit" id="btn_form_submit" class="btn btn-primary">Save</button>
                  </div>
                  <div id="error_message" class="hide" style="padding-left:10px; color:red;">Please enter debit and credit same value!</div>
                  <div id="correct_message" class="hide" style="padding-left:10px; color:green;">All values are correct</div>
                </form>
              </div> 

            <!--<div class="box-footer">
              Footer
            </div>--><!-- /.box-footer-->
          </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      @stop
      @section('footer_scripts')
      <style type="text/css">
      option.bold-text { font-weight:bold !important; text-shadow: 0px 0px 0px black !important; }
      </style>
      <script type="text/javascript">
        $(document).ready(function () {
          $("#btn_form_submit").prop("disabled", true);
          $("#d_amount_debit").prop("disabled", false);
          $("#c_amount_credit").prop("disabled", false);
          // Debit debit
          $('#d_amount_debit').keyup(function () {
              var len = $(this).val().length;
              if (len >= 1) {
                  $("#d_amount_credit").prop("disabled", true);
              }
              else{
                  $("#d_amount_credit").prop("disabled", false);
              }
          });
          // Debit credit
          $('#d_amount_credit').keyup(function () {
              var len = $(this).val().length;
              if (len >= 1) {
                  $("#d_amount_debit").prop("disabled", true);
              }
              else{
                  $("#d_amount_debit").prop("disabled", false);
              }
          });

          // Credit debit
          $('#c_amount_debit').keyup(function () {
              var len = $(this).val().length;
              if (len >= 1) {
                  $("#c_amount_credit").prop("disabled", true);
              }
              else{
                  $("#c_amount_credit").prop("disabled", false);
              }
              if( ($("#c_amount_debit").val() == "" && $("#c_amount_credit").val() == "") || ($("#c_amount_debit").val() != $("#d_amount_credit").val()) )
              {
                $("#error_message").removeClass('hide');
                $("#correct_message").addClass('hide');
                $("#btn_form_submit").prop("disabled", true);
              }
              else   
              {
                $("#error_message").addClass('hide');
                $("#correct_message").removeClass('hide');
                $("#btn_form_submit").prop("disabled", false);
              }
          });

          // Credit credit
          $('#c_amount_credit').keyup(function () {
              var len = $(this).val().length;
              if (len >= 1) {
                  $("#c_amount_debit").prop("disabled", true);
              }
              else{
                  $("#c_amount_debit").prop("disabled", false);
              }
              if( ($("#c_amount_debit").val() == "" && $("#c_amount_credit").val() == "") ||  ( $("#d_amount_debit").val() != $("#c_amount_credit").val()) )
              {
                $("#error_message").removeClass('hide');
                $("#correct_message").addClass('hide');
                $("#btn_form_submit").prop("disabled", true);
              }
              else   
              {
                $("#error_message").addClass('hide');
                $("#correct_message").removeClass('hide');
                $("#btn_form_submit").prop("disabled", false);
              }
          });

            
         }); 
        //   function GetDebit(id)
        //   {
        //     if(id == 1)
        //     {
        //       if($("#d_amount_credit").val() != "")
        //       {
        //         $("#d_amount_debit").prop("disabled", true); 
        //         $("#d_amount_credit").prop("enable"); 
        //       }
        //       else
        //       {
        //         $("#d_amount_debit").prop("enable"); 
        //         $("#d_amount_credit").prop("disabled", true);  
        //       }
        //     }
        //     else if(id == 2)
        //     { 
        //       if($("#d_amount_debit").val() != "")
        //       {
        //         $("#d_amount_credit").prop("disabled", true);
        //         $("#d_amount_debit").prop("enable");
        //       }
        //       // else
        //       // {
        //       //   $("#d_amount_debit").prop("disabled", true);
        //       //   $("#d_amount_credit").prop("enable");
        //       // }
        //     }
              
        //   }
        // });
      </script>
      @stop