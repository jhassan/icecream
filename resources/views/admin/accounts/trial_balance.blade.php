@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>Trial Balance</h1>
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

function get_opening_balance($coa_code, $start_date)
{
	// $arrayOpBalance = array();
	// $arrayOpBalance = DB::table('coa')
	// 				->select('coa_debit','coa_credit')
	// 				->whereRaw('coa_code = "'.$coa.'"')
	// 				->get();	
	// return $arrayOpBalance;
	$ClosingBalance = 0;
	if($coa_code == "511001")
	{
		// $arrayDetail = DB::table('vouchermaster')
		// 			->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
		// 			->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
		// 			->select(DB::raw('((`coa_credit`+`coa_debit`) + SUM(vd_debit)) - SUM(vd_credit) AS OpeningBalance'))
		// 			->whereRaw('vd_coa_code = "'.$coa_code.'" AND vm_date < "'.$start_date.'" AND vouchermaster.shop_id <> 0 ')
		// 			->get();
		$arrayDetail = DB::table('vouchermaster')
                        ->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
                        ->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
                        ->select(DB::raw('(SUM(IFNULL(coa_debit, 0) - IFNULL(coa_credit, 0)) + SUM(IFNULL(vd_debit, 0))) - SUM(IFNULL(vd_credit, 0)) AS OpeningBalance'))
                        ->whereRaw('vd_coa_code = "'.$coa_code.'" AND vm_date < "'.$start_date.'" AND vouchermaster.shop_id <> 0 ')
                        ->get();
	}
	else
	{
		// $arrayDetail = DB::table('vouchermaster')
		// 			->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
		// 			->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
		// 			->select(DB::raw('((`coa_credit`+`coa_debit`) + SUM(vd_debit)) - SUM(vd_credit) AS OpeningBalance'))
		// 			->whereRaw('vd_coa_code = "'.$coa_code.'" AND vm_date < "'.$start_date.'" AND vouchermaster.shop_id <> 0 AND vm_type <> "JV" ')
		// 			->get();
		$arrayDetail = DB::table('vouchermaster')
                        ->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
                        ->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
                        ->select(DB::raw('(SUM(IFNULL(coa_debit, 0) - IFNULL(coa_credit, 0)) + SUM(IFNULL(vd_debit, 0))) - SUM(IFNULL(vd_credit, 0)) AS OpeningBalance'))
                        ->whereRaw('vd_coa_code = "'.$coa_code.'" AND vm_date < "'.$start_date.'" AND vouchermaster.shop_id <> 0 AND vm_type <> "JV" ')
                        ->get();	
	}
	
	$ClosingBalance = $arrayDetail[0]->OpeningBalance;
	 if(empty($ClosingBalance))
	 {
	 	$arrayOpBalance = array();
		$arrayOpBalance = DB::table('coa')
					->select('coa_debit','coa_credit')
					->whereRaw('coa_code = "'.$coa_code.'"')
					->get();	

		if($arrayOpBalance[0]->coa_debit != 0)
			$ClosingBalance = $arrayOpBalance[0]->coa_debit; 
		elseif($arrayOpBalance[0]->coa_credit != 0)
			$ClosingBalance = $arrayOpBalance[0]->coa_credit;
	 }

	return $ClosingBalance;
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
					->whereRaw('vd_coa_code = '.$coa.' AND vm_date >= "'.$start_date.'" AND vm_date <= "'.$end_date.'" AND vouchermaster.shop_id <> 0 ')
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

function ShowTransactions($start_date, $end_date)
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
	$Grand_Total_Closing_Credit = 0;
	$sub_Total_Closing_Debit = 0;
	$sub_Total_Closing_Credit = 0;
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
		$Total_Closing_Credit = 0;
		$sub_Total_Closing_Debit = 0;
		$sub_Total_Closing_Credit = 0;
		
		
		foreach ($nResultDetail as $key => $value) {
			$ClosingBalance = 0;
			$OB_Debit = 0;
			$OB_Credit = 0;
			$OpBalance = 0;
				$OB_Balance = get_opening_balance($value->coa_code, $start_date);
				$is_Debit = "";
				if(!empty($OB_Balance))
				{
					if($value->coa_type == "D")
					{
						$is_Debit = "Dr"; 
						$OB_Debit = $OB_Balance; 
						$OpBalance = $OB_Balance;
					}
					elseif($value->coa_type == "C")
					{
						$is_Debit = "Cr";
						$OB_Credit = $OB_Balance;
						$OpBalance = $OB_Balance;
					}	
				}
			$allData = search_vouchers($value->coa_code, $start_date, $end_date, $OpBalance);
			$Total_TR_Debit = $allData['Debit'];
			$Total_TR_Credit = $allData['Credit'];
			$Total_Closing_Credit = 0;
			$Total_Closing_Debit = 0;
			//$Total_Closing = ($OpBalance + $Total_TR_Debit) - $Total_TR_Credit;
			if($is_Debit == "Dr")
				$Total_Closing_Debit = ($OpBalance) + $Total_TR_Debit - $Total_TR_Credit;
			else
				$Total_Closing_Credit = ($OpBalance) + $Total_TR_Credit - $Total_TR_Debit;
			echo "	<tr>";
			echo "		<td >" . AccountName($value->coa_code, $value->coa_account) . "</td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px'>".number_format($OB_Debit)."</span><span style='text-align:right; float:right;'>".number_format($OB_Credit)."</span></td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px'>".number_format($Total_TR_Debit)."</span><span style='text-align:right; float:right;'>".number_format($Total_TR_Credit)."</span></td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px'>".number_format(str_replace("-", "", $Total_Closing_Debit))."</span><span style='text-align:right; float:right;'>".number_format(str_replace("-", "", $Total_Closing_Credit))."</span></td>";
			echo "	</tr>";
			$Total_OB_Debit += $OB_Debit;
			$Total_OB_Credit += $OB_Credit;
			$sub_Total_Debit += $Total_TR_Debit;
			$sub_Total_Credit += $Total_TR_Credit;
			if($is_Debit == "Dr")
			{
				$sub_Total_Closing_Debit += $Total_Closing_Debit;
				$sub_Total_Closing_Credit = 0;
			}
			else
			{
				$Total_Closing_Credit == 0 ? 0 : $Total_Closing_Credit;
				$sub_Total_Closing_Debit = 0;
				$sub_Total_Closing_Credit += $Total_Closing_Credit;	
			}
			$Total_Closing_Debit += $Closing_Balance_Debit;
		}			
		// Sub total head
			echo "	<tr>";
			echo "		<td align='right' style='font-weight:bold;'>Sub Head Total:</td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px; font-weight:bold'>".number_format($Total_OB_Debit)."</span><span style='text-align:right; float:right; font-weight:bold'>".number_format($Total_OB_Credit)."</span></td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px; font-weight:bold'>".number_format($sub_Total_Debit)."</span><span style='text-align:right; float:right; font-weight:bold'>".number_format($sub_Total_Credit)."</span></td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px; font-weight:bold'>".number_format(str_replace("-", "", $sub_Total_Closing_Debit))."</span><span style='text-align:right; float:right; font-weight:bold'>".number_format(str_replace("-", "", $sub_Total_Closing_Credit))."</span></td>";
			echo "	</tr>";
			$Grand_Total_Debit += $Total_OB_Debit;
			$Grand_Total_Credit += $Total_OB_Credit;
			$Grand_TR_Total_Debit += $sub_Total_Debit;
			$Grand_TR_Total_Credit += $sub_Total_Credit;
			$Grand_Total_Closing_Credit += $sub_Total_Closing_Credit;
			$Grand_Total_Closing_Debit += $sub_Total_Closing_Debit;
	}
		// Grand total head
			echo "	<tr>";
			echo "		<td align='right' style='font-weight:bold;'>Grand Total:</td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px; font-weight:bold'>".number_format($Grand_Total_Debit)."</span><span style='text-align:right; float:right; font-weight:bold'>".number_format($Grand_Total_Credit)."</span></td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px; font-weight:bold'>".number_format($Grand_TR_Total_Debit)."</span><span style='text-align:right; float:right; font-weight:bold'>".number_format($Grand_TR_Total_Credit)."</span></td>";
			echo "		<td><span style='text-align:left; float:left; padding-left:20px; font-weight:bold'>".number_format($Grand_Total_Closing_Debit)."</span><span style='text-align:right; float:right; font-weight:bold'>".number_format($Grand_Total_Closing_Credit)."</span></td>";
			echo "	</tr>";
}
?>

<!-- Main content -->
<section class="content">
<div class="row">
<div class="col-xs-12">
  <div class="box">
    <div class="box-body">
    	<div class="box box-primary hide">
                <!-- /.box-header -->
                <!-- form start -->
                <form action="trial_balance" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="box-body col-sm-4">
                      <label for="shop_address">Start Date</label>
                      <input type="text" class="date-pick form-control" id="start_date" placeholder="Start Date" name="start_date">
                    </div>
                    <div class="box-body col-sm-4">
                      <label for="shop_address">End Date</label>
                      <input type="text" class="date-pick form-control" id="end_date" placeholder="End Date" name="end_date">
                    </div>
                  <!-- </div> --><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" style="margin-top:4px;" class="btn btn-primary">Search</button>
                  </div>
                </form>
              </div>
      <table id="example2" class="table table-bordered table-hover">
        <thead>
            <tr class="filters">
                <h2 align="center" style="font-family: cursive; font-size: 37px;">Cappellos</h2>
                <p clas="text-center" align="center" style="font-size:16px;">3rd Floor United Mall, Abdali Road Multan</p>
            </tr>
            <tr class="filters">
                <h4 align="center" style="font-weight: bold; text-decoration: underline;">Trail Balance</h4>
            </tr>
            <tr class="filters hide">
                <h4 align="left" style="font-size: 15px; text-align: center; font-weight: bold;">Date: {{$start_date}} to {{$end_date}} </h4>
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

        <?php ShowTransactions($start_date, $end_date);?>
            
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