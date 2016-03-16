SELECT 
`sales_details`.`product_id`,  
products.`product_price`,
SUM(sales_details.product_price) AS NetAmount,
  SUM(sales_details.`product_qty`) AS TotalQty,
  sales.*
    
FROM
  `sales` 
  INNER JOIN `sales_details` 
    ON `sales`.`sale_id` = `sales_details`.`sale_id` 
  INNER JOIN `products` 
    ON `products`.`id` = `sales_details`.`product_id` 
    GROUP BY sales.created_at
-- where sales.created_at = "2016-03-01"


SELECT 
`sales_details`.`product_id`
FROM
  `sales_details` 
  -- INNER JOIN `products` ON `products`.`id` = `sales_details`.`product_id` 
    -- group by sales.created_at
 WHERE sales_details.created_at LIKE '%2016-03-05'
 
 
 SELECT 
`sales`.`net_amount`
FROM
  `sales` 
  -- INNER JOIN `products` ON `products`.`id` = `sales_details`.`product_id` 
    -- group by sales.created_at
 WHERE sales.created_at = '2016-03-04'