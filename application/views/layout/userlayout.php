<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="JIiCok2TvBcxw5qP9dYLGwnUbDMiCdecOSkWmhLA">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name='robots' content="NOODP, nofollow, noindex">

    <!-- <title>Dashboard | User</title> -->

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4XEX1VMTN0"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-4XEX1VMTN0');
    </script>

    <!-- General CSS File -->
    <link href="<?php echo base_url() ?>assets/newlayout/assets/default/css/font.css" rel="stylesheet">
    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/toast/jquery.toast.min.css">
    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/simplebar/simplebar.css">
    <link rel="icon" href="<?php echo base_url() ?>assets/images/one-aus-logo.png" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/newlayout/assets/default/css/panel.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/newlayout/assets/default/css/app.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/newlayout/assets/default/css/loader.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/dashboardcss/style.css">

    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/chartjs/chart.min.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/app-search-sidebar.css" />
    <link rel="stylesheet"
    href="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/apexcharts/apexcharts.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <link href='https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css' rel='stylesheet'
    type='text/css'>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/user-layout.css" />
    <style>
        <?php if ($this->session->userdata('profile_completed') != 1) { ?>
            .panel-content {
                padding: 30px 50px;
                width: 100%;
                background-color: #b7daf5;
            }
        <?php } ?>
    </style>
    <style>
        @font-face {
            font-family: 'main-font-family';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(<?php echo base_url() ?>assets/newlayout/store/1/fonts/montserrat-regular.woff2) format('woff2');
        }

        @font-face {
            font-family: 'main-font-family';
            font-style: normal;
            font-weight: bold;
            font-display: swap;
            src: url(<?php echo base_url() ?>assets/newlayout/store/1/fonts/montserrat-bold.woff2) format('woff2');
        }

        @font-face {
            font-family: 'main-font-family';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(<?php echo base_url() ?>assets/newlayout/store/1/fonts/montserrat-medium.woff2) format('woff2');
        }

        @font-face {
            font-family: 'rtl-font-family';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(<?php echo base_url() ?>assets/newlayout/store/1/fonts/Vazir-Regular.woff2) format('woff2');
        }

        @font-face {
            font-family: 'rtl-font-family';
            font-style: normal;
            font-weight: bold;
            font-display: swap;
            src: url(<?php echo base_url() ?>assets/newlayout/store/1/fonts/Vazir-Bold.woff2) format('woff2');
        }

        @font-face {
            font-family: 'rtl-font-family';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(<?php echo base_url() ?>assets/newlayout/store/1/fonts/Vazir-Medium.woff2) format('woff2');
        }

        :root {}

        p {
            line-height: 1.6;
        }
    </style>
    <script src="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/pace-loading/pace.min.js"></script>
</head>

<body class="">

    <div class="loading-overlay flex-column d-none" id="app-loader">
        <div class="loader"></div>
        <div class="loader-label">Scoring...</div>
    </div>
    <div id="panel_app">

        <div id="navbarVacuum"></div>
        <nav id="navbar" class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between w-100">

                    <a class="navbar-brand d-flex align-items-center justify-content-center mr-0 p-10 p-lg-0"
                        href="<?php echo base_url() ?>">
                        <!-- <img class="logo-abbr" src="<?php echo base_url() ?>assets/images/one-aus-logo.png" alt=""> -->
                        <img src="<?php echo base_url() ?>assets/images/one-aus-logo.png" class="img-cover"
                            alt="site logo">

                    </a>


                    <?php $pte_core = 1; ?>
                 <!-- form that posts button value to session -->
                 <?php if ($pte_core){ ?>
                 <div class="d-flex sidebar-user-stats ml-0 default-tab align-items-center">
                    <form action="<?php echo base_url() ?>user/switch" method="post" class="d-flex pteswitch">
                        <div class="sidebar-user-stat-item d-flex flex-column">
                            <input type="hidden" class="csrfToken"
                                name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <button name="ptetype" value="<?php echo PTEACADEMIC; ?>" id="pteacademic"
                                class="<?php if ($this->session->userdata('pte_type') == PTEACADEMIC) {echo PTEACADEMIC;} ?> pteacademicbtn" autofocus>PTE Academic <br> <span class="d-flex align-items-center">(Australia <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130 120" xml:space="preserve" style="width: 15px;  margin:0 2px;"><path fill="#D8D8D8" d="M-500-1350h2180V350H-500z"/><path fill="#2A66B7" d="M0 0v120h130V0z"/><path fill="#FFF" d="m42.6 88.5 2.3 4.9 5.2.8-3.7 3.9.8 5.4-4.6-2.6-4.6 2.6.9-5.4-3.8-3.9 5.2-.8zm61.9 0 2.3 4.9 5.2.8-3.8 3.9.9 5.4-4.6-2.6-4.6 2.6.9-5.4-3.8-3.9 5.2-.8zm0-55.2 2.3 5 5.2.8-3.8 3.8.9 5.4-4.6-2.5-4.6 2.5.9-5.4-3.8-3.8 5.2-.8z"/><g fill="#DC4437"><path d="M55.8 51.7h-1v5.2l23.6 21.9h6.8v-5.6l-23-21.5zM29.5 27.3h.9v-5.2L6.8.2H0v5.6l23.1 21.5zm-6.6 24.4L0 72.9v5.9h6.4l24-22.1v-5h-1zM78.8.2l-24 22.1v5h7.5L85.2 6.1V.2z"/><path d="M50.3.2H35v31.7H0v15.2h35v31.7h15.3V47.1h34.9V31.9H50.3z"/></g><path d="M62.3 27.3h-7.5v-5L78.8.2H72L54.8 16V.2h-4.5v31.7h34.9v-4.6H69.1l16.1-14.9V6.1zM30.4 15.9 13.5.2H6.8l23.6 21.9v5.2h-7.3L0 5.8v6.3l16.3 15.2H0v4.6h35V.2h-4.6zm19.9 31.2v31.7h4.5V63.1l16.9 15.7h6.7L54.8 56.9v-5.2h7.4l23 21.5v-6.3L68.9 51.7h16.3v-4.6H60.6zM0 47.1v4.6h16.1L0 66.6v6.3l22.9-21.2h7.5v5l-24 22.1h6.8L30.4 63v15.8H35V47.1h-.7z" fill="#FFF"/></svg> )</span></button>

                        </div>

                        <div class="sidebar-user-stat-item d-flex flex-column">
                            <button name="ptetype" value="<?php echo PTECORE; ?>" id="ptecore"
                                class=" <?php if ($this->session->userdata('pte_type') == PTECORE) {echo PTECORE;} ?> ptecorebtn">PTE Core <br> <span class="d-flex align-items-center"> (Canada <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 496" xml:space="preserve"  style="width: 15px; margin:0 2px;"><path style="fill:#d32027" d="M160 80H48C21.6 80 0 99.2 0 126.4v243.2C0 396.8 21.6 416 48 416h112zm288 0H336v336h112c26.4 0 48-19.2 48-46.4V126.4c0-27.2-21.6-46.4-48-46.4"/><path style="fill:#bc1723" d="M448 80H336v240.8L446.4 416c26.4 0 49.6-19.2 49.6-46.4V126.4c0-27.2-21.6-46.4-48-46.4m-288 0H48l112 95.2z"/><path style="fill:#aa0e21" d="M336 416h112c26.4 0 48-16 48-48H336zM0 368c0 32 21.6 48 48 48h112v-48zM448 80H336v84.8l160 49.6v-88c0-27.2-21.6-46.4-48-46.4m-288 0H48l112 32.8z"/><path style="fill:#fff" d="M144 80h208v336H144z"/><path style="fill:#e9f3f4" d="M352 320.8V80H144v95.2z"/><path style="fill:#d3e9ea" d="M144 368h208v48H144zm208-203.2V80H144v32.8z"/><path style="fill:#d32027" d="M322.4 249.6c-2.4-2.4-8-2.4-8.8-6.4-1.6-10.4 3.2-16 6.4-23.2-15.2 3.2-27.2 9.6-27.2-8-8.8 10.4-18.4 21.6-21.6 19.2-5.6-3.2 5.6-30.4 6.4-44.8-5.6 2.4-15.2 8-15.2 8S256 176 248 167.2c-8 8.8-14.4 27.2-14.4 27.2s-10.4-5.6-15.2-8c.8 14.4 12 41.6 6.4 44.8-4 1.6-12.8-8.8-21.6-19.2 0 16.8-12 11.2-27.2 8 3.2 7.2 8 12.8 6.4 23.2-.8 4-6.4 4-8.8 6.4 17.6 17.6 48 30.4 33.6 44.8l39.2-4c1.6 12.8-3.2 29.6.8 37.6h3.2c4-8-.8-24.8.8-37.6l39.2 4c-16-15.2 14.4-27.2 32-44.8"/><path style="fill:#aa0e21" d="M322.4 249.6c-2.4-2.4-8-2.4-8.8-6.4-1.6-10.4 3.2-16 6.4-23.2-15.2 3.2-27.2 9.6-27.2-8-8.8 10.4-18.4 21.6-21.6 19.2-5.6-3.2 5.6-30.4 6.4-44.8-5.6 2.4-15.2 8-15.2 8S256 176 248 167.2V328s-.8 0 0 0h1.6c4-8-.8-24.8.8-37.6l39.2 4c-15.2-15.2 15.2-27.2 32.8-44.8"/></svg> ) </span></button>
                        </div>
                    </form>

                    <p class="loggedin d-none d-sm-block"><?php if ($this->session->userdata('pte_type') == PTEACADEMIC) {echo "You are in - PTE Academic Module";} ?></p>
                    <p class="loggedin  d-none d-sm-block"><?php if ($this->session->userdata('pte_type') == PTECORE) {echo  "You are in - PTE Core Module";} ?></p>



                </div>
                <?php } else { ?>
                <!-- end -->

                <!-- inplace of pte core swtich temp -->
                <div class="d-flex sidebar-user-stats pb-10 ml-0 pb-lg-20 mt-15 mt-lg-30">
                    <div class="sidebar-user-stat-item d-flex flex-column">
                        <strong class="text-center">
                            <?php echo $today_practice_count; ?>
                        </strong>
                        <span class="font-12" style="text-align: center;">Today Practiced</span>
                    </div>

                    <div class="border-left mx-10"></div>

                    <div class="sidebar-user-stat-item d-flex flex-column">
                        <strong class="text-center">
                            <?php echo $total_practice_count; ?>
                        </strong>
                        <span class="font-12" style="text-align: center;">Total Practiced</span>
                    </div>
                </div>
                <!-- inplace of pte core swtich temp -->
                <?php } ?>

                    <!-- <button class="navbar-toggler navbar-order" type="button" id="navbarToggle">
                        <span class="navbar-toggler-icon"></span>
                    </button> -->

                    <div class="mx-lg-30 d-none d-lg-flex flex-grow-1 navbar-toggle-content justify-content-center"
                        id="navbarContent">
                        <div class="navbar-toggle-header text-right d-lg-none">
                            <button class="btn-transparent" id="navbarClose">
                                <i data-feather="x" width="32" height="32"></i>
                            </button>
                        </div>

                        <!-- <ul class="navbar-nav mr-auto d-flex align-items-center">


                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url() ?>user/home">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Courses</a>
                            </li>
                        </ul> -->
                    </div>
                    <div class="d-flex-center d-lg-none">
                        <button
                            class="sidebar-toggler navbar-toggler btn-transparent d-flex flex-column-reverse justify-content-center align-items-center p-5 rounded-sm sidebarNavToggle"
                            type="button" id="ham-menu"
                            style="font-size: 1rem; border: 1px solid rgba(52, 52, 52, 0.1) !important;  background: linear-gradient(-25.660715deg, rgba(255, 139, 195, 1) -103.72282438712148%, rgba(133, 103, 255, 1) 173.13996196592132%, rgba(128, 205, 251, 1) 259.3467377445952%);" >
                            <!-- <span class="navbar-toggler-icon"></span> -->
                            <i data-feather="menu" width="16" height="16" class="text-white m-10"></i>
                        </button>
                        <!-- <label class="pl-1 m-0 d-flex justify-content-center d-none d-sm-block" for="ham-menu">Menu</label> -->
                    </div>

                    <div class="d-none nav-icons-or-start-live navbar-order d-lg-block">

                        <div class="d-none nav-notify-cart-dropdown top-navbar " style="height: 43px;">
                            <a href="<?php echo base_url() ?>user/profile" class="user-avatar bg-gray200"
                                style="border-radius: 50%;">
                                <img src="<?php echo $this->session->userdata('profile_picture') ? base_url($this->session->userdata('profile_picture')) : base_url('assets/images/default-profile.png'); ?>"
                                    class="img-cover" alt="">
                            </a>

                            <a href="<?php echo base_url() ?>user/profile" class="ml-1 mt-15 user-name">
                            <h5 class="fs13 font-weight-bold text-center" style="text-transform: capitalize;">
                                <?php echo $this->session->userdata('name'); ?>
                            </h5>
<!-- 
                            <p class="fs10 font-weight-bold text-center">
                                <?php 
                                    $email =$this->encryption->decrypt($this->session->userdata('email'));
                                    echo $email; 
                                ?>
                             </p> -->
                        </a>



                            <!-- <div class="dropdown">
                                <button type="button" disabled class="btn btn-transparent dropdown-toggle"
                                    id="navbarShopingCart" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i data-feather="shopping-cart" width="20" height="20" class="mr-10"></i>

                                </button> 

                                 <div class="dropdown-menu" aria-labelledby="navbarShopingCart">
                                    <div class="d-md-none border-bottom mb-20 pb-10 text-right">
                                        <i class="close-dropdown" data-feather="x" width="32" height="32"
                                            class="mr-10"></i>
                                    </div>
                                    <div class="h-100">
                                        <div class="navbar-shopping-cart h-100" data-simplebar>
                                            <div class="d-flex align-items-center text-center py-50">
                                                <i data-feather="shopping-cart" width="20" height="20"
                                                    class="mr-10"></i>
                                                <span class="">Your cart is empty</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="border-left mx-15"></div> -->

                            <!-- <div class="dropdown">
                                <button type="button" class="btn btn-transparent dropdown-toggle"
                                    id="navbarNotification" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i data-feather="bell" width="20" height="20" class="mr-10"></i>

                                    <img src="<?php echo base_url() ?>assets/newlayout/store/1/default_images/default_profile.jpg"
                                        class="img-cover" alt="Xyla Waller">

                                </button>

                                <div class="dropdown-menu pt-20" aria-labelledby="navbarNotification">
                                    <div class="d-flex flex-column h-100">
                                        <div class="mb-auto navbar-notification-card" data-simplebar> -->
                            <!-- <div class="d-md-none border-bottom mb-20 pb-10 text-right">
                                                <i class="close-dropdown" data-feather="x" width="32" height="32"
                                                    class="mr-10"></i>
                                            </div> -->


                            <!-- <div class="d-flex align-items-center p-15 border rounded-sm">
                                                <div class="d-flex-center size-40 rounded-circle bg-gray100">
                                                    <i data-feather="bell" width="20" height="20" class="text-gray"></i>
                                                </div>
                                                <div class="ml-5">
                                                    <div class="text-secondary font-14"><span
                                                            class="font-weight-bold">2</span> Notifications</div>

                                                    <a href="/panel/notifications/mark-all-as-read"
                                                        class="delete-action d-block mt-5 font-12 cursor-pointer text-hover-primary"
                                                        data-title="Convert unread messages to read"
                                                        data-confirm="Yes; Mark all as read!">
                                                        Mark all notifications as read
                                                    </a>
                                                </div>
                                            </div> -->

                            <!-- <a href="#">
                                                <div class="navbar-notification-item border-bottom">
                                                    <h4 class="font-14 font-weight-bold text-secondary">Profile</h4>
                                                    <span class="notify-at d-block mt-5">2 Sep 2023 | 09:30</span> 
                                                </div>
                                            </a>
                                            <a href="<?php echo base_url(); ?>user/logout">
                                                <div class="navbar-notification-item border-bottom">
                                                    <h4 class="font-14 font-weight-bold text-secondary">Logout
                                                    </h4>
                                                    <span class="notify-at d-block mt-5">2 Sep 2023 | 09:30</span>
                                                </div>
                                            </a>


                                        </div> -->

                            <!-- <div class="mt-10 navbar-notification-action">
                                            <a href="/panel/notifications" class="btn btn-sm btn-danger btn-block">All
                                                notifications</a>
                                        </div> -->
                            <!-- </div>
                                </div> -->
                        </div>
                    </div>

                    <?php if ($this->session->userdata('profile_completed')) { ?>
                        <a type="submit" class="btn btn-sm btn-primary renew-btn mx-20 p-20 predictionbtn d-none d-lg-inline-flex"
                            href="<?php echo base_url('public/study-materials/prediction.pdf'); ?>"
                            download="PTE PREDICTION">Get Free Prediction File</a>
                    <?php } ?>

                </div>
            </div>
    </div>
    </nav>


    <div class="d-flex justify-content-end">
        <!-- <div class="xs-panel-nav d-flex d-lg-none justify-content-between py-5 px-15"> -->
        <!-- <div class="user-info d-flex align-items-center justify-content-between">
                <div class="user-avatar bg-gray200">
                    <img src="<?php echo $this->session->userdata('profile_picture') ? base_url($this->session->userdata('profile_picture')) : base_url('assets/images/default-profile.png'); ?>"
                        class="img-cover" alt="Xyla Waller">
                </div>

                <div class="user-name ml-15">
                    <h3 class="font-16 font-weight-bold">
                        <?php echo $this->session->userdata('name'); ?> <i class="fa fa-pen" style="font-size:10px"></i>
                    </h3>
                </div>
            </div> -->

        <!-- <button
                class="sidebar-toggler navbar-toggler btn-transparent d-flex flex-column-reverse justify-content-center align-items-center p-5 rounded-sm sidebarNavToggle"
                type="button"> -->
        <!-- <span class="navbar-toggler-icon"></span> -->
        <!-- <i data-feather="menu" width="16" height="16" class="text-gray m-10"></i>
            </button> -->
        <!-- </div> -->

        <?php if ($this->session->userdata('profile_completed')) { ?>
            <div class="panel-sidebar pt-50 pb-25 px-25" id="panelSidebar">
                <button class="btn-transparent panel-sidebar-close sidebarNavToggle">
                    <i data-feather="x" width="24" height="24"></i>
                </button>

                <div class="user-info d-flex align-items-center flex-row flex-lg-column justify-content-lg-center">
                    <a href="<?php echo base_url() ?>user/profile" class="user-avatar bg-gray200">
                        <img src="<?php echo $this->session->userdata('profile_picture') ? base_url($this->session->userdata('profile_picture')) : base_url('assets/images/default-profile.png'); ?>"
                            class="img-cover" alt="Xyla Waller">

                    </a>

                    <div class="p-10 p-lg-0 d-flex flex-column align-items-center justify-content-center">
                        <a href="<?php echo base_url() ?>user/profile" class="user-name mt-15">
                            <h3 class="font-13 font-weight-bold text-center text-white" style="text-transform: capitalize;">
                                <?php echo $this->session->userdata('name'); ?> <i class="fa fa-pencil"></i>
                            </h3>
                        </a>

                    </div>
                </div>

                <ul id="panel-sidebar-scroll" class="sidebar-menu pt-10  ">

                    <li class="sidenav-item  <?php if ($active_bar == 'home') {
                        echo 'sidenav-item-active';
                    } ?>">
                        <a href="<?php echo base_url() ?>user/home" class="d-flex align-items-center">
                            <span class="sidenav-item-icon mr-10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <g id="Group_1264" transform="translate(-188.102 -869.102)">
                                        <g id="Group_1262">
                                            <g id="speedometer" transform="translate(188.102 869.102)">
                                                <path id="Path_1547"
                                                    d="M20.484 3.515a12 12 0 0 0-16.97 16.97 12 12 0 0 0 16.97-16.97zM12 22.593A10.594 10.594 0 1 1 22.593 12 10.606 10.606 0 0 1 12 22.593zm0 0"
                                                    class="cls-1" />
                                                <path id="Path_1548"
                                                    d="M118.647 321.206a.7.7 0 0 0-.5-.206h-8.094a.7.7 0 0 0-.5.206l-2.228 2.228a.7.7 0 0 0-.012.982 9.357 9.357 0 0 0 13.569 0 .7.7 0 0 0-.012-.982zm-4.544 4.716a7.882 7.882 0 0 1-5.273-2l1.517-1.517h7.512l1.517 1.517a7.882 7.882 0 0 1-5.273 2zm0 0"
                                                    class="cls-1" transform="translate(-102.104 -305.954)" />
                                                <path id="Path_1549"
                                                    d="M216.719 120.194a.7.7 0 0 0-.919.38l-1.606 3.876h-.091a2.063 2.063 0 1 0 1.39.541l1.606-3.877a.7.7 0 0 0-.38-.919zm-2.616 6.969a.654.654 0 1 1 .654-.654.655.655 0 0 1-.657.654zm0 0"
                                                    class="cls-1" transform="translate(-202.104 -114.509)" />
                                                <path id="Path_1550"
                                                    d="M65.375 56A9.385 9.385 0 0 0 56 65.375a.7.7 0 0 0 .7.7h1.25a.7.7 0 1 0 0-1.406h-.516a7.933 7.933 0 0 1 1.83-4.409l.362.362a.7.7 0 1 0 .994-.994l-.362-.362a7.934 7.934 0 0 1 4.41-1.83v.516a.7.7 0 1 0 1.406 0v-.516a7.934 7.934 0 0 1 4.41 1.83l-.362.362a.7.7 0 0 0 .994.994l.362-.362a7.932 7.932 0 0 1 1.83 4.409H72.8a.7.7 0 0 0 0 1.406h1.25a.7.7 0 0 0 .7-.7A9.385 9.385 0 0 0 65.375 56zm0 0"
                                                    class="cls-1" transform="translate(-53.376 -53.375)" />
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            <span class="font-14 text-dark-blue font-weight-500">Dashboard</span>
                        </a>
                    </li>


                    <li class="sidenav-item <?php if ($active_bar == 'read_alouds' || $active_bar == 'repeat_sentences' || $active_bar == 'respond_situation' || $active_bar == 'describe_images' || $active_bar == 'retell_lectures' || $active_bar == 'answer_questions') {
                        echo 'sidenav-item-active';
                    } ?>">
                        <a class="d-flex align-items-center" data-toggle="collapse" href="#webinarCollapse" role="button"
                            aria-expanded="false" aria-controls="webinarCollapse">
                            <span class="sidenav-item-icon mr-10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <g id="Mask_Group_17" clip-path="url(#clip-path)" data-name="Mask Group 17"
                                        transform="translate(-25 -410)">
                                        <g id="online-class" transform="translate(25 410)">
                                            <path id="Path_153"
                                                d="M22.078 12.319a2.112 2.112 0 0 0 1.922-2.1V3.656a2.112 2.112 0 0 0-2.109-2.109h-6.985A2.112 2.112 0 0 0 12.8 3.656v2.766H4.031a2.112 2.112 0 0 0-2.109 2.109v8.438a2.1 2.1 0 0 0 .121.7h-.777A1.267 1.267 0 0 0 0 18.938a3.52 3.52 0 0 0 3.516 3.516h16.968A3.52 3.52 0 0 0 24 18.938a1.267 1.267 0 0 0-1.266-1.266h-.777a2.1 2.1 0 0 0 .121-.7zM14.2 3.656a.7.7 0 0 1 .7-.7h6.984a.7.7 0 0 1 .7.7v6.562a.7.7 0 0 1-.7.7h-6.509a.7.7 0 0 0-.373.107l-1.418.886.589-1.963a.7.7 0 0 0 .03-.2zm6.281 17.391H3.516a2.112 2.112 0 0 1-2.1-1.969h21.173a2.112 2.112 0 0 1-2.105 1.969zM6.7 12.375a.8.8 0 1 1 .8.8.8.8 0 0 1-.8-.8zm-.375 3c0-.424.548-.8 1.172-.8a1.435 1.435 0 0 1 .885.287.692.692 0 0 1 .287.51v2.3H6.328zm3.75 2.3v-2.3a2.074 2.074 0 0 0-.815-1.608l-.036-.027a2.2 2.2 0 1 0-3.455 0 2.073 2.073 0 0 0-.851 1.634v2.3h-.887a.7.7 0 0 1-.7-.7V8.531a.7.7 0 0 1 .7-.7H12.8v1.816l-.559 1.864a1.4 1.4 0 0 0 2.092 1.6l1.247-.779h5.1v4.641a.7.7 0 0 1-.7.7z"
                                                class="cls-3" data-name="Path 153" />
                                            <path id="Path_154"
                                                d="M19.125 7.922h-1.5a.7.7 0 0 0 0 1.406h1.5a.7.7 0 0 0 0-1.406z"
                                                class="cls-3" data-name="Path 154" />
                                            <path id="Path_155"
                                                d="M16.5 5.953h3.75a.7.7 0 0 0 0-1.406H16.5a.7.7 0 0 0 0 1.406z"
                                                class="cls-3" data-name="Path 155" />
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            <span class="font-14 text-dark-blue font-weight-500">Speaking</span>
                        </a>

                        <div class="collapse <?php if ($active_bar == 'read_alouds' || $active_bar == 'repeat_sentences' || $active_bar == 'respond_situation' || $active_bar == 'describe_images' || $active_bar == 'retell_lectures' || $active_bar == 'answer_questions') {
                            echo 'show';
                        } ?>" id="webinarCollapse">
                            <ul class="sidenav-item-collapse">
                                <li class="mt-5 <?php if ($active_bar == 'read_alouds') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/read_alouds"> Read Alouds <span class="aiscore">
                                            AI Score </span> </a>
                                </li>
                                <li class="mt-5 <?php if ($active_bar == 'repeat_sentences') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/repeat_sentences"> Repeat Sentences <span
                                            class="aiscore"> AI Score </span> </a>
                                </li>

                                <li class="mt-5 <?php if ($active_bar == 'describe_images') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/describe_images"> Describe Image <span
                                            class="aiscore"> AI Score </span> </a>
                                </li>
                                <!-- Condition that checks the value of pte , if it is academic it will show retell lecture -->
                                <?php if ($this->session->userdata('pte_type') == PTEACADEMIC) { ?>
                                <li class="mt-5 <?php if ($active_bar == 'retell_lectures') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/retell_lectures"> Re-tell Lecture <span
                                            class="aiscore"> AI Score </span> </a>
                                </li>
                                <?php } ?>
                                <!-- Condition that checks the value of pte , if it is core it will show respond to a situation -->
                                <?php if ($this->session->userdata('pte_type') == PTECORE) { ?>
                                
                                <li class="mt-5 <?php if ($active_bar == 'respond_situation') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/respond_situation"> Respond to a
                                        situation<span class="aiscore"> AI Score </span> </a>
                                </li>
                                <?php } ?>
                                <li class="mt-5 <?php if ($active_bar == 'answer_questions') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/answer_questions"> Answer Short Question <span
                                            class="aiscore"> AI Score </span> </a>
                                </li>


                            </ul>
                        </div>
                    </li>
                    <li class="sidenav-item <?php if ($active_bar == 'swtx' || $active_bar == 'essays' || $active_bar == 'email') {
                        echo 'sidenav-item-active';
                    } ?>">
                        <a class="d-flex align-items-center" data-toggle="collapse" href="#meetingCollapse" role="button"
                            aria-expanded="false" aria-controls="meetingCollapse">
                            <span class="sidenav-item-icon mr-10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <g id="Mask_Group_21" clip-path="url(#clip-path)" data-name="Mask Group 21"
                                        transform="translate(-25 -410)">
                                        <g id="online-class_1_" data-name="online-class (1)" transform="translate(25 410)">
                                            <path id="Path_170"
                                                d="M21.422 0H2.578A2.581 2.581 0 0 0 0 2.578v18.844A2.581 2.581 0 0 0 2.578 24h18.844A2.581 2.581 0 0 0 24 21.422V2.578A2.581 2.581 0 0 0 21.422 0zM1.406 2.578a1.173 1.173 0 0 1 1.172-1.172h18.844a1.173 1.173 0 0 1 1.172 1.172v13.453H1.406zm21.188 18.844a1.173 1.173 0 0 1-1.172 1.172H2.578a1.173 1.173 0 0 1-1.172-1.172v-3.984h21.188z"
                                                class="cls-3" data-name="Path 170" />
                                            <path id="Path_171"
                                                d="M3.563 20.719h9.609v.234a.7.7 0 0 0 1.406 0v-.234h5.859a.7.7 0 0 0 0-1.406h-5.859v-.234a.7.7 0 0 0-1.406 0v.234H3.563a.7.7 0 0 0 0 1.406z"
                                                class="cls-3" data-name="Path 171" />
                                            <path id="Path_172"
                                                d="M20.167 6.122L12.2 3.779a.7.7 0 0 0-.4 0L3.833 6.122a.7.7 0 0 0 0 1.349l2.777.817v3.665a.7.7 0 0 0 .7.7h9.375a.7.7 0 0 0 .7-.7V8.288l1.875-.551v3.279a.7.7 0 0 0 1.406 0V6.8a.7.7 0 0 0-.499-.678zm-4.183 5.128H8.016V8.7L11.8 9.815a.7.7 0 0 0 .4 0L15.984 8.7zM12 8.408L6.523 6.8 12 5.186 17.477 6.8z"
                                                class="cls-3" data-name="Path 172" />
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            <span class="font-14 text-dark-blue font-weight-500">Writing</span>
                        </a>

                        <div class="collapse <?php if ($active_bar == 'swtx' || $active_bar == 'essays' || $active_bar == 'email') {
                            echo 'show';
                        } ?>" id="meetingCollapse">
                            <ul class="sidenav-item-collapse">
                                <li class="mt-5 <?php if ($active_bar == "swtx") {
                                    echo "active";
                                } ?>">
                                    <a href="<?php echo base_url(); ?>user/swtx">Summarize Written Text <span
                                            class="aiscore"> AI Score </span></a>
                                </li>
                                <!-- Condition that checks the value of pte , if it is academic it will show essay -->
                                <?php if ($this->session->userdata('pte_type') == PTEACADEMIC) { ?>
                                    <li class="mt-5 <?php if ($active_bar == "essays") {
                                        echo "active";
                                    } ?>">
                                        <a href="<?php echo base_url(); ?>user/essays ">Write Essay <span class="aiscore"> AI
                                                Score </span></a>
                                    </li>
                                <?php } ?>
                                <!-- Condition that checks the value of pte , if it is core it will show email -->
                                <?php if ($this->session->userdata('pte_type') == PTECORE) { ?>
                                    <li class="mt-5 <?php if ($active_bar == "email") {
                                        echo "active";
                                    } ?>">
                                        <a href="<?php echo base_url(); ?>user/email">Write Email <span class="aiscore"> AI
                                                Score </span></a>
                                    </li>
                                <?php } ?>
                            </ul>


                        </div>
                    </li>

                    <li class="sidenav-item <?php if ($active_bar == 'fib_wr' || $active_bar == 'ro' || $active_bar == 'fib_rd' || $active_bar == 'r_mcm' || $active_bar == 'r_mcs') {
                        echo 'sidenav-item-active';
                    } ?>">
                        <a class="d-flex align-items-center" data-toggle="collapse" href="#certificatesCollapse"
                            role="button" aria-expanded="false" aria-controls="certificatesCollapse">
                            <span class="sidenav-item-icon mr-10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <defs>
                                        <clipPath id="clip-path">
                                            <path id="Rectangle_204" fill="#1f3b64" stroke="#707070" d="M0 0H24V24H0z"
                                                data-name="Rectangle 204" transform="translate(25 410)" />
                                        </clipPath>
                                    </defs>
                                    <g id="Mask_Group_19" clip-path="url(#clip-path)" data-name="Mask Group 19"
                                        transform="translate(-25 -410)">
                                        <g id="reward" transform="translate(25 410)">
                                            <g id="Group_183" data-name="Group 183">
                                                <g id="Group_182" data-name="Group 182">
                                                    <path id="Path_163"
                                                        d="M16.423 5.789a7.668 7.668 0 0 0-1.478-.824l-.59 1.406a6.165 6.165 0 0 1 1.181.659z"
                                                        class="cls-3" data-name="Path 163" />
                                                    <path id="Path_164"
                                                        d="M18.665 8.291a7.619 7.619 0 0 0-.982-1.373l-1.136 1.018a6.177 6.177 0 0 1 .786 1.1z"
                                                        class="cls-3" data-name="Path 164" />
                                                    <path id="Path_165"
                                                        d="M17.855 10.28a6.092 6.092 0 1 1-4.794-4.29l.263-1.5A7.81 7.81 0 0 0 12 4.374a7.618 7.618 0 1 0 7.321 5.479z"
                                                        class="cls-3" data-name="Path 165" />
                                                    <path id="Path_166"
                                                        d="M24 12l-1.954-2.692L22.393 6l-3.038-1.355L18 1.607l-3.308.347L12 0 9.308 1.954 6 1.607 4.645 4.645 1.607 6l.347 3.308L0 12l1.954 2.692L1.607 18l3.038 1.354L6 22.393l3.308-.347L12 24l2.692-1.954 3.308.347 1.354-3.038L22.393 18l-.347-3.308zm-5.8 6.2l-1.145 2.56-2.785-.3L12 22.116l-2.27-1.651-2.788.292L5.8 18.2l-2.563-1.148.3-2.782L1.884 12l1.651-2.27-.3-2.788L5.8 5.8l1.145-2.563 2.788.292L12 1.884l2.27 1.651 2.788-.292L18.2 5.8l2.562 1.144-.3 2.782L22.116 12l-1.651 2.27.292 2.788z"
                                                        class="cls-3" data-name="Path 166" />
                                                    <path id="Path_167"
                                                        d="M8.726 11.461l-1.078 1.078 2.827 2.827 5.115-5.115-1.079-1.078-4.036 4.037z"
                                                        class="cls-3" data-name="Path 167" />
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            <span class="font-14 text-dark-blue font-weight-500">Reading</span>
                        </a>

                        <div class="collapse <?php if ($active_bar == 'fib_wr' || $active_bar == 'ro' || $active_bar == 'fib_rd' || $active_bar == 'r_mcm' || $active_bar == 'r_mcs') {
                            echo 'show';
                        } ?>" id="certificatesCollapse">
                            <ul class="sidenav-item-collapse">

                                <li class="mt-5 <?php if ($active_bar == 'fib_wr') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/fib_wr"> Reading & Writing：Fill in the blanks
                                    </a>
                                </li>

                                <li class="mt-5 <?php if ($active_bar == 'r_mcm') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/r_mcm"> Multiple Choice (Multiple) </a>
                                </li>

                                <li class="mt-5 <?php if ($active_bar == 'ro') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/ro"> Re-order Paragraphs </a>
                                </li>
                                <li class="mt-5 <?php if ($active_bar == 'fib_rd') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/fib_rd"> Reading：Fill in the Blanks </a>
                                </li>
                                <li class="mt-5 <?php if ($active_bar == 'r_mcs') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/r_mcs"> Multiple Choice (Single) </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <li class="sidenav-item <?php if (in_array($active_bar, ['ssts', 'l_mcm', 'l_mcs', 'l_fib', 'l_hcs', 'l_smw', 'hiws', 'wfds'])) {
                        echo 'sidenav-item-active';
                    } ?>">
                        <a class="d-flex align-items-center" data-toggle="collapse" href="#listeningCollapse" role="button"
                            aria-expanded="false" aria-controls="listeningCollapse">
                            <span class="sidenav-item-icon mr-10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <defs>
                                        <clipPath id="clip-path">
                                            <path id="Rectangle_204" fill="#1f3b64" stroke="#707070" d="M0 0H24V24H0z"
                                                data-name="Rectangle 204" transform="translate(25 410)" />
                                        </clipPath>
                                    </defs>
                                    <g id="Mask_Group_18" clip-path="url(#clip-path)" data-name="Mask Group 18"
                                        transform="translate(-25 -410)">
                                        <g id="reward" transform="translate(25 410)">
                                            <g id="Group_183" data-name="Group 183">
                                                <g id="Group_182" data-name="Group 182">
                                                    <path id="Path_163"
                                                        d="M16.423 5.789a7.668 7.668 0 0 0-1.478-.824l-.59 1.406a6.165 6.165 0 0 1 1.181.659z"
                                                        class="cls-3" data-name="Path 163" />
                                                    <path id="Path_164"
                                                        d="M18.665 8.291a7.619 7.619 0 0 0-.982-1.373l-1.136 1.018a6.177 6.177 0 0 1 .786 1.1z"
                                                        class="cls-3" data-name="Path 164" />
                                                    <path id="Path_165"
                                                        d="M17.855 10.28a6.092 6.092 0 1 1-4.794-4.29l.263-1.5A7.81 7.81 0 0 0 12 4.374a7.618 7.618 0 1 0 7.321 5.479z"
                                                        class="cls-3" data-name="Path 165" />
                                                    <path id="Path_166"
                                                        d="M24 12l-1.954-2.692L22.393 6l-3.038-1.355L18 1.607l-3.308.347L12 0 9.308 1.954 6 1.607 4.645 4.645 1.607 6l.347 3.308L0 12l1.954 2.692L1.607 18l3.038 1.354L6 22.393l3.308-.347L12 24l2.692-1.954 3.308.347 1.354-3.038L22.393 18l-.347-3.308zm-5.8 6.2l-1.145 2.56-2.785-.3L12 22.116l-2.27-1.651-2.788.292L5.8 18.2l-2.563-1.148.3-2.782L1.884 12l1.651-2.27-.3-2.788L5.8 5.8l1.145-2.563 2.788.292L12 1.884l2.27 1.651 2.788-.292L18.2 5.8l2.562 1.144-.3 2.782L22.116 12l-1.651 2.27.292 2.788z"
                                                        class="cls-3" data-name="Path 166" />
                                                    <path id="Path_167"
                                                        d="M8.726 11.461l-1.078 1.078 2.827 2.827 5.115-5.115-1.079-1.078-4.036 4.037z"
                                                        class="cls-3" data-name="Path 167" />
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            <span class="font-14 text-dark-blue font-weight-500">Listening</span>
                        </a>

                        <div class="collapse <?php if (in_array($active_bar, ['ssts', 'l_mcm', 'l_mcs', 'l_fib', 'l_hcs', 'l_smw', 'hiws', 'wfds'])) {
                            echo 'show';
                        } ?>" id="listeningCollapse">
                            <ul class="sidenav-item-collapse">

                                <li class="mt-5 <?php if ($active_bar == 'ssts') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/ssts"> Summarize Spoken Text <span
                                            class="aiscore"> AI Score </span> </a>
                                </li>

                                <li class="mt-5 <?php if ($active_bar == 'l_mcm') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/l_mcm"> Multiple Choice (Multiple) </a>
                                </li>

                                <li class="mt-5 <?php if ($active_bar == 'l_fib') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/l_fib"> Fill in the Blanks </a>
                                </li>
                                <?php if ($this->session->userdata('pte_type') == PTEACADEMIC) { ?>
                                <li class="mt-5 <?php if ($active_bar == 'l_hcs') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/l_hcs"> Highlight Correct Summary </a>
                                </li>
                                <?php } ?>
                                <li class="mt-5 <?php if ($active_bar == 'l_mcs') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/l_mcs">Multiple Choice (Single) </a>
                                </li>
                                <li class="mt-5 <?php if ($active_bar == 'l_smw') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/l_smw"> Select Missing Word </a>
                                </li>
                                <li class="mt-5 <?php if ($active_bar == 'hiws') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/hiws">Highlight Incorrect Words </a>
                                </li>
                                <li class="mt-5 <?php if ($active_bar == 'wfds') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url() ?>user/wfds">Write From Dictation </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <?php if ($this->session->userdata('show_videos')  && $this->session->userdata('pte_type') == PTEACADEMIC ) {  ?>
                        <li class="sidenav-item">
                            <a href="<?php echo base_url(); ?>user/studyvideos" class="d-flex align-items-center">
                                <span class="sidenav-item-icon mr-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <defs>
                                            <clipPath id="clip-path">
                                                <path id="Rectangle_204" fill="#1f3b64" stroke="#707070" d="M0 0H24V24H0z"
                                                    data-name="Rectangle 204" transform="translate(25 410)" />
                                            </clipPath>
                                        </defs>
                                        <g id="Mask_Group_19" clip-path="url(#clip-path)" data-name="Mask Group 19"
                                            transform="translate(-25 -410)">
                                            <g id="reward" transform="translate(25 410)">
                                                <g id="Group_183" data-name="Group 183">
                                                    <g id="Group_182" data-name="Group 182">
                                                        <path id="Path_163"
                                                            d="M16.423 5.789a7.668 7.668 0 0 0-1.478-.824l-.59 1.406a6.165 6.165 0 0 1 1.181.659z"
                                                            class="cls-3" data-name="Path 163" />
                                                        <path id="Path_164"
                                                            d="M18.665 8.291a7.619 7.619 0 0 0-.982-1.373l-1.136 1.018a6.177 6.177 0 0 1 .786 1.1z"
                                                            class="cls-3" data-name="Path 164" />
                                                        <path id="Path_165"
                                                            d="M17.855 10.28a6.092 6.092 0 1 1-4.794-4.29l.263-1.5A7.81 7.81 0 0 0 12 4.374a7.618 7.618 0 1 0 7.321 5.479z"
                                                            class="cls-3" data-name="Path 165" />
                                                        <path id="Path_166"
                                                            d="M24 12l-1.954-2.692L22.393 6l-3.038-1.355L18 1.607l-3.308.347L12 0 9.308 1.954 6 1.607 4.645 4.645 1.607 6l.347 3.308L0 12l1.954 2.692L1.607 18l3.038 1.354L6 22.393l3.308-.347L12 24l2.692-1.954 3.308.347 1.354-3.038L22.393 18l-.347-3.308zm-5.8 6.2l-1.145 2.56-2.785-.3L12 22.116l-2.27-1.651-2.788.292L5.8 18.2l-2.563-1.148.3-2.782L1.884 12l1.651-2.27-.3-2.788L5.8 5.8l1.145-2.563 2.788.292L12 1.884l2.27 1.651 2.788-.292L18.2 5.8l2.562 1.144-.3 2.782L22.116 12l-1.651 2.27.292 2.788z"
                                                            class="cls-3" data-name="Path 166" />
                                                        <path id="Path_167"
                                                            d="M8.726 11.461l-1.078 1.078 2.827 2.827 5.115-5.115-1.079-1.078-4.036 4.037z"
                                                            class="cls-3" data-name="Path 167" />
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
                                <span class="font-14 text-dark-blue font-weight-500">Study Videos</span>
                                <svg class="ml-0" width="24px" height="24px" viewBox="0 0 400 400"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="translate(200,200)">
                                        <circle id="core" cx="0" cy="0" r="30"></circle>
                                        <circle id="radar" cx="0" cy="0" r="30"></circle>
                                    </g>
                                </svg>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (!$this->session->userdata('show_videos') && $this->session->userdata('pte_type') == PTEACADEMIC) { ?>
                        <li class="sidenav-item">
                            <a href="<?php echo base_url(); ?>user/studyvideosfree" class="d-flex align-items-center">
                                <span class="sidenav-item-icon mr-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <defs>
                                            <clipPath id="clip-path">
                                                <path id="Rectangle_204" fill="#1f3b64" stroke="#707070" d="M0 0H24V24H0z"
                                                    data-name="Rectangle 204" transform="translate(25 410)" />
                                            </clipPath>
                                        </defs>
                                        <g id="Mask_Group_19" clip-path="url(#clip-path)" data-name="Mask Group 19"
                                            transform="translate(-25 -410)">
                                            <g id="reward" transform="translate(25 410)">
                                                <g id="Group_183" data-name="Group 183">
                                                    <g id="Group_182" data-name="Group 182">
                                                        <path id="Path_163"
                                                            d="M16.423 5.789a7.668 7.668 0 0 0-1.478-.824l-.59 1.406a6.165 6.165 0 0 1 1.181.659z"
                                                            class="cls-3" data-name="Path 163" />
                                                        <path id="Path_164"
                                                            d="M18.665 8.291a7.619 7.619 0 0 0-.982-1.373l-1.136 1.018a6.177 6.177 0 0 1 .786 1.1z"
                                                            class="cls-3" data-name="Path 164" />
                                                        <path id="Path_165"
                                                            d="M17.855 10.28a6.092 6.092 0 1 1-4.794-4.29l.263-1.5A7.81 7.81 0 0 0 12 4.374a7.618 7.618 0 1 0 7.321 5.479z"
                                                            class="cls-3" data-name="Path 165" />
                                                        <path id="Path_166"
                                                            d="M24 12l-1.954-2.692L22.393 6l-3.038-1.355L18 1.607l-3.308.347L12 0 9.308 1.954 6 1.607 4.645 4.645 1.607 6l.347 3.308L0 12l1.954 2.692L1.607 18l3.038 1.354L6 22.393l3.308-.347L12 24l2.692-1.954 3.308.347 1.354-3.038L22.393 18l-.347-3.308zm-5.8 6.2l-1.145 2.56-2.785-.3L12 22.116l-2.27-1.651-2.788.292L5.8 18.2l-2.563-1.148.3-2.782L1.884 12l1.651-2.27-.3-2.788L5.8 5.8l1.145-2.563 2.788.292L12 1.884l2.27 1.651 2.788-.292L18.2 5.8l2.562 1.144-.3 2.782L22.116 12l-1.651 2.27.292 2.788z"
                                                            class="cls-3" data-name="Path 166" />
                                                        <path id="Path_167"
                                                            d="M8.726 11.461l-1.078 1.078 2.827 2.827 5.115-5.115-1.079-1.078-4.036 4.037z"
                                                            class="cls-3" data-name="Path 167" />
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
                                <span class="font-14 text-dark-blue font-weight-500">Study Videos</span>
                                <svg class="ml-0" width="24px" height="24px" viewBox="0 0 400 400"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="translate(200,200)">
                                        <circle id="core" cx="0" cy="0" r="30"></circle>
                                        <circle id="radar" cx="0" cy="0" r="30"></circle>
                                    </g>
                                </svg>
                            </a>
                        </li>
                    <?php } ?>


                    <li class="sidenav-item <?php if ($active_bar == 'myattempts' || $active_bar == 'mocktestlist') {
                        echo 'sidenav-item-active';
                    } ?>">
                        <a class="d-flex align-items-center" data-toggle="collapse" href="#supportCollapse" role="button"
                            aria-expanded="false" aria-controls="supportCollapse">
                            <span class="sidenav-item-icon assign-fill mr-10">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                                    width="512" height="512" x="0" y="0" viewBox="0 0 512 512"
                                    style="enable-background:new 0 0 512 512" xml:space="preserve">
                                    <g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path
                                                    d="M437.02,74.98C388.667,26.629,324.38,0,256,0S123.333,26.629,74.98,74.98C26.629,123.333,0,187.62,0,256    s26.629,132.667,74.98,181.02C123.333,485.371,187.62,512,256,512s132.667-26.629,181.02-74.98    C485.371,388.667,512,324.38,512,256S485.371,123.333,437.02,74.98z M256,30c56.921,0,108.988,21.161,148.767,56.019    l-69.813,69.813c-21.736-17.169-49.168-27.43-78.954-27.43c-29.785,0-57.218,10.261-78.953,27.43l-69.813-69.813    C147.012,51.161,199.079,30,256,30z M353.598,256c0,53.816-43.782,97.598-97.598,97.598c-53.816,0-97.598-43.782-97.598-97.598    c0-53.816,43.782-97.598,97.598-97.598C309.816,158.402,353.598,202.184,353.598,256z M30,256    c0-56.922,21.162-108.989,56.021-148.768l69.813,69.813c-17.17,21.736-27.432,49.169-27.432,78.956    c0,29.785,10.261,57.218,27.43,78.954l-69.813,69.813C51.161,364.988,30,312.921,30,256z M256,482    c-56.922,0-108.989-21.162-148.769-56.021l69.813-69.813c21.736,17.17,49.169,27.431,78.955,27.431s57.219-10.261,78.956-27.432    l69.813,69.813C364.989,460.838,312.922,482,256,482z M425.981,404.766l-69.813-69.813c17.169-21.736,27.43-49.168,27.43-78.953    c0-29.786-10.261-57.219-27.431-78.955l69.813-69.813C460.838,147.011,482,199.078,482,256    C482,312.921,460.839,364.988,425.981,404.766z"
                                                    fill="#000000" data-original="#000000"></path>
                                            </g>
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            <span class="font-14 text-dark-blue font-weight-500">Mock Test</span>
                        </a>

                        <div class="collapse <?php if ($active_bar == 'myattempts' || $active_bar == 'mocktestlist') {
                            echo 'show';
                        } ?>" id="supportCollapse">
                            <ul class="sidenav-item-collapse">
                                <li class="mt-5 <?php if ($active_bar == 'myattempts') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url(); ?>mock/myattempts">My Attempts</a>
                                </li>
                                <li class="mt-5 <?php if ($active_bar == 'mocktestlist') {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo base_url(); ?>mock/mocktestlist">Take Test</a>
                                </li>

                            </ul>
                        </div>
                    </li>


                    <?php if ($this->session->userdata('show_materials')) { ?>
                        <li class="sidenav-item">
                            <a href="<?php echo base_url(); ?>user/studymaterials" class="d-flex align-items-center">
                                <span class="sidenav-item-icon mr-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <defs>
                                            <clipPath id="clip-path">
                                                <path id="Rectangle_204" fill="#1f3b64" stroke="#707070" d="M0 0H24V24H0z"
                                                    data-name="Rectangle 204" transform="translate(25 410)" />
                                            </clipPath>
                                        </defs>
                                        <g id="Mask_Group_19" clip-path="url(#clip-path)" data-name="Mask Group 19"
                                            transform="translate(-25 -410)">
                                            <g id="reward" transform="translate(25 410)">
                                                <g id="Group_183" data-name="Group 183">
                                                    <g id="Group_182" data-name="Group 182">
                                                        <path id="Path_163"
                                                            d="M16.423 5.789a7.668 7.668 0 0 0-1.478-.824l-.59 1.406a6.165 6.165 0 0 1 1.181.659z"
                                                            class="cls-3" data-name="Path 163" />
                                                        <path id="Path_164"
                                                            d="M18.665 8.291a7.619 7.619 0 0 0-.982-1.373l-1.136 1.018a6.177 6.177 0 0 1 .786 1.1z"
                                                            class="cls-3" data-name="Path 164" />
                                                        <path id="Path_165"
                                                            d="M17.855 10.28a6.092 6.092 0 1 1-4.794-4.29l.263-1.5A7.81 7.81 0 0 0 12 4.374a7.618 7.618 0 1 0 7.321 5.479z"
                                                            class="cls-3" data-name="Path 165" />
                                                        <path id="Path_166"
                                                            d="M24 12l-1.954-2.692L22.393 6l-3.038-1.355L18 1.607l-3.308.347L12 0 9.308 1.954 6 1.607 4.645 4.645 1.607 6l.347 3.308L0 12l1.954 2.692L1.607 18l3.038 1.354L6 22.393l3.308-.347L12 24l2.692-1.954 3.308.347 1.354-3.038L22.393 18l-.347-3.308zm-5.8 6.2l-1.145 2.56-2.785-.3L12 22.116l-2.27-1.651-2.788.292L5.8 18.2l-2.563-1.148.3-2.782L1.884 12l1.651-2.27-.3-2.788L5.8 5.8l1.145-2.563 2.788.292L12 1.884l2.27 1.651 2.788-.292L18.2 5.8l2.562 1.144-.3 2.782L22.116 12l-1.651 2.27.292 2.788z"
                                                            class="cls-3" data-name="Path 166" />
                                                        <path id="Path_167"
                                                            d="M8.726 11.461l-1.078 1.078 2.827 2.827 5.115-5.115-1.079-1.078-4.036 4.037z"
                                                            class="cls-3" data-name="Path 167" />
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
                                <span class="font-14 text-dark-blue font-weight-500">Study Materials</span>
                            </a>
                        </li>
                    <?php } ?>


                    <li class="sidenav-item <?php if ($active_bar == 'studycenter') {
                        echo 'sidenav-item-active';
                    } ?>">
                        <a href="<?php echo base_url(); ?>user/studycenter" class="d-flex align-items-center">
                            <span class="sidenav-setting-icon sidenav-item-icon mr-10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <g id="Mask_Group_24" clip-path="url(#clip-path)" data-name="Mask Group 24"
                                        transform="translate(-25 -410)">
                                        <g id="settings" transform="translate(25 410)">
                                            <path id="Path_177"
                                                d="M12.753 24h-1.506a2.212 2.212 0 0 1-2.209-2.209v-.51a9.689 9.689 0 0 1-1.5-.625l-.361.361a2.209 2.209 0 0 1-3.125 0l-1.07-1.064a2.209 2.209 0 0 1 0-3.125l.361-.361a9.69 9.69 0 0 1-.625-1.5h-.51A2.212 2.212 0 0 1 0 12.753v-1.506a2.212 2.212 0 0 1 2.209-2.209h.51a9.692 9.692 0 0 1 .625-1.5l-.361-.361a2.209 2.209 0 0 1 0-3.125l1.064-1.07a2.209 2.209 0 0 1 3.125 0l.361.361a9.7 9.7 0 0 1 1.5-.625v-.51A2.212 2.212 0 0 1 11.247 0h1.506a2.212 2.212 0 0 1 2.209 2.209v.51a9.689 9.689 0 0 1 1.5.625l.361-.361a2.209 2.209 0 0 1 3.125 0l1.065 1.065a2.209 2.209 0 0 1 0 3.125l-.361.361a9.69 9.69 0 0 1 .625 1.5h.51A2.212 2.212 0 0 1 24 11.247v1.506a2.212 2.212 0 0 1-2.209 2.209h-.51a9.692 9.692 0 0 1-.625 1.5l.361.361a2.209 2.209 0 0 1 0 3.125l-1.065 1.065a2.209 2.209 0 0 1-3.125 0l-.361-.361a9.7 9.7 0 0 1-1.5.625v.51A2.212 2.212 0 0 1 12.753 24zm-4.985-4.82a8.288 8.288 0 0 0 2.148.892.7.7 0 0 1 .527.681v1.038a.8.8 0 0 0 .8.8h1.506a.8.8 0 0 0 .8-.8v-1.039a.7.7 0 0 1 .527-.681 8.288 8.288 0 0 0 2.148-.892.7.7 0 0 1 .855.108l.735.735a.8.8 0 0 0 1.135 0l1.065-1.065a.8.8 0 0 0 0-1.136l-.736-.736a.7.7 0 0 1-.108-.855 8.287 8.287 0 0 0 .892-2.148.7.7 0 0 1 .681-.527h1.038a.8.8 0 0 0 .8-.8v-1.508a.8.8 0 0 0-.8-.8h-1.028a.7.7 0 0 1-.681-.527 8.288 8.288 0 0 0-.892-2.148.7.7 0 0 1 .108-.855l.735-.735a.8.8 0 0 0 0-1.136l-1.065-1.069a.8.8 0 0 0-1.136 0l-.736.736a.7.7 0 0 1-.855.108 8.288 8.288 0 0 0-2.148-.892.7.7 0 0 1-.527-.681V2.209a.8.8 0 0 0-.8-.8h-1.509a.8.8 0 0 0-.8.8v1.039a.7.7 0 0 1-.527.681 8.288 8.288 0 0 0-2.148.892.7.7 0 0 1-.855-.108l-.735-.735a.8.8 0 0 0-1.135 0l-1.07 1.064a.8.8 0 0 0 0 1.136l.736.736a.7.7 0 0 1 .108.855 8.287 8.287 0 0 0-.892 2.148.7.7 0 0 1-.681.527H2.209a.8.8 0 0 0-.8.8v1.506a.8.8 0 0 0 .8.8h1.039a.7.7 0 0 1 .681.527 8.288 8.288 0 0 0 .892 2.148.7.7 0 0 1-.108.855l-.735.735a.8.8 0 0 0 0 1.136l1.065 1.065a.8.8 0 0 0 1.136 0l.736-.736a.706.706 0 0 1 .855-.108z"
                                                class="cls-3" data-name="Path 177" />
                                            <path id="Path_178"
                                                d="M12 17.222A5.222 5.222 0 1 1 17.222 12 5.228 5.228 0 0 1 12 17.222zm0-9.038A3.816 3.816 0 1 0 15.816 12 3.82 3.82 0 0 0 12 8.184z"
                                                class="cls-3" data-name="Path 178" />
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            <span class="font-14 text-dark-blue font-weight-500">Study Center</span>
                        </a>
                    </li>


                    <li class="sidenav-item <?php if ($active_bar == 'package' || $active_bar == 'subscriptions') {
                        echo 'sidenav-item-active';
                    } ?>">
                        <a href="#myPurchaseCollapse" role="button" aria-expanded="false" aria-controls="myPurchaseCollapse"
                            class="d-flex align-items-center" data-toggle="collapse">
                            <span class="sidenav-item-icon mr-10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <defs>
                                        <clipPath id="clip-path">
                                            <path id="Rectangle_204" fill="#1f3b64" stroke="#707070" d="M0 0H24V24H0z"
                                                data-name="Rectangle 204" transform="translate(25 410)" />
                                        </clipPath>
                                    </defs>
                                    <g id="Mask_Group_19" clip-path="url(#clip-path)" data-name="Mask Group 19"
                                        transform="translate(-25 -410)">
                                        <g id="reward" transform="translate(25 410)">
                                            <g id="Group_183" data-name="Group 183">
                                                <g id="Group_182" data-name="Group 182">
                                                    <path id="Path_163"
                                                        d="M16.423 5.789a7.668 7.668 0 0 0-1.478-.824l-.59 1.406a6.165 6.165 0 0 1 1.181.659z"
                                                        class="cls-3" data-name="Path 163" />
                                                    <path id="Path_164"
                                                        d="M18.665 8.291a7.619 7.619 0 0 0-.982-1.373l-1.136 1.018a6.177 6.177 0 0 1 .786 1.1z"
                                                        class="cls-3" data-name="Path 164" />
                                                    <path id="Path_165"
                                                        d="M17.855 10.28a6.092 6.092 0 1 1-4.794-4.29l.263-1.5A7.81 7.81 0 0 0 12 4.374a7.618 7.618 0 1 0 7.321 5.479z"
                                                        class="cls-3" data-name="Path 165" />
                                                    <path id="Path_166"
                                                        d="M24 12l-1.954-2.692L22.393 6l-3.038-1.355L18 1.607l-3.308.347L12 0 9.308 1.954 6 1.607 4.645 4.645 1.607 6l.347 3.308L0 12l1.954 2.692L1.607 18l3.038 1.354L6 22.393l3.308-.347L12 24l2.692-1.954 3.308.347 1.354-3.038L22.393 18l-.347-3.308zm-5.8 6.2l-1.145 2.56-2.785-.3L12 22.116l-2.27-1.651-2.788.292L5.8 18.2l-2.563-1.148.3-2.782L1.884 12l1.651-2.27-.3-2.788L5.8 5.8l1.145-2.563 2.788.292L12 1.884l2.27 1.651 2.788-.292L18.2 5.8l2.562 1.144-.3 2.782L22.116 12l-1.651 2.27.292 2.788z"
                                                        class="cls-3" data-name="Path 166" />
                                                    <path id="Path_167"
                                                        d="M8.726 11.461l-1.078 1.078 2.827 2.827 5.115-5.115-1.079-1.078-4.036 4.037z"
                                                        class="cls-3" data-name="Path 167" />
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            <span class="font-14 text-dark-blue font-weight-500">Purchase</span>
                            <svg class="ml-0" width="24px" height="24px" viewBox="0 0 400 400"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g transform="translate(200,200)">
                                    <circle id="core" cx="0" cy="0" r="30"></circle>
                                    <circle id="radar" cx="0" cy="0" r="30"></circle>

                                </g>
                            </svg>
                            <div class="collapse <?php if ($active_bar == 'package' || $active_bar == 'subscriptions') {
                                echo 'show';
                            } ?>" id="myPurchaseCollapse">
                                <ul class="sidenav-item-collapse">
                                    <li class="mt-5 <?php if ($active_bar == 'package') {
                                        echo 'active';
                                    } ?>">
                                        <a href="<?php echo base_url() ?>user/package">Buy Now
                                        </a>
                                    </li>

                                    <li class="mt-5 <?php if ($active_bar == 'subscriptions') {
                                        echo 'active';
                                    } ?>">
                                        <a href="<?php echo base_url() ?>user/subscriptions"> My Subscriptions </a>
                                    </li>
                                </ul>
                            </div>
                    </li>
                    </a>
                    </li>

                    <li class="sidenav-item <?php if ($active_bar == 'search') {
                        echo 'sidenav-item-active';
                    } ?>">
                        <a href="<?php echo base_url(); ?>user/search" class="d-flex align-items-center">
                            <span class="sidenav-setting-icon sidenav-item-icon mr-10">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100"
                                    viewBox="0,0,256,256">
                                    <g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1"
                                        stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10"
                                        stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none"
                                        font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                        <g transform="scale(5.12,5.12)">
                                            <path
                                                d="M21,3c-9.39844,0 -17,7.60156 -17,17c0,9.39844 7.60156,17 17,17c3.35547,0 6.46094,-0.98437 9.09375,-2.65625l12.28125,12.28125l4.25,-4.25l-12.125,-12.09375c2.17969,-2.85937 3.5,-6.40234 3.5,-10.28125c0,-9.39844 -7.60156,-17 -17,-17zM21,7c7.19922,0 13,5.80078 13,13c0,7.19922 -5.80078,13 -13,13c-7.19922,0 -13,-5.80078 -13,-13c0,-7.19922 5.80078,-13 13,-13z">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            <span class="font-14 text-dark-blue font-weight-500">Search</span>
                        </a>
                    </li>


                    <li class="sidenav-item">
                        <a href="<?php echo base_url(); ?>user/logout" class="d-flex align-items-center">
                            <span class="sidenav-logout-icon sidenav-item-icon mr-10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23.999" height="23.999"
                                    viewBox="0 0 23.999 23.999">
                                    <g id="Group_1263" transform="translate(-161.102 -869.102)">
                                        <g id="power-button" transform="translate(161.102 869.102)">
                                            <path id="Path_1541"
                                                d="M20.473 3.526a11.984 11.984 0 1 0 0 16.947 11.945 11.945 0 0 0 0-16.947zM12 22.591A10.591 10.591 0 1 1 22.591 12 10.6 10.6 0 0 1 12 22.591z"
                                                class="cls-1" />
                                            <path id="Path_1542"
                                                d="M153.7 168.953a.7.7 0 0 0-.93 1.047 3.8 3.8 0 1 1-5.016-.019.7.7 0 1 0-.925-1.058 5.2 5.2 0 1 0 6.875.025z"
                                                class="cls-1" transform="translate(-138.252 -160.845)" />
                                            <path id="Path_1543"
                                                d="M241.753 126.205a.7.7 0 0 0 .7-.7v-3.749a.7.7 0 1 0-1.406 0v3.744a.7.7 0 0 0 .706.705z"
                                                class="cls-1" transform="translate(-229.754 -115.378)" />
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            <span class="font-14 text-dark-blue font-weight-500">Log out</span>
                        </a>
                    </li>
                </ul>


            </div>
        <?php } ?>

        <div class="panel-content">
            <?php $this->load->view($subview); ?>

        </div>
    </div>
    <!--practice sidetoggle content-->

    <?php
    $show_search_sidebar = false;
    if ($active_bar && in_array($active_bar, ['read_alouds', 'repeat_sentences', 'respond_situation', 'describe_images', 'retell_lectures', 'answer_questions', 'fib_wr', 'fib_rd', 'r_mcm', 'r_mcs', 'ro', 'swtx', 'essays', 'email', 'ssts', 'wfds', 'l_mcm', 'l_mcs', 'l_hcs', 'l_smw', 'l_fib', 'hiws'])) {
        $show_search_sidebar = true;
        $category = getCategoryDataByCode($active_bar);
    }
    ?>
    <!--practice sidetoggle content-->
    <?php if ($show_search_sidebar) { ?>
        <div class="sidetoggle-wrapper" id="sidetoggleBtn">
            <div class="sidetoggle-bgshadow"></div>
            <div class="sidetoggle-body">
                <div class="sidetoggle-content-wrapper">
                    <div class="sidetoggle-sec">
                        <div class="sidetoggle-btn" onclick=toggleSidebar()>
                            <i class="fa fa-angle-right"></i>
                        </div>
                    </div>
                    <div class="sidetoggle-content-body">
                        <div class="sidetoggle-content-header">
                            <div class="title">
                                <h1 class="section-title">
                                    <?php echo $category['name']; ?>
                                </h1>
                            </div>
                            <div class="sidetoggle-search">
                                <form method="get" action="<?php echo base_url('user/search'); ?>" id="search-question" class="border">
                                    <input type="hidden" name="type" value="<?php echo $active_bar; ?>">
                                    <input type="text" name="text" placeholder="Question Content / Number"
                                        data-type="<?php echo $active_bar; ?>" class="form-control">
                                    <a href="javascript:void(0);" class="search-icon"
                                        onclick="document.getElementById('search-question').submit();">
                                        <!-- <div > -->
                                        <i class="fa fa-search"></i>
                                        <!-- </div> -->
                                    </a>
                                </form>
                            </div>
                        </div>
                        <div class="sidetoggle-content">
                            <div class="form-group col-lg-3 pb-20">
                                <label class="input-label">Practice Status</label><br>
                                <select id="practicestatus" class="form-control">
                                    <option></option>
                                    <option value="practiced">Practiced</option>
                                    <option value="unpracticed">Unpracticed</option>
                                </select>
                            </div>
                            <small>Found <span id="questions-found">0</span> Questions</small>
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="table-responsive">
                                        <table class="table custom-table" data-type="<?php echo $active_bar; ?>"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <!--practice sidetoggle content ends-->
    </div>

    <!-- Feedback -->
    <div class="modal fade" id="feedback-modal" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Report issue</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <form id="feedback-form" action="<?php echo base_url(); ?>feedback/add" method="POST">
                    <input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                        value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="modal-body">
                        <textarea class="form-control font-weight-light line-height-1 report-text" cols="40" rows="4"
                            name="feedback" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary light" id="submit-feedback">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- redeem coupon -->
    <div class="modal fade" id="reedem-coupon-modal" role="dialog" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body" style="border: 2px solid #000;">
                            <div class="svgdata text-center mt-3 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 90" xml:space="preserve" width="90" height="90"><path d="M56.998 31.939H26.475V18.596c0-6.336 5.155-11.49 11.491-11.49s11.491 5.155 11.491 11.491v3.632a3.552 3.552 0 0 0 7.105 0v-3.633C56.563 8.342 48.221 0 37.967 0S19.371 8.342 19.371 18.596v13.342h-.436c-5.415 0-9.822 4.406-9.822 9.822v37.98c0 5.657 4.602 10.259 10.259 10.259H56.56c5.657 0 10.259-4.603 10.259-10.259V41.76c0-5.415-4.406-9.822-9.822-9.822m2.718 47.802a3.156 3.156 0 0 1-3.154 3.154H19.372a3.156 3.156 0 0 1-3.154-3.154V41.76a2.72 2.72 0 0 1 2.716-2.716h38.063a2.72 2.72 0 0 1 2.716 2.716z"/><path d="M37.967 47.761c-4.054 0-7.35 3.298-7.35 7.35a7.36 7.36 0 0 0 3.798 6.431v9.081a3.552 3.552 0 0 0 7.105 0v-9.081a7.35 7.35 0 0 0 3.798-6.431c0-4.054-3.298-7.35-7.35-7.35m25.479-28.513a3.546 3.546 0 0 0 4.62-1.975l2.645-6.594a3.552 3.552 0 1 0-6.594-2.645l-2.645 6.594a3.555 3.555 0 0 0 1.975 4.62m4.087 4.377a3.56 3.56 0 0 0 3.269 2.156 3.5 3.5 0 0 0 1.395-.287l6.533-2.793a3.552 3.552 0 0 0-2.793-6.533l-6.533 2.793a3.555 3.555 0 0 0-1.87 4.664m11.011 6.655-6.594-2.645a3.552 3.552 0 1 0-2.645 6.594l6.594 2.645a3.546 3.546 0 0 0 4.62-1.975 3.555 3.555 0 0 0-1.975-4.62"/></svg>
                                
                                <h4>Unlock your Test</h4>
                            </div>
                    <form id="reedem-coupon-form" class="d-flex justify-content-center my-4" action="<?php echo base_url("coupons/reedem"); ?>" method="POST">
                        <div class="couponform text-center">
                            <input type="text" class="coupon-input form-control font-weight-light line-height-1 "
                                name="coupon_code" id="coupon-input" placeholder="Enter code here" required></input>
                            <button class="reedem-coupon-submit-btn" type="button"><i class="fas fa-lock-open"></i><input
                                    type="button" id="reedem-coupon-submit-btn" value="Submit" /></button>
    
                        </div>
                    </form>
                    <div class="my-3 font-18 bold text-center"><a href="javascript:void(0);" onClick="handleRedeemHelp();">Need
                            Help?</a>
                        <p class="text-dark">Download Applykart from</p>
                    </div>
                    <div class="d-flex justify-content-even align-items-center flex-wrap">
                        <a class="w-50" href="https://play.google.com/store/apps/details?id=com.applykart"><img class=""
                                src="<?php echo base_url() ?>assets/images/playstore.png" alt="play store"></a>
                        <a class="w-50" href="https://apps.apple.com/us/app/applykart/id1638867413"><img class=""
                                src="<?php echo base_url() ?>assets/images/appstore.png" alt="app store"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Template JS File -->
    <script src="<?php echo base_url() ?>assets/newlayout/assets/default/js/app.js"></script>
    <script src="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/moment.min.js"></script>
    <script
        src="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/feather-icons/dist/feather.min.js"></script>
    <script
        src="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/toast/jquery.toast.min.js"></script>
    <script type="text/javascript"
        src="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/simplebar/simplebar.min.js"></script>
    <?php if($this->session->userdata("switch_notify")){ ?>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <?php } ?>

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



    <script src="<?php echo base_url() ?>assets/js/script-chart.js"></script>
    <!-- <script src="<?php echo base_url() ?>assets/js/apexcharts.min.js"></script> -->
    <!-- <script src="<?php echo base_url() ?>assets/js/custom-apexcharts.js"></script> -->
    <!-- <script src="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/apexcharts/apexcharts.min.js"></script> -->
    <!-- <script src="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/chartjs/chart.min.js"></script> -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/newlayout/assets/vendors/fontawesome/css/all.min.css" />
    <!-- <script src="<?php echo base_url() ?>assets/newlayout/assets/default/js/panel/dashboard.min.js"></script> -->
    <script src="<?php echo base_url() ?>assets/newlayout/assets/default/js/parts/navbar.min.js"></script>
    <script src="<?php echo base_url() ?>assets/newlayout/assets/default/js//parts/main.min.js"></script>
    <script src="<?php echo base_url() ?>assets/newlayout/assets/default/js/panel/public.min.js"></script>


    <?php if ($show_search_sidebar) { ?>
        <script>
            const app_url = "<?php echo base_url(); ?>";
        </script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
        <script src="<?php echo base_url('assets/js/app/sidebar-search.js') ?>"></script>
    <?php } ?>
    <script type="text/javascript">
        let tagArr = document.getElementsByTagName("input");
        let textareas = document.getElementsByTagName("textarea");
        for (let i = 0; i < tagArr.length; i++) {
            tagArr[i].autocomplete = 'off';
            tagArr[i].spellcheck = false;
        }
        for (let i = 0; i < textareas.length; i++) {
            textareas[i].autocomplete = 'off';
            textareas[i].spellcheck = false;
        }

        $('[name="submit"],[name="submitbtn"]').click(function (e) {
            $('#app-loader').removeClass('d-none');
        });

        $('#feedback-form').submit(function (e) {
            e.preventDefault();
            $('#submit-feedback').addClass('disabled');
            let form = $('#feedback-form');
            let category = $('[name="task_details"').data('type');
            let questionid = $('[name="task_details"').data('questionid');

            $("<input />").attr("type", "hidden")
                .attr("name", "category")
                .attr("value", category)
                .appendTo(form);

            $("<input />").attr("type", "hidden")
                .attr("name", "questionid")
                .attr("value", questionid)
                .appendTo(form);

            var formData = new FormData($(form)[0]);
            $.ajax({
                url: $('#feedback-form').attr('action'),
                type: "POST",
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                data: formData,
            }).done(function (response) {
                $('#feedback-form .csrfToken').val(response.token);
                $.toast({
                    text: 'Issue reported',
                    bgColor: '#E8E8E7',
                    textColor: 'black',
                    hideAfter: 3000,
                    position: 'bottom-right',
                    stack: false,
                });
                $('#submit-feedback').removeClass('disabled');
                $('#feedback-form').trigger("reset");
                $('#feedback-modal').modal('hide');
            });
        });

        function alphaWhitespace(evt) {
            var inputValue = event.which;
            var inputText = evt.target.value;
            if (inputText.length > 50) {
                event.preventDefault();
            }
            if (!(inputValue >= 65 && inputValue <= 90) && !(inputValue >= 97 && inputValue <= 122) && (inputValue != 32 &&
                inputValue != 0)) {
                event.preventDefault();
            }
        }

        function addressalphaWhitespace(evt) {
            var inputValue = event.which;
            var inputText = evt.target.value;

            if (inputText.length > 800) {
                event.preventDefault();
            }
            if (!(inputValue >= 65 && inputValue <= 90) && !(inputValue >= 97 && inputValue <= 122) && (inputValue != 32 &&
                inputValue != 0) && (inputValue != 46 && inputValue != 44) && !(inputValue >= 48 && inputValue <= 59)) {
                event.preventDefault();
            }
        }

        function isNumberKey(evt) {
            var inputText = evt.target.value;
            if (inputText.length >= 10) {
                event.preventDefault();
            }
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                event.preventDefault();
            }
        }

        function NumberKey(evt) {
            var inputText = evt.target.value;
            if (inputText.length >= 10) {
                event.preventDefault();
            }
            var charCode = (evt.which) ? evt.which : event.keyCode;
            alert(charCode);
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                event.preventDefault();
            }
        }
        function toggleSidebar() {
            let sidebar = document.getElementById("sidetoggleBtn");
            if(sidebar) sidebar.classList.toggle('active');
        }

        function app_toastify(message) {
            Toastify({
                text: message,
                duration: 3000,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "center", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "#fff",
                    border: "1px solid #d5d5d5",
                    color: "#000"
                }
            }).showToast();
        }

        $(document).ready(function () {
            <?php if($this->session->userdata("switch_notify")){ ?>
                app_toastify("Switched to PTE <?php echo ucfirst($this->session->userdata('pte_type')); ?>");
            <?php $this->session->unset_userdata("switch_notify"); } ?>

            $lstorage = localStorage.getItem("activeBar");
            if ($lstorage == undefined || $lstorage != "<?php echo $active_bar; ?>") {
                localStorage.setItem("activeBar", "<?php echo $active_bar; ?>");
                toggleSidebar();
            }
        });

        function redeemcoupon(){
            $('#reedem-coupon-modal').modal('show');
        }


        document.getElementById("reedem-coupon-submit-btn").addEventListener("click", function (e) {
            const form = document.getElementById("reedem-coupon-form");
            const formData = new FormData(form);
            const formObject = Object.fromEntries(formData.entries());

            if(!formObject?.coupon_code) return false;
            handleredeemcoupon(formObject?.coupon_code);
        });

        function handleRedeemHelp(){
            Swal.fire({
                html: "<p style='line-height:1.7'><strong>Log in to your ApplyKart account to retrieve the code that will unlock your mock test. If you haven't registered yet, sign up now to get access!</strong></p>",
            });
        }

        function handleredeemcoupon(coupon){
            var csrfName = $('.csrfToken').attr('name');
            var csrfHash = $('.csrfToken').val(); // CSRF hash
            const form = document.getElementById("reedem-coupon-form");
            
            $.ajax({
                url: siteUrl + "coupons/redeem",
                type: "POST",
                crossDomain: true,
                dataType: 'json',
                cache: false,
                data: {[csrfName]: csrfHash, coupon: coupon},
                success: function (data) {
                    $('.csrfToken').val(data.token);
                    if(data.success == true){
                        Swal.fire("Coupon redeemed successfully. We will notify you once coupon is verified.","","success").then((action) => {
                            location.reload();
                        });
                    }else{
                        Swal.fire(data?.msg,"","info");
                    }
                },
                complete: function (){form.reset();}
            });
        }
    </script>

</body>

</html>