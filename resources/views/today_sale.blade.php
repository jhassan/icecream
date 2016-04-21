@extends('layout/default')

    <!-- Page Content -->
    @section('content')
    	<div class="container">
        <div class="table-responsive">
          <table class="table table-striped m-b-0">
              <thead>
                <tr>
                  <th>Product Price</th>
                  <th>Product Quantity</th>
                  <th>Product Name</th>
                  <th>Invoice #</th>
                  <th>Date</th>
                  <th>Employee</th>
                </tr>
              </thead>
              <tbody>
              
                	@foreach($detail_sale as $detail)
                <tr>
                  <td>{{ $detail->product_price }}</td>
                  <td>{{ $detail->product_qty }}</td>
                  <td>{{ $detail->product_name }}</td>
                  <td>{{ $detail->shop_code }}-{{ $detail->invoice_id }}</td>
                  <td>{{ date("d-M-Y H:i A",strtotime($detail->created_at)) }}</td>
                  <td>{{ $detail->first_name }}</td>
                </tr>
																@endforeach
              </tbody>
            </table>
            <?php $AllTotal = str_replace(",","",$TotalSale) - str_replace(",","",$DiscountAmount) ;?>
<?php
function PriceTypeCount($strDate,$nPrice)
{
	$PriceType = array();
  $user_id = Session::get('user_id');
	$arrayPrice = DB::table('sales')
            ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
						->join('products', 'products.id', '=', 'sales_details.product_id')
						->select(DB::raw('SUM(`product_qty`) AS PriceType'))
						->whereRaw('sales_details.created_at LIKE "%'.$strDate.'%" AND products.product_price = '.$nPrice.' AND `return_id` = 0  AND sales.user_id = '.$user_id.'')
						->get();
						$PriceType = $arrayPrice[0]->PriceType;
return $PriceType;
}
// Get Discount
function GetDiscount($strDate)
{
	//$arrayDiscount = array();
  $user_id = Session::get('user_id');
	$arrayDiscount = DB::table('sales')
						->select(DB::raw('SUM(discount_amount) AS DiscountAmount'))
						->whereRaw('sales.created_at LIKE "%'.$strDate.'%" AND sales.return_id = 0 AND sales.user_id = '.$user_id.' ')
						->get();
						$Discount = $arrayDiscount[0]->DiscountAmount;
return $Discount;
}
$TodayDate = date("Y-m-d");
?>
            <table class="table table-striped m-b-0">
              <thead>
                <tr>
                  <td width="146" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,20) }}/20</td>
                  <td width="112" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,100) }}/100</td>
                  <td width="91" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,150) }}/150</td>
                  <td width="105" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,180) }}/180</td>
                  <td width="198" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,200) }}/200</td>
                  <td width="198" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,220) }}/220</td>
                  <td width="198" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,40) }}/40</td>
                  <td width="160" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,70) }}/70</td>
                  <td width="1">&nbsp;</td>
                  <td width="36">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" style="width:200px; font-weight:bold;">Discount Amount : {{ (int)GetDiscount($TodayDate) }}</td>
                  <td colspan="2" style="width:200px; font-weight:bold;">Total Quantity : {{ $TotalQty }}</td>
                  <td colspan="2" style="width:200px; font-weight:bold;">Total Sale : <?php echo number_format((int)$AllTotal);?></td>
                  <td style="width:200px; font-weight:bold;"></td>
                  <td style="width:162px; font-weight:bold;"></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </thead>
           </table>
            {!! $detail_sale->render() !!}
          </div>
     </div>     
    @stop
         <script src="{{asset('../../plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script type="text/javascript">
    $(document).ready(function() {
        var isAuth = "<?php echo Auth::check(); ?>";
									if (isAuth != 1) 
									{
													window.location = "/";
									}
    });
</script>
