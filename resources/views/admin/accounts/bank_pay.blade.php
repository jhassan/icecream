@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Bank Pay Vouchers
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Bank Pay Vouchers</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
             <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <form action="add_accounts" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="vm_type" value="BP" />
                  <div class="box-body col-sm-4">
                  <div class="dropdown">
                    <label for="gender">Debit Account</label>
                        <select class="form-control" title="Select Debit COA" name="vd_debit">
                         <option value="">Select Debit COA</option>
                        @foreach($arrayDebit as $coa)
                         <?php                        
                           $strCode = $coa->coa_code;
                           $strAcc = $coa->coa_account;
																											$parent_id = $coa->parent_id;
                            
                            if($parent_id == 0)	// for default bank acc
																													echo "<optgroup label='".$strAcc."'></optgroup>";
                            else
                             echo "<option class='p-l-15' value='".$strCode."'>&nbsp;&nbsp;&nbsp;&nbsp;".$strAcc."</option>\r\n";
                          ?>
		                      @endforeach   
                        </select>
			                </div>
                    </div>
                    <div class="box-body col-sm-4">
                  <div class="dropdown">
                    <label for="gender">Credit Account</label>
                        <select class="form-control" title="Select Credit COA" name="vd_credit">
                         <option value="">Select Credit COA</option>
                        @foreach($arrayCredit as $coa)
                         <?php                        
                           $strCode = $coa->coa_code;
                           $strAcc = $coa->coa_account;
																											$parent_id = $coa->parent_id;
                            
                            if($parent_id == 0)	// for default bank acc
																													echo "<optgroup label='".$strAcc."'></optgroup>";
                            else
                             echo "<option class='p-l-15' value='".$strCode."'>&nbsp;&nbsp;&nbsp;&nbsp;".$strAcc."</option>\r\n";
                          ?>
		                      @endforeach   
                        </select>
			                </div>
                    </div>
                    <div class="box-body col-sm-4">
                      <label for="shop_address">Amount</label>
                      <input type="text" class="form-control" id="vm_amount" placeholder="Amount" maxlength="8" name="vm_amount">
                    </div>
                    <div class="box-body col-sm-4">
                      <label for="shop_address">Date</label>
                      <input type="text" class="date-pick form-control" id="vm_date" placeholder="Date" name="vm_date">
                    </div>
                    <div class="box-body col-sm-4">
                      <label for="shop_address">Descriptions</label>
                      <textarea type="text" class="form-control" id="vm_desc" placeholder="Descriptions" name="vm_desc"></textarea>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer clear" style="clear:both !important;">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div> 

            <!--<div class="box-footer">
              Footer
            </div>--><!-- /.box-footer-->
          </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      @stop
      <style type="text/css">
      option.bold-text { font-weight:bold !important; text-shadow: 0px 0px 0px black !important; }
      </style>
      