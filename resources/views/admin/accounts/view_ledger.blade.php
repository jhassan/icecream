@extends('admin/layout/default')

{{-- Page content --}}
@section('content') 
<?php
//print_r($arrayLedeger); die;
// $coa_crdit = $OpBalance[0]->coa_credit;
// $coa_debit = $OpBalance[0]->coa_debit;
// if($coa_crdit != 0)
// 	$OPeninBalance = $coa_crdit;
// elseif($coa_debit != 0)
// 	$OPeninBalance = $coa_debit;	 
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
	$coa_code = (!empty($arrayLedeger[0]->coa_code)) ? $arrayLedeger[0]->coa_code : '';
	$coa_account = (!empty($arrayLedeger[0]->coa_account)) ? $arrayLedeger[0]->coa_account : '';

	// Check OPBalance is Credit OR Debit
	function get_opening_balance($coa)
	{
		$arrayOpBalance = array();
		$arrayOpBalance = DB::table('coa')
						->select('coa_debit','coa_credit','coa_type')
						->whereRaw('coa_code = "'.$coa.'"')
						->get();	
		return $arrayOpBalance;
	}
	$CheckDebitCreditOP = get_opening_balance($coa_code);
	//print_r($CheckDebitCreditOP); die;
	$is_Debit = "";
	if(!empty($CheckDebitCreditOP))
	{
		if($CheckDebitCreditOP[0]->coa_type == "D")
			$is_Debit = "Dr"; 
		elseif($CheckDebitCreditOP[0]->coa_type == "C")
			$is_Debit = "Cr"; 
	}												
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <a href="/admin/accounts/general_ledeger">View General Ledger </a></h1>
    <ol class="breadcrumb">
      <li><a href="/admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="/admin/accounts/general_ledeger">Search Ledger</a></li>
      <li><button id="PrintContent" onclick="printDiv()" class="btn btn-primary no-print pull-right">Print</button></li>
    </ol>

  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">
          	<div id="heading_div2">
              	<table>
              	<tr class="filters">
	                <h2 align="center" style="margin-top: 0px;font-family: cursive; font-size: 37px; margin-bottom: 0px;">Cappellos</h2>
	                <p clas="text-center" align="center" style="font-size:16px; margin-bottom: 0px;">3rd Floor United Mall, Abdali Road Multan</p>
	            </tr>
	            <tr class="filters">
	                <h4 align="center" style=" margin-top: 0px;font-weight: bold; text-decoration: underline; margin-bottom: 0px;">General Ledger</h4>
	            </tr>
	            <tr class="filters hide">
	                <h4 align="left" style=" margin-top: 0px;font-size: 15px; text-align: center; font-weight: bold; margin-bottom: 0px;">Date: {{ date("d-M-Y",strtotime($start_date)) }} to {{ date("d-M-Y",strtotime($end_date)) }} </h4>
	            </tr>
	            </table>
            </div>
            <table width="100%" class="table table-bordered table-hover" id="example2">
              <tbody>

                <tr>
                
                  <td width="7%" valign="top" align="center"><strong>{{ $coa_code }}</strong></td>
                  <td width="20%" valign="top" align="left"><strong>{{ $coa_account }}</strong></td>
                  <td width="11%" style="padding-top: 0px;"><strong>Date From</strong></td>
                  <td width="14%" style="padding-top: 0px;" align="left">{{ date("d-M-Y",strtotime($start_date))  }}</td>
                  <td width="8%" style="padding-top: 0px;" align="left"><strong>Date To</strong></td>
                  <td width="13%" style="padding-top: 0px;">{{ date("d-M-Y",strtotime($end_date))  }}</td>
                </tr>
                <tr>
                  <td colspan="2" style="padding-top: 0px;">&nbsp;</td>
                  <td colspan="3" style="padding-top: 0px;"><strong>Opening Balance</strong></td>
                  <td style="padding-top: 0px;">{{ number_format($OpBalance) }}   
                  	@if(!empty($is_Debit))
                  	<strong style="padding-left:10px; padding-top: 0px;">({{ $is_Debit }})</strong>
                  	@endif
                  </td>
                </tr>
              </tbody>
            </table>
            <table width="100%" class="table table-bordered table-hover" id="heading_div">
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
				$dBalance = 0;
				$dDebit = 0;
				$dCredit = 0;
				$ClosingBalance = 0;
				$i = 1;
				if(count($arrayLedeger) > 0)
				{
					foreach($arrayLedeger as $rstRow)
					{
						if($is_Debit == "Dr")
							$OpBalance = ($OpBalance + $rstRow->vd_debit) - $rstRow->vd_credit;	
						else
							$OpBalance = ($OpBalance + $rstRow->vd_credit) - $rstRow->vd_debit;	
						
						echo "	<tr>";
						echo "		<td align=center>" . date("d-m-Y", strtotime($rstRow->vm_date)) . "</td>";
						echo "		<td >" . $rstRow->vd_desc . "</td>";
						echo "		<td align=center>" . $rstRow->vm_type . "</td>";
						echo "		<td align=right>" . number_format($rstRow->vd_debit, 0) . "</td>";
						echo "		<td align=right>" . number_format($rstRow->vd_credit, 0) . "</td>";
						echo "		<td align=right>" . number_format($OpBalance, 0) . "</td>";
						echo "	</tr>";
			
						$dDebit += $rstRow->vd_debit;
						$dCredit += $rstRow->vd_credit;
						$i++;
					}
						echo "	<tr>";
						echo "		<td colspan=3 align=right><strong>Total</strong></td>";
						echo "		<td align=right><strong>" . number_format($dDebit, 0) . "</strong></td>";
						echo "		<td align=right><strong>" . number_format($dCredit, 0) . "</strong></td>";
						$Debit = $dDebit;
						$Credit = $dCredit;
						$ClosingBalance = ($OpBalance + $Credit) - $Debit;
						echo "		<td align=right><strong>" . number_format($OpBalance,0) . "</strong></td>";
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
<script type="text/javascript">
function printDiv() {    
    // 1st
   var divToPrint = document.getElementById('example2');
   var heading_div = document.getElementById('heading_div');
   var heading_div2 = document.getElementById('heading_div2');
    var htmlToPrint = '' +
        '<style type="text/css">' +
        'table th, table td {' +
        'border: solid #000 !important;' +
        'border-width: 0 1px 1px 0 !important;' +
        'padding-left: 0px !important;' +
        'font-size: 12px !important;' +
        '}' +
        'table {' +
        'border: solid #000 !important;' +
        'border-width: 1px 0 0 1px !important;' +
        '}' +
        'th, td span {' +
        // 'border: solid #000 !important;' +
        // 'border-width: 1px 0 0 1px !important;' +
        'padding-left: 2px !important;' +
        '}' +
        '.main_title {' +
        'width: 50px !important;' +
        '}' +
        'h2 {' +
        'margin-bottom: 0px !important;' +
        'margin-top: 0px !important;' +
        '}' +
        
        '</style>';
    //var htmlToPrint = '';
    htmlToPrint += heading_div2.outerHTML;
    htmlToPrint += divToPrint.outerHTML;
    htmlToPrint += heading_div.outerHTML;
    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
 }
</script>

@stop