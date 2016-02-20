@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Trial Balance
          </h1>
          <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/shops/add">Add Shop</a></li>
          </ol>
        </section>
        <?php
										function AccountName($strCode, $strName)
										{
											if(substr($strCode, 1) == "00000")
												return 	$strName;
											else if(substr($strCode, 3) == "000")
												return "&nbsp;&nbsp;&nbsp;&nbsp;" . $strName;
											else
												return "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $strName;
										}
										
										function AccountTran($strCode)
										{
											$arrayCoa = DB::table('voucherdetail')
																->select(DB::raw('SUM(vd_debit) as total_debit, SUM(vd_credit) as total_credit'))
																->whereRaw('vd_coa_code = '.$strCode.'')
																->get();
										return $arrayCoa;
										}
										
										function ShowTransactions()
										{
											$strCoaCode = "";
											$str = "";
											$nToalClosing = 0;
											$dDebit = 0;
											$dCredit = 0;
											$dOpening1  = 0;
											$nToalClosing1  = 0;
											$dOpening  = 0;
											$nResult = DB::table('coa')
                ->orderBy('coa_code', 'asc')
                ->get();
											
											//while($rstRow = mysql_fetch_array($nResult))
											foreach($nResult as $rstRow)
											{
												//echo $rstRow->coa_code; die;
												$arr = AccountTran($rstRow->coa_code);
												
												$strCoaCode = $rstRow->coa_code;
												//$dOpening += $rstRow["coa_open_bal"];
												//$dOpening1 = $rstRow["coa_open_bal"];
												$dDebit += $arr[0]->total_debit;
												$dCredit += $arr[0]->total_credit;
												$dDebit1 = $arr[0]->total_debit;
												$dCredit1 = $arr[0]->total_credit;
												
												$nString = substr($strCoaCode,0,1);
												// 1 5 
												if ($nString == "1" || $nString == "5") 
												{
													$nTotal  = ($dOpening1 + $dDebit1) - ($dCredit1);
												//	$nTotal = str_replace('-','',$nTotal);
													$nToalClosing = $nTotal;
													$nToalClosing1 += $nTotal;
												}
												// 2 3 4
												else if ($nString == "2" || $nString == "3" || $nString == "4") 	
												{
													$nTotal  = ($dOpening1 + $dCredit1) - ($dDebit1);
													//$nTotal = str_replace('-','',$nTotal);
													
													$nToalClosing = $nTotal;
													$nToalClosing1 += $nTotal;
												}
											
												echo "	<tr>";
												echo "		<td align=left>" . $rstRow->coa_code . "</td>";
												echo "		<td >" . AccountName($rstRow->coa_code, $rstRow->coa_account) . "</td>";
												//echo "		<td align=right>" . (int)number_format($rstRow["coa_open_bal"], 0) . "</td>";
												echo "		<td align=right>" . number_format($arr[0]->total_debit, 0) . "</td>";
												echo "		<td align=right>" . number_format($arr[0]->total_credit, 0) . "</td>";
												//echo "		<td align=right>" . number_format($rstRow["coa_open_bal"] + $arr["total_debit"] - $arr["total_credit"], 0) . "</td>";
												echo "		<td align=right>" . number_format($nToalClosing, 0) . "</td>";
												echo "	</tr>";
												
											}
											
												echo "	<tr>";
												echo "		<td colspan=2 align=right>Total</td>";
												//echo "		<td align=right>" . number_format($dOpening, 0) . "</td>";
												echo "		<td align=right>" . number_format($dDebit, 0) . "</td>";
												echo "		<td align=right>" . number_format($dCredit, 0) . "</td>";
												echo "		<td align=right>" . number_format($nToalClosing1,0) . "</td>";
												echo "	</tr>";
																
										}
        		
								
								?>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr class="filters">
                            <th>Code</th>
                            <th>Account</th>
                            <!--<th>Opening</th>-->
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Closing</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php ShowTransactions();?>
                        
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
     @stop 

     @section('footer_scripts')
     
     @stop