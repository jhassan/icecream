<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\salesDetails;
use DB,Input,Redirect,paginate;
use Session;

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
    $user_id = Session::get('user_id');
    $user_type = Session::get('user_type');
    $TodayDate = date("Y-m-d");
    if($user_type == 1)
    {
    $shop_id = Session::get('shop_id');
    $sales['total_sale'] = DB::table('sales')
                        ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                        ->join('products', 'products.id', '=', 'sales_details.product_id')
                        ->join('users', 'users.id', '=', 'sales.user_id')
                        ->join('shops', 'shops.shop_id', '=', 'users.shop_id')
                        ->select('sales_details.*','product_name','first_name','invoice_id','shop_code')
                        ->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.user_id = '.(int)$user_id.' AND sales.return_id = 0')
                        ->orderBy('sales_details_id', 'desc')
                        ->paginate(10); //,DB::raw('SUM(sales_details.product_price) AS Total')
        $sales['sum_sale'] = DB::table('sales')
                        ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                        ->join('products', 'products.id', '=', 'sales_details.product_id')
                        ->select(DB::raw('SUM(sales_details.product_price) as TotalPrice, SUM(sales_details.product_qty) as TotalQty , SUM(sales.discount_amount) as DiscountAmount'))
                        ->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.user_id = '.(int)$user_id.' AND sales.return_id = 0')
                        //->groupBy('sales_details.product_id')
                        ->orderBy('sales_details_id', 'desc')
                        ->get();
/*$sales['discount_amount'] = DB::table('sales')
                        ->select(DB::raw('SUM(sales.discount_amount) as DiscountAmount'))
                        ->whereRaw('sales.created_at =  SUBDATE(CURDATE(),0) AND sales.user_id = '.(int)$user_id.'')
                        //->groupBy('sales_details.product_id')
                        //->orderBy('sales_details_id', 'desc')
                        ->get();*/                                                                      
                                                
        $sales['discount_amount'] = DB::table('sales')
                        //->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                        //->join('products', 'products.id', '=', 'sales_details.product_id')
                        ->select(DB::raw('SUM(sales.discount_amount) AS DiscountAmount'))
                        ->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.user_id = '.(int)$user_id.' AND sales.return_id = 0')
                        ->get();
        }
        else
        {
        if($shop_id == 0) $shop_id = 1; 
        $sales['total_sale'] = DB::table('sales')
                        ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                        ->join('products', 'products.id', '=', 'sales_details.product_id')
                        ->join('users', 'users.id', '=', 'sales.user_id')
                        ->select('sales_details.*','product_name','first_name')
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
        $sales['yesterday_sale'] = DB::table('sales')
                        ->select(DB::raw('SUM(sales.net_amount) as YesterdaySale'))
                        ->whereRaw('sales.created_at =  SUBDATE(CURDATE(),1)  AND sales.return_id = 0')
                        ->get();
        $sales['today_expense'] = DB::table('vouchermaster')
                        ->select(DB::raw('SUM(vm_amount) AS TodayExpense'))
                        ->whereRaw('vm_date =  "'.$TodayDate.'"')
                        ->get();
        $sales['yesterday_expense'] = DB::table('vouchermaster')
                        ->select(DB::raw('SUM(vm_amount) AS YesterdayExpense'))
                        ->whereRaw('vm_date =  SUBDATE(CURDATE(),1)')
                        ->get();                
        $sales['discount_amount'] = DB::table('sales')
                        //->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
                        //->join('products', 'products.id', '=', 'sales_details.product_id')
                        ->select(DB::raw('SUM(sales.discount_amount) AS DiscountAmount'))
                        ->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.shop_id = "'.$shop_id.'" AND sales.return_id = 0')
                        ->get();                                                                                                                                                        
        }
    return $sales;
    }
    
    // All Sale
    public function all_sale()
    {
        $user_id = Session::get('user_id');
        $user_type = Session::get('user_type');
        if($user_type == 1)
        {
        $sales['total_sale'] = DB::table('sales')
            ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
            ->join('products', 'products.id', '=', 'sales_details.product_id')
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->select('sales_details.*','product_name','first_name')
            ->where('sales.user_id', '=', $user_id)
            ->where('sales.return_id', '=', 0)
            // AND sales.return_id = 0
            ->orderBy('sales_details_id', 'desc')
            ->paginate(10);
        $sales['sum_sale'] = DB::table('sales')
            ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
            ->join('products', 'products.id', '=', 'sales_details.product_id')
            ->select(DB::raw('SUM(sales_details.product_price) as TotalPrice, SUM(sales_details.product_qty) as TotalQty'))
            ->where('sales.user_id', '=', $user_id)
            ->where('sales.return_id', '=', 0)
            ->orderBy('sales_details_id', 'desc')
            ->get();            
        }
        else
        {
        $sales['total_sale'] = DB::table('sales')
            ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
            ->join('products', 'products.id', '=', 'sales_details.product_id')
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->select('sales_details.*','product_name','first_name')
            ->orderBy('sales_details_id', 'desc')
            ->paginate(10);
        $sales['sum_sale'] = DB::table('sales')
            ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
            ->join('products', 'products.id', '=', 'sales_details.product_id')
            ->select(DB::raw('SUM(sales_details.product_price) as TotalPrice, SUM(sales_details.product_qty) as TotalQty'))
            ->orderBy('sales_details_id', 'desc')
            ->get();    
        }
        return $sales;
    }
    
    // Max id for invoice
    public function get_invoice_id()
    {
            $date = date('Y-m-d');
            $shop_id = Session::get('shop_id');
            $max_id = DB::table('sales')
                    ->where('created_at', '=' ,$date)
                    ->where('sales.shop_id', '=', $shop_id)
                    ->max('invoice_id');
            return $max_id;
    }
    
    // Get Shop Code
    public function get_shop_code()
    {
            $user_id = Session::get('user_id'); 
            $arrayShopCode = DB::table('users')
                    ->join('shops', 'shops.shop_id', '=', 'users.shop_id')
                    ->select('shop_code','shop_name')
                    ->where('users.id', '=' ,(int)$user_id)
                    ->get();
    //return $arrayShopCode[0]->shop_code;
                    return $arrayShopCode;
    }
    
    // Sale Summery
    public function get_sale_summery($start_date, $end_date)
    {
        // $arraySaleSummery = DB::table('sales')
        //  ->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
        //  ->join('products', 'products.id', '=', 'sales_details.product_id')
        //  ->select(DB::raw('sales_details.product_id AS product_id, products.product_price, SUM(sales_details.product_price) AS NetAmount,SUM(sales_details.product_qty) AS TotalQty, sales.*'))
        //  ->where('sales.return_id', '=', 0)
        //  ->groupBy('sales.created_at')
        //  // ->orderBy('sales.created_at', 'desc')
        //  ->paginate(30);
        //echo $start_date; die;
        $arraySaleSummery = DB::table('sale_summery')
                    ->select('sale_summery.*')
                    ->whereRaw('current_date1 BETWEEN "'.$start_date.'" AND "'.$end_date.'" ')
                    ->groupBy('sale_summery.current_date1','sale_summery.shop_id')
                    ->paginate(30);
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

}
