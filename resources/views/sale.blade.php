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
                            <td class="col-md-1 text-center" colspan="2"><strong id="NetAmount">0</strong></td> 
                        </tr> 
                        <tr> 
                            <td class="col-md-8"><strong>Paid Amount:</strong></td> 
                            <td class="col-md-1 text-center" colspan="2"><strong id="PaidAmount">0</strong></td> 
                        </tr> 
                        <tr> 
                            <td class="col-md-8"><strong>Change Amount:</strong></td> 
                            <td class="col-md-1 text-center" colspan="2"><strong id="ChangeAmount">0</strong></td> 
                        </tr>
                        <tr> 
                            <td class="col-md-12" colspan="3">Thanks for choosing Cappellos</td> 
                        </tr>
                        <tr> 
                            <td class="col-md-12" colspan="3">Developed by: (0334)6026706, (0321)6328470</td> 
                        </tr> 
                        <tr class="noprint"> 
                            <td class="col-md-12" colspan="3" align="right"><button onclick="printDiv();" type="button" class="btn btn-success">Save and Print</button></td> 
                        </tr>   
                    </tbody> 
            </table> 
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
					var CurrentValue = $("#NetAmount").html();
					var NetAmount = parseInt(product_price) + parseInt(CurrentValue);
					$("#NetAmount").html(NetAmount);
					// Quantity
					var Qty = $("#Qty_"+id+"").html();
					var NetQty = parseInt(1) + parseInt(Qty);
					$("#Qty_"+id+"").html(NetQty);
					// Price
					var ProductPrice = $("#ProductPrice_"+id+"").html();
					var NetProductPrice = parseInt(product_price) + parseInt(ProductPrice);
					$("#ProductPrice_"+id+"").html(NetProductPrice);
					}
					else
					{
					var CurrentValue = $("#NetAmount").html();
					var NetAmount = parseInt(product_price) + parseInt(CurrentValue);
					$("#NetAmount").html(NetAmount);
					var str = "";
					str = "<tr id='Product_"+id+"' onclick='DeleteProduct("+id+","+product_price+");' class='cursor'>";
					str += "<td class='col-md-8'>"+product_name+"</td>"; 
					str += "<td class='col-md-1 text-center' id='Qty_"+id+"'>1</td>"; 
					str += "<td class='col-md-1 text-center' id='ProductPrice_"+id+"'>"+product_price+"</td>"; 
					str += "</tr>";
					$('#ShowSaleProduct').prepend(str); 
					}
					
				}
				function DeleteProduct(id,product_price)
				{
				var ProductPrice = $("#ProductPrice_"+id+"").html();	
				var CurrentValue = $("#NetAmount").html();
				var NetAmount = parseInt(CurrentValue) - parseInt(ProductPrice);
				$("#NetAmount").html(NetAmount);  
				$("#Product_"+id).remove();
				}
</script>
