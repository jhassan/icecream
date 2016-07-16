@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Today Sale
          </h1>
          <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
          </ol>
        </section>
                  <?php
                  $OpBalance = 0;
                  //print_r($OpBalance[0]->NetAmount); die;
                          $OpeningBalance = number_format($OpBalance);
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
                              @if($shop_id == $shop->shop_id)
                                <option value="{{{ $shop->shop_id}}}" selected="selected">{{{ $shop->shop_name}}}</option>
                              @else
                                <option value="{{{ $shop->shop_id}}}"  >{{{ $shop->shop_name}}}</option>  
                              @endif  
                            @endforeach
                        </select>
                      </div>

                  </div>
                  <div class="box-footer clear" style="padding-top:33px;">
                    <button type="submit" class="btn btn-primary">Search</button>
                  </div>
                  
            </form>      
            <div class="col-xs-12">

              <div class="box">
                <div class="box-body">
                  <?php $OpeningBalance = 0; ?>
                <div class="col-xs-3">Opening Balance : {{ $OpeningBalance }}</div>
                <div class="col-xs-3">Today Expense : {{ $TodayExpense }}</div>
                <div class="col-xs-3">Today Sale : {{ $TotalSale }}</div>
                <?php
                          $OpeningBalance = str_replace(",","",$OpeningBalance);
                                          $TotalSale = str_replace(",","",$TotalSale);
                                          $TodayExpense = str_replace(",","",$TodayExpense);
                                          $TodaySaleTotal = (((int)$OpeningBalance + (int)$TotalSale) - ((int)($TodayExpense)));
                                ?>
                <div class="col-xs-3">Total : <?php echo number_format($TodaySaleTotal); ?></div>
                  <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="filters">
                            <th>Product Price</th>
                            <th>Product Quantity</th>
                            <th>Product Name</th>
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
                      <td>{{ date("d-M-Y H:i A",strtotime($detail->created_at)) }}</td>
                      <td>{{ $detail->first_name }}</td>
                    </tr>
                    @endforeach
                        
                    </tbody>
                  </table>
                  <?php 
function PriceTypeCount($strDate,$nPrice,$shop_id)
{
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
                  
                  <table class="table table-striped m-b-0">
                    <?php if($shop_id == 0) $shop_id = 1 ; ?>
                  <thead>
                    <tr>
                  <td width="146" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,20,$shop_id) }}/20</td>
                  <td width="112" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,100,$shop_id) }}/100</td>
                  <td width="91" style="font-weight:bold;">{{ (int)PriceTypeCount($TodayDate,150,$shop_id) }}/150</td>
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
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
     @stop 

     @section('footer_scripts')
     
     @stop