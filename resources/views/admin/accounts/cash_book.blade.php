@extends('admin/layout/default')

{{-- Page content --}}
@section('content') 

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Cash Book </h1>
    <ol class="breadcrumb hide">
      <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="/admin/accounts/general_voucher">Search Ledger</a></li>
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
                  <td width="7%" valign="top" align="center"><strong></strong></td>
                  <td width="20%" valign="top" align="left"><strong></strong></td>
                  <td width="11%"><strong>Date From</strong></td>
                  <td width="14%" align="left"></td>
                  <td width="8%" align="left"><strong>Date To</strong></td>
                  <td width="13%"></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                  <td colspan="3"><strong>Opening Balance</strong></td>
                  <td>0</td>
                </tr>
              </tbody>
            </table>
            <hr>
            <table width="100%" class="table table-bordered table-hover">
              <tbody>
                <tr>
                  <td width="10%" align="center"><b>Date</b></td>
                  <td width="40%" align="center"><b>Details</b></td>
                  <td width="10%" align="center"><b>Voucher</b></td>
                  <td width="10%" align="center"><b>Debit</b></td>
                  <td width="10%" align="center"><b>Credit</b></td>
                  <td width="10%" align="center"><b>Balance</b></td>
                </tr>
                <?php
																/*$OPeninBalance = 0;
																$dBalance = 0;
																$dDebit = 0;
																$dCredit = 0;
																$ClosingBalance = 0;
																$i = 1;
																if(count($arrayLedeger) > 0)
																{
																foreach($arrayLedeger as $rstRow)
																{
                					$nVMId = $rstRow->vm_id;
																					if($i == 1)
																						$dBalance = $OPeninBalance + $dBalance + $rstRow->vd_debit - $rstRow->vd_credit;
																					else
																						$dBalance = $dBalance + $rstRow->vd_debit - $rstRow->vd_credit;	
																					
																					echo "	<tr>";
																					echo "		<td align=center>" . $rstRow->vm_date . "</td>";
																					echo "		<td >" . $rstRow->vd_desc . "</td>";
																					echo "		<td align=center>" . $rstRow->vm_type . "</td>";
																					echo "		<td align=right>" . number_format($rstRow->vd_debit, 0) . "</td>";
																					echo "		<td align=right>" . number_format($rstRow->vd_credit, 0) . "</td>";
																					echo "		<td align=right>" . number_format($dBalance, 0) . "</td>";
																					echo "	</tr>";
																		
																					$dDebit += $rstRow->vd_debit;
																					$dCredit += $rstRow->vd_credit;
																					$i++;
																}
																					echo "	<tr>";
																					echo "		<td colspan=3 align=right><strong>Total</strong></td>";
																					echo "		<td align=right><strong>" . number_format($dDebit, 0) . "</strong></td>";
																					echo "		<td align=right><strong>" . number_format($dCredit, 0) . "</strong></td>";
																					//$OPeninBalance1 = $OPeninBalance1;
																					$Debit = $dDebit;
																					$Credit = $dCredit;
																					$ClosingBalance = ($OPeninBalance + $Debit) - $Credit;
																					echo "		<td align=right><strong>" . number_format($ClosingBalance,0) . "</strong></td>";
																					echo "	</tr>";
																}*/
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