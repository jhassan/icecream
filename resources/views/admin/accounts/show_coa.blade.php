@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View COA
          </h1>
          <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/accounts/index_coa">Add COA</a></li>
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
                            <th>COA</th>
                            <th>COA Descriptions</th>
                            <th>COA Debit</th>
                            <th>COA Credit</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($arrayCOA as $coa)
                    	<tr>
                        <td>{{{ $coa->coa_code }}}</td>
                        <td>{{{ $coa->coa_account }}}</td>
                        <td>{{{ $coa->coa_debit }}}</td>
                        <td>{{{ $coa->coa_credit }}}</td>
								            				<td> <a href="{{ route('edit_coa.update', $coa->coa_id) }}"><img src="{{asset("dist/img/edit.gif")}}" ></a>
							<a href="{{ route('confirm-delete/shop', $coa->coa_id) }}" class="hide"><img src="{{asset("dist/img/delete.png")}}" ></a>
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