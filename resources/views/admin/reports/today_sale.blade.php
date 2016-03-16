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
									//print_r($OpBalance[0]->NetAmount); die;
													$OpeningBalance = number_format($OpBalance[0]->NetAmount);
								?>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
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
																					function PriceTypeCount($strDate,$nPrice)
																					{
																						$PriceType = array();
																						$arrayPrice = DB::table('sales_details')
																											->join('products', 'products.id', '=', 'sales_details.product_id')
																											->select(DB::raw('SUM(`product_qty`) AS PriceType'))
																											->whereRaw('sales_details.created_at LIKE "%'.$strDate.'%" AND products.product_price = '.$nPrice.'')
																											->get();
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
																			$TodayDate = date("Y-m-d");
																			$AllTotal = str_replace(",","",$TotalSale) - str_replace(",","",GetDiscount($TodayDate)) ;
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
                  <td width="198" style="font-weight:bold;"></td>
                  <td width="160" style="font-weight:bold;"></td>
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
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
     @stop 

     @section('footer_scripts')
     
     @stop