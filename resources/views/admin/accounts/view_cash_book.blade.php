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
				// Oppening Balance
				// function get_opening_balance($coa)
				// {
				// 		$arrayOpBalance = array();
				// 		$arrayOpBalance = DB::table('coa')
				// 						->select('coa_debit','coa_credit')
				// 						->whereRaw('coa_code = "'.$coa.'"')
				// 						->get();	
				// 		return $arrayOpBalance;
			 //    }

			 //    $OpBalance = get_opening_balance("414002");	
			 //    $coa_crdit = $OpBalance[0]->coa_credit;
    //             $coa_debit = $OpBalance[0]->coa_debit;
    //             if($coa_crdit != 0)
    //             	$OPeninBalance = $coa_crdit;
    //             elseif($coa_debit != 0)
    //             	$OPeninBalance = $coa_debit;
					$OPeninBalance = $OpBalance;
				?>
                  <td align="left" valign="top"><?php echo date('h:i:s A');?></td>
                  <td width="11%"><strong>Date From</strong></td>
                  <td width="14%" align="left">{{ date("d-M-Y",strtotime($start_date))  }}</td>
                  <td width="8%" align="left"><strong>Date To</strong></td>
                  <td width="13%">{{ date("d-M-Y",strtotime($end_date)) }}</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="3"><strong>Opening Balance</strong></td>
                  <td>{{ number_format($OPeninBalance) }}</td>
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
					// $DateExpense = 0;
					// //$DateExpense = GetDateWiseExpense($rstRow->vm_date);
					// //$dBalance = ($OPeninBalance - $DateExpense) + $rstRow->vd_credit;
					// if($rstRow->vd_debit == '0.0000')
					// 	{
					// 		$DateExpense = GetDateWiseExpense($rstRow->vm_date);
					// 		$dBalance = ($OPeninBalance + $rstRow->vd_credit) - $DateExpense; 
					// 	}
					// else
					// 	$dBalance = 0;
					// echo $rstRow->vd_coa_code."------".$rstRow->vm_type.","; 
					$dBalance = ($OPeninBalance + $rstRow->vd_credit) - $rstRow->vd_debit;
					if($rstRow->vd_coa_code != "414002" || $rstRow->vm_type != "CR" || $rstRow->vd_credit != "0.0000")
					{
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
					}	
					
				}
					echo "	<tr>";
					echo "		<td colspan=5 align=right><strong>Total</strong></td>";
					echo "		<td align=right><strong>" . number_format($dDebit, 0) . "</strong></td>";
					echo "		<td align=right><strong>" . number_format($dCredit, 0) . "</strong></td>";
					$Debit = $dDebit;
					$Credit = $dCredit;
					//echo $OPeninBalance."***".$Debit."-----".$Credit;
					$ClosingBalance = ($OPeninBalance + $Credit) - $Debit;
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