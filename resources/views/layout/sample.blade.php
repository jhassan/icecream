@include('layout/header')


@include('layout/sidebar')

<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add User
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Users</a></li>
            <li class="active">Add User</li>
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
            
             <div class="box box-primarry">
             	<div class="has-error">
                        {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                        {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                        {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                       
                    </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="" method="POST">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <div class="box-body">
                    <div class="form-group">
                      <label for="first_name">First Name *</label>
                      <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name" value="{{{ Input::old('first_name') }}}">
                    </div>
                    <div class="form-group">
                      <label for="last_name">Last Name *</label>
                      <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name" value="{{{ Input::old('last_name') }}}">
                    </div>
                    <div class="form-group">
                      <label for="login_name">Login Name *</label>
                      <input type="text" class="form-control" id="login_name" placeholder="Login Name" name="login_name" value="{{{ Input::old('login_name') }}}">
                    </div>
                    <div class="form-group">
                      <label for="email">Email *</label>
                      <input type="text" class="form-control" id="email" placeholder="Email" name="email" value="{{{ Input::old('email') }}}">
                    </div>
                    <div class="form-group">
                      <label for="Password">Password *</label>
                      <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                    </div>
                    <div class="form-group">
                      <label for="confirm_password">Confirm Password *</label>
                      <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" name="confirm_password">
                    </div>
                    <div class="dropdown">
                                        <label for="gender" >Gender</label>
                       
                                            <select class="form-control" title="Select Gender..." name="gender">
                                                <option value="">Select</option>
                                                <option value="1" @if(Input::old('gender') === 'male') selected="selected" @endif >MALE</option>
                                                <option value="2" @if(Input::old('gender') === 'female') selected="selected" @endif >FEMALE</option>

                                            </select>
                                    </div>
                    <div class="form-group">
                      <label for="city">City</label>
                      <input type="text" class="form-control" id="city" placeholder="City" name="city">
                    </div>
                    <div class="form-group">
                      <label for="address">Address</label>
                      <input type="text" class="form-control" id="address" placeholder="Address" name="address">
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <input type="submit" class="btn btn-primary" value="Submit">
                  </div>
                </form>
              </div> 

            <!--<div class="box-footer">
              Footer
            </div>--><!-- /.box-footer-->
          </div>
          <!-- /.box -->

        </section><!-- /.content -->


      </div>
      @include('layout/footer')
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

      @include('layout/jquery')

      </body>
  </html> 