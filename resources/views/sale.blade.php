@extends('layout/default')

    <!-- Page Content -->
    @section('content')
        <div class="container">

        <!-- Page Heading -->
        
        <!-- /.row -->
        <div class="row" style="min-height:200px;">
        <div class="col-md-8">
          <p>
          @foreach ($products as $product)
	         	<button type="button" onclick="AddProductToSale({{ $product->id }}, '{{ $product->product_name }}',{{ $product->product_price }});" class="m-t-10 btn btn-success btn-lg">{{ $product->product_name }}</button>
 	       @endforeach
          
        </p>
        </div>
        <div class="col-md-4" id="InvoiceDiv">
          <h2 class="text-center" style="font-family:icon; margin-top:0px;">Cappellos</h2>
          <div class="bs-example" data-example-id="simple-table"> 
          	<form class="form-signin" id="FormID" method="post" action="{{ URL::to('sale_product') }}">
        		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <table class="table table table-bordered" width="100%" style="table-layout:fixed; margin-bottom:0px; font-size:12px;"> 
            <tbody class="border"> 
                <tr> 
                    <td colspan="2" style="overflow: hidden;" class="text-center">Unitd Mall Multan</td>
                </tr> 
                <tr> 
                    <td width="45%" class="col-md-6">Invoice#: MUL-01</td> 
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
                            <td class="col-md-8"><strong>Net Amount:</strong></td> 
                            <td class="col-md-1 text-center" colspan="2"><input type="text" name="net_amount" id="NetAmount" value="0" /></td> 
                        </tr> 
                        <tr> 
                            <td class="col-md-8"><strong>Paid Amount:</strong></td> 
                            <td class="col-md-1 text-center" colspan="2"><input type="text" maxlength="6" name="paid_amount" id="PaidAmount" value="0" /></td> 
                        </tr> 
                        <tr> 
                            <td class="col-md-8"><strong>Change Amount:</strong></td> 
                            <td class="col-md-1 text-center" colspan="2"><input type="text" maxlength="6" name="ChangeAmount" id="ChangeAmount" value="0" /></td> 
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
    <style>
    @page { size: auto;  margin: 0mm; }
    @media print {
       .noprint{
          display: none !important;
       }
							body {margin:0px !important; padding: 0px !important;}
				#InvoiceDiv, #InvoiceDiv * {
						visibility: visible;
				}
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
    }
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
    <script type="text/javascript">
				$(document).ready(function(e) {
     $('#FormID')[0].reset();
    });
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
					str = "<tr id='Product_"+id+"' onclick='DeleteProduct("+id+","+product_price+");' class='cursor'>";
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
</script>
