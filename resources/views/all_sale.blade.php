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
                  <td>{{ date("d-M-Y",strtotime($detail->created_at)) }}</td>
                  <td>Jawad</td>
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
