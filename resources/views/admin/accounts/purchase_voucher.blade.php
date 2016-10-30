@extends('admin/layout/default')

{{-- Page content --}}
@section('content')
<?php
function COAComboWithoutTable($arrAcc, $strName, $nSelected = "")
{
    $bGroupOpen = false;
    $nResult = DB::table('coa')
                ->where('coa_code', 'LIKE', '511%')
                ->orderBy('coa_code', 'asc')
                ->get();
    echo "<select id=$strName name=$strName class='form-control'>\r\n";
    
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
      else
        
        if($strCode == $nSelected)  // for default bank acc
          echo "<option selected value='$strCode'>$strAcc\r\n";
        else
          echo "<option value='$strCode'>$strAcc\r\n";
    }
    
    if($bGroupOpen) echo "</optgroup>\r\n";
    echo "</select>\r\n";
}
                ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           Add Purchase Voucher
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
              <h3 class="box-title">Purchase Voucher</h3>
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
                <form action="add_purchase_voucher" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="vm_type" value="BP" />
                  <div class="box-body col-sm-4">
                      <div class="dropdown">
                      <label for="shop" >Vendor</label>
                        <select class="form-control" title="Select Vendor..." name="vendor_id">
                            <option value="">Select Vendor</option>
                            @foreach ($vendors as $vendor)
                            <option value="{{{ $vendor->vendor_id}}}"  >{{{ $vendor->vendor_name}}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                  <div class="box-body col-sm-4">
                  <div class="dropdown">
                    <label for="gender">Debit Account</label>
                    <?php COAComboWithoutTable("", "vd_debit",""); ?>
                      </div>
                    </div>
                  <div class="box-body col-sm-4">
                      <div class="dropdown">
                      <label for="shop" >Cash Mode</label>
                        <select class="form-control" title="Cash Mode..." name="cash_mode">
                            <option value="">Select Cash Mode</option>
                            <option value="414002">Cash</option>
                            <option value="414001">Bank</option>
                        </select>
                      </div>
                  </div>
                    <div class="box-body col-sm-4">
                      <label for="shop_address">Date</label>
                      <input type="text" class="date-pick form-control" id="vm_date" placeholder="Date" name="vm_date">
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
                  <div class="box-body col-sm-4">
                      <label for="shop_address">Total Amount</label>
                      <input type="text" class="form-control" id="vm_amount" placeholder="Total Amount" maxlength="10" name="vm_amount">
                    </div>
                  <div class="box-body col-sm-4">
                      <label for="shop_address">Memo No</label>
                      <input type="text" class="form-control" id="vm_memo_no" placeholder="Memo No" maxlength="50" name="vm_memo_no">
                    </div>
                    <div class="box-body col-sm-4">
                      <label for="shop_address">Descriptions</label>
                      <textarea type="text" class="form-control" id="vm_desc" placeholder="Descriptions" name="vm_desc"></textarea>
                    </div>
                  <!--</div> /.box-body -->
                    <div class="row col-sm-12 hide">
                      <h3 style="padding-left:10px;">Add All Purchased Items</h3>
                      <div class="box-body col-sm-4">
                        <label for="shop_address">Item Name</label>
                        <input type="text" class="form-control tags" id="item_name" placeholder="Item Name" maxlength="50" name="item_name" value="">
                      </div>
                      <div class="box-body col-sm-2">
                        <label for="shop_address">Item Quantity</label>
                        <input type="text" class="form-control number_only" id="item_qty" placeholder="Item Quantity" maxlength="5" name="item_qty" value="">
                      </div>
                      <div class="box-body col-sm-2">
                        <label for="shop_address">Item Amount</label>
                        <input type="text" class="form-control number_only" id="item_amount" placeholder="Item Amount" maxlength="10" name="item_amount">
                      </div>
                      <div class="box-body col-sm-2">
                        <input type="button" class="btn btn-primary" id="add_item" value="Add Item" style="margin-top:23px;">
                      </div>
                    </div>
                    <div class="row col-sm-12 clear" id="add_new_row"></div>
                    <div class="row clear hide" id="messageTotalAmount" style="padding-left:20px; font-weight:bold; color:green;">Total Items Purchase Amout: <span id="TotalPurchaseAmount"></span></div>
                    <div id="error_message" class="hide" style="padding-left:10px; color:red;">Purchase Item Amount not same!</div>
                  <div id="correct_message" class="hide" style="padding-left:10px; color:green;">All values are correct</div>
                  <div class="box-footer clear" style="clear:both !important;">
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                  <input type="hidden" id="selectedText" value="" />
                  <input type="hidden" id="selectedValue" value="" />
                  <input type="hidden" id="selectedItemAmount" name="vm_amount1" />
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
      .ui-menu-item li{ padding-left: 10px !important; }
      </style>
      @section('footer_scripts')
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
       <!-- <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script> -->
      <script>
  $( function() {
    $("#btn_form_submit").prop("disabled", true);
    //$("#selectedItemAmount").val('');
    $("#vm_amount").val('');
    $("#item_qty").val('');
    $("#item_amount").val('')
    $("#vm_memo_no").val('');
    $('form').each(function() { this.reset() });
    $("#add_item").on('click', function () {
        var str = "";
        var itemName = $("#selectedText").val();
        var itemID = $("#selectedValue").val();
        var itemAmount = $("#item_amount").val();
        var itemQty = $("#item_qty").val();
        var CurrentValue = $("#TotalPurchaseAmount").html();
        if(CurrentValue == "")
          CurrentValue = 0;
          //if(CurrentValue != "")
        itemAmount = itemAmount.replace(",", "");
        itemQty = itemQty.replace(",", "");  
            
         var CurretnItemTotal = (parseInt(itemAmount) * parseInt(itemQty));

        if( itemQty == "" && itemAmount == "" )         // use this if you are using id to check
        {
            alert('Please enter quantity and Item amount!');
            return false;
             
        }
        else if(  $('#new_row_'+itemID).length )
        {
          alert('Item already added. Pleaase add another'); 
               //var itemAmount = $("#item_amount").val();
               //var itemQty = $("#item_qty").val();
               var CurrentValue = $("#selectedItemAmount").val();
              var NetAmount = parseInt(CurrentValue) - (parseInt(itemAmount) * parseInt(itemQty));
              $("#selectedItemAmount").val(CurrentValue);
             $("#item_name").val(''); 
              $("#item_amount").val(''); 
              $("#item_qty").val(''); 
              $("#selectedText").val('');
              $("#selectedValue").val(''); 
             return false;
        }
        else
        {
          str = "<div id='new_row_"+itemID+"'>";
          str += "<div class='box-body col-sm-4'>";
            str += "<label>"+itemName+"</label>";
            str += "<input type='hidden' class='form-control' name='item_id[]' value='"+itemID+"'>";
          str += "</div>";
          str += "<div class='box-body col-sm-2'>";
            str += "<label id='itemQuantity_"+itemID+"'>"+itemQty+"</label>";
            str += "<input type='hidden' class='form-control' name='item_qty[]' value='"+itemQty+"'>";
          str += "</div>";
          str += "<div class='box-body col-sm-2'>";
            str += "<label id='itemAmount_"+itemID+"'>"+itemAmount+"</label>";
            str += "<input type='hidden' class='form-control' name='add_item_amount[]' value='"+itemAmount+"'>";
          str += "<span style='padding-left: 40px; font-weight: bold;'>("+CurretnItemTotal+")</span></div><div class='box-body col-sm-2'><a id='"+itemID+"' class='DeleteRow' style='cursor:pointer;'>X</a></div><div class='clear'></div></div>";
          $('#add_new_row').prepend(str);
          $("#item_name").val(''); 
          $("#item_amount").val(''); 
          $("#item_qty").val(''); 
          $("#selectedText").val('');
          $("#selectedValue").val(''); 
          var NetAmount = (parseInt(itemAmount) * parseInt(itemQty)) + parseInt(CurrentValue);

          $("#TotalPurchaseAmount").html(NetAmount);
          $("#selectedItemAmount").val(NetAmount);
        }
        // show error if ammounts are not same
        // var vm_amount = $("#vm_amount").val();
        // var GetCurrentValue = $("#selectedItemAmount").val();
        // if(GetCurrentValue != vm_amount)
        // {
        //   $("#error_message").removeClass('hide');
        //   $("#btn_form_submit").prop("disabled", true);
        //   $("#correct_message").addClass('hide');
        // }
        // else
        // {
        //   $("#error_message").addClass('hide'); 
        //   $("#correct_message").removeClass('hide');
        //   $("#btn_form_submit").prop("disabled", false); 
        // }
        var GetCurrentValue = $("#TotalPurchaseAmount").html();
        if(GetCurrentValue != 0)
        {
          $("#btn_form_submit").prop("disabled", false);
        }
        $("#messageTotalAmount").removeClass('hide');
        //$("#TotalPurchaseAmount").html($("#selectedItemAmount").val());
    });
    // Get All Purchase Items from Database
    $.ajax( {
            type: "GET",
            url : '/purchase_items',
            success: function( response ) {
            var raw = eval('(' + response + ')');
            var source  = [ ];
            var mapping = { };
            var source1  = [ ];
            var mapping1 = { };
            for(var i = 0; i < raw.length; ++i) {
                source.push(raw[i].label);
                mapping[raw[i].label] = raw[i].label;
                source1.push(raw[i].value);
                mapping1[raw[i].label] = raw[i].value;
            }

            $('.tags').autocomplete({
                minLength: 1,
                source: source,
                select: function(event, ui) {
                    $("#selectedText").val('');
                    $("#selectedValue").val('');
                    var selectedText = mapping[ui.item.label];
                    var selectedValue = mapping1[ui.item.value];
                    $("#selectedText").val(selectedText);
                    $("#selectedValue").val(selectedValue);
                }
            }); 
          }
        } );
    // Delete Record
    $(document).on('click', '.DeleteRow', function(){
        var DelId = $(this).attr('id');
        //$("#correct_message").addClass('hide');
        //$("#error_message").removeClass('hide');
        $("#btn_form_submit").prop("disabled", true);
        var itemAmount = $("#itemAmount_"+DelId).html();
        var itemQuantity = $("#itemQuantity_"+DelId).html();
        var CurrentValue = $("#TotalPurchaseAmount").html();
        //console.log(parseInt(itemAmount) * parseInt(itemQuantity));
        var NetAmount = parseInt(CurrentValue) - (parseInt(itemAmount) * parseInt(itemQuantity));
        //console.log(NetAmount);
        $("#TotalPurchaseAmount").html(NetAmount);
        $("#selectedItemAmount").val(NetAmount);
        // // show error if ammounts are not same
        // var vm_amount = $("#vm_amount").val();
        // var GetCurrentValue = $("#selectedItemAmount").val();
        // if(GetCurrentValue != vm_amount)
        // {
        //   $("#error_message").removeClass('hide');
        // }
        // else
        // {
        //   $("#error_message").addClass('hide'); 
        //   $("#correct_message").removeClass('hide');
        //   $("#btn_form_submit").prop("disabled", false); 
        // }
        //$("#TotalPurchaseAmount").html($("#selectedItemAmount").val());
        $("#new_row_"+DelId).remove();  
      });
      $(".date-pick").datepicker('setDate', new Date());
  } );
  </script>
  @stop
      