<!DOCTYPE html>
<html lang="en-US">

<head>
  <!-- Meta setup -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Title -->
  <title>Administrator Signin</title>

  <!-- Fav Icon -->
  <link rel="icon" href="<?php echo base_url() ?>assets/images/one-aus-logo.png" />
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/js/parsley/parsley.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

  <style type="text/css">
    @media screen and (max-width: 767px) {
      element.style {
        width: 80px;
      }
    }

    .form-outline input {
      background-color: #EBEBEB;
      border-radius: 10px;
      height: 50px;
      color: #aaa;

    }

    .btnform {
      color: #FFFFFF;
      background: #007bff;
      border-radius: 10px;
      height: 50px;
      border-color: #007bff;
      padding: 10px;
    }

    .form-control:focus {
      color: #495057;
      border: 2px solid #007bff;
      outline: 0;
    }

    .btnform:hover {
      color: #007bff;
      background: #FFFFFF;
      border-color: #007bff;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1 class="text-center mt-5 mb-5">Sign In as Admin</h1>
  </div>

  <section>
    <div class="container">
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col-lg-12 col-xl-11">
          <div class="row justify-content-center">
            <div class="col-md-6 col-lg-6 col-xl-6 order-2 order-lg-1">

              <!-- form error notification -->
              <?php if (isset($error_msg) && strlen($error_msg) > 0) { ?>
                <div class="alert alert-danger" role="alert">
                  <?php echo $error_msg; ?>
                </div>
              <?php } ?>

              <form class="mb-5" id="signin_form" action="<?php echo base_url(); ?>admin/signin" method="POST" accept-charset="utf-8" data-parsley-validate>
                <input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                
                <div class="d-flex flex-row align-items-center mb-4">
                  <div class="form-outline flex-fill mb-0 ml-5 mr-5">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email id" autocomplete="off" required>
                  </div>
                </div>

                <div class="d-flex flex-row align-items-center mb-2">
                  <div class="form-outline flex-fill mb-0 ml-5 mr-5">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Your Password.." data-parsley-minlength="8" autocomplete="off" required>
                    <i class="fa fa-eye" id="togglePassword" style="cursor: pointer; float: right; margin-top: -35px; margin-right: 10px;"></i>
                  </div>
                </div>

                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4 ml-5 mr-5">
                  <input type="submit" class="btn btn-primary btn-lg btnform w-100 btnlogin" name="signin_btn" id="signin" value="Signin" />
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</body>

<script>
  $(document).ready(function () {
    $('#signin').on('click', function (e) {
      e.preventDefault();
      var _this = $(this);
      var form = $(this).parents('form');
      var action = $(this).parents('form').attr('goingact');
      var parent_id = $(this).parents('.modal.fade').attr('id');
      form.parsley().validate();
      if (!form.parsley().isValid()) {
        return false;
      } else {
        $('#signin_form').submit();
      }
    });
  });

  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');

  togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye / eye slash icon
    this.classList.toggle('bi-eye');
  });
</script>

<script src="<?php echo base_url() ?>assets/js/validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>

</html>