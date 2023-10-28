<?php
// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
// header("Cache-Control: post-check=0, pre-check=0", false);
// header("Pragma: no-cache");
?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>tool/favicon.png"/> 
  <title><?php echo $PageTitle.' - '.$MainTitle; ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/dist/css/AdminLTE.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/dist/css/skins/_all-skins.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!-- [if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- <link rel="stylesheet" href="<?php echo base_url();?>tool/fonts_google.css"> -->
  <style type="text/css">
    .control-sidebar-subheading, .user-body,
    #control-sidebar-theme-demo-options-tab .form-group {
      display: none !important;
    }
    #control-sidebar-home-tab p { font-size: 15px; font-weight: bold; }
    .navbar-nav>.user-menu>.dropdown-menu>li.user-header { height: auto; }
    .breadcrumb a { color: white !important; font-weight: bold; }
    /*for problem content height with sidebar dynamic*/
    .wrapper { 
      width: 100%;
      min-height: 100%;
      height: auto !important;
      position: absolute;
    }
    /*----------------------------------------------*/

    /*report-summary*/
    .report-summary .icon { top : 0px !important; }
    .report-summary h3, .report-summary p { margin : 0px !important; }
    /*----------------------------------------------*/

    input, textarea, select {font-weight: bold;}
    .datepicker { z-index: 10000 !important; }

    input[type="radio"] {
      -webkit-appearance:none;
      width:15px;
      height:15px;
      background:white;
      border-radius:3px;
      border:1px solid #555;
      margin-left: -20px !important;
      margin-right: 20px !important;
    }
    input[type="checkbox"] {
      -webkit-appearance:none;
      width:15px;
      height:15px;
      background:white;
      border-radius:3px;
      border:1px solid #555;
    }
    input[type="radio"]:checked,
    input[type="checkbox"]:checked {
      background: #f39c12;
    }
    
    /*for cekBox setting sideBar*/
    .sidebar-set {
      -webkit-appearance:none;
      width:15px;
      height:15px;
      background:white;
      border-radius:3px;
      border:1px solid #555;
      margin-left: -20px !important;
      margin-right: 20px !important;
    }
    .sidebar-set:checked {
      background: #f39c12;
    }
    /*---------------------------*/
    ul.sidebar-menu { margin-bottom: 20px; }
    @media only screen and (max-width: 760px) {
      .cek_screen { display: none; }
    }

    .div_dt_print { display: none; }
    .dtAlignRight { text-align: right; }
    .alignCenter { text-align: center; }
    .alignRight { text-align: right; }

    .min-w-100 { min-width: 100px; }
    .min-w-150 { min-width: 150px; }
    .pad-l-2 { padding-left: 2px; }

    @media (min-width: 950px) {
      .modal-dialog {
        width: 85%;
        margin: 10px auto;
      }
    }
    .modal-body {
      background: #dbdbdb;
      overflow: auto;
    }
    #detailcontentAjax {
      background-color: white;
      overflow: auto;
    }
    .detailcontentAjax {
      text-align: center;
      background-color: white;
      padding: 10px !important;
      overflow: auto;
    }

    /*.btn { margin-bottom: 3px; }*/
    .atributeConn {
      padding: 2px !important;
      min-width: 70px !important;
    }
    .input-group-atributeConn {
      vertical-align: top;
    }
    .atributeSeparator {
      border: 0px;
      padding: 0px !important;
    }
    label { font-weight: 600 !important; }
    /*.select2-container { width: 100% !important; }*/

    /*efek load*/ 
    .loader {
      margin: auto;
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid blue;
      border-bottom: 16px solid blue;
      width: 120px;
      height: 120px;
      -webkit-animation: spin 2s linear infinite;
      animation: spin 2s linear infinite;
    }
    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    /*-------------------------------*/
    
    .marbot-0 { margin-bottom: 0px; }
    .select2 { width: 100% !important; }
    .no-wrap td, .no-wrap th { white-space: nowrap; }
    .bold { font-weight: bold; }
    .bolder { font-weight: bolder; }
  </style>

</head>

<!-- ADD THE CLASS layout-boxed TO GET A BOXED LAYOUT -->
<?php
  if(uri_string()=="approval/approve_marketing_activity" OR uri_string()=="report/report_product_kpi" OR uri_string()=="report/report_product_stock_all" OR uri_string()=="report/report_product_stock_ready") {$open="sidebar-collapse";} else {$open="";}
?>
<body class="hold-transition skin-blue sidebar-mini <?php echo $open ?>">
<div class="wrapper">
  <input type="text" name="userename" style="position: absolute;"> 

  <header class="main-header">
    <a href="<?php echo base_url();?>" class="logo">
        
      <span class="logo-mini"><img src="<?php echo base_url();?>tool/logo_small.png" style="width:100%; margin-top: 15px;"></span>
      <span class="logo-lg"><img src="<?php echo base_url();?>tool/logo_big.png" style="width:100%; margin-top: 2px;"></span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?php echo $notification['total']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <ul class="menu">
                  <?php
                    foreach ($notification['content'] as $row => $list) { ?>
                      <li>
                        <a href="<?php echo base_url().$list['link'];?>">
                           <?php echo $list['text']; ?>
                        </a>
                      </li>
                  <?php } ?>
                </ul>
              </li>
            </ul>
          </li>

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="data:image/jpeg;base64, <?php echo base64_encode( $image );?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $UserName; ?><div class="cek_screen"></div></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <p>
                  <?php echo $UserName; ?> <br> <?php echo $JobTitleCode; ?>
                  <small>Member since <?php echo substr($CreatedDate, 0, 10); ?></small>
                </p>
              </li>
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
                </div>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <?php if ($EmployeeID != 0) { ?>
                  <a href="<?php echo base_url();?>employee/view_profile/<?php echo $EmployeeID;?>" class="btn btn-default ">Profile</a>
                  <?php } ?>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url();?>/login/logout" class="btn btn-default " id="logout">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <?php $this->load->view($menu); ?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <?php if (isset($error_info) and $error_info != "") { ?>
    <div class="alert alert-danger alert-dismissible alert-sessError">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <?php 
          echo $error_info; 
          $newdata['error_info'] = "";
          $this->session->set_userdata($newdata);
      ?>
    </div>
  <?php } ?>
  <?php $this->load->view($body,$data); ?>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-left userlive">User Online : </div><br><br>
    <div class="pull-right hidden-xs">
      Page rendered in {elapsed_time} seconds
    </div>
    <strong>Copyright &copy; 2018 ANGZOFT</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
      <!-- <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li> -->
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <ul class="control-sidebar-menu">
          <li>
            <a href="#" data-toggle="modal" data-target="#modal-default">
              <i class="menu-icon fa fa-key bg-red"></i>
              <div class="menu-info">
                <p>Change Password</p>
              </div>
            </a>
          </li>
          <?php if ($EmployeeID != 0) { ?>
          <li>
            <a target="_blank" href="<?php echo base_url();?>employee/employee_all">
              <i class="menu-icon fa fa-user bg-yellow"></i>
              <div class="menu-info">
                <p>View Partner</p>
              </div>
            </a>
          </li>
          <li>
            <a target="_blank" href="<?php echo base_url();?>employee/employee_attendance_personal/<?php echo $EmployeeID;?>">
              <i class="menu-icon fa fa-thumbs-up bg-green"></i>
              <div class="menu-info">
                <p>View Attendance</p>
              </div>
            </a>
          </li>
          <?php } ?>
          <li>
              <div class="menu-info">
                <input type="checkbox" class="pull-left sidebar-set">
                <p>
                  Toggle Sidebar
                  <a href="<?php echo base_url();?>main/cek_any1"> . </a>
                  <a href="#" class="cek_any2"> . </a>
                </p>
              </div>
          </li>
        </ul>
      </div>
    </div>
  </aside>

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Change Password</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Old Password" autocomplete="off" name="oldpassword" id="oldpassword">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" placeholder="New Password" autocomplete="off" name="newpassword" id="newpassword">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left cancel-password" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary save-password">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-loading-ajax">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
            <div class="loader"></div>
        </div> 
      </div>
    </div>
  </div>

  <div class="div_dt_print"></div>
  <div class="control-sidebar-bg"></div>
</div>

<style type="text/css">
    /*css datatable*/
    table.dataTable tr:hover { background-color:#71d1eb !important; }
    table.dataTable { width:100% !important; }
    .dataTables_scrollFootInner table.dataTable { width:max-content !important; }
    @media (min-width: 950px) {
      /*for DT info on top*/
      .dataTables_wrapper .dataTables_length {
        margin-right: 20px;
        display: inline;
      }
      .dataTables_wrapper .dataTables_info {
        display: inline-block;
      }
      .dataTables_wrapper .dataTables_filter {
        float: right;
      }
      .dataTables_wrapper .dataTables_paginate {
        float: right;
      }
      /*-------------------*/
    }
    .dataTables_filter .btn { margin-bottom: 0px; }
    #dt_list td, #dt_list th, 
    #dt_list2 td, #dt_list2 th, 
    #dt_list3 td, #dt_list3 th,
    .dataTables_scrollHeadInner thead { 
      white-space: nowrap; 
      vertical-align: top !important;
    }
    #dt_list th, #dt_list2 th, #dt_list3 th, 
    .dataTables_scrollHeadInner th { 
      text-align: center;
    }
    #dt_list tbody td,
    #dt_list2 tbody td,
    #dt_list3 tbody td {
      padding-top: 4px;
      padding-bottom: 4px;
    }
    #dt_list tbody, #dt_list thead, #dt_list tfoot,
    #dt_list2 tbody, #dt_list2 thead, #dt_list2 tfoot,
    #dt_list3 tbody, #dt_list3 thead, #dt_list3 tfoot,
    .dataTables_scrollHeadInner thead,
    .dataTables_scrollFootInner tfoot,
    .DTFC_LeftWrapper tfoot {
      font-size: 12px !important;
    }
    .dataTables_scrollBody { max-height: 60vh; }

    .tr-filter-column { display: none; }
    .input-filter-column { width: 100%; }
    /*------------------------*/

    .info_filter {
      width: 100%;
      height: auto;
      background-color: #00a65a8c;
      margin-bottom: 5px;
      padding: 5px;
      color: white
    }
</style>

<!-- jQuery 3 -->
<script src="<?php echo base_url();?>tool/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url();?>tool/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>tool/adminlte/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>tool/adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>tool/adminlte/dist/js/demo.js"></script>
<!-- jquery alphanumeric -->
<script src="<?php echo base_url();?>tool/jquery.alphanum.js"></script>

<script>
jQuery( document ).ready(function( $ ) {
  $( "li.<?php echo $data['menu'];?>" ).addClass("active").parents("li").addClass("active");
  
  check_sidebar()
  if ( $( ".alert-sessError" ).length ) {
    $('.alert-sessError').prependTo('.content-wrapper');
  }
  setTimeout(function() {
    $ ('body').resize() 
  }, 100);
  $(".btn").addClass("btn-flat");

  // cek info filter
  <?php 
    $info = 0;
    $status = "";
    if (isset($data['content']['info_filter']) and $data['content']['info_filter'] != "") {
      $status = $data['content']['info_filter'];
      $info = 1;
    } elseif (isset($data['content']['main']['info_filter']) and $data['content']['main']['info_filter'] != "") {
      $status = $data['content']['main']['info_filter'];
      $info = 1;
    }
    if ($info != 0) {
  ?>
    $("<div class='info_filter'><?php echo $status;?></div>").insertBefore("#dt_list_wrapper");
  <?php
    }
  ?>
  // --------------------------------

});
$(document).on('DOMNodeInserted', function(e) {
    $(".btn").addClass('btn-flat');
});


$(".save-password").click(function() {
  $.ajax({
    url: "<?php echo base_url();?>main/change_password",
    type : 'GET',
    data : 'old=' + $("#oldpassword").val() + '&new=' + $("#newpassword").val() + '&id=<?php echo $UserAccountID;?>',
    dataType : 'json',
    success : function (result) {
      alert(result);
      setTimeout(logout, 3);
    },
    error : function () {
       alert("Error !");
    }
  })
});
function logout() {
  window.location.href = "<?php echo base_url();?>/login/logout";
}
// jeda submit form 10detik
$("form").submit(function(){
  var el = $(this).find('button[type=submit]');
  el.prop('disabled', true);
  setTimeout(function(){
    el.prop('disabled', false);
  }, 10000);
});
// kode keyboard tidak dibolehkan untuk input
var ingnore_key_codes = [13,222,186];
// kode keyboard tidak dibolehkan untuk textarea
var ingnore_key_codes2 = [13,222,186,220];
$(document).on('keydown', 'input', function(e){
  if ($.inArray(e.keyCode, ingnore_key_codes) >= 0) {
    e. preventDefault();
    return false;
  }
});
$(document).on('keydown', 'textarea', function(e){
  if ($.inArray(e.keyCode, ingnore_key_codes2) >= 0) {
      e.preventDefault();
      return false;
  }
});
$(document).on('change', 'input', function(){
  this.value = this.value.replace(/\n/g, ', ');
  this.value = this.value.replace(/\t/g, ' ');
  this.value = this.value.replace(/\'/g, '');
  this.value = this.value.replace(/\"/g, '');
  this.value = this.value.replace(/\</g, '');
});
$(document).on('change', 'textarea', function(){
  this.value = this.value.replace(/\n/g, ', ');
  this.value = this.value.replace(/\t/g, ' ');
  this.value = this.value.replace(/\'/g, '');
  this.value = this.value.replace(/\"/g, '');
  this.value = this.value.replace(/\</g, '');
});

$(document).on('keydown', '.nonComma', function(e){
  if (e.keyCode === 188) {
      e.preventDefault();
      return false;
  }
});
$(document).on('keyup', '.toUpperCase', function(){
    this.value = this.value.toUpperCase();
});
$(".NoSpace").on({
  keydown: function(e) {
    if (e.which === 32)
      return false;
  },
  change: function() {
    this.value = this.value.replace(/\s/g, "");
  }
});

$(document).on('click', '.cek_any2', function(){
    $.ajax({
      url: "<?php echo base_url();?>main/cek_any2",
      type: "POST",
      data: {data: 'oke'}, 
      success: function(response){
        console.log(response)
      }
    }); 
});

var url = window.location.pathname;
$.get("<?php echo base_url();?>main/checkAlive");
$.get("<?php echo base_url();?>main/stillAlive?url="+url);
$.ajax({
  url: "<?php echo base_url();?>main/userlive",
  type : 'GET',
  dataType : 'json',
  success : function (response) {
    $(".userlive").append(response);
  }
})

// cek sidebar
$('.sidebar-set').change(function() {
   if($(this).is(":checked")) {
    if ( $("body").hasClass("sidebar-collapse") ) {

    } else {
      $('.sidebar-toggle').click()
    }
    document.cookie = "sidebar=open; expires=Wed, 31 Dec 2025 12:00:00 UTC; path=/";
   } else {
    if ( $("body").hasClass("sidebar-collapse") ) {
      $('.sidebar-toggle').click()
    } 
    document.cookie = "sidebar=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
   }
});
function check_sidebar() {
  sidebar = getCookie("sidebar");
  is_mobile = false;
  if( $('.cek_screen').css('display')=='none') {
      is_mobile = true;       
  }
  if (is_mobile != true) {
    if (sidebar != "") {
        $('.sidebar-set').attr('checked', true);
        $('.sidebar-toggle').click()
    } else {
        $('.sidebar-set').attr('checked', false);
    }
  }
}
function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
          c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
      }
  }
  return "";
}

$(document).on("wheel", "input[type=number]", function (e) {
    $(this).blur();
});

$('.UpperCase').keyup(function(){
    this.value = this.value.toUpperCase();
});


$("#setFixedColumn").click(function(){
  $(".divSetFixedColumn").slideToggle();
});

</script>

</body>
