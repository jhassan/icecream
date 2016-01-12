@extends('/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Shops
          </h1>
          <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/shops/add">Add Shop</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr class="filters">
                            <th>ID</th>
                            <th>Shop Name</th>
                            <th>Shop Address</th>
                            <th>Shop Code</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($shops as $shop)
                    	<tr>
                            <td>{{{ $shop->shop_id }}}</td>
                    		<td>{{{ $shop->shop_name }}}</td>
            				<td>{{{ $shop->shop_address }}}</td>
            				<td>{{{ $shop->shop_code }}}</td>
            				<td>{{{ $shop->created_at }}}</td> 
            				<td> <a href="{{ route('shops.update', $shop->shop_id) }}"><img src="{{asset("dist/img/edit.gif")}}" ></a>
							<a href="{{ route('confirm-delete/shop', $shop->shop_id) }}"><img src="{{asset("dist/img/delete.png")}}" ></a>
                            </td>
            			</tr>
                    @endforeach
                        
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
     @stop 

     @section('footer_scripts')
     <script src="{{asset('../../plugins/datatables/jquery.dataTables.min.js')}}"></script>
      <script src="{{asset('../../plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
      
      <script>
      $(function () {
        //$("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
     @stop