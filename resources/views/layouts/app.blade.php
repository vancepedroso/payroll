@inject('request', 'Illuminate\Http\Request')
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/launchpad icon.png') }}">
    <title>Payroll</title>

    <link href="{{ asset('matrix admin/assets/extra-libs/multicheck/multicheck.css') }}" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-colvis-1.7.0/b-html5-1.7.0/b-print-1.7.0/cr-1.5.3/fh-3.1.8/r-2.2.7/datatables.min.css"/>

    <link href="{{ asset('matrix admin/assets/libs/flot/css/float-chart.css') }}" rel="stylesheet">
    <link href="{{ asset('matrix admin/assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('matrix admin/assets/libs/select2/dist/css/select2.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('vendor/icofont/icofont.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/venobox/venobox.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datetimepicker/jquery.datetimepicker.min.css') }}" rel="stylesheet">
    <!-- bootstrap datepicker -->
    <link href="{{ asset('vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">

    <link href="{{ asset('matrix admin/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/CustomStyle.css') }}" rel="stylesheet">
</head>


<body>

    <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-body text-white">
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Confirmation</h5>
          </div>
          <div class="modal-body">
            <div id="delete_content"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="uni_modal" role='dialog'>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
        </div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="{{ route('admin.home') }}">
                        <!-- Logo icon -->
                        <b class="logo-icon p-l-10">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{ asset('img/launchpad icon.png') }}" alt="homepage" class="light-logo" width="100%" />
                           
                        </b>
                        <!--End Logo icon -->
                         <!-- Logo text -->
                        <span class="logo-text">
                             <!-- dark Logo text -->
                             <img src="{{ asset('img/launchpad text.png') }}" alt="homepage" class="light-logo" width="100%" />
                            
                        </span>
                        <!-- Logo icon -->
                        <!-- <b class="logo-icon"> -->
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <!-- <img src="{{ asset('matrix admin/assets/images/logo-text.png') }}" alt="homepage" class="light-logo" /> -->
                            
                        <!-- </b> -->
                        <!--End Logo icon -->
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                        <!-- ============================================================== -->
                        <!-- create new -->
                        <!-- ============================================================== -->
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <span class="d-none d-md-block">Create New <i class="fa fa-angle-down"></i></span>
                             <span class="d-block d-md-none"><i class="fa fa-plus"></i></span>   
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li> -->
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item search-box"> <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search position-absolute">
                                <input type="text" class="form-control" placeholder="Search &amp; enter"> <a class="srh-btn"><i class="ti-close"></i></a>
                            </form>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell font-24"></i>
                            </a>
                             <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <!-- <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a> -->
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="font-24 mdi mdi-comment-processing"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" aria-labelledby="2">
                                <ul class="list-style-none">
                                    <li>
                                        <div class="">
                                             <!-- Message -->
                                            <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span class="btn btn-primary btn-circle"><i class="ti-calendar"></i></span>
                                                    <div class="m-l-10">
                                                        <h5 class="m-b-0">Event today</h5> 
                                                        <span class="mail-desc">Just a reminder</span> 
                                                    </div>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span class="btn btn-info btn-circle"><i class="ti-settings"></i></span>
                                                    <div class="m-l-10">
                                                        <h5 class="m-b-0">Settings</h5> 
                                                        <span class="mail-desc">You can customize</span> 
                                                    </div>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span class="btn btn-primary btn-circle"><i class="ti-user"></i></span>
                                                    <div class="m-l-10">
                                                        <h5 class="m-b-0">IT Admin</h5> 
                                                        <span class="mail-desc">Just see the my admin!</span> 
                                                    </div>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span class="btn btn-danger btn-circle"><i class="fa fa-link"></i></span>
                                                    <div class="m-l-10">
                                                        <h5 class="m-b-0">Launchpad Admin</h5> 
                                                        <span class="mail-desc">Just see the my new admin!</span> 
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('matrix admin/assets/images/users/1.jpg') }}" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-user m-r-5 m-l-5"></i> My Profile</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-email m-r-5 m-l-5"></i> Inbox</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>
                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                  <i class="fa fa-power-off m-r-5 m-l-5"></i> Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                  @csrf
                                </form>

                                <!-- <div class="dropdown-divider"></div>
                                <div class="p-l-30 p-10"><a href="javascript:void(0)" class="btn btn-sm btn-success btn-rounded">View Profile</a></div> -->
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item {{ request()->is('admin/dashboard') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.home') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                        <li class="sidebar-item {{ request()->is('admin/employee') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.employees.index') }}" aria-expanded="false"><i class="mdi mdi-account-multiple-outline"></i><span class="hide-menu">Employees</span></a></li>
                        <li class="sidebar-item {{ request()->is('admin/payroll') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.payroll.index') }}" aria-expanded="false"><i class="mdi mdi-table"></i><span class="hide-menu">Payroll</span></a></li>
                        <li class="sidebar-item {{ request()->is('admin/incentives') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.incentives.index') }}" aria-expanded="false"><i class="mdi mdi-cash-multiple"></i><span class="hide-menu">Incentives</span></a></li>
                        <li class="sidebar-item {{ request()->is('admin/earning') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.earnings.index') }}" aria-expanded="false"><i class="mdi mdi-plus-circle-outline"></i><span class="hide-menu">Earnings</span></a></li>
                        <li class="sidebar-item {{ request()->is('deduction') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.deductions.index') }}" aria-expanded="false"><i class="mdi mdi-minus-circle-outline"></i><span class="hide-menu">Deductions</span></a></li>
                        <li class="sidebar-item
                        {{ request()->is('admin/permissions*') ? 'selected' : '' }}
                        {{ request()->is('admin/roles*') ? 'selected' : '' }}
                        {{ request()->is('admin/users*') ? 'selected' : '' }}
                        {{ request()->is('admin/logs*') ? 'selected' : '' }}">
                        <a class="sidebar-link has-arrow waves-effect waves-dark
                        {{ request()->is('admin/permissions*') ? 'active' : '' }}
                        {{ request()->is('admin/roles*') ? 'active' : '' }}
                        {{ request()->is('admin/users*') ? 'active' : '' }}
                        {{ request()->is('admin/logs*') ? 'active' : '' }}" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-key"></i><span class="hide-menu">User Management </span></a>
                          <ul aria-expanded="false" class="collapse  first-level
                          {{ request()->is('admin/permissions*') ? 'in' : '' }}
                          {{ request()->is('admin/roles*') ? 'in' : '' }}
                          {{ request()->is('admin/users*') ? 'in' : '' }}
                          {{ request()->is('admin/logs*') ? 'in' : '' }}">
                            <li class="sidebar-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                              <a href="{{ route('admin.users.index') }}" class="sidebar-link">
                                <i class="mdi mdi-all-inclusive"></i>
                                <span class="hide-menu"> User </span>
                              </a>
                            </li>
                            <li class="sidebar-item {{ request()->is('admin/permissions*') ? 'active' : '' }}">
                              <a href="{{ route('admin.permissions.index') }}" class="sidebar-link">
                                <i class="mdi mdi-all-inclusive"></i>
                                <span class="hide-menu"> Permissions </span>
                              </a>
                            </li>
                            <li class="sidebar-item {{ request()->is('admin/roles*') ? 'active' : '' }}">
                              <a href="{{ route('admin.roles.index') }}" class="sidebar-link">
                                <i class="mdi mdi-all-inclusive"></i>
                                <span class="hide-menu"> Roles </span>
                              </a>
                            </li>
                            <li class="sidebar-item {{ request()->is('admin/logs*') ? 'active' : '' }}">
                              <a href="{{ route('admin.logs.index') }}" class="sidebar-link">
                                <i class="mdi mdi-all-inclusive"></i>
                                <span class="hide-menu"> Logs </span>
                              </a>
                            </li>
                          </ul>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">{{ ucfirst($request->segment(2)) }}</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">{{ $request->segment(1) }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $request->segment(2) }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                    @yield('content')
                </div>
              </div>
            </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Page wrapper  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('matrix admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('matrix admin/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('matrix admin/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('matrix admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('matrix admin/assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('matrix admin/dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('matrix admin/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('matrix admin/dist/js/custom.min.js') }}"></script>

    <!-- User page js -->
    <script src="{{ asset('matrix admin/assets/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
    <script src="{{ asset('matrix admin/assets/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
    <!-- <script src="{{ asset('matrix admin/assets/extra-libs/DataTables/datatables.min.js') }}"></script> -->

    <!-- DataTables & Plugins -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-colvis-1.7.0/b-html5-1.7.0/b-print-1.7.0/cr-1.5.3/fh-3.1.8/r-2.2.7/datatables.min.js"></script>

    <!-- Select2 -->
    <script src="{{ asset('matrix admin/assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('matrix admin/assets/libs/select2/dist/js/select2.min.js') }}"></script>

    <!-- Charts js Files -->
    <script src="{{ asset('matrix admin/assets/libs/flot/excanvas.js') }}"></script>
    <script src="{{ asset('matrix admin/assets/libs/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('matrix admin/assets/libs/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('matrix admin/assets/libs/flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('matrix admin/assets/libs/flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('matrix admin/assets/libs/flot/jquery.flot.crosshair.js') }}"></script>
    <script src="{{ asset('matrix admin/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('matrix admin/dist/js/pages/chart/chart-page-init.js') }}"></script>
    <script src="{{ asset('matrix admin/assets/libs/toastr/build/toastr.min.js') }}"></script>

    <!-- Custom Javascript -->
    <script src="{{ asset('vendor/venobox/venobox.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
    <!-- datepicker -->
    <script src="{{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>

    <script type="text/javascript">

      window.start_load = function(){
        $('body').prepend('<div id="preloader2"></div>')
      }

      window.end_load = function(){
        $('#preloader2').fadeOut('fast', function() {
          $(this).remove();
        })
      }

      window.uni_modal = function($title='',$url='',$size=''){
        start_load()
        $.ajax({
          url:$url,
          error:err=>{
            console.log();
            alert("An error occured");
            end_load();
          },
          success:function(resp){
            if(resp){
              $('#uni_modal .modal-title').html($title)
              $('#uni_modal .modal-body').html(resp)
              if($size != ''){
                $('#uni_modal .modal-dialog').removeClass("modal-xl modal-md").addClass($size);
              }else{
                $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md");
              }
              $('#uni_modal').modal({
                show:true,
                backdrop:'static',
                keyboard:false,
                focus:true
              })
              end_load()
            }
          }
        })
      }

      window._conf = function($msg='',$func='',$params = []){
        $('#confirm_modal #confirm').attr('onclick',$func+"("+$params.join(',')+")")
        $('#confirm_modal .modal-body').html($msg)
        $('#confirm_modal').modal({
          show:true,
          backdrop:'static',
          keyboard:false,
          focus:true
        })
      }

      window.alert_toast = function($msg = 'TEST',$bg = 'success'){
        if($bg == 'success')
          toastr.success($msg);
        if($bg == 'danger')
          toastr.danger($msg);
        if($bg == 'info')
          toastr.info($msg);
        if($bg == 'error')
          toastr.error($msg);
      }

      $(document).ready(function(){
        $('#preloader').fadeOut('fast', function() {
            $(this).remove();
          })
      })

      $('.datetimepicker').datetimepicker({
          format:'Y/m/d H:i',
          startDate: '+3d'
      })

      //Date picker
      $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
      })

      //Date range picker
      $('.daterange').daterangepicker({
        autoUpdateInput: false,
        locale: {
          format: 'YYYY-MM-DD'
        }
      })

      $('.daterange').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
      })

      $('.select2').select2({
        placeholder:" Please select here",
        width: "100%"
      })

      $('.select-all').click(function () {
        let $select2 = $(this).parent().siblings('.select2')
        $select2.find('option').prop('selected', 'selected')
        $select2.trigger('change')
      })
      $('.deselect-all').click(function () {
        let $select2 = $(this).parent().siblings('.select2')
        $select2.find('option').prop('selected', '')
        $select2.trigger('change')
      })

      var table = $('#custom_table').DataTable( {
        colReorder: true,
        fixedHeader: true,
        responsive: true,
        "autoWidth": false,
        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
      });
        
      table.buttons().container().appendTo( $('.col-md-6:eq(0)', table.table().container() ));

      // $('#custom_table').DataTable({
      //   "paging": false,
      //   "lengthChange": true,
      //   "searching": true,
      //   "ordering": false,
      //   "info": true,
      //   "autoWidth": false,
      //   "iDisplayLength": 100,
      //   "responsive": true,
      // });

      $('[data-toggle="tooltip"]').tooltip();
      $(".preloader").fadeOut();

      // Scolldown 
      (function() {
        $(window).scroll(function() {
          toggleBackToTop();
        });
        
        // Show and hide back to top button 
        function toggleBackToTop() {
          var offset = 1, // Offset position when to show
              scrollTop = 0,
              $btn = $('.back-to-top');
          
          scrollTop = $(window).scrollTop();
          
          if(scrollTop >= offset) {
              $btn.fadeIn();
          } else {
            $btn.fadeOut();
          }
          
        }
      })();

    </script>
    @yield('scripts')

</body>
</html>