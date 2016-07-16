@extends('admin/layout/default')

{{-- Page content --}}
@section('content')
<?php //echo $start_date."******".$end_date; die; ?>
<?php
if(empty($shop_id)) $shop_id = 1;
function PriceTypeCount($strDate = "", $nPrice = "", $shop_id)
{
	$PriceType = 0;
	$arrayPrice = array();
	if(!empty($strDate) && !empty($nPrice))
	{
	$arrayPrice = DB::table('sales')
						->join('sales_details', 'sales_details.sale_id', '=', 'sales.sale_id')
            ->join('products', 'products.id', '=', 'sales_details.product_id')
						->select(DB::raw('SUM(`product_qty`) AS PriceType'))
						->whereRaw('sales.created_at = "'.$strDate.'" AND products.product_price = '.$nPrice.' AND shop_id =  '.$shop_id.'')
						->get();
	}
	elseif(!empty($nPrice))
	{
	$arrayPrice = DB::table('sales')
            ->join('sales_details', 'sales_details.sale_id', '=', 'sales.sale_id')
						->join('products', 'products.id', '=', 'sales_details.product_id')
						->select(DB::raw('SUM(`product_qty`) AS PriceType'))
						->whereRaw('products.product_price = '.$nPrice.' AND shop_id =  '.$shop_id.' ')
						->get();	
	}
}
$start_date = $start_date;
$end_date = $end_date;
$start_date   = date("Y-m-d",strtotime($start_date));
$end_date     = date("Y-m-d",strtotime($end_date));
//echo $start_date."******".$end_date; die;
function TotalCount($field_name, $nPrice, $start_date, $end_date, $shop_id)
{
  $PriceType = 0;
  $arrayPrice = array();
  $arrayPrice = DB::table('sale_summery')
            ->select(DB::raw('SUM(`'.$field_name.'`) AS PriceType'))
            ->whereRaw('current_date1 BETWEEN "'.$start_date.'" AND "'.$end_date.'" AND shop_id =  '.$shop_id.'')
            ->get();  
  					$PriceType = $arrayPrice[0]->PriceType;
return $PriceType;
}

// Get Discount
function GetDiscount($start_date, $end_date, $shop_id)
{
    $arrayDiscount = DB::table('sale_summery')
            ->select(DB::raw('SUM(discount_amount) AS DiscountAmount'))
            ->whereRaw('current_date1 BETWEEN "'.$start_date.'" AND "'.$end_date.'" AND shop_id =  '.$shop_id.'')
            ->get();
            $Discount = $arrayDiscount[0]->DiscountAmount;
return $Discount;
}

// Get Total Sale
function GetTotalSale($start_date, $end_date, $shop_id)
{
  //$arrayDiscount = array();
  $arraySaleAmount = DB::table('sale_summery')
            ->select(DB::raw('SUM(total_sale) AS SaleAmount'))
            ->whereRaw('current_date1 BETWEEN "'.$start_date.'" AND "'.$end_date.'" AND shop_id =  '.$shop_id.' ')
            ->get();
            $SaleAmount = $arraySaleAmount[0]->SaleAmount; 
  return $SaleAmount;
}

// Get Expense and Credit
function GetExpenseCredit($strDate,$Type)
{
$sales = array();	
		if($Type == "D")
		{
			$sales = DB::table('vouchermaster')
						->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
						->select(DB::raw('SUM(vd_debit) AS TodayExpense'))
						->whereRaw('vm_date = "'.$strDate.'"')
						->get();	
			$Amount = $sales[0]->TodayExpense;									
		}
		else
		{
				$sales = DB::table('vouchermaster')
								->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
								->select(DB::raw('SUM(vd_credit) AS TodayCredit'))
								->whereRaw('vm_date = "'.$strDate.'"')
								->get();	
				$Amount = $sales[0]->TodayCredit;									
		}
}


?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Sale Summery
          </h1>
          <ol class="breadcrumb hide">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <form action="search_view_ledger" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="box-body col-sm-3">
                      <label for="shop_address">Start Date</label>
                      <input type="text" class="date-pick form-control" id="start_date" placeholder="Start Date" name="start_date">
                    </div>
                    <div class="box-body col-sm-3">
                      <label for="shop_address">End Date</label>
                      <input type="text" class="date-pick form-control" id="end_date" placeholder="End Date" name="end_date">
                    </div>
                    <div class="box-body col-sm-3">
                      <div class="dropdown">
                      <label for="shop" >Shop</label>
                        <select class="form-control" title="Select Shop..." name="shop_id">
                            <option value="">Select</option>
                            @foreach ($shops as $shop)
                              @if($shop_id == $shop->shop_id)
                                <option value="{{{ $shop->shop_id}}}" selected="selected" >{{{ $shop->shop_name}}}</option>
                              @else    
                                <option value="{{{ $shop->shop_id}}}"  >{{{ $shop->shop_name}}}</option>
                              @endif  
                            @endforeach
                        </select>
                      </div>
                  </div>
                  <div class="box-footer">
                    <button type="submit" style='margin-top:23px;' class="btn btn-primary">Search</button>
                  </div>
                </form>
              </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
                  <table width="991" class="table table-bordered table-hover">
                    <thead>
                        <tr class="filters">
                            <th width="132">Date</th>
                            <th colspan="2">No.CUP 150</th>
                            <th colspan="2">No.CUP 180</th>
                            <th colspan="2">No.CUP 200</th>
                            <th colspan="2">No.CUP 220</th>
                            <th colspan="2">Topping(20)</th>
                            <th colspan="2">Joy Kid(100)</th>
                            <th colspan="2">Water(40)</th>
                            <th colspan="2">Water(70)</th>
                            <th width="66">Sale</th>
                            <th width="46">D/C</th>
                            <th width="103">Net Sale</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                    $nToalClosing = 0;
										$dDebit = 0;
										$dCredit = 0;
										?>
                    @foreach($arraySummery as $summery) 
                    <?php 
										$CurrentDate = date("Y-m-d",strtotime($summery->current_date1));
										//$product_id = $summery->product_id;
										// For 150 Price
										$Array150 = $summery->ice_150;
										// For 180 Price
										$Array180 = $summery->ice_180;
										// For 200 Price
										$Array200 = $summery->ice_200;
										// For 100 Price
										$Array100 = $summery->ice_100;
										// For 20 Price
										$Array20 = $summery->ice_20;
										// For 220 Price
										$Array220 = $summery->ice_220;
                    // For 40 Price
                    $Array40 = $summery->wt_40;
                    // For 70 Price
                    $Array70 = $summery->wt_70;
										//$NetAmount = (((int)$Array150 * 150) + ((int)$Array180 * 180) + ((int)$Array100 * 100) 
										//+ ((int)$Array20 * 20) + ((int)$Array200 * 200));
										//$dDebit1 = 
										//$nToalClosing  += $summery->NetAmount - GetDiscount($CurrentDate);
										 ?>
                    				<tr>
                      <td>{{ date("d-M-y",strtotime($summery->current_date1)) }}</td>
                      <td width="67">{{ (int)$Array150 }}</td>
                      <td width="84">{{ number_format((int)$Array150 * 150) }}</td>
                      <td width="63">{{ (int)$Array180 }}</td>
                      <td width="69">{{ number_format((int)$Array180 * 180) }}</td>
                      <td width="63">{{ (int)$Array200 }}</td>
                      <td width="69">{{ number_format((int)$Array200 * 200) }}</td>
                      <td width="43">{{ (int)$Array220 }}</td>
                      <td width="54">{{ number_format((int)$Array220 * 220) }}</td>
                      <td width="43">{{ (int)$Array20 }}</td>
                      <td width="54">{{ number_format((int)$Array20 * 20) }}</td>
                      <td width="40">{{ (int)$Array100 }}</td>
                      <td width="59">{{ number_format((int)$Array100 * 100) }}</td>
                      <td width="40">{{ (int)$Array40 }}</td>
                      <td width="59">{{ number_format((int)$Array40 * 40) }}</td>
                      <td width="40">{{ (int)$Array70 }}</td>
                      <td width="59">{{ number_format((int)$Array70 * 70) }}</td>
                      <td>{{ number_format($summery->total_sale) }}</td>
                      <td>{{ number_format($summery->discount_amount) }}</td>
                      <td>{{ number_format($summery->net_sale) }}</td>
                    </tr>
                    @endforeach

                    <tr class="filters">
                            <th width="132"></th>
                            <th colspan="2">{{ number_format(TotalCount("ice_150", 150, $start_date, $end_date, $shop_id)) }}</th>
                            <th colspan="2">{{ number_format(TotalCount("ice_180",180, $start_date, $end_date, $shop_id)) }}</th>
                            <th colspan="2">{{ number_format(TotalCount("ice_200",200, $start_date, $end_date, $shop_id)) }}</th>
                            <th colspan="2">{{ number_format(TotalCount("ice_220",220, $start_date, $end_date, $shop_id)) }}</th>
                            <th colspan="2">{{ number_format(TotalCount("ice_20",20, $start_date, $end_date, $shop_id)) }}</th>
                            <th colspan="2">{{ number_format(TotalCount("ice_100",100, $start_date, $end_date, $shop_id)) }}</th>
                            <th colspan="2">{{ number_format(TotalCount("wt_40",40, $start_date, $end_date, $shop_id)) }}</th>
                            <th colspan="2">{{ number_format(TotalCount("wt_70",70, $start_date, $end_date, $shop_id)) }}</th>
                            <th width="66">{{ number_format(GetTotalSale($start_date, $end_date, $shop_id)) }}</th>
                            <th width="46">{{ number_format(GetDiscount($start_date, $end_date, $shop_id)) }}</th>
                            <th width="103">{{ number_format(GetTotalSale($start_date, $end_date, $shop_id) - GetDiscount($start_date, $end_date, $shop_id)) }}</th>

                        </tr>
                    </tbody>
                    
                  </table>
                  {!! $arraySummery->render() !!}
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
     @stop 

     @section('footer_scripts')
     
     @stop