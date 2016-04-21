<?php
  $host = "localhost";
  $uname = "root";
  $pass = "";
  $return = "";
  $database = "icecream";
  $connection = mysqli_connect($host,$uname,$pass,$database);
  $YesterDayDate = date('Y-m-d',strtotime("-1 days"));
// Get today sale summery  
function sale_summery($connection,$YesterDayDate)
{
  $nToalClosing = 0;$TotalSale = 0; $discount_amount = 0; $net_sale = 0; $closing_balance = 0;
  $sql = "SELECT sales.created_at AS now_date 
          FROM sales
          INNER JOIN sales_details ON sales_details.sale_id = sales.sale_id
          WHERE sales.created_at = '".$YesterDayDate."' GROUP BY now_date";
  $result = mysqli_query($connection,$sql);
  $row = mysqli_fetch_array($result))
  $CurrentDate = date("Y-m-d",strtotime($row['now_date']));
  $TotalSale  = GetTotalSale($connection,$CurrentDate) - GetDiscount($connection, $CurrentDate);
  $discount_amount = GetDiscount($connection, $CurrentDate);
  $net_sale = $TotalSale - $discount_amount;
  $CurrentDate1 = date("d-m-Y",strtotime($row['now_date']));
  // Insert into master
  $sqlInsertMaster = "INSERT INTO 
          vouchermaster (vm_date, vm_type, vm_desc, vm_amount )
          VALUES ('".$CurrentDate."', 'CR', '".$CurrentDate1." Net Sale', '".$net_sale."')";
  $resultInsertMaster = mysqli_query($connection,$sqlInsertMaster);
  // Insert into detail
  $sqlInsertMaster1 = "INSERT INTO 
          voucherdetail (vd_vm_id, vd_coa_code, vd_desc, vd_debit, vd_credit )
          VALUES ('".$resultInsertMaster."', '0', '".$CurrentDate1." Net Sale', '".$net_sale."',0)";
  $resultInsertMaster1 = mysqli_query($connection,$sqlInsertMaster1);
  $sqlInsertMaster2 = "INSERT INTO 
          voucherdetail (vd_vm_id, vd_coa_code, vd_desc, vd_debit, vd_credit )
          VALUES ('".$resultInsertMaster."', '414002', '".$CurrentDate1." Net Sale', 0, '".$net_sale."')";
  $resultInsertMaster2 = mysqli_query($connection,$sqlInsertMaster2);        
  
}
// Get Discount
function GetDiscount($connection,$strDate)
{
  $sql = "SELECT SUM(discount_amount) AS DiscountAmount 
          FROM sales
          WHERE sales.created_at LIKE '%".$strDate."%'"; 
  $result = mysqli_query($connection,$sql);
  $row = mysqli_fetch_array($result); 
           $Discount = $row['DiscountAmount'];        
  return $Discount;
}

// Get Total Sale
function GetTotalSale($connection,$strDate)
{
  $sql = "SELECT SUM(sales_details.product_price) AS TotalPrice 
          FROM sales 
          INNER JOIN sales_details ON sales_details.sale_id = sales.sale_id
          INNER JOIN products ON products.id = sales_details.product_id
          WHERE sales.created_at LIKE '%".$strDate."%'"; 
  $result = mysqli_query($connection,$sql);
  $row = mysqli_fetch_array($result); 
           $TotalPrice = $row['TotalPrice'];        
  return $TotalPrice;
}
sale_summery($connection,$YesterDayDate);
mysqli_close($connection);
?>