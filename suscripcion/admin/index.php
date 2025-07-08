<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>PerflopPerfect-Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Plataforma administrativa de PerflopPerfect" name="description">
        <meta content="Coderthemes" name="author">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets\images\favicon.ico">

        <!-- App css -->
        <link href="assets\css\bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets\css\icons.min.css" rel="stylesheet" type="text/css">
        <link href="assets\css\app.min.css" rel="stylesheet" type="text/css">

    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include ('header.php') ?>             

            <!-- ========== Left Sidebar Start ========== -->
            <?php include ('nav.php') ?>             

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Minton</a></li>
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Welcome !</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="avatar-lg rounded-circle bg-icon-success float-left">
                                        <i class="mdi mdi-android-studio font-24 avatar-title text-white"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span class="counter">64,570</span></h3>
                                        <p class="text-muted mb-0">Today's Visits</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="avatar-lg rounded-circle bg-icon-primary float-left">
                                        <i class="mdi mdi-amazon font-24 avatar-title text-white"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span class="counter">31,570</span></h3>
                                        <p class="text-muted mb-0">Total Revenue</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="avatar-lg rounded-circle bg-icon-danger float-left">
                                        <i class="mdi mdi-apple font-24 avatar-title text-white"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span class="counter">280</span></h3>
                                        <p class="text-muted mb-0">Today's Sales</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="avatar-lg rounded-circle bg-icon-purple float-left">
                                        <i class="mdi mdi-barley font-24 avatar-title text-white"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span class="counter">0.16</span>%</h3>
                                        <p class="text-muted mb-0">Conversion</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card-box">
                                    <div class="dropdown float-right">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Download</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Upload</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>

                                    <h4 class="header-title">Total Revenue</h4>

                                    <div class="mt-3 text-center">
                                        <p class="text-muted font-15 font-family-secondary mb-0">
                                            <span class="mx-2"><i class="mdi mdi-checkbox-blank-circle text-success"></i> Desktop</span>
                                            <span class="mx-2"><i class="mdi mdi-checkbox-blank-circle text-primary"></i> Laptop</span>
                                        </p>

                                        <div id="sparkline1" class="mt-3"></div>

                                        <div class="row mt-3">
                                            <div class="col-4">
                                                <p class="text-muted font-15 mb-1 text-truncate">Target</p>
                                                <h4> $56,214</h4>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-muted font-15 mb-1 text-truncate">Last week</p>
                                                <h4><i class="fe-arrow-up text-success"></i> $840</h4>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-muted font-15 mb-1 text-truncate">Last Month</p>
                                                <h4><i class="fe-arrow-down text-danger"></i> $7,845</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->

                            <div class="col-xl-4">
                                <div class="card-box">
                                    <div class="dropdown float-right">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Download</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Upload</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>

                                    <h4 class="header-title">Yearly Sales Report</h4>

                                    <div class="mt-3 text-center">
                                        <p class="text-muted font-15 font-family-secondary mb-0">
                                            <span class="mx-2"><i class="mdi mdi-checkbox-blank-circle text-pink"></i> Revenue</span>
                                            <span class="mx-2"><i class="mdi mdi-checkbox-blank-circle text-light"></i> Number of Sales</span>
                                        </p>

                                        <div id="sparkline2" class="text-center mt-3"></div>

                                        <div class="row mt-3">
                                            <div class="col-4">
                                                <p class="text-muted font-15 mb-1 text-truncate">Target</p>
                                                <h4>$8712</h4>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-muted font-15 mb-1 text-truncate">Last week</p>
                                                <h4><i class="fe-arrow-up text-success"></i> $523</h4>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-muted font-15 mb-1 text-truncate">Last Month</p>
                                                <h4><i class="fe-arrow-down text-danger"></i> $965</h4>
                                            </div>
                                        </div>

                                    </div>
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->

                            <div class="col-xl-4">
                                <div class="card-box">
                                    <div class="dropdown float-right">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Download</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Upload</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>

                                    <h4 class="header-title">Weekly Sales Report</h4>

                                    <div class="mt-3 text-center">
                                        <p class="text-muted font-15 font-family-secondary mb-0">
                                            <span class="mx-2"><i class="mdi mdi-checkbox-blank-circle text-success"></i> Direct</span>
                                            <span class="mx-2"><i class="mdi mdi-checkbox-blank-circle text-primary"></i> Affilliate</span>
                                            <span class="mx-2"><i class="mdi mdi-checkbox-blank-circle text-warning"></i> Sponsored</span>
                                        </p>

                                        <div id="sparkline3" class="text-center mt-3"></div>

                                        <div class="row mt-3">
                                            <div class="col-4">
                                                <p class="text-muted font-15 mb-1 text-truncate">Target</p>
                                                <h4> $12,365</h4>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-muted font-15 mb-1 text-truncate">Last week</p>
                                                <h4><i class="fe-arrow-down text-danger"></i> $365</h4>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-muted font-15 mb-1 text-truncate">Last Month</p>
                                                <h4><i class="fe-arrow-up text-success"></i> $8,501</h4>
                                            </div>
                                        </div>

                                    </div>
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->

                        </div>
                        <!-- end row -->

                        <div class="row">

                            <div class="col-xl-6">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="row align-items-center">
                                                <div class="col-6 text-center">
                                                    <h1 class="display-4"><i class="wi wi-day-sleet text-primary"></i></h1>
                                                </div>
                                                <div class="col-6">
                                                    <div class="text-muted">
                                                        <h2 class="mt-1"><b>32�</b></h2>
                                                        <p>Partly cloudy</p>
                                                        <p class=" mb-0">15km/h - 37%</p>
                                                    </div>
                                                </div>
                                            </div><!-- End row -->
                                        </div>
                                        <div class="col-md-5">
                                            <div class="row">
                                                <div class="col-4 text-center">
                                                    <h4 class="text-muted mt-0">SAT</h4>
                                                    <h3 class="my-3"><i class="wi wi-night-alt-cloudy text-primary"></i></h3>
                                                    <h4 class="text-muted mb-0">30<i class="wi wi-degrees"></i></h4>
                                                </div>
                                                <div class="col-4 text-center">
                                                    <h4 class="text-muted mt-0">SUN</h4>
                                                    <h3 class="my-3"><i class="wi wi-day-sprinkle text-primary"></i></h3>
                                                    <h4 class="text-muted mb-0">28<i class="wi wi-degrees"></i></h4>
                                                </div>
                                                <div class="col-4 text-center">
                                                    <h4 class="text-muted mt-0">MON</h4>
                                                    <h3 class="my-3"><i class="wi wi-hot text-primary"></i></h3>
                                                    <h4 class="text-muted mb-0">33<i class="wi wi-degrees"></i></h4>
                                                </div>
                                            </div><!-- end row -->
                                        </div>
                                    </div><!-- end row -->
                                </div><!-- cardbox -->
                                <!-- END Weather WIDGET 1 -->

                            </div><!-- End col-xl-6 -->

                            <div class="col-xl-6">

                                <!-- WEATHER WIDGET 2 -->
                                <div class="card-box">

                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="row align-items-center">
                                                <div class="col-6 text-center">
                                                    <h1 class="display-4"><i class="wi wi-night-sprinkle text-success"></i></h1>
                                                </div>
                                                <div class="col-6">
                                                    <div class="text-muted">
                                                        <h2 class="mt-1"><b>18�</b></h2>
                                                        <p>Partly cloudy</p>
                                                        <p class=" mb-0">15km/h - 37%</p>
                                                    </div>
                                                </div>
                                            </div><!-- End row -->
                                        </div>
                                        <div class="col-md-5">
                                            <div class="row">
                                                <div class="col-4 text-center">
                                                    <h4 class="text-muted mt-0">SAT</h4>
                                                    <h3 class="my-3"><i class="wi wi-day-sprinkle text-success"></i></h3>
                                                    <h4 class="text-muted mb-0">30<i class="wi wi-degrees"></i></h4>
                                                </div>
                                                <div class="col-4 text-center">
                                                    <h4 class="text-muted mt-0">SUN</h4>
                                                    <h3 class="my-3"><i class="wi wi-storm-showers text-success"></i></h3>
                                                    <h4 class="text-muted mb-0">28<i class="wi wi-degrees"></i></h4>
                                                </div>
                                                <div class="col-4 text-center">
                                                    <h4 class="text-muted mt-0">MON</h4>
                                                    <h3 class="my-3"><i class="wi wi-night-alt-cloudy text-success"></i></h3>
                                                    <h4 class="text-muted mb-0">33<i class="wi wi-degrees"></i></h4>
                                                </div>
                                            </div><!-- end row -->
                                        </div>
                                    </div><!-- end row -->
                                </div><!-- card-box -->
                                <!-- END WEATHER WIDGET 2 -->

                            </div><!-- /.col-xl-6 -->
                        </div>

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card-box">
                                    <div class="dropdown float-right">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Download</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Upload</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>
                                    <h4 class="header-title">Earning Reports</h4>
                                    <p class="text-muted">1 Mar - 31 Mar Showing Data</p>
                                    <h2 class="mb-4"><i class="mdi mdi-currency-usd text-primary"></i>25,632.78</h2>

                                    <div class="row mb-4">
                                        <div class="col-6">
                                            <p class="text-muted mb-1">This Month</p>
                                            <h3 class="mt-0 font-20">$120,254 <small class="badge badge-light-success font-13">+15%</small></h3>
                                        </div>

                                        <div class="col-6">
                                            <p class="text-muted mb-1">Last Month</p>
                                            <h3 class="mt-0 font-20">$98,741 <small class="badge badge-light-danger font-13">-5%</small></h3>
                                        </div>
                                    </div>

                                    <h5 class="font-16"><i class="mdi mdi-chart-donut text-primary"></i> Weekly Earning Report</h5>

                                    <div class="mt-5">
                                        <span data-plugin="peity-bar" data-colors="#3bafda,#ebeff2" data-width="100%" data-height="86">5,3,9,6,5,9,7,3,5,2,9,7,2,1,3,5,2,9,7,2,5,3,9,6,5,9,7</span>
                                    </div>

                                </div> <!-- end card-box -->
                            </div> <!-- end col -->
                            <div class="col-xl-8">
                                <div class="card-box">
                                    <div class="dropdown float-right">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Download</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Upload</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>
                                    <h4 class="header-title mb-3">Revenue History</h4>

                                    <div class="table-responsive">
                                        <table class="table table-borderless table-hover table-centered m-0">

                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Marketplaces</th>
                                                    <th>Date</th>
                                                    <th>US Tax Hold</th>
                                                    <th>Payouts</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h5 class="m-0 font-weight-normal">Themes Market</h5>
                                                    </td>
    
                                                    <td>
                                                        Oct 15, 2018
                                                    </td>
                                                    
                                                    <td>
                                                        $125.23
                                                    </td>

                                                    <td>
                                                        $5848.68
                                                    </td>
    
                                                    <td>
                                                        <span class="badge badge-light-warning">Upcoming</span>
                                                    </td>
    
                                                    <td>
                                                        <a href="javascript: void(0);" class="btn btn-xs btn-secondary"><i class="mdi mdi-pencil"></i></a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <h5 class="m-0 font-weight-normal">Freelance</h5>
                                                    </td>
    
                                                    <td>
                                                        Oct 12, 2018
                                                    </td>

                                                    <td>
                                                        $78.03
                                                    </td>
    
                                                    <td>
                                                        $1247.25
                                                    </td>
    
                                                    <td>
                                                        <span class="badge badge-light-success">Paid</span>
                                                    </td>
    
                                                    <td>
                                                        <a href="javascript: void(0);" class="btn btn-xs btn-secondary"><i class="mdi mdi-pencil"></i></a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <h5 class="m-0 font-weight-normal">Share Holding</h5>
                                                    </td>
    
                                                    <td>
                                                        Oct 10, 2018
                                                    </td>

                                                    <td>
                                                        $358.24
                                                    </td>
    
                                                    <td>
                                                        $815.89
                                                    </td>
    
                                                    <td>
                                                        <span class="badge badge-light-success">Paid</span>
                                                    </td>
    
                                                    <td>
                                                        <a href="javascript: void(0);" class="btn btn-xs btn-secondary"><i class="mdi mdi-pencil"></i></a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <h5 class="m-0 font-weight-normal">Envato's Affiliates</h5>
                                                    </td>
    
                                                    <td>
                                                        Oct 03, 2018
                                                    </td>

                                                    <td>
                                                        $18.78
                                                    </td>
    
                                                    <td>
                                                        $248.75
                                                    </td>
    
                                                    <td>
                                                        <span class="badge badge-light-danger">Overdue</span>
                                                    </td>
    
                                                    <td>
                                                        <a href="javascript: void(0);" class="btn btn-xs btn-secondary"><i class="mdi mdi-pencil"></i></a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <h5 class="m-0 font-weight-normal">Marketing Revenue</h5>
                                                    </td>
    
                                                    <td>
                                                        Sep 21, 2018
                                                    </td>

                                                    <td>
                                                        $185.36
                                                    </td>
    
                                                    <td>
                                                        $978.21
                                                    </td>
    
                                                    <td>
                                                        <span class="badge badge-light-warning">Upcoming</span>
                                                    </td>
    
                                                    <td>
                                                        <a href="javascript: void(0);" class="btn btn-xs btn-secondary"><i class="mdi mdi-pencil"></i></a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <h5 class="m-0 font-weight-normal">Advertise Revenue</h5>
                                                    </td>
    
                                                    <td>
                                                        Sep 15, 2018
                                                    </td>

                                                    <td>
                                                        $29.56
                                                    </td>
    
                                                    <td>
                                                        $358.10
                                                    </td>
    
                                                    <td>
                                                        <span class="badge badge-light-success">Paid</span>
                                                    </td>
    
                                                    <td>
                                                        <a href="javascript: void(0);" class="btn btn-xs btn-secondary"><i class="mdi mdi-pencil"></i></a>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div> <!-- end .table-responsive-->
                                </div> <!-- end card-box-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                               2016 - 2019 &copy; Minton theme by <a href="">Coderthemes</a> 
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-right footer-links d-none d-sm-block">
                                    <a href="javascript:void(0);">About Us</a>
                                    <a href="javascript:void(0);">Help</a>
                                    <a href="javascript:void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div class="rightbar-title">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i class="fe-x noti-icon"></i>
                </a>
                <h4 class="m-0 text-white">Settings</h4>
            </div>
            <div class="slimscroll-menu">
                <!-- User box -->
                <div class="user-box">
                    <div class="user-img">
                        <img src="assets\images\users\avatar-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                        <a href="javascript:void(0);" class="user-edit"><i class="mdi mdi-pencil"></i></a>
                    </div>
            
                    <h5><a href="javascript: void(0);">Nik G. Patel</a> </h5>
                    <p class="text-muted mb-0"><small>Admin Head</small></p>
                </div>

                <ul class="nav nav-pills bg-light nav-justified">
                    <li class="nav-item">
                        <a href="#home1" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                            General
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#messages1" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                            Chat
                        </a>
                    </li>
                </ul>
                <div class="tab-content pl-3 pr-3">
                    <div class="tab-pane" id="home1">
                        <div class="row mb-2">
                            <div class="col">
                                <h5 class="m-0 font-15">Notifications</h5>
                                <p class="text-muted"><small>Do you need them?</small></p>
                            </div> <!-- end col-->
                            <div class="col-auto">
                                <div class="custom-control custom-switch mb-2">
                                    <input type="checkbox" class="custom-control-input" id="tabswitch1">
                                    <label class="custom-control-label" for="tabswitch1"></label>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                        <div class="row mb-2">
                            <div class="col">
                                <h5 class="m-0 font-15">API Access</h5>
                                <p class="text-muted"><small>Enable/Disable access</small></p>
                            </div> <!-- end col-->
                            <div class="col-auto">
                                <div class="custom-control custom-switch mb-2">
                                    <input type="checkbox" class="custom-control-input" checked="" id="tabswitch2">
                                    <label class="custom-control-label" for="tabswitch2"></label>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                        <div class="row mb-2">
                            <div class="col">
                                <h5 class="m-0 font-15">Auto Updates</h5>
                                <p class="text-muted"><small>Keep up to date</small></p>
                            </div> <!-- end col-->
                            <div class="col-auto">
                                <div class="custom-control custom-switch mb-2">
                                    <input type="checkbox" class="custom-control-input" id="tabswitch3">
                                    <label class="custom-control-label" for="tabswitch3"></label>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                        <div class="row mb-2">
                            <div class="col">
                                <h5 class="m-0 font-15">Online Status</h5>
                                <p class="text-muted"><small>Show your status to all</small></p>
                            </div> <!-- end col-->
                            <div class="col-auto">
                                <div class="custom-control custom-switch mb-2">
                                    <input type="checkbox" class="custom-control-input" checked="" id="tabswitch4">
                                    <label class="custom-control-label" for="tabswitch4"></label>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                        <div class="alert alert-success alert-dismissible fade mt-3 show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">�</span>
                            </button>
                            <h5>Unlimited Access</h5>
                            Upgrade to plan to get access to unlimited reports
                            <br>
                            <a href="javascript: void(0);" class="btn btn-outline-success mt-3 btn-sm">Upgrade<i class="ml-1 mdi mdi-arrow-right"></i></a>
                        </div>
                
                    </div>
                    <div class="tab-pane show active" id="messages1">
                        <div>
                            <div class="inbox-widget">
                                <h5 class="mt-0">Recent</h5>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-2.jpg" class="rounded-circle" alt=""> <i class="online user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Tomaslau</a></p>
                                    <p class="inbox-item-text">I've finished it! See you so...</p>
                                </div>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-3.jpg" class="rounded-circle" alt=""> <i class="away user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Stillnotdavid</a></p>
                                    <p class="inbox-item-text">This theme is awesome!</p>
                                </div>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-4.jpg" class="rounded-circle" alt=""> <i class="online user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kurafire</a></p>
                                    <p class="inbox-item-text">Nice to meet you</p>
                                </div>
        
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-5.jpg" class="rounded-circle" alt=""> <i class="busy user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Shahedk</a></p>
                                    <p class="inbox-item-text">Hey! there I'm available...</p>
                                </div>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-6.jpg" class="rounded-circle" alt=""> <i class="user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Adhamdannaway</a></p>
                                    <p class="inbox-item-text">This theme is awesome!</p>
                                </div>

                                <hr>
                                <h5>Favorite <span class="float-right badge badge-pill badge-danger">18</span></h5>
                                <hr>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-7.jpg" class="rounded-circle" alt=""> <i class="busy user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kennith</a></p>
                                    <p class="inbox-item-text">I've finished it! See you so...</p>
                                </div>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-3.jpg" class="rounded-circle" alt=""> <i class="busy user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Stillnotdavid</a></p>
                                    <p class="inbox-item-text">This theme is awesome!</p>
                                </div>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-10.jpg" class="rounded-circle" alt=""> <i class="online user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kimberling</a></p>
                                    <p class="inbox-item-text">Nice to meet you</p>
                                </div>
        
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-4.jpg" class="rounded-circle" alt=""> <i class="user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kurafire</a></p>
                                    <p class="inbox-item-text">Hey! there I'm available...</p>
                                </div>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-9.jpg" class="rounded-circle" alt=""> <i class="away user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Leonareade</a></p>
                                    <p class="inbox-item-text">This theme is awesome!</p>
                                </div>

                                <div class="text-center mt-2">
                                    <a href="javascript:void(0);" class="text-muted"><i class="mdi mdi-spin mdi-loading mr-1"></i> Load more </a>
                                </div>

                            </div> <!-- end inbox-widget -->
                        </div> <!-- end .p-3-->
                    </div>
                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets\js\vendor.min.js"></script>

        <script src="assets\libs\jquery-knob\jquery.knob.min.js"></script>
        <script src="assets\libs\peity\jquery.peity.min.js"></script>

        <!-- Sparkline charts -->
        <script src="assets\libs\jquery-sparkline\jquery.sparkline.min.js"></script>

        <!-- init js -->
        <script src="assets\js\pages\dashboard-1.init.js"></script>

        <!-- App js -->
        <script src="assets\js\app.min.js"></script>
        
    </body>
</html>