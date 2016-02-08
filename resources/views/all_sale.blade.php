@extends('layout/default')

    <!-- Page Content -->
    @section('content')
    	<div class="container">
        <div class="table-responsive">
            <table class="table table-striped">
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
              
                	@foreach($sales as $detail)
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
            {!! $sales->render() !!}
          </div>
     </div>     
    @stop
