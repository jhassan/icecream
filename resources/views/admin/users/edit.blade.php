@extends('admin/layout/default')

{{-- Page content --}}
@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Edit User
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Users</a></li>
            <li class="active">Edit User</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">User</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            
             <div class="box box-primary">
             	<div class="has-error">
                        {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                        {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                        {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                        {!! $errors->first('login_name', '<span class="help-block">:message</span>') !!}
                        {!! $errors->first('gender', '<span class="help-block">:message</span>') !!}
                        {!! $errors->first('user_type', '<span class="help-block">:message</span>') !!}
                       
                    </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="" method="POST">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <div class="box-body">
                    <div class="form-group col-sm-4">
                      <label for="first_name">First Name *</label>
                      <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name" value="{{{ $users->first_name }}}">
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="last_name">Last Name *</label>
                      <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name" value="{{{ $users->last_name }}}">
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="login_name">Login Name *</label>
                      <input type="text" class="form-control" id="login_name" placeholder="Login Name" name="login_name" value="{{{ $users->login_name }}}">
                    </div>
                    <div class="form-group col-sm-4 hide">
                      <label for="email">Email *</label>
                      <input type="text" class="form-control" id="email" placeholder="Email" name="email" value="{{{ $users->email }}}">
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="Password">Password *</label>
                      <input type="password" class="form-control" id="password" placeholder="Password" name="password" >
                    </div>
                    <div class="form-group col-sm-4 hide">
                      <label for="confirm_password">Confirm Password *</label>
                      <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" name="confirm_password">
                    </div>
                    <div class="dropdown col-sm-4">
                    <label for="gender" >Gender</label>
   
                        <select class="form-control" title="Select Gender..." name="gender">
                            <option value="">Select</option>
                            <option value="1" <?php if($users->gender == 1) echo $selected = "selected"; else echo $selected = ""; ?>>MALE</option>
                            <option value="2" <?php if($users->gender == 2) echo $selected = "selected"; else echo $selected = ""; ?>>FEMALE</option>

                        </select>
                    </div>
                    <div class="dropdown col-sm-4">
                        <label for="gender" >User Type</label>
                            <select class="form-control" title="Select User Type..." name="user_type" id="get_user_type">
                                <option value="">Select User Type</option>
                                <option value="2" <?php if($users->user_type == 2) echo $selected = "selected"; else echo $selected = ""; ?>>Admin</option>
                                <option value="3" <?php if($users->user_type == 3) echo $selected = "selected"; else echo $selected = ""; ?>>Sub Admin</option>
                                <option value="1" <?php if($users->user_type == 1) echo $selected = "selected"; else echo $selected = ""; ?>>Client</option>

                            </select>
                    </div>
                    <div class="clear" style="clear:both !important;"></div>
                    <div class="form-group col-sm-4">
                      <label for="city">City</label>
                      <input type="text" class="form-control" id="city" placeholder="City" name="city" value="{{$users->city}}">
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="address">Address</label>
                      <input type="text" class="form-control" id="address" placeholder="Address" name="address" value="{{{$users->address}}}">
                    </div>
                    <div class="dropdown col-sm-4">
                      <label for="shop" >Shop</label>
     																		
                          <select class="form-control" title="Select Shop..." name="shop_id">
                              <option value="">Select</option>
                              @foreach ($shops as $shop)
                              <?php if($users->shop_id == $shop->shop_id) $selected = "selected"; else $selected = ""; ?>
                              <option value="{{{ $shop->shop_id}}}" <?php echo $selected; ?>>{{{ $shop->shop_name}}}</option>
                              @endforeach

                          </select>
                  </div>
                  <div class="clear"></div>
                  <div id="permission_block" class="">
                  <div class="form-group col-sm-3 pull-left" style=" margin-top: 20px;">
                      <input checked="checked" type="checkbox" id="checkAll"/> <label style="font-size: 14px;">Check All</label>
                    </div>
                  <div class="clear"></div>

                  @foreach($patentPermission as $parent)
                  <div class="form-group col-sm-12">
                    <label style="font-size: 14px;">{{ ucfirst($parent->name) }}</label>
                    <div class="clear"></div>
                    @foreach($childPermission as $child)
                      @if($child->parent_id == $parent->id)
                      <?php 
                      if(!empty($user_permission))
                      {
                        $array_permission = explode(',',$user_permission);
                        if (in_array($child->id, $array_permission))
                          $checked = "checked='checked'";
                        else
                          $checked = "";
                      }
                      else
                          $checked = "";
                        
                      ?>
                      <div class="col-sm-3" style="padding-left: 0px;">
                        <p style="padding-left: 0px;" class="text-left col-sm-9">{{ ucfirst($child->name) }}</p>
                        <input class="checkedAll" {{ $checked }} name="permission[{{$child->id}}]" type="checkbox" value="{{ $child->id }}" id="{{ $child->id }}">
                      </div>
                      @endif
                    @endforeach
                  </div>
                  <div class="clear"></div>
                  @endforeach
                  </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <input type="submit" class="btn btn-primary" value="Edit User">
                  </div>
                </form>
              </div> 

            <!--<div class="box-footer">
              Footer
            </div>--><!-- /.box-footer-->
          </div>
          <!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      @stop
      @section('footer_scripts')
  <script type="text/javascript">
  $(document).ready(function() {

    // Hide permission div
    if($("#get_user_type").val() == 1)
      $("#permission_block").addClass('hide');
    $("#get_user_type").change(function (){
      var value = $(this).val();
      if(value == 1)
        $("#permission_block").addClass('hide');
      else
        $("#permission_block").removeClass('hide');
    });

    $("#checkAll").change(function () {
        $("input:checkbox.checkedAll").prop('checked', $(this).prop("checked"));
    });
    $(".cb-element").change(function () {
        _tot = $(".cb-element").length              
        _tot_checked = $(".checkedAll:checked").length;
        
        if(_tot != _tot_checked){
          $("#checkAll").prop('checked',false);
        }
    });
  });
  </script>
@endsection