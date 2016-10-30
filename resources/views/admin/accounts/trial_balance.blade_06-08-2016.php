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
<ol class="breadcrumb hide">
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
		return "<span style='font-weight:bold; padding-left:10px'>" . $strName . "</span>";
	else
		return "<span style='padding-left:20px'>" . $strName . "</span>";
}

function AccountTran($strCode)
{
	$arrayCoa = DB::table('voucherdetail')
	->select(DB::raw('SUM(vd_debit) as total_debit, SUM(vd_credit) as total_credit'))
	->whereRaw('vd_coa_code = '.$strCode.'')
	->get();
return $arrayCoa;
}

function get_opening_balance($coa)
{
	$arrayOpBalance = array();
	$arrayOpBalance = DB::table('coa')
					->select('coa_debit','coa_credit')
					->whereRaw('coa_code = "'.$coa.'"')
					->get();	
	return $arrayOpBalance;
}

function search_vouchers($coa, $start_date, $end_date, $OpBalance)
{
	$Debit = 0;
	$Credit = 0;
	$dDebit = 0;
	$dCredit = 0;
	$ClosingBalance = 0;
	$arrayVoucher = DB::table('vouchermaster')
					->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
					->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
					->select('vouchermaster.*','voucherdetail.*','coa.*')
					->whereRaw('vd_coa_code = '.$coa.' AND vm_date >= "'.$start_date.'" AND vm_date <= "'.$end_date.'" ')
					->orderBy('vm_date', 'asc')
					->get();
	if(count($arrayVoucher) > 0)
	{
		foreach($arrayVoucher as $rstRow)
		{
			$dDebit += $rstRow->vd_debit;
			$dCredit += $rstRow->vd_credit;
		}
			$Debit = $dDebit;
			$Credit = $dCredit;
			$ClosingBalance = ($OpBalance + $Debit) - $Credit;
			$allArray = array();
			$allArray['Debit'] = $Debit;
			$allArray['Credit'] = $Credit;
			$allArray['ClosingBalance'] = $ClosingBalance;
			return $allArray;
	}
}

// Check OPBalance is Credit OR Debit

function ShowTransactions()
{
	$OB_Debit  = 0;
	$OB_Credit = 0;
	$Grand_Total = 0;
	$Grand_Total_Debit = 0;
	$Grand_Total_Credit = 0;
	$Grand_TR_Total_Debit = 0;
	$Grand_TR_Total_Credit = 0;
	$Grand_Total_Closing = 0;
	$Grand_Total_Closing_Debit = 0;
	$nResult = DB::table('coa')
	->where('parent_id', '=', 0)
	->orderBy('coa_code', 'asc')
	->get();

	foreach($nResult as $rstRow)
	{
		// Show Main Head
			echo "	<tr>";
			echo "		<td >" . AccountName($rstRow->coa_code, $rstRow->coa_account) . "</td>";
			echo "		<td></td>";
			echo "		<td></td>";
			echo "		<td></td>";
			echo "	</tr>";

		$nResultDetail = DB::table('coa')
					->where('parent_id', '=', $rstRow->coa_id)
					->orderBy('coa_code', 'asc')
					->get();
		$Total_OB_Debit = 0;
		$Total_OB_Credit = 0;
		$Total_TR_Debit = 0;
		$Total_TR_Credit = 0;
		$Total_Closing = 0;
		$OpBalance = 0;	
		$sub_Total_Debit = 0;
		$sub_Total_Credit = 0;	
		$sub_Total_Closing = 0;	
		$Closing_Balance_Debit = 0;
		$Closing_Balance_Credit = 0;
		$Total_Closing_Debit = 0;
		foreach ($nResultDetail as $key => $value) {
			$OB_Balance = get_opening_balance($value->coa_code);
			$is_Debit = "";
			if(!empty($OB_Balance))
			{
				if($OB_Balance[0]->coa_debit != 0)
					$is_Debit = "Dr"; 
				elseif($OB_Balance[0]->coa_credit != 0)
					$is_Debit = "Cr"; 
			}
			$OB_Debit = $OB_Balance[0]->coa_debit; 
			$OB_Credit = $OB_Balance[0]->coa_credit; 
			$OpBalance = $OB_Debit + $OB_Credit;
			$start_date = "2016-04-01";
			$end_date =  date("Y-m-d");
			// Get all debit credit sum with opening balance
			$allData = search_vouchers($value->coa_code, $start_date, $end_date, $OpBalance);
			$Total_TR_Debit = $allData['Debit'];
			$Total_TR_Credit = $allData['Credit'];
			//$Total_Closing = ($OpBalance + $Total_TR_Debit) - $Total_TR_Credit;
			if($is_Debit == "Dr")
				$Total_Closing = ($OpBalance + $Total_TR_Debit) - $Total_TR_Credit;
			else
				$Total_Closing = ($OpBalance - $Total_TR_Debit) + $Total_TR_Credit;
			$sub_Total_Debit += $Total_TR_Debit;
			$sub_Total_Credit += $Total_TR_Credit;
			$Closing_Balance_Debit = $OB_Debit + $Total_TR_Debit;
			echo "	<tr>";
			echo "		<td >" . AccountName($value->coa_code, $value->coa_account) . "</td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px'>".number_format($OB_Debit)."</span><span style='text-align:right; float:right;'>".number_format($OB_Credit)."</span></td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px'>".number_format($Total_TR_Debit)."</span><span style='text-align:right; float:right;'>".number_format($Total_TR_Credit)."</span></td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px'>".number_format($Closing_Balance_Debit)."</span><span style='text-align:right; float:right;'>".number_format($Total_Closing)."</span></td>";
			echo "	</tr>";
			$Total_OB_Debit += $OB_Debit;
			$Total_OB_Credit += $OB_Credit;
			$sub_Total_Closing += $Total_Closing;
			$Total_Closing_Debit += $Closing_Balance_Debit;
		}			
		// Sub total head
			echo "	<tr>";
			echo "		<td align='right' style='font-weight:bold;'>Sub Head Total:</td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px; font-weight:bold'>".number_format($Total_OB_Debit)."</span><span style='text-align:right; float:right; font-weight:bold'>".number_format($Total_OB_Credit)."</span></td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px; font-weight:bold'>".number_format($sub_Total_Debit)."</span><span style='text-align:right; float:right; font-weight:bold'>".number_format($sub_Total_Credit)."</span></td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px; font-weight:bold'>".number_format($Total_Closing_Debit)."</span><span style='text-align:right; float:right; font-weight:bold'>".number_format($sub_Total_Closing)."</span></td>";
			echo "	</tr>";
			
			$Grand_Total_Debit += $Total_OB_Debit;
			$Grand_Total_Credit += $Total_OB_Credit;
			$Grand_TR_Total_Debit += $sub_Total_Debit;
			$Grand_TR_Total_Credit += $sub_Total_Credit;
			$Grand_Total_Closing += $Total_OB_Credit + $sub_Total_Credit;
			$Grand_Total_Closing_Debit += $Total_Closing_Debit;
		
	}
		// Grand total head
			echo "	<tr>";
			echo "		<td align='right' style='font-weight:bold;'>Grand Total:</td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px; font-weight:bold'>".number_format($Grand_Total_Debit)."</span><span style='text-align:right; float:right; font-weight:bold'>".number_format($Grand_Total_Credit)."</span></td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px; font-weight:bold'>".number_format($Grand_TR_Total_Debit)."</span><span style='text-align:right; float:right; font-weight:bold'>".number_format($Grand_TR_Total_Credit)."</span></td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px; font-weight:bold'>".number_format($Grand_Total_Closing_Debit)."</span><span style='text-align:right; float:right; font-weight:bold'>".number_format($Grand_Total_Closing)."</span></td>";
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
                <h2 align="center">Cappellos</h2>
            </tr>
            <tr class="filters">
                <h4 align="center">Trail Balance</h4>
            </tr>
            <tr class="filters hide">
                <h4 align="left" class="hide">Date: 06-09-2016 to 06-06-2016 </h4>
            </tr>
            <tr class="filters">
                <th>&nbsp;</th>
                <th style="text-align:center; width:250px">OPening Balance</th>
                <th style="text-align:center; width:250px">Transection</th>
                <th style="text-align:center; width:250px">Closing Balance</th>
            </tr>
            <tr class="filters">
                <td style="width:350px;">Title of A/C</td>
                <td><span style="text-align:left; float:left; font-weight:bold; padding-left:20px">Debit</span><span style="text-align:right; float:right; font-weight:bold;">Credit</span></td>
                <td><span style="text-align:left; float:left; font-weight:bold; padding-left:20px">Debit</span><span style="text-align:right; float:right; font-weight:bold;">Credit</span></td>
                <td><span style="text-align:left; float:left; font-weight:bold; padding-left:20px">Debit</span><span style="text-align:right; float:right; font-weight:bold;">Credit</span></td>
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