@extends('layout/default')

    <!-- Page Content -->
    @section('content')
        <div class="container">

        <!-- Page Heading -->
        
        <!-- /.row -->
        <div class="row" style="min-height:200px;">
        <div class="col-md-8" style="overflow: auto; max-height: 500px;">
          <p>
          @foreach ($products as $product)
	         	<button type="button" onclick="AddProductToSale({{ $product->id }}, '{{ $product->product_name }}',{{ $product->product_price }});" title="{{ $product->product_name }}" style="text-align:left; font-size: 14px; font-weight: bold;" class="col-md-3 m-l-5 m-t-10 btn btn-success btn-lg">{{ $product->product_name }}</button>
 	       @endforeach
          
        </p>
        </div>
        <div class="col-md-4" id="InvoiceDiv"><?php //echo url('/img/logo1.png');?>
          <div class="text-center"><img height="35" src="{{ asset('img/logo1.png') }}" alt="Cappellos" /></div>
          <div class="bs-example" data-example-id="simple-table"> 
          	<form class="form-signin" id="FormID" method="post" action="{{ URL::to('sale_product') }}" onsubmit="return CheckValidate();">
        		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <table class="table table table-bordered" width="100%" style="table-layout:fixed; margin-bottom:0px; font-size:12px;"> 
            <tbody class="border"> 
                <tr> 
                	<td colspan="2" style="overflow: hidden;" class="text-center">Fried Roll Ice Cream</td> 
                 </tr>
                <tr> 
                    <td colspan="2" style="overflow: hidden;" class="text-center">3rd Floor Unitd Mall Multan</td>
                </tr>
                <tr> 
                    <td width="45%" class="col-md-6">Invoice#: {{ $shop_code }}-{{ $invoice_id }}</td> 
                    <td width="55%" class="col-md-6">Date:{{ date('d-M-Y') }}</td> 
                </tr> 
              </tbody>
            </table>
            <table class="table table table-bordered" style="font-size:12px; border-top-color:#fff;"> 
            <thead class="border"> 
                <tr> 
                    <th class="col-md-4">Description</th> 
                    <th class="col-md-1">Qty</th> 
                    <th class="col-md-1">Amount</th> 
                </tr> 
                </thead> 
                    <tbody class="border" id="ShowSaleProduct"> 
                        <tr> 
                            <td class="col-md-2">Discount:<span id="txtDiscountAmount" class="p-l-10">0</span></td> 
                            <td class="col-md-2" colspan="2">Net Amount:<span id="txtNetAmount" class="p-l-10">0</span></td> 
                        </tr>
                        <tr> 
                            <td class="col-md-2">Paid:<span id="txtPaidAmount" class="p-l-10">0</span></td> 
                            <td class="col-md-2" colspan="2">Change:<span id="txtChangeAmount" class="p-l-10">0</span></td> 
                        </tr>
                        <tr class="noprint"> 
                            <td class="col-md-8 noprint"><strong>Discount Amount:</strong></td> 
                            <td class="col-md-1 noprint text-center" colspan="2"><input type="text" maxlength="3" name="discount_amount" id="DiscountAmount" value="0" class="number_only noprint" /></td> 
                        </tr>
                        <tr class="noprint"> 
                            <td class="col-md-8"><strong>Net Amount:</strong></td> 
                            <td class="col-md-1 text-center" colspan="2"><input maxlength="6" type="text" name="net_amount" id="NetAmount" value="0" class="number_only" /></td> 
                        </tr>
                        <tr class="noprint"> 
                            <td class="col-md-8"><strong>Paid Amount:</strong></td> 
                            <td class="col-md-1 text-center" colspan="2"><input type="text" maxlength="6" maxlength="6" name="paid_amount" id="PaidAmount" value="0" class="number_only" onkeyup="GetAmount();" /></td> 
                        </tr> 
                        <tr class="noprint"> 
                            <td class="col-md-8"><strong>Change Amount:</strong></td> 
                            <td class="col-md-1 text-center" colspan="2"><input type="text" maxlength="6" maxlength="6" name="ChangeAmount" id="ChangeAmount" value="0" class="number_only" /></td> 
                        </tr>
                        <tr> 
                            <td class="col-md-12" colspan="3">Thanks for choosing Cappellos</td> 
                        </tr>
                        <tr> 
                            <td class="col-md-12" colspan="3">Developed by: (0334)6026706, (0321)6328470</td> 
                        </tr> 
                        <tr class="noprint"> 
                            <td class="col-md-12" colspan="3" align="right"><button type="submit" class="btn btn-success">Save and Print</button></td> 
                        </tr>   <!--onclick="printDiv();"-->
                    </tbody> 
            </table> 
            </form>
        </div>  
        </div>
      </div>
    @stop
    @section('footer_scripts')
    
    <script type="text/javascript">
    $(document).ready(function() {
        var isAuth = "<?php echo Auth::check(); ?>";
									if (isAuth != 1) 
									{
													window.location = "/";
									}
    });
</script>
    <script type="text/javascript">
				$(document).ready(function(e) {
     $('#FormID')[0].reset();
					
					// Numeric only control handler
		jQuery.fn.ForceNumericOnly =
		function()
		{
			return this.each(function()
			{
				$(this).keydown(function(e)
				{
					var key = e.charCode || e.keyCode || 0;
					// allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
					// home, end, period, and numpad decimal
					return (
						key == 8 || 
						key == 9 ||
						key == 13 ||
						key == 46 ||
						key == 110 ||
						key == 190 ||
						(key >= 35 && key <= 40) ||
						(key >= 48 && key <= 57) ||
						(key >= 96 && key <= 105));
				});
			});
		};   
		
		// Call Only numbers
		$(".number_only").ForceNumericOnly();
		
		// Keypress add commas in numbers
		 $('input.number_only').keyup(function(event){
			  // skip for arrow keys
			  if(event.which >= 37 && event.which <= 40){
				  event.preventDefault();
			  }
			  var $this = $(this);
			  var num = $this.val().replace(/,/gi, "").split("").reverse().join("");
			  var num2 = RemoveRougeChar(num.replace(/(.{3})/g,"$1,").split("").reverse().join(""));
			  // the following line has been simplified. Revision history contains original.
			  $this.val(num2);
		  });
				
				$('input.number_only')
				.on('focus', function(){
								var $this = $(this);
								if($this.val() == 0){
												$this.val('');
								}
				})
				.on('blur', function(){
								var $this = $(this);
								if($this.val() == ''){
												$this.val(0);
								}
				})
					
}); // End ready
    function printDiv() {    
    var printContents = document.getElementById('InvoiceDiv').innerHTML;
    var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
    }
				
				// AddProductToSale()
				function AddProductToSale(id,product_name,product_price)
				{
					
					var AlreadyId = $("#Product_"+id+"").closest('tr').attr('id');
					if(AlreadyId)
					{
					// Net Amount
					var CurrentValue = $("#NetAmount").val();
					var NetAmount = parseInt(product_price) + parseInt(CurrentValue);
					$("#NetAmount").val(NetAmount);
					//$("#net_amount").val(NetAmount);
					// Quantity
					var Qty = $("#Qty_"+id+"").html();
					var NetQty = parseInt(1) + parseInt(Qty);
					$("#Qty_"+id+"").html(NetQty);
					$("#TotalQty_"+id+"").val(NetQty);
					
					// Price
					var ProductPrice = $("#ProductPrice_"+id+"").val();
					var NetProductPrice = parseInt(product_price) + parseInt(ProductPrice);
					$("#ProductPrice_"+id+"").val(NetProductPrice);
					$("#TotalProductPrice_"+id+"").html(NetProductPrice);
					}
					else
					{
					var CurrentValue = $("#NetAmount").val();
					var NetAmount = parseInt(product_price) + parseInt(CurrentValue);
					$("#NetAmount").val(NetAmount);
					var str = "";
					str = "<tr class='count_product' id='Product_"+id+"' onclick='DeleteProduct("+id+","+product_price+");' class='cursor'>";
					str += "<td class='col-md-8'>"+product_name+"<input type='hidden' name='product_id[]' value='"+id+"' /></td>"; 
					str += "<td class='col-md-1 text-center'><span id='Qty_"+id+"'>1</span><input id='TotalQty_"+id+"' type='hidden' name='product_qty[]' value='1' /></td>"; 
					str += "<td class='col-md-1 text-center'><input id='ProductPrice_"+id+"' type='hidden' name='product_price[]' value='"+product_price+"' /><span id='TotalProductPrice_"+id+"'>"+product_price+"</span></td>"; 
					str += "</tr>";
					$('#ShowSaleProduct').prepend(str); 
					}
					
				}
				function DeleteProduct(id,product_price)
				{
				var ProductPrice = $("#ProductPrice_"+id+"").val();	
				var CurrentValue = $("#NetAmount").val();
				var NetAmount = parseInt(CurrentValue) - parseInt(ProductPrice);
				$("#NetAmount").val(NetAmount);  
				$("#Product_"+id).remove();
				}
				
				function RemoveRougeChar(convertString)
				{
					if(convertString.substring(0,1) == ",")
					{
						return convertString.substring(1, convertString.length)            
					}
					return convertString;
				}
				function GetAmount()
				{
					var PaidAmount = $("#PaidAmount").val();
					$("#txtPaidAmount").html(PaidAmount);
					PaidAmount = PaidAmount.replace(',', '');
					var NetAmount = $("#NetAmount").val();
						$("#txtNetAmount").html(NetAmount);
					var DiscountAmount = $("#DiscountAmount").val();
					$("#txtDiscountAmount").html(DiscountAmount);
						var TotalAmount = parseInt(PaidAmount) - (parseInt(NetAmount) - parseInt(DiscountAmount));
						TotalAmount = (isNaN(TotalAmount)) ? 0 : TotalAmount;
							$("#ChangeAmount").val(TotalAmount);
							$("#txtChangeAmount").html(TotalAmount);	
				}
				function CheckValidate()
				{
					var count_product = document.getElementsByClassName('count_product');
					var PaidAmount = document.getElementById('PaidAmount').value;
					if (count_product.length > 0) {
						if(PaidAmount == 0)
						{
								alert('Please add paid amount!');
								return false;		
						}
						//printDiv();
						return true;
					}
					else
					{
					alert('Please select any flavours!');
					return false;
					}
			}
</script>

@stop
<style type="text/css">
    @page { size: auto;  margin: 0mm; }
    
				table {
    border-collapse: collapse;
				}
				
				table, th, td {
								font-family:Verdana;
				}
				.border tr td{ padding: 2px !important;
				}
				.border tr th{ padding: 2px !important;
				}
				.cursor{ cursor:pointer;}
				
    </style>
<style type="text/css" media="print">

@media print {
       
							body {margin:0px !important; padding: 0px !important;}
				/*#InvoiceDiv, #InvoiceDiv * {
						visibility: visible;
				}*/
				#InvoiceDiv {
						position: absolute;
						left: 0px;
						top: 0px;
				}
				body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td { 
    margin:0;
    padding:0;
}
html,body {
    margin:0;
    padding:0;
}
   .noprint{ display: none !important; }
    }
</style>