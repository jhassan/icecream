<table class="table table-stripped table-responsive">
<tr>
<th>Account</th>
<th>Description</th>
<th>Debit</th>
<th>Credit</th>
<th>Balance</th>
</tr>
<?php
			$dSumDr = 0;
			$dSumCr = 0;
			$TotalBalance = 0;
			$GrandTotal = 0;
			$OPBalance = 0;
			foreach($SelectedVoucher as $rstRow)
			{
			$TotalBalance = ( $OPBalance + $rstRow->vd_credit ) - $rstRow->vd_debit;
			echo "<tr>";
			echo "	<td valign=top style='width:180px;'>" . $rstRow->coa_account . "  ". $rstRow->vd_coa_code .  "</td>";
			echo "	<td valign=top>" . nl2br($rstRow->vd_desc) .  "</td>";
			echo "	<td valign=top align=right>" . number_format($rstRow->vd_debit) .  "</td>";
			echo "	<td valign=top align=right>" . number_format($rstRow->vd_credit) .  "</td>";
			echo "	<td valign=top align=right>" . number_format($TotalBalance) .  "</td>";
			echo "</tr>";
			$dSumDr += $rstRow->vd_debit;
			$dSumCr += $rstRow->vd_credit;
			$GrandTotal += $TotalBalance;
			}
			echo "<tr>";
		echo "	<td valign=top colspan=2 align=right>Total</td>";
		echo "	<td valign=top align=right>" . number_format($dSumDr) .  "</td>";
		echo "	<td valign=top align=right>" . number_format($dSumCr) .  "</td>";
		echo "	<td valign=top align=right>" . number_format($GrandTotal) .  "</td>";
		echo "</tr>";

?>


<!--<tr>
<td>John</td>
<td>100</td>
<td>{!! print_r($SelectedVoucher) !!}</td>
</tr>-->
</table>