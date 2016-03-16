@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

<?php
function COAComboWithoutTable($arrAcc, $strName, $nSelected = "")
{
		$bGroupOpen = false;
		$nResult = DB::table('coa')
                ->orderBy('coa_code', 'asc')
                ->get();
		echo "<select id=$strName name=$strName class='form-control'>\r\n";
		echo "<optgroup label=''><option value=''>Select COA</option></optgroup>";
		foreach($nResult as $rstRow)
		{
			$strCode = $rstRow->coa_code;
			$strAcc = $rstRow->coa_account;
			
			if(substr($strCode, 3) == "000") // if this is control account
			{
				if($bGroupOpen) echo "</optgroup>";
			
				if(substr($strCode, 1) == "00000")
					echo "<optgroup label='--- $strAcc ---'>\r\n";
				else
					echo "<optgroup label='$strAcc'>\r\n";
				
				$bGroupOpen = true;
			}
			else
				
				if($strCode == $nSelected)	// for default bank acc
					echo "<option selected value='$strCode'>$strAcc ($strCode)\r\n";
				else
					echo "<option value='$strCode'>$strAcc ($strCode)\r\n";
		}
		
		if($bGroupOpen) echo "</optgroup>\r\n";
		echo "</select>\r\n";
}
								?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add COA
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ URL::to('/accounts/view_coa') }}">View COA</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">COA</h3>
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
                <form action="add_coa" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <div class="box-body col-sm-4">
                  <div class="dropdown">
                    <label for="gender">Debit Account</label>
                    <?php COAComboWithoutTable("", "vd_debit",""); ?>
			                </div>
                    </div>
                    <div class="box-body col-sm-4">
                      <label for="shop_address">COA Code</label>
                      <input type="text" class="form-control" id="coa_code" placeholder="COA Code" maxlength="6" name="coa_code">
                    </div>
                    <div class="box-body col-sm-4">
                      <label for="shop_address">COA Descriptions</label>
                      <input type="text" class="form-control" id="coa_account" placeholder="COA Code" name="coa_account">
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
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
      