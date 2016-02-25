<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cappellos</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('../../bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('../../dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('../../dist/css/skins/_all-skins.min.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('../../plugins/iCheck/flat/blue.css')}}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{asset('../../plugins/morris/morris.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{asset('../../plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{asset('../../plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('../../plugins/datepicker/bootstrap-datetimepicker.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('../../plugins/daterangepicker/daterangepicker-bs3.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="../../admin/users" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>LT</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Cappellos</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle hide" data-toggle="dropdown">
                  <i class="fa fa-envelope-o hide"></i>
                  <span class="label label-success hide">4</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 4 messages</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li><!-- start message -->
                        <a href="#">
                          <div class="pull-left">
                            <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                          </div>
                          <h4>
                            Support Team
                            <small><i class="fa fa-clock-o hide"></i> 5 mins</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li><!-- end message -->
                    </ul>
                  </li>
                  <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
              </li>
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle hide" data-toggle="dropdown">
                  <i class="fa fa-bell-o hide"></i>
                  <span class="label label-warning hide">10</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 10 notifications</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
              <!-- Tasks: style can be found in dropdown.less -->
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o hide"></i>
                  <span class="label label-danger hide">9</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header hide">You have 9 tasks</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li><!-- Task item -->
                        <a href="#">
                          <h3>
                            Design some buttons
                            <small class="pull-right hide">20%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">20% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li><!-- end task item -->
                    </ul>
                  </li>
                  <li class="footer">
                    <a href="#">View all tasks</a>
                  </li>
                </ul>
              </li>
              <li>
              <div class="pull-right" style="margin:10px 20px 0px 0px !important;">
                      <a href="{{ URL::to('auth/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                    </div>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu hide">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                  <span class="hidden-xs hide">Alexander Pierce</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    <p>
                      Alexander Pierce - Web Developer
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                    <div class="row">
                      <div class="col-xs-4 text-center">
                        <a href="#">Followers</a>
                      </div>
                      <div class="col-xs-4 text-center">
                        <a href="#">Sales</a>
                      </div>
                      <div class="col-xs-4 text-center">
                        <a href="#">Friends</a>
                      </div>
                    </div><!-- /.row -->
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{ URL::to('auth/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li class="hide">
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>


<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel hide">
            <div class="pull-left image">
              <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>Alexander Pierce</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form hide">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview hide">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="../../index"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                <li><a href="../../index2"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
              </ul>
            </li>
            <li class="treeview {{ Request::is('admin/users/add') ? 'active' : '' }} {{ Request::is('admin/users') ? 'active' : '' }}">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Users Management</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class=""><a href="{{ URL::to('admin/users/add') }}"><i class="fa fa-circle-o"></i> Add User</a></li>
                <li><a href="{{ URL::to('admin/users') }}"><i class="fa fa-circle-o"></i> View Users</a></li>
              </ul>
            </li>  
            <li class="treeview {{ Request::is('admin/shops/add') ? 'active' : '' }} {{ Request::is('admin/shops') ? 'active' : '' }}">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Shop Management</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="active"><a href="{{ URL::to('admin/shops/add') }}"><i class="fa fa-circle-o"></i> Add Shop</a></li>
                <li><a href="{{ URL::to('admin/shops') }}"><i class="fa fa-circle-o"></i> View Shops</a></li>
              </ul>
            </li>
            <li class="treeview {{ Request::is('admin/products/add') ? 'active' : '' }} {{ Request::is('admin/products') ? 'active' : '' }}">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Product Management</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="active"><a href="{{ URL::to('admin/products/add') }}"><i class="fa fa-circle-o"></i> Add Products</a></li>
                <li><a href="{{ URL::to('admin/products') }}"><i class="fa fa-circle-o"></i> View Products</a></li>
              </ul>
            </li>
            <li class="treeview {{ Request::is('admin/reports/all_sale') ? 'active' : '' }} {{ Request::is('admin/reports/today_sale') ? 'active' : '' }}">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Report Management</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="active"><a href="{{ URL::to('admin/reports/all_sale') }}"><i class="fa fa-circle-o"></i> All Sale Report</a></li>
                <li><a href="{{ URL::to('admin/reports/today_sale') }}"><i class="fa fa-circle-o"></i> Today Sale</a></li>
              </ul>
            </li>
            <li class="treeview {{ Request::is('admin/accounts/index_coa') ? 'active' : '' }} {{ Request::is('admin/accounts/show_coa') ? 'active' : '' }}">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>COA Management</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="active"><a href="{{ URL::to('admin/accounts/index_coa') }}"><i class="fa fa-circle-o"></i> Add COA</a></li>
                <li><a href="{{ URL::to('admin/accounts/show_coa') }}"><i class="fa fa-circle-o"></i> View COA</a></li>
              </ul>
            </li>
            <li class="treeview {{ Request::is('admin/accounts/bank_pay') ? 'active' : '' }} {{ Request::is('admin/accounts/bank_receipt') ? 'active' : '' }} {{ Request::is('admin/accounts/cash_receipt') ? 'active' : '' }} {{ Request::is('admin/accounts/cash_pay') ? 'active' : '' }} {{ Request::is('admin/accounts/trial_balance') ? 'active' : '' }} {{ Request::is('admin/accounts/all_vouchers') ? 'active' : '' }}">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Account Management</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="active"><a href="{{ URL::to('admin/accounts/bank_pay') }}"><i class="fa fa-circle-o"></i> Bank Pay Voucher</a></li>
                <li class="active"><a href="{{ URL::to('admin/accounts/bank_receipt') }}"><i class="fa fa-circle-o"></i> Bank Receipt Voucher</a></li>
                <li class="active"><a href="{{ URL::to('admin/accounts/cash_pay') }}"><i class="fa fa-circle-o"></i> Cash Pay Voucher</a></li>
                <li class="active"><a href="{{ URL::to('admin/accounts/cash_receipt') }}"><i class="fa fa-circle-o"></i> Cash Receipt Voucher</a></li>
                <li class="active"><a href="{{ URL::to('admin/accounts/trial_balance') }}"><i class="fa fa-circle-o"></i> Trial Balance</a></li>
                <li class="active"><a href="{{ URL::to('admin/accounts/all_vouchers') }}"><i class="fa fa-circle-o"></i> View Vouchers</a></li>
                
              </ul>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

@yield('content')

<footer class="main-footer">
<div class="pull-right hidden-xs">
  <b>Version</b> 2.3.0
</div>
<strong class="hide">Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
</footer>
  <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->
<!-- jQuery 2.1.4 -->
    <script src="{{asset('../../plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('../../plugins/jQueryUI/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      //$.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{asset('../../bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="{{asset('../../plugins/morris/morris.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{asset('../../plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    <!-- jvectormap -->
    <script src="{{asset('../../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{asset('../../plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{asset('../../plugins/knob/jquery.knob.js')}}"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="{{asset('../../plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- datepicker -->
    <script src="{{asset('../../plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('../../plugins/datepicker/bootstrap-datetimepicker.js')}}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{asset('../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
    <!-- Slimscroll -->
    <script src="{{asset('../../plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('../../plugins/fastclick/fastclick.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('../../dist/js/app.min.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!--<script src="{{asset('../../dist/js/dashboard.js')}}"></script>-->
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('../../dist/js/demo.js')}}"></script>
    
    <script>
				$(function() {
						$( ".datepicker" ).datepicker({
								changeMonth: true,
								changeYear: true
						});
						$(".date-pick").datepicker('setDate', new Date());
				});
  </script>
     @yield('footer_scripts')
      </body>
  </html> 