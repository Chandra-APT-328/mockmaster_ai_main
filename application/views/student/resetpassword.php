<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="SztBloXg1EMUk09jWzlC64BncCkMoaLSAmNFeH8d">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

     <!-- Title -->
     <title>Forgot Password</title>
        
    <!-- Fav Icon -->
    <link rel="icon" href="<?php echo base_url() ?>assets/images/one-aus-logo.png" />  
   
    <link rel="stylesheet" href="<?php echo base_url();?>assets/newlayout/assets/default/css/app.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/validate.min.js"></script> 
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

    .pace {
        -webkit-pointer-events: none;
        pointer-events: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    .pace-inactive {
        display: none;
    }

    .pace .pace-progress {
        background: #29d;
        position: fixed;
        z-index: 2000;
        top: 0;
        right: 100%;
        width: 100%;
        height: 2px;
    }

    .pace .pace-progress-inner {
        display: block;
        position: absolute;
        right: 0px;
        width: 100px;
        height: 100%;
        box-shadow: 0 0 10px #29d, 0 0 5px #29d;
        opacity: 1.0;
        -webkit-transform: rotate(3deg) translate(0px, -4px);
        -moz-transform: rotate(3deg) translate(0px, -4px);
        -ms-transform: rotate(3deg) translate(0px, -4px);
        -o-transform: rotate(3deg) translate(0px, -4px);
        transform: rotate(3deg) translate(0px, -4px);
    }

    .pace .pace-activity {
        display: block;
        position: fixed;
        z-index: 2000;
        top: 15px;
        right: 15px;
        width: 14px;
        height: 14px;
        border: solid 2px transparent;
        border-top-color: #29d;
        border-left-color: #29d;
        border-radius: 10px;
        -webkit-animation: pace-spinner 400ms linear infinite;
        -moz-animation: pace-spinner 400ms linear infinite;
        -ms-animation: pace-spinner 400ms linear infinite;
        -o-animation: pace-spinner 400ms linear infinite;
        animation: pace-spinner 400ms linear infinite;
    }

    .error{
        margin-top: 6px;
        margin-bottom: 0px;
        font-size: 12px;
        color: white;
    }

    @-webkit-keyframes pace-spinner {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-moz-keyframes pace-spinner {
        0% {
            -moz-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -moz-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-o-keyframes pace-spinner {
        0% {
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-ms-keyframes pace-spinner {
        0% {
            -ms-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -ms-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @keyframes pace-spinner {
        0% {
            transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    </style>
    
</head>

<body class="">

    <div id="app" class="" style="background-color: rgba(27,127,204,.8);">
        <div id="navbarVacuum"></div>
        <nav id="navbar" class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between w-100">

                <a class="navbar-brand navbar-order d-flex align-items-center justify-content-center mr-0 " href="/">
                    <img src="<?php echo base_url() ?>assets/images/one-aus-logo.png" class="img-cover" alt="site logo">
                </a>

                    <button class="navbar-toggler navbar-order" type="button" id="navbarToggle">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="mx-lg-30 d-none d-lg-flex flex-grow-1 navbar-toggle-content " id="navbarContent">
                        <div class="navbar-toggle-header text-right d-lg-none">
                            <button class="btn-transparent" id="navbarClose">
                                <i data-feather="x" width="32" height="32"></i>
                            </button>
                        </div>

                        <ul class="navbar-nav ml-auto d-flex align-items-center">
                            <li class="nav-item">
                            <a href="<?php echo base_url(); ?>user/signup" class="py-5 px-10  font-14">Register</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>



        <div class="container">

            <div class="row login-container" style="border: 0;">

                <div class="col-12 col-md-6 pl-0" style="background-color: #fff;border-radius: 15px 0 0 15px;">
                    <img src="<?php echo base_url() ?>assets/images/loginpage.png" class="img-cover" alt="Login" style="width: 100%;">
                </div>
                <div class="col-12 col-md-6" style="background-color: #0074ad;border-radius: 0 15px 15px 0;color: #fff;">
                    <div class="login-card" >
                        <h1 class="font-20 font-weight-bold">Reset Password</h1>
                        
                        <form action="<?php echo base_url(); ?>user/resetpassword" method="POST" id="reset_password_form" accept-charset="utf-8" class="mt-35">
                        <input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        
                        <?php if($this->session->userdata('error')){ ?>
                            <div class="alert alert-danger mb-2" role="alert" style="background-color: unset;border: 0;color: #fff;padding: 0;">
                                <?php 
                                    echo $this->session->userdata('error'); 
                                    $this->session->unset_userdata('error');
                                ?>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                                <label class="input-label" for="username" style="color: #fff;">Email:</label>
                                <input name="email" type="email" class="form-control " id="username" value=""
                                    aria-describedby="emailHelp">
                            </div>


                            <button type="submit" class="btn btn-primary btn-block mt-20" style="background-color: #2aba5e;border: 0;">Reset Password</button>
                        </form>

                        <div class="text-center mt-20" >
                            <span class="text-secondary" style="color: #fff !important;">
                                Already have an account?
                                <a href="<?php echo base_url(); ?>user/signin"
                                    class="text-secondary font-weight-bold" style="color: #fff !important;">Login</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer bg-secondary position-relative user-select-none">
           


            <div class="container">

                <div class=" border-blue py-25 d-flex align-items-center justify-content-between">
                    <div class="footer-logo">
                    <a class="navbar-brand navbar-order d-flex align-items-center justify-content-center mr-0 "
                        href="/">
                        <img src="<?php echo base_url() ?>assets/images/one-aus-logo.png" class="img-cover" 
                            alt="site logo">
                    </div>
                    <div class="footer-social">
                        <a href="https://www.instagram.com/">
                            <img src="<?php echo base_url() ?>assets/newlayout/store/1/default_images/social/instagram.svg" alt="Instagram" class="mr-15">
                        </a>
                        <a href="https://web.whatsapp.com/">
                            <img src="<?php echo base_url() ?>assets/newlayout/store/1/default_images/social/whatsapp.svg" alt="Whatsapp" class="mr-15">
                        </a>
                        <a href="https://twitter.com/">
                            <img src="<?php echo base_url() ?>assets/newlayout/store/1/default_images/social/twitter.svg" alt="Twitter" class="mr-15">
                        </a>
                        <a href="https://www.facebook.com/">
                            <img src="<?php echo base_url() ?>assets/newlayout/store/1/default_images/social/facebook.svg" alt="Facebook" class="mr-15">
                        </a>
                    </div>
                </div>
            </div>

            <div class="footer-copyright-card">
                <div class="container d-flex align-items-center justify-content-between py-15">
                    <div class="font-14 text-white">Copyright2023@PTE </div>

                    <div class="d-flex align-items-center justify-content-center">
                       

                        <div class="border-left mx-5 mx-lg-15 h-100"></div>

                        <div class="d-flex align-items-center text-white font-14">
                            <i data-feather="mail" width="20" height="20" class="mr-10"></i>
                            <a href="#" class="__cf_email__"  style="color:#fff !important;">mail@oneaustraliagroup.com</a>
                        </div>
                    </div>
                </div>
            </div>

        </footer>


    </div>
    
    <script>
        $('#reset_password_form').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                }
            },
            messages: {
                email: 'Enter a valid email'
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    </script>
    <!-- <script src="<?php echo base_url();?>assets/newlayout/assets/default/js/app.js"></script> -->
    <script src="<?php echo base_url();?>assets/newlayout/assets/default/js/parts/navbar.min.js"></script>
    <script src="<?php echo base_url();?>assets/newlayout/assets/default/vendors/pace-loading/pace.min.js"></script>
    <!-- Custom jQuery -->
    <script src="<?php echo base_url('assets/js/app/scroll_to_top.js'); ?>"></script>
        
    <!-- Scroll-Top button -->
    <a href="#" class="scrolltotop"><i class="fas fa-angle-up"></i></a>
   
</body>

</html>