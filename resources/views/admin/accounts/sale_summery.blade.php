@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

<?php
function PriceTypeCount($strDate = "", $nPrice = "")
{
	$PriceType = 0;
	$arrayPrice = array();
	if(!empty($strDate) && !empty($nPrice))
	{
	$arrayPrice = DB::table('sales_details')
						->join('products', 'products.id', '=', 'sales_details.product_id')
						->select(DB::raw('SUM(`product_qty`) AS PriceType'))
						->whereRaw('sales_details.created_at LIKE "%'.$strDate.'%" AND products.product_price = '.$nPrice.'')
						->get();
	}
	elseif(!empty($nPrice))
	{
	$arrayPrice = DB::table('sales_details')
						->join('products', 'products.id', '=', 'sales_details.product_id')
						->select(DB::raw('SUM(`product_qty`) AS PriceType'))
						->whereRaw('products.product_price = '.$nPrice.'')
						->get();	
	}
	// var_dump($arrayPrice[0]->PriceType); die;
						$PriceType = $arrayPrice[0]->PriceType;
return $PriceType;
}

// Get Discount
function GetDiscount($strDate)
{
	//$arrayDiscount = array();
	$arrayDiscount = DB::table('sales')
						->select(DB::raw('SUM(discount_amount) AS DiscountAmount'))
						->whereRaw('sales.created_at LIKE "%'.$strDate.'%"')
						->get();
						$Discount = $arrayDiscount[0]->DiscountAmount;
return $Discount;
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
																								$CurrentDate = date("Y-m-d",strtotime($summery->created_at));
																								$product_id = $summery->product_id;
																								// For 150 Price
																								$Array150 = PriceTypeCount($CurrentDate,150);
																								// For 180 Price
																								$Array180 = PriceTypeCount($CurrentDate,180);
																								// For 200 Price
																								$Array200 = PriceTypeCount($CurrentDate,200);
																								// For 100 Price
																								$Array100 = PriceTypeCount($CurrentDate,100);
																								// For 20 Price
																								$Array20 = PriceTypeCount($CurrentDate,20);
																								// For 220 Price
																								$Array220 = PriceTypeCount($CurrentDate,220);
																								//$NetAmount = (((int)$Array150 * 150) + ((int)$Array180 * 180) + ((int)$Array100 * 100) 
																								//+ ((int)$Array20 * 20) + ((int)$Array200 * 200));
																								//$dDebit1 = 
																								$nToalClosing  += $summery->NetAmount - GetDiscount($CurrentDate);
																								 ?>
                    				<tr>
                      <td>{{ date("d-M-Y",strtotime($summery->created_at)) }}</td>
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
                      <td>{{ number_format($summery->NetAmount) }}</td>
                      <td>{{ number_format(GetDiscount($CurrentDate)) }}</td>
                      <td>{{ number_format($summery->NetAmount - GetDiscount($CurrentDate)) }}</td>
                    </tr>
                    @endforeach
                    <tr class="filters">
                            <th width="132"></th>
                            <th colspan="2">{{ PriceTypeCount("",150) }}</th>
                            <th colspan="2">{{ PriceTypeCount("",180) }}</th>
                            <th colspan="2">{{ PriceTypeCount("",200) }}</th>
                            <th colspan="2">{{ PriceTypeCount("",220) }}</th>
                            <th colspan="2">{{ PriceTypeCount("",20) }}</th>
                            <th colspan="2">{{ PriceTypeCount("",100) }}</th>
                            <th width="66">Sale</th>
                            <th width="46">D/C</th>
                            <th width="103">Net Sale</th>
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