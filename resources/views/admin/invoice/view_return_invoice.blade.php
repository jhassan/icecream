@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Return Invoices
          </h1>
          <ol class="breadcrumb hide">
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
                  <table id="example21" class="table table-bordered table-hover">
                    <thead>
                    <tr class="filters">
                        <th>Net Amount</th>
                        <th>Return Date</th>
                        <th>Shop Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($returns as $return_id)
                      <tr>
                        <td>{{ $return_id->net_amount }}</td>
                        <td>{{ $return_id->created_at }}</td>
                        <td>{{ $return_id->shop_name }}</td>
                      </tr>
                    @endforeach
                        
                    </tbody>
                  </table>
                  {!! $returns->render() !!}
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