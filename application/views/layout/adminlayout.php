<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Dashboard </title>
    <meta name="csrf-token" content="2BGCMmSHTlT6me6NgGdpyVGf0hcjAkPDd52io4tY">
    <link rel="icon" href="<?php echo base_url() ?>assets/images/one-aus-logo.png" />
    <!-- General CSS File -->
    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/newlayout/assets/vendors/fontawesome/css/all.min.css" />
    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/toast/jquery.toast.min.css">


    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/owl.carousel/owl.carousel.min.css">
    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/owl.carousel/owl.theme.min.css">


    <link rel="stylesheet" href="<?php echo base_url() ?>assets/newlayout/assets/admin/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/newlayout/assets/admin/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/newlayout/assets/admin/css/components.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/chartjs/chart.min.css">
    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/daterangepicker/daterangepicker.min.css">
    <!-- <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/select2/select2.min.css"> -->


    <style>
        :root {
            --primary: #6777ef;
        }
    </style>
</head>

<body class="">

    <div id="app">
        <div class="main-wrapper">
            <button type="button" class="sidebar-close">
                <i class="fa fa-times"></i>
            </button>

            <div class="navbar-bg"></div>

            <nav class="navbar navbar-expand-lg main-navbar">

                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                                    class="fas fa-search"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">

                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="<?php echo $this->session->userdata('profile_picture') ? base_url($this->session->userdata('profile_picture')) : base_url('assets/images/default-profile.png'); ?>" class="rounded-circle mr-1">
                            <!-- <div class="d-sm-none d-lg-inline-block">Admin</div> -->
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            
                            <a href="<?php echo base_url(); ?>admin/logout" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

             <!-- sidebar -->
        <div class="main-sidebar">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                <img class="logo-abbr" src="<?php echo base_url() ?>assets/images/one-aus-logo.png" alt="" style="width: 100px;">
            <!-- <img class="brand-title" src="<?php echo base_url() ?>assets/images/one-aus-logo.png" alt=""> -->
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                <img class="logo-abbr" src="<?php echo base_url() ?>assets/images/one-aus-logo.png" alt="" style="height: 30px;">
            <!-- <img class="brand-title" src="<?php echo base_url() ?>assets/images/one-aus-logo.png" alt="" style="height: 30px;"> -->
                    </a>
                </div>
        
                <?php $active = "";?>
                <ul class="sidebar-menu">
                   
                        <li class="">
                            <a  href="<?php echo base_url(); ?>admin" class="nav-link">
                                <i class="fas fa-fire"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <!-- <li class="">
                            <a  href="<?php echo base_url(); ?>admin/add" class="nav-link">
                                <i class="fas fa-file"></i>
                                <span>Add Student</span>
                            </a>
                        </li> -->

                        <li class="nav-item dropdown <?php echo $active_bar == "addstudent" || $active_bar == "students" ? "active" : ""; ?>">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                                <i class="fas fa-user-graduate"></i>
                                <span>Student Manage</span>
                            </a>
                            <ul class="dropdown-menu">
                               
                                    <li class="<?php echo $active_bar == "addstudent" ? "active" : ""; ?>">
                                        <a class="nav-link" href="<?php echo base_url(); ?>admin/addstudent">Add Student</a>
                                    </li>
        
                                    <li class="<?php echo $active_bar == "students" ? "active" : ""; ?>">
                                        <a class="nav-link" href="<?php echo base_url(); ?>admin/students">Student List</a>
                                    </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown <?php echo $active_bar == "addlisteningquestions" || $active_bar == "addwritingquestions" || $active_bar == "addspeakingquestions" || $active_bar == "addreadingquestions" ? "active" : ""; ?>">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                            <i class="fas fa-plus-circle "></i>
                                <span>Add Questions</span>
                            </a>
                            <ul class="dropdown-menu">
                               
                                    <li class="<?php echo $active_bar == "addlisteningquestions" ? "active" : ""; ?>">
                                        <a class="nav-link" href="<?php echo base_url(); ?>admin/addlisteningquestions">Listening</a>
                                    </li>
        
                                    <li class="<?php echo $active_bar == "addwritingquestions" ? "active" : ""; ?>">
                                        <a class="nav-link" href="<?php echo base_url(); ?>admin/addwritingquestions">Writing</a>
                                    </li>
        
                                    <li class="<?php echo $active_bar == "addspeakingquestions" ? "active" : ""; ?>">
                                        <a class="nav-link" href="<?php echo base_url(); ?>admin/addspeakingquestions">Speaking</a>
                                    </li>
                                    
                                    <li class="<?php echo $active_bar == "addreadingquestions" ? "active" : ""; ?>">
                                        <a class="nav-link" href="<?php echo base_url(); ?>admin/addreadingquestions">Reading</a>
                                    </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown <?php echo $active_bar == "listeningquestions" || $active_bar == "writingquestions" || $active_bar == "speakingquestions" || $active_bar == "readingquestions" ? "active" : ""; ?>">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                                <i class="fas fa-eye"></i>
                                <span>View Questions</span>
                            </a>
                            <ul class="dropdown-menu">
                               
                                    <li class="<?php echo $active_bar == "listeningquestions" ? "active" : ""; ?>">
                                        <a class="nav-link" href="<?php echo base_url(); ?>admin/listeningquestions">Listening</a>
                                    </li>
        
                                    <li class="<?php echo $active_bar == "writingquestions" ? "active" : ""; ?>">
                                        <a class="nav-linkbeep beep-sidebar" href="<?php echo base_url(); ?>admin/writingquestions">Writing</a>
                                    </li>
        
                                    <li class="<?php echo $active_bar == "speakingquestions" ? "active" : ""; ?>">
                                        <a class="nav-link" href="<?php echo base_url(); ?>admin/speakingquestions">Speaking</a>
                                    </li>
                                    
                                    <li class="<?php echo $active_bar == "readingquestions" ? "active" : ""; ?>">
                                        <a class="nav-link" href="<?php echo base_url(); ?>admin/readingquestions">Reading</a>
                                    </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown <?php echo $active_bar == "listPackage" || $active_bar == "createPackage" ? "active" : ""; ?>">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                                <i class="fas fa-sliders-h"></i>
                                <span>Manage Package</span>
                            </a>
                            <ul class="dropdown-menu">
                               
                                    <li class="<?php echo $active_bar == "createPackage" ? "active" : ""; ?>">
                                    <a class=" ai-icon" href="<?php echo base_url(); ?>package/createPackage">Create Package</a>
                                    </li>
        
                                    <li class="<?php echo $active_bar == "listPackage" ? "active" : ""; ?>">
                                        <a class="nav-linkbeep beep-sidebar" href="<?php echo base_url(); ?>package/listPackage">List Package</a>
                                    </li>
                            </ul>
                        </li>
                       
                        <li class="nav-item dropdown <?php echo $active_bar == "material" || $active_bar == "materials" ? "active" : ""; ?>">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                                <i class="fas fa-book"></i>
                                <span>Manage Materials</span>
                            </a>
                            <ul class="dropdown-menu">
                               
                                    <li class="<?php echo $active_bar == "material" ? "active" : ""; ?>">
                                    <a class=" ai-icon" href="<?php echo base_url(); ?>admin/material">New Material</a>
                                    </li>
        
                                    <li class="<?php echo $active_bar == "materials" ? "active" : ""; ?>">
                                        <a class="nav-linkbeep beep-sidebar" href="<?php echo base_url(); ?>admin/materials">All Materials</a>
                                    </li>
                            </ul>
                        </li>
                        
                        <li class="<?php echo $active_bar == "studentResults" ? "active" : ""; ?>">
                            <a  href="<?php echo base_url(); ?>admin/studentResults" class="nav-link">
                                <i class="fas fa-poll-h"></i>
                                <span>Results</span>
                            </a>
                        </li>
                        <li class="<?php echo $active_bar == "createmocktest" && $mock_test_type == "full" ? "active" : ""; ?>">
                            <a  href="<?php echo base_url(); ?>admin/createmocktest/full" class="nav-link">
                                <i class="fas fa-plus-circle "></i>
                                <span>Create Full Test</span>
                            </a>
                        </li>
                        <li class="<?php echo $active_bar == "createmocktest" && $mock_test_type == "section" ? "active" : ""; ?>">
                            <a  href="<?php echo base_url(); ?>admin/createmocktest/section" class="nav-link">
                                <i class="fas fa-plus-circle "></i>
                                <span>Create Section Test</span>
                            </a>
                        </li>
                        <li class="<?php echo $active_bar == "createmocktest" && $mock_test_type == "question" ? "active" : ""; ?>">
                            <a  href="<?php echo base_url(); ?>admin/createmocktest/question" class="nav-link">
                                <i class="fas fa-plus-circle "></i>
                                <span>Create Question Test</span>
                            </a>
                        </li>
                        <li class="<?php echo $active_bar == "viewmocktest" ? "active" : ""; ?>">
                            <a  href="<?php echo base_url(); ?>admin/viewmocktest" class="nav-link">
                                <i class="fas fa-eye"></i>
                                <span>View Mock Tests</span>
                            </a>
                        </li>
                        <li class="<?php echo $active_bar == "packageSale" ? "active" : ""; ?>">
                            <a  href="<?php echo base_url(); ?>admin/packageSale" class="nav-link">
                                <i class="fab fa-sellsy"></i>
                                <span>Package Sale</span>
                            </a>
                        </li>
                        <li class="<?php echo $active_bar == "orderHistory" ? "active" : ""; ?>">
                            <a  href="<?php echo base_url(); ?>admin/orderHistory" class="nav-link">
                                <i class="fas fa-history"></i>
                                <span>Order History</span>
                            </a>
                        </li>
                        <li class="<?php echo $active_bar == "feedbacks" ? "active" : ""; ?>">
                            <a  href="<?php echo base_url(); ?>admin/feedbacks" class="nav-link">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>Reported Issues</span>
                            </a>
                        </li>
                        <!-- <li><a class=" ai-icon" href="<?php echo base_url(); ?>package/createPackage" aria-expanded="false">
                            <div class="tab-color"> <i class="flaticon-381-file-2"></i>
                             <span class="nav-text">package</span></div>
                          </a>
                    </li>
                        <li><a class=" ai-icon" href="<?php echo base_url(); ?>package/listPackage" aria-expanded="false">
                            <div class="tab-color"> <i class="flaticon-381-file-2"></i>
                             <span class="nav-text">package List</span></div>
                          </a>
                    </li> -->
                    
        
                </ul>
                <br><br><br>
            </aside>
        </div>
        
        <!-- sidebar end -->


        <div class="main-content" style="min-height: 675px;">
        <section class="section">

            
            <?php $this->load->view($subview); ?> 
            
        </section>
                
            </div>

    </div>
    <!-- General JS Scripts -->
    <!-- <script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script> -->
    <script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/poper/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/moment/moment.min.js"></script>
    <script src="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/toast/jquery.toast.min.js"></script>
    

    <script>
        (function () {
            "use strict";

            window.csrfToken = $('meta[name="csrf-token"]');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            window.adminPanelPrefix = '/admin';

        })(jQuery);
    </script>

    <script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/daterangepicker/daterangepicker.min.js"></script>
    <!-- <script src="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/select2/select2.min.js"></script> -->
    <!-- <script src="<?php echo base_url() ?>assets/newlayout/vendor/laravel-filemanager/js/stand-alone-button.js"></script> -->
    <!-- Template JS File -->
    <script src="<?php echo base_url() ?>assets/newlayout/assets/admin/js/scripts.js"></script>
    <script src="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/chartjs/chart.min.js"></script>
    <script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/owl.carousel/owl.carousel.min.js"></script>

    <script>
        var deleteAlertTitle = 'Are you sure?';
        var deleteAlertHint = 'This action cannot be undone!';
        var deleteAlertConfirm = 'Delete';
        var deleteAlertCancel = 'Cancel';
        var deleteAlertSuccess = 'Success';
        var deleteAlertFail = 'Failed';
        var deleteAlertFailHint = 'Error while deleting item!';
        var deleteAlertSuccessHint = 'Item successfully deleted.';
        var forbiddenRequestToastTitleLang = '&quot;FORBIDDEN&quot; Request';
        var forbiddenRequestToastMsgLang = 'You not access to this content.';
    </script>

    <script src="<?php echo base_url() ?>assets/newlayout/assets/admin/js/custom.js"></script>
    <script>

    </script>
</body>

</html>