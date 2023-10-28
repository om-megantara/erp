<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>tool/favicon.png"/> 
  <title>Anghauz Backoffice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">
    .forgot_success {
      background-color: #449d44;
      padding: 10px;
      color: white;
      font-weight: bold;
    }
    .forgot_fail {
      background-color: #dd4b39 !important;
      padding: 10px;
      color: white;
      font-weight: bold;
    }
    .forgot_fail, .forgot_success { 
      display: none;
      margin-top: 10px;
    }
  </style>
</head>

<span style="display: none;">
<?php

$parts = parse_url( $_SERVER['HTTP_REFERER'] );
echo json_encode($parts);

?>
</span>

<body class="hold-transition login-page">
  <div class="login-box box-solid">
    <div class="login-logo">
      <a href="#"><b>Angz</b>DNA</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="<?php echo base_url();?>/login/cek" method="post" autocomplete="on">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Username" name="username">
          <span class="glyphicon glyphicon-envelope form-control-feedback" ></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <a href="#" class="forgot" data-toggle="modal" data-target="#modal-forgot">I forgot my password</a><br>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block ">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
        
      </form>
    </div>
    <!-- /.login-box-body -->
  </div>
<!-- /.login-box -->
  <div class="modal fade" id="modal-forgot">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Insert Your Email For New Random Password</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" autocomplete="">
          </div>
          <div class="row">
            <div class="col-xs-12 forgot_success">
              Congratulation, New Password Has been sent to your email ...
            </div>
            <div class="col-xs-12 forgot_fail">
              Sorry, Your email does not exist in the system !!! 
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" onclick="send_email();">Submit</button>
        </div>
      </div>
    </div>
  </div>
<!-- jQuery 3 -->
<script src="<?php echo base_url();?>tool/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url();?>tool/adminlte/plugins/iCheck/icheck.min.js"></script>
<script>
$(function () {
  $('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' /* optional */
  });
});
function send_email() {
  $.ajax({
    url: '<?php echo base_url();?>login/send_email',
    type: 'post',
    data : {email:$("#email").val()},
    dataType: 'json',
    success:function(response){
      $("#email").val("")
      if (response === "success") { 
        $('.forgot_success').slideDown('slow').delay(1500).slideUp('slow');
      } else {
        $('.forgot_fail').slideDown('slow').delay(1500).slideUp('slow');

      }
    }
  });
}
</script>
</body>
</html>
