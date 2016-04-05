@extends('admin/layout/default')

{{-- Page content --}}
@section('content') 

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Cash Book </h1>
    <ol class="breadcrumb">
      <li class="hide"><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="/admin/accounts/frm_cash_book">Search Cash Book</a></li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">
            <table width="100%" class="table table-bordered table-hover">
              <tbody>
                <tr>
                <?php
                //	$coa_code = (!empty($arrayCashBook[0]->coa_code)) ? $arrayCashBook[0]->coa_code : '';
																//	$coa_account = (!empty($arrayCashBook[0]->coa_account)) ? $arrayCashBook[0]->coa_account : '';
																function GetDateWiseExpense($date)
																{
																			$arrayDetail = DB::table('vouchermaster')
																																					->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
																																					->select(DB::raw('SUM(vd_debit) AS TotalExpense'))
																																					->whereRaw('vm_date = "'.$date.'" AND vd_coa_code != 0')
																																					->orderBy('vm_date', 'asc')
																																					->get();	
																																					return $arrayDetail[0]->TotalExpense;
																}
																?>
                  <td align="left" valign="top"><?php echo date('h:i:s A');?></td>
                  <td width="11%"><strong>Date From</strong></td>
                  <td width="14%" align="left">{{ $start_date }}</td>
                  <td width="8%" align="left"><strong>Date To</strong></td>
                  <td width="13%">{{ $end_date }}</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="3"><strong>Opening Balance</strong></td>
                  <td>0{{-- number_format($OpBalance) --}}</td>
                </tr>
              </tbody>
            </table>
            <hr>
            <table width="100%" class="table table-bordered table-hover">
              <tbody>
                <tr>
                  <td width="5%" align="center"><b>Type</b></td>
                  <td width="10%" align="center"><b>Date</b></td>
                  <td width="8%" align="center"><b>Code</b></td>
                  <td width="22%" align="center"><b>Name</b></td>
                  <td width="32%" align="left"><b>Remarks</b></td>
                  <td width="8%" align="center"><b>Debit</b></td>
                  <td width="8%" align="center"><b>Credit</b></td>
                  <td width="7%" align="center"><b>Balance</b></td>
                </tr>
                <?php
																$OpBalance = 0;
																$dBalance = 0;
																$dDebit = 0;
																$dCredit = 0;
																$ClosingBalance = 0;
																$DetailDebit = 0;
																$DetailCredit = 0;
																$i = 1;
																$now_date = '';
																$sum_debit = 0;
																if(count($arrayCashBook) > 0)
																{
																foreach($arrayCashBook as $rstRow)
																{
                					/*$nVMId = $rstRow->vm_id;
																					if($i == 1)
																						$dBalance = $OPeninBalance + $dBalance + $rstRow->vd_debit - $rstRow->vd_credit;
																					else
																						$dBalance = $dBalance + $rstRow->vd_debit - $rstRow->vd_credit;	*/
																					
																					
																					/*$arrayDetail = DB::table('vouchermaster')
																																					->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
																																					->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
																																					->select('vm_date','voucherdetail.*','vm_type','coa_account')
																																					->whereRaw('vm_date = "'.$rstRow->vm_date.'"')
																																					->orderBy('vm_date', 'asc')
																																					->groupBy('vd_vm_id')
																																					->get();
																					foreach($arrayDetail as $Detail)
																					{
																							$DetailDebit += $Detail->vd_debit;
																							$DetailCredit += $Detail->vd_credit;
																						
																					}
																					
																					//echo $rstRow->vd_credit; die;
																					$now_date = $rstRow->vm_date;
																					if($rstRow->vd_credit == '0.0000')
																					{
																								$sum_debit += $rstRow->vd_debit; 
																								$dBalance = ($OpBalance - $sum_debit) + $DetailCredit; 
																					}
																					else
																								$sum_debit = 0;*/
																					
																							//echo $rstRow->vd_debit; die;
																							
																							$dBalance = 0;	
																							$DateExpense = 0;
																							if($rstRow->vd_debit == '0.0000')
																								{
																									//echo $rstRow->vd_credit."*****"; 
																									 
																									$DateExpense = GetDateWiseExpense($rstRow->vm_date);
																								//	echo $rstRow->vd_credit."--------".$DateExpense; die;
																									$dBalance = ($OpBalance - $DateExpense) + $rstRow->vd_credit; 
																									//$dBalance = $DateExpense - $rstRow->vd_credit; 
																									//$dBalance = $DateExpense;//  - $rstRow->vd_credit; 
																								}
																							else
																								{
																											//echo $rstRow->vd_debit."adfadfda"; 34390
																											$dBalance = 0;
																									}
																							//echo $dBalance."*****"; die;	
																							echo "	<tr>";
																							echo "		<td align=center>" . $rstRow->vm_type . "</td>";
																							echo "		<td >" . date("d-M-Y",strtotime($rstRow->vm_date)) . "</td>";
																							echo "		<td align=center>" . $rstRow->vd_coa_code . "</td>";
																							echo "		<td align=left>" . $rstRow->coa_account . "</td>";
																							echo "		<td align=left>" . $rstRow->vd_desc . "</td>";
																							echo "		<td align=right>" . number_format($rstRow->vd_debit, 0) . "</td>";
																							echo "		<td align=right>" . number_format($rstRow->vd_credit, 0) . "</td>";
																							echo "		<td align=right>" . number_format($dBalance, 0) . "</td>";
																							echo "	</tr>";
																				
																							$dDebit += $rstRow->vd_debit;
																							$dCredit += $rstRow->vd_credit;
																						//	$dBalance = 0;
																					
																					
																					//$i++;
																}
																					echo "	<tr>";
																					echo "		<td colspan=5 align=right><strong>Total</strong></td>";
																					echo "		<td align=right><strong>" . number_format($dDebit, 0) . "</strong></td>";
																					echo "		<td align=right><strong>" . number_format($dCredit, 0) . "</strong></td>";
																					//$OPeninBalance1 = $OPeninBalance1;
																					$Debit = $dDebit;
																					$Credit = $dCredit;
																					$ClosingBalance = ($OpBalance + $Debit) - $Credit;
																					echo "		<td align=right><strong>" . number_format($ClosingBalance,0) . "</strong></td>";
																					echo "	</tr>";
																}
																?>
              </tbody>
            </table>
          </div>
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
<!-- /.content-wrapper --> 
@stop 
@section('footer_scripts') 
@stop