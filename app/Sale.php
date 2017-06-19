<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\salesDetails;
use DB,Input,Redirect,paginate;
use Session;
use Auth;
class Sale extends Model {

    protected $table = 'sales';
    
    public function index()
    {
        $member_detail = self::with('sales_details')->get();
        return $member_detail;
    }

    public function sales_details()
    {
        return $this->hasMany('App\salesDetails', 'sale_id', 'id')->orderBy('sales_details_id', 'desc')->get();
    }
                
// Today Sale
public function today_sale($shop_id = "")
{
    //$user_id = Session::get('user_id');
    $user_id = Auth::user()->id;
    //$user_type = Session::get('user_type');
    $user_type = Auth::user()->user_type;
    $TodayDate = date("Y-m-d");
    $date_value = $this->check_date_diff();
    //var_dump($user_type);die;
    //$last_date = date("Y-m-d", strtotime($TodayDate.'-1 day'));
    if($user_type == 2)
    {
        //print_r($shop_id); die;
        if($shop_id == 0)
        {
            if($date_value == 1):
                $last_date = date("Y-m-d", strtotime($TodayDate.'-1 day'));
                $sales['total_sale'] = DB::table('sales')
                            ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                            ->join('products', 'products.id', '=', 'sales_details.product_id')
                            ->join('users', 'users.id', '=', 'sales.user_id')
                            ->join('shops', 'shops.shop_id', '=', 'users.shop_id')
                            ->select('sales_details.*','product_name','first_name','invoice_id','shop_code')
                            //->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.return_id = 0')
                            ->whereRaw('sales.created_at BETWEEN "'.$last_date.' 00:00:00" AND "'.$TodayDate.' 06:00:00" AND sales.return_id = 0')
                            ->orderBy('sales_details_id', 'desc')
                            ->paginate(10); 
                $sales['sum_sale'] = DB::table('sales')
                                ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                                ->join('products', 'products.id', '=', 'sales_details.product_id')
                                ->select(DB::raw('SUM(sales_details.product_price) as TotalPrice, SUM(sales_details.product_qty) as TotalQty , SUM(sales.discount_amount) as DiscountAmount'))
                                //->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.return_id = 0')
                                ->whereRaw('sales.created_at BETWEEN "'.$last_date.' 00:00:00" AND "'.$TodayDate.' 06:00:00" AND sales.return_id = 0')
                                ->orderBy('sales_details_id', 'desc')
                                ->get();
                $sales['discount_amount'] = DB::table('sales')
                            ->select(DB::raw('SUM(sales.discount_amount) AS DiscountAmount'))
                            //->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.return_id = 0')
                            ->whereRaw('sales.created_at BETWEEN "'.$last_date.' 00:00:00" AND "'.$TodayDate.' 06:00:00" AND sales.return_id = 0')
                            ->get();
            else:

                $sales['total_sale'] = DB::table('sales')
                            ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                            ->join('products', 'products.id', '=', 'sales_details.product_id')
                            ->join('users', 'users.id', '=', 'sales.user_id')
                            ->join('shops', 'shops.shop_id', '=', 'users.shop_id')
                            ->select('sales_details.*','product_name','first_name','invoice_id','shop_code')
                            ->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.return_id = 0')
                            //->whereRaw('sales.created_at BETWEEN "'.$last_date.' 00:00:00" AND "'.$TodayDate.' 06:00:00" AND sales.return_id = 0')
                            ->orderBy('sales_details_id', 'desc')
                            ->paginate(10); 
                $sales['sum_sale'] = DB::table('sales')
                                ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                                ->join('products', 'products.id', '=', 'sales_details.product_id')
                                ->select(DB::raw('SUM(sales_details.product_price) as TotalPrice, SUM(sales_details.product_qty) as TotalQty , SUM(sales.discount_amount) as DiscountAmount'))
                                ->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.return_id = 0')
                                //->whereRaw('sales.created_at BETWEEN "'.$last_date.' 00:00:00" AND "'.$TodayDate.' 06:00:00" AND sales.return_id = 0')
                                ->orderBy('sales_details_id', 'desc')
                                ->get();
                $sales['discount_amount'] = DB::table('sales')
                            ->select(DB::raw('SUM(sales.discount_amount) AS DiscountAmount'))
                            ->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.return_id = 0')
                            //->whereRaw('sales.created_at BETWEEN "'.$last_date.' 00:00:00" AND "'.$TodayDate.' 06:00:00" AND sales.return_id = 0')
                            ->get();
            
            endif;                
        }
        else
        {
            if($date_value == 1):
                $last_date = date("Y-m-d", strtotime($TodayDate.'-1 day'));
                $sales['total_sale'] = DB::table('sales')
                            ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                            ->join('products', 'products.id', '=', 'sales_details.product_id')
                            ->join('users', 'users.id', '=', 'sales.user_id')
                            ->join('shops', 'shops.shop_id', '=', 'users.shop_id')
                            ->select('sales_details.*','product_name','first_name','invoice_id','shop_code')
                            //->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.shop_id = "'.$shop_id.'" AND sales.return_id = 0')
                            ->whereRaw('sales.created_at BETWEEN "'.$last_date.' 00:00:00" AND "'.$TodayDate.' 06:00:00" AND sales.return_id = 0 AND sales.shop_id = "'.$shop_id.'"')
                            ->orderBy('sales_details_id', 'desc')
                            ->paginate(10); 
                $sales['sum_sale'] = DB::table('sales')
                                ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                                ->join('products', 'products.id', '=', 'sales_details.product_id')
                                ->select(DB::raw('SUM(sales_details.product_price) as TotalPrice, SUM(sales_details.product_qty) as TotalQty , SUM(sales.discount_amount) as DiscountAmount'))
                                //->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.shop_id = "'.$shop_id.'" AND sales.return_id = 0')
                                ->whereRaw('sales.created_at BETWEEN "'.$last_date.' 00:00:00" AND "'.$TodayDate.' 06:00:00" AND sales.return_id = 0 AND sales.shop_id = "'.$shop_id.'"')
                                ->orderBy('sales_details_id', 'desc')
                                ->get();
                $sales['discount_amount'] = DB::table('sales')
                            ->select(DB::raw('SUM(sales.discount_amount) AS DiscountAmount'))
                            //->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.shop_id = "'.$shop_id.'" AND sales.return_id = 0')
                            ->whereRaw('sales.created_at BETWEEN "'.$last_date.' 00:00:00" AND "'.$TodayDate.' 06:00:00" AND sales.return_id = 0 AND sales.shop_id = "'.$shop_id.'"')
                            ->get();
                else:
                    $last_date = date("Y-m-d", strtotime($TodayDate.'-1 day'));
                $sales['total_sale'] = DB::table('sales')
                            ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                            ->join('products', 'products.id', '=', 'sales_details.product_id')
                            ->join('users', 'users.id', '=', 'sales.user_id')
                            ->join('shops', 'shops.shop_id', '=', 'users.shop_id')
                            ->select('sales_details.*','product_name','first_name','invoice_id','shop_code')
                            ->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.shop_id = "'.$shop_id.'" AND sales.return_id = 0')
                            ->orderBy('sales_details_id', 'desc')
                            ->paginate(10); 
                $sales['sum_sale'] = DB::table('sales')
                                ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                                ->join('products', 'products.id', '=', 'sales_details.product_id')
                                ->select(DB::raw('SUM(sales_details.product_price) as TotalPrice, SUM(sales_details.product_qty) as TotalQty , SUM(sales.discount_amount) as DiscountAmount'))
                                ->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.shop_id = "'.$shop_id.'" AND sales.return_id = 0')
                                ->orderBy('sales_details_id', 'desc')
                                ->get();
                $sales['discount_amount'] = DB::table('sales')
                            ->select(DB::raw('SUM(sales.discount_amount) AS DiscountAmount'))
                            ->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.shop_id = "'.$shop_id.'" AND sales.return_id = 0')
                            ->get();
                endif;                            
        }
        
        }
        else if($user_type == 1 || $user_type == 3)
        {
            if($shop_id == 0)
                $shop_id = Auth::user()->shop_id;
            //echo $session_shop_id; die;
        $sales['total_sale'] = DB::table('sales')
                        ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                        ->join('products', 'products.id', '=', 'sales_details.product_id')
                        ->join('users', 'users.id', '=', 'sales.user_id')
                        ->join('shops', 'shops.shop_id', '=', 'users.shop_id')
                        ->select('sales_details.*','product_name','first_name','shop_code')
                        ->whereRaw('sales.created_at = "'.$TodayDate.'" AND sales.shop_id = "'.$shop_id.'" AND sales.return_id = 0')
                        //->groupBy('sales_details.product_id')
                        ->orderBy('sales_details_id', 'desc')
                        ->paginate(10); 
        $sales['sum_sale'] = DB::table('sales')
                        ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                        ->join('products', 'products.id', '=', 'sales_details.product_id')
                        ->select(DB::raw('SUM(sales_details.product_price) as TotalPrice, SUM(sales_details.product_qty) as TotalQty'))
                        ->whereRaw(' sales.created_at =  "'.$TodayDate.'" AND sales.shop_id = "'.$shop_id.'" AND sales.return_id = 0 ')
                        ->orderBy('sales_details_id', 'desc')
                        ->get();
        $sales['discount_amount'] = DB::table('sales')
                        ->select(DB::raw('SUM(sales.discount_amount) AS DiscountAmount'))
                        ->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.shop_id = "'.$shop_id.'" AND sales.return_id = 0')
                        ->get();                                                                                                                                                        
        }
    return $sales;
    }
    
    // All Sale
    public function all_sale()
    {
        $user_id = Auth::user()->id;
        $user_type = Auth::user()->user_type;
        $shop_id = Auth::user()->shop_id;
        if($user_type == 2)
        {
            $sales['total_sale'] = DB::table('sales')
                ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                ->join('products', 'products.id', '=', 'sales_details.product_id')
                ->join('users', 'users.id', '=', 'sales.user_id')
                ->select('sales_details.*','product_name','first_name')
                //->where('sales.user_id', '=', $user_id)
                ->where('sales.return_id', '=', 0)
                ->orderBy('sales_details_id', 'desc')
                ->paginate(10);
            $sales['sum_sale'] = DB::table('sales')
                ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                ->join('products', 'products.id', '=', 'sales_details.product_id')
                ->select(DB::raw('SUM(sales_details.product_price) as TotalPrice, SUM(sales_details.product_qty) as TotalQty'))
                //->where('sales.user_id', '=', $user_id)
                ->where('sales.return_id', '=', 0)
                ->orderBy('sales_details_id', 'desc')
                ->get(); 
            $sales['discount_amount'] = DB::table('sales')
                ->select(DB::raw('SUM(sales.discount_amount) AS DiscountAmount'))
                ->whereRaw('sales.return_id = 0')
                ->get();               
        }
        else if($user_type == 1 || $user_type == 3)
        {
            $shop_id = Auth::user()->shop_id;
            $sales['total_sale'] = DB::table('sales')
                ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                ->join('products', 'products.id', '=', 'sales_details.product_id')
                ->join('users', 'users.id', '=', 'sales.user_id')
                ->select('sales_details.*','product_name','first_name')
                ->where('sales.return_id', '=', 0)
                ->where('sales.shop_id', '=', $shop_id)
                ->orderBy('sales_details_id', 'desc')
                ->paginate(10);
            $sales['sum_sale'] = DB::table('sales')
                ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                ->join('products', 'products.id', '=', 'sales_details.product_id')
                ->select(DB::raw('SUM(sales_details.product_price) as TotalPrice, SUM(sales_details.product_qty) as TotalQty'))
                ->where('sales.return_id', '=', 0)
                ->where('sales.shop_id', '=', $shop_id)
                ->orderBy('sales_details_id', 'desc')
                ->get();
            $sales['discount_amount'] = DB::table('sales')
                ->select(DB::raw('SUM(sales.discount_amount) AS DiscountAmount'))
                ->whereRaw('sales.return_id = 0 AND sales.shop_id = "'.$shop_id.'"')
                ->get();     
        }
            return $sales;
    }
    
    // Max id for invoice
    public function get_invoice_id()
    {
        // $date = date('Y-m-d');
        // $shop_id = Session::get('shop_id');
        // $max_id = DB::table('sales')
        //         ->where('created_at', '=' ,$date)
        //         ->where('sales.shop_id', '=', $shop_id)
        //         ->max('invoice_id');
        // return $max_id;
        $date_value = $this->check_date_diff();
        if($date_value == 1)
            $date = date("Y-m-d", strtotime(date("Y-m-d").'-1 day'));
        else
            $date = date('Y-m-d');
       
        $shop_id = Session::get('shop_id');
        //$shop_id = 1;
        $max_id = DB::table('sales')
                ->where('created_at', '=' ,$date)
                ->where('sales.shop_id', '=', $shop_id)
                ->max('invoice_id');
        return $max_id;
    }
    
    // Get Shop Code
    public function get_shop_code()
    {
        $user_id = Auth::user()->id; 
        $arrayShopCode = DB::table('users')
                ->join('shops', 'shops.shop_id', '=', 'users.shop_id')
                ->select('shop_code','shop_name')
                ->where('users.id', '=' ,(int)$user_id)
                ->get();
        return $arrayShopCode;
    }
    
    // Sale Summery
    public function get_sale_summery($start_date, $end_date)
    {
        $shop_id = Auth::user()->shop_id;
        $user_type = Auth::user()->user_type;
        if($user_type == 2)
        {
            $arraySaleSummery = DB::table('sale_summery')
                    ->select('sale_summery.*')
                    ->whereRaw('current_date1 BETWEEN "'.$start_date.'" AND "'.$end_date.'" ')
                    ->groupBy('sale_summery.current_date1','sale_summery.shop_id')
                    ->orderBy('current_date1', 'desc')
                    ->paginate(20);    
        }
        else{
            $arraySaleSummery = DB::table('sale_summery')
                    ->select('sale_summery.*')
                    ->whereRaw('current_date1 BETWEEN "'.$start_date.'" AND "'.$end_date.'" AND shop_id = "'.$shop_id.'" ')
                    ->groupBy('sale_summery.current_date1','sale_summery.shop_id')
                    ->orderBy('current_date1', 'desc')
                    ->paginate(20);
        }
        
        return $arraySaleSummery;
    }

    public function search_ledeger123($start_date, $end_date)
    {
        $arraySaleSummery = DB::table('sales')
            
            //->select('sales_details.product_id AS product_id','products.product_price','SUM(sales_details.product_price) AS NetAmount','SUM(sales_details.product_qty) AS TotalQty','sales.*')
            //->where('created_at', '>=', "$start_date")
            //->where('created_at', '<=', "$end_date")
            ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
            ->select('sales.*')
            //->join('products', 'products.id', '=', 'sales_details.product_id')
            //->select(DB::raw('sales_details.product_id AS product_id, products.product_price, SUM(sales_details.product_price) AS NetAmount,SUM(sales_details.product_qty) AS TotalQty, sales.*'))
            
            ->whereRaw('sales.created_at >= "'.$start_date.'" AND sales.created_at <= "'.$end_date.'" ')
            
            ->groupBy('sales.created_at')
            // ->orderBy('sales.created_at', 'desc')
            ->paginate(30);
            //->get();
            //print_r($arraySaleSummery); die;
        return $arraySaleSummery;
    }

    public function search_ledeger($start_date, $end_date, $shop_id)
    {
        $arraySaleSummery = DB::table('sale_summery')
            ->select('sale_summery.*')
            ->whereRaw('current_date1 BETWEEN "'.$start_date.'" AND "'.$end_date.'" AND shop_id = '.(int)$shop_id.'')
            ->paginate(30);
        return $arraySaleSummery;
    }

    // Oppening Balance
    public function get_opening_balance($coa)
    {
            $arrayOpBalance = array();
            $arrayOpBalance = DB::table('coa')
                            ->select('coa_debit','coa_credit')
                            ->whereRaw('coa_code = "'.$coa.'"')
                            ->get();    
    return $arrayOpBalance;
    }        

    // Today Flavour Sale
    public function TodayFlavourSale($shop_id = "", $start_date = "")
   {
        //echo $start_date."-----".$shop_id; die;
        $user_type = Auth::user()->user_type;
        if($user_type == 1 || $user_type == 3)
        {
           $shop_id = Auth::user()->shop_id;
           if(empty($start_date))
           $start_date = date("Y-m-d");
           $start_date =  date("Y-m-d", strtotime($start_date));
           $sales['all_flavour'] = DB::table('sales')
                ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                ->join('products', 'products.id', '=', 'sales_details.product_id')
                ->select(DB::raw('SUM(`product_qty`) AS TotalQty, product_name, sales.`created_at`'))
                ->whereRaw('sales.`created_at` = "'.$start_date.'" AND sales.return_id = 0 AND sales.shop_id = "'.(int)$shop_id.'" ')
                ->orderBy('TotalQty', 'desc')
                ->groupBy('product_id')
                ->get();
            $sales['all_flavour_sum'] = DB::table('sales')
                ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                ->join('shops', 'shops.shop_id', '=', 'sales.shop_id')
                ->join('products', 'products.id', '=', 'sales_details.product_id')
                ->select(DB::raw('SUM(`product_qty`) AS TotalQty, shop_name, sales.`created_at` AS TodayDate'))
                ->whereRaw('sales.`created_at` = "'.$start_date.'" AND sales.return_id = 0 AND sales.shop_id = "'.(int)$shop_id.'" ')
                ->get();
        }
        else
        {
            if(empty($shop_id))
            {
                if(empty($start_date))
               $start_date = date("Y-m-d");
               $start_date =  date("Y-m-d", strtotime($start_date));
               $sales['all_flavour'] = DB::table('sales')
                    ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                    ->join('products', 'products.id', '=', 'sales_details.product_id')
                    ->select(DB::raw('SUM(`product_qty`) AS TotalQty, product_name, sales.`created_at`'))
                    ->whereRaw('sales.`created_at` = "'.$start_date.'" AND sales.return_id = 0 ')
                    ->orderBy('TotalQty', 'desc')
                    ->groupBy('product_id')
                    ->get();
                $sales['all_flavour_sum'] = DB::table('sales')
                    ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                    ->join('shops', 'shops.shop_id', '=', 'sales.shop_id')
                    ->join('products', 'products.id', '=', 'sales_details.product_id')
                    ->select(DB::raw('SUM(`product_qty`) AS TotalQty, shop_name, sales.`created_at` AS TodayDate'))
                    ->whereRaw('sales.`created_at` = "'.$start_date.'" AND sales.return_id = 0 ')
                    ->get();
            }
            else
            {
               if(empty($start_date))
               $start_date = date("Y-m-d");
               $start_date =  date("Y-m-d", strtotime($start_date));
               $sales['all_flavour'] = DB::table('sales')
                    ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                    ->join('products', 'products.id', '=', 'sales_details.product_id')
                    ->select(DB::raw('SUM(`product_qty`) AS TotalQty, product_name, sales.`created_at`'))
                    ->whereRaw('sales.`created_at` = "'.$start_date.'" AND sales.return_id = 0 AND sales.shop_id = "'.(int)$shop_id.'" ')
                    ->orderBy('TotalQty', 'desc')
                    ->groupBy('product_id')
                    ->get();
                $sales['all_flavour_sum'] = DB::table('sales')
                    ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                    ->join('shops', 'shops.shop_id', '=', 'sales.shop_id')
                    ->join('products', 'products.id', '=', 'sales_details.product_id')
                    ->select(DB::raw('SUM(`product_qty`) AS TotalQty, shop_name, sales.`created_at` AS TodayDate'))
                    ->whereRaw('sales.`created_at` = "'.$start_date.'" AND sales.return_id = 0 AND sales.shop_id = "'.(int)$shop_id.'" ')
                    ->get();
            }
           
        }
        

        return $sales;    
   }    

   // Check date 
   public function check_date_diff()
   {
    $date_time = date("Y-m-d H:i:s");
    $date = date("Y-m-d");
    //$next_day = date("Y-m-d", strtotime($date.'+1 day'));
    //$sql = DB::select("SELECT '2017-05-20 04:59:00' BETWEEN '2017-05-19 11:55:00' AND '2017-05-20 06:00:00' AS diffdate");
    $query = "SELECT '".$date_time."' BETWEEN '".$date." 00:00:00' AND '".$date." 06:00:00' AS diffdate";
    //echo $query; die;
    $sql = DB::select($query);
    return $sql[0]->diffdate;
   }        

}
