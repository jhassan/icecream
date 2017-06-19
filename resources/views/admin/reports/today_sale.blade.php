@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Today Sale</h1>
          <ol class="breadcrumb hide">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
          </ol>
        </section>
<?php
$OpBalance = 0;
//print_r($OpBalance[0]->NetAmount); die;
$OpeningBalance = number_format($OpBalance);
function PriceTypeCount($strDate,$nPrice,$shop_id)
{
  if($shop_id == 0)
    $shop_id = Auth::user()->shop_id;
  $PriceType = array();
  $user_id = Session::get('user_id');
  $arrayPrice = DB::table('sales')
            ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
            ->join('products', 'products.id', '=', 'sales_details.product_id')
            ->select(DB::raw('SUM(`product_qty`) AS PriceType'))
            ->whereRaw('sales_details.created_at LIKE "%'.$strDate.'%" AND sales.shop_id = '.$shop_id.' AND products.product_price = '.$nPrice.' AND `return_id` = 0')
            ->get();
            $PriceType = $arrayPrice[0]->PriceType;
return $PriceType;
}
// Get Discount
function GetDiscount($strDate,$shop_id)
{
  //$arrayDiscount = array();
  if($shop_id == 0)
    $shop_id = Auth::user()->shop_id;
  $user_id = Session::get('user_id');
  $arrayDiscount = DB::table('sales')
            ->select(DB::raw('SUM(discount_amount) AS DiscountAmount'))
            ->whereRaw('sales.created_at LIKE "%'.$strDate.'%" AND sales.shop_id = '.$shop_id.' AND sales.return_id = 0 ')
            ->get();
            $Discount = $arrayDiscount[0]->DiscountAmount;
return $Discount;
}
                  $TodayDate = date("Y-m-d");
                  $AllTotal = str_replace(",","",$TotalSale) - str_replace(",","",GetDiscount($TodayDate,$shop_id)) ;
?>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <form action="today_sale" method="get">
            <div class="box-body col-sm-4" style="margin-left:6px">
                      <div class="dropdown">
                      <label for="shop" >All Shop</label>
                        <select class="form-control" title="Select Shop..." name="shop_id">
                            <option value="">Select</option>
                            @foreach ($shops as $shop)
                                <option value="{{{ $shop->shop_id}}}"  >{{{ $shop->shop_name}}}</option>  
                            @endforeach
                        </select>
                      </div>

                  </div>
                  <div class="box-footer" style="padding-top:33px;">
                    <button type="submit" class="btn btn-primary">Search</button>
                  </div>
                  
            </form>      
            <div class="col-xs-12">

              <div class="box">
                <div class="box-body">
                  <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="filters">
                            <th>Product Price</th>
                            <th>Product Quantity</th>
                            <th>Product Name</th>
                            <th>Date</th>
                            <th>Employee</th>
                            <th>Shop</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($detail_sale as $detail)
                    <?php //$date = date("d-M-Y H:i A",strtotime($detail->created_at)); 
                        //$last_date = date("Y-m-d",strtotime($detail->created_at)); 
                        // $today_date = date("Y-m-d"." 11:55 AM");
                        //echo $last_date;
                        if($detail->new_date_time == "0000-00-00 00:00:00")
                          $date = date("d-M-Y H:i A",strtotime($detail->created_at));
                        else
                          $date = date("d-M-Y H:i A",strtotime($detail->new_date_time));
                  ?>
                    <tr>
                      <td>{{ $detail->product_price }}</td>
                      <td>{{ $detail->product_qty }}</td>
                      <td>{{ $detail->product_name }}</td>
                      <td>{{ $date }}</td>
                      <td>{{ $detail->first_name }}</td>
                      <td>{{ $detail->shop_code }}</td>
                    </tr>
                    @endforeach
                        
                    </tbody>
                  </table>
                  
                  
                  <table class="table table-striped m-b-0">
                    <?php //if($shop_id == 0) $shop_id = 1 ; ?>
                  <thead>
                    <tr>
                  <td width="146" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,20,$shop_id) }}/20</td>
                  <td width="112" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,100,$shop_id) }}/100</td>
                  <td width="91" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,150,$shop_id) }}/150</td>
                  <td width="91" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,170,$shop_id) }}/170</td>
                  <td width="105" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,180,$shop_id) }}/180</td>
                  <td width="198" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,200,$shop_id) }}/200</td>
                  <td width="198" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,220,$shop_id) }}/220</td>
                  <td width="198" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,40,$shop_id) }}/40</td>
                  <td width="160" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,70,$shop_id) }}/70</td>
                  <td width="1">&nbsp;</td>
                  <td width="36">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" style="width:200px; font-weight:bold;">Discount Amount : {{ (int)GetDiscount($TodayDate,$shop_id) }}</td>
                  <td colspan="2" style="width:200px; font-weight:bold;">Total Quantity : {{ number_format((int)$TotalQty) }}</td>
                  <td colspan="2" style="width:200px; font-weight:bold;">Total Sale : <?php echo number_format((int)$AllTotal);?></td>
                  <td style="width:200px; font-weight:bold;"></td>
                  <td style="width:162px; font-weight:bold;"></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                  </thead>
               </table>
                  {!! $detail_sale->render() !!}
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div> /.content-wrapper -->
      
     @stop 

     @section('footer_scripts')
     
     @stop