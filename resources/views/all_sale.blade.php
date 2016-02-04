@foreach($sales as $sale)
{!! $sale->net_amount !!}<br/>
@foreach($sale->sales_details as $detail)
	{!! $detail->product_price !!}
@endforeach


@endforeach