<?php
$host = "localhost";
  $uname = "root";
  $pass = "";
  $return = "";
  $database = "icecream";
  $connection = mysqli_connect($host,$uname,$pass,$database);
// Get today sale summery  
function sale_summery($connection)
{
  $nToalClosing = 0;$TotalSale = 0; $discount_amount = 0; $net_sale = 0; $closing_balance = 0;
  $sql = "SELECT `sales`.`created_at` AS now_date 
          FROM sales
          INNER JOIN `sales_details` ON `sales_details`.`sale_id` = `sales`.`sale_id`
          GROUP BY now_date";
  $result = mysqli_query($connection,$sql);
  while($row = mysqli_fetch_array($result))
  {
      $CurrentDate = date("Y-m-d",strtotime($row['now_date']));
      // For 150 Price
      $Array150 = PriceTypeCount($connection,$CurrentDate,150);
      // For 180 Price
      $Array180 = PriceTypeCount($connection,$CurrentDate,180);
      // For 200 Price
      $Array200 = PriceTypeCount($connection,$CurrentDate,200);
      // For 100 Price
      $Array100 = PriceTypeCount($connection,$CurrentDate,100);
      // For 20 Price
      $Array20 = PriceTypeCount($connection,$CurrentDate,20);
      // For 220 Price
      $Array220 = PriceTypeCount($connection,$CurrentDate,220);
      // Water 40
      $Array40 = PriceTypeCount($connection,$CurrentDate,40);
      // Water 70
      $Array70 = PriceTypeCount($connection,$CurrentDate,70);
      $TotalSale  = GetTotalSale($connection,$CurrentDate) - GetDiscount($connection, $CurrentDate);
      $discount_amount = GetDiscount($connection, $CurrentDate);
      $net_sale = $TotalSale - $discount_amount;
      // Insert data into sale_summery table
      $total_expense = GetExpense($connection,$CurrentDate);
      $closing_balance = ($closing_balance + $net_sale) - $total_expense;
      $sqlInsert = "INSERT INTO 
              sale_summery (`current_date`, ice_20, ice_100, ice_150, ice_180, ice_200, ice_220, wt_40, wt_70, total_sale, discount_amount, net_sale, total_expense, closing_balance )
              VALUES ('".$CurrentDate."', '".$Array20."', '".$Array100."', '".$Array150."', '".$Array180."', '".$Array200."', '".$Array220."', '".$Array40."', '".$Array70."', '".$TotalSale."', '".$discount_amount."', '".$net_sale."', '".$total_expense."', '".$closing_balance."' )";
      $resultInsert = mysqli_query($connection,$sqlInsert);        
  }
}
// Get price Type Count
function PriceTypeCount($connection, $strDate = "", $nPrice = "")
{
  $sql = ""; $PriceType = 0;
  if(!empty($strDate) && !empty($nPrice))
  {
    $sql = "SELECT SUM(`product_qty`) AS PriceType 
            FROM sales_details
            INNER JOIN products ON products.`id` = sales_details.product_id
            WHERE sales_details.created_at LIKE '%".$strDate."%' AND products.product_price = '".$nPrice."'";
  }
  elseif(!empty($nPrice))
  {
    $sql = "SELECT SUM(`product_qty`) AS PriceType 
          FROM sales_details
          INNER JOIN products ON products.`id` = sales_details.product_id
          WHERE products.product_price = '".$nPrice."'";          
  }
    $result = mysqli_query($connection,$sql);
    $row = mysqli_fetch_array($result);
    $PriceType = (int)$row['PriceType'];
    return $PriceType;
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

// Get Expense
function GetExpense($connection,$strDate)
{
  $TotalExpense = 0;
  $sql = "SELECT SUM(`vd_debit`) AS TotalExpense 
          FROM vouchermaster
          INNER JOIN `voucherdetail` ON `voucherdetail`.`vd_vm_id` = `vouchermaster`.`vm_id`
          WHERE vm_date LIKE '%".$strDate."%' AND `vd_coa_code` <> 0"; 
  $result = mysqli_query($connection,$sql);
  $row = mysqli_fetch_array($result); 
           $TotalExpense = $row['TotalExpense'];        
  return $TotalExpense;
}

// Get Total Sale
function GetTotalSale($connection,$strDate)
{
  $sql = "SELECT SUM(sales_details.product_price) AS TotalPrice 
          FROM sales 
          INNER JOIN sales_details ON sales_details.sale_id = sales.sale_id
          INNER JOIN products ON products.`id` = sales_details.product_id
          WHERE sales.created_at LIKE '%".$strDate."%'"; 
  $result = mysqli_query($connection,$sql);
  $row = mysqli_fetch_array($result); 
           $TotalPrice = $row['TotalPrice'];        
  return $TotalPrice;
}
sale_summery($connection);

?>