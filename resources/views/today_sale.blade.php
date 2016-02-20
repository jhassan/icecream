@extends('layout/default')

    <!-- Page Content -->
    @section('content')
    	<div class="container">
        <div class="table-responsive">
            <table class="table table-striped m-b-0">
              <thead>
                <tr>
                  <th>Product Price</th>
                  <th>Product Quantity</th>
                  <th>Product Name</th>
                  <th>Invoice #</th>
                  <th>Date</th>
                  <th>Employee</th>
                </tr>
              </thead>
              <tbody>
              
                	@foreach($detail_sale as $detail)
                <tr>
                  <td>{{ $detail->product_price }}</td>
                  <td>{{ $detail->product_qty }}</td>
                  <td>{{ $detail->product_name }}</td>
                  <td>{{ $detail->shop_name }}-{{ $detail->invoice_id }}</td>
                  <td>{{ date("d-M-Y",strtotime($detail->created_at)) }}</td>
                  <td>{{ $detail->first_name }}</td>
                </tr>
																@endforeach
              </tbody>
            </table>
            <table class="table table-striped m-b-0">
              <thead>
                <tr>
                  <td style="width:162px; font-weight:bold;">Total Sale : {{ $TotalSale }}</td>
                  <td style="font-weight:bold;">Total Quantity : {{ $TotalQty }}</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </thead>
           </table>
            {!! $detail_sale->render() !!}
          </div>
     </div>     
    @stop
         <script src="{{asset('../../plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script type="text/javascript">
    $(document).ready(function() {
        var isAuth = "<?php echo Auth::check(); ?>";
									if (isAuth != 1) 
									{
													window.location = "/";
									}
    });
</script>
