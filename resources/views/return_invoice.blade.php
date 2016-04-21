@extends('layout/default')

    <!-- Page Content -->
    @section('content')
    	<div class="container">
        <div class="table-responsive">
          @if($errors->has())
    @foreach ($errors->all() as $error)
        <div style='color:red; margin-left:13px !important;'>{{ $error }}</div>
    @endforeach
@endif
@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
            <form action="search_return_invoice" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="box-body col-sm-4">
                      <label for="shop_address">Invoice #</label>
                      <input type="text" class="form-control" id="invoice_id" placeholder="Enter Invoice #" name="invoice_id">
                    </div>
                  <div class="box-footer">
                    <button type="submit" style='margin-top:23px;' class="btn btn-primary">Search</button>
                  </div>
                </form>
          </div>
     </div>     
    @stop
