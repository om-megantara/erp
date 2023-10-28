<link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<style type="text/css">
	.cardAddUser {
		display: none;
	}
  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 150px;
      padding: 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 10px; }
  }
</style>

<div class="modal fade" id="modal-add-user" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form role="form" action="<?php echo base_url();?>manage_app/account_user_add_act" method="post">
      <div class="modal-header">
        <h4 class="modal-title">Add User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row"> 
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">User Name</label>
              <span class="left2">
                <input type="text" name="name" class="form-control form-control-sm" placeholder="Enter Name">
              </span>
            </div>
            <div class="form-group">
              <label class="left">User Email</label>
              <span class="left2">
                <input type="email" name="email" class="form-control form-control-sm" placeholder="Enter email">
              </span>
            </div>
            <div class="form-group">
              <label class="left">User Login</label>
              <span class="left2">
                <input type="text" name="login" class="form-control form-control-sm noSpace" placeholder="Enter Login">
              </span>
            </div>
            <div class="form-group">
              <label class="left">User Password</label>
              <span class="left2">
                <input type="password" name="password" class="form-control form-control-sm" placeholder="Enter Password">
              </span>
            </div>
          </div>
          <div class="col-md-6">
              <div class="table-responsive" style="overflow: auto; max-height: 450px;">
                <table class="table table-bordered table-standard">
                  <tr class="">
                    <th style="width: 10px">#</th>
                    <th>Menu Note</th>
                  </tr>
                  <?php
                    foreach ($menu_list as $row => $list) { ?>
                      <tr>
                        <td>
                          <input type="checkbox" class="menu-<?php echo $list['MenuID'];?>" name="menu[]" value="<?php echo $list['MenuID'];?>">
                        </td>
                        <td>
                          <?php echo str_repeat('->', $list['Menulevel']);?>
                          <?php echo $list['MenuNote'];?>
                        </td>
                      </tr>
                  <?php } ?>
                </table>
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-edit-user" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form role="form" action="<?php echo base_url();?>manage_app/account_user_edit_act" method="post">
      <div class="modal-header">
        <h4 class="modal-title">Add User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row"> 
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">User ID</label>
              <span class="left2">
                <input type="text" name="userid" class="form-control form-control-sm userid" readonly="">
              </span>
            </div>
            <div class="form-group">
              <label class="left">User Name</label>
              <span class="left2">
                <input type="text" name="name" class="form-control form-control-sm username" placeholder="Enter Name">
              </span>
            </div>
            <div class="form-group">
              <label class="left">User Email</label>
              <span class="left2">
                <input type="email" name="email" class="form-control form-control-sm useremail" placeholder="Enter email">
              </span>
            </div>
            <div class="form-group">
              <label class="left">User Login</label>
              <span class="left2">
                <input type="text" name="login" class="form-control form-control-sm noSpace userlogin" placeholder="Enter Login">
              </span>
            </div>
            <div class="form-group">
              <label class="left">User Password</label>
              <span class="left2">
                <input type="password" name="password" class="form-control form-control-sm" placeholder="leave it empty will not change it">
              </span>
            </div>
            <div class="form-group">
              <label class="left">Status</label>
              <span class="left2">
                <select class="form-control input-sm userstatus" name="status">
                  <option value="1">Aktif</option>   
                  <option value="0">NonAktif</option>   
                </select>
              </span>
            </div>
          </div>
          <div class="col-md-6">
              <div class="table-responsive" style="overflow: auto; max-height: 450px;">
                <table class="table table-bordered table-standard">
                  <tr class="">
                    <th style="width: 10px">#</th>
                    <th>Menu Note</th>
                  </tr>
                  <?php
                    foreach ($menu_list as $row => $list) { ?>
                      <tr>
                        <td>
                          <input type="checkbox" class="menu-<?php echo $list['MenuID'];?>" name="menu[]" value="<?php echo $list['MenuID'];?>">
                        </td>
                        <td>
                          <?php echo str_repeat('->', $list['Menulevel']);?>
                          <?php echo $list['MenuNote'];?>
                        </td>
                      </tr>
                  <?php } ?>
                </table>
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><?php echo $PageTitle;?></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <button class="btn btn-info btn-xs btnAddUser" data-toggle="modal" data-target="#modal-add-user">Add User</button>
          </li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row"> 
      <div class="col-md-12">
        <div class="card">
          <div class="card-body"> 
            <table id="dt_list" class="table table-bordered table-hover nowrap">
              <thead>
                <tr>
                  <th>User ID</th>
                  <th>Full Name</th>
                  <th>User Name</th>
                  <th>Email</th>
                  <th>Active</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              <?php
                if (isset($content)) {
                  foreach ($content as $row => $list) { ?>
                    <tr>
                      <td><?php echo $list['UserID'];?></td>
                      <td><?php echo $list['UserFullName'];?></td>
                      <td><?php echo $list['UserName'];?></td>
                      <td><?php echo $list['UserEmail'];?></td>
                      <td><?php echo $list['isActive']=="1" ? "Active" : "NonActive";?></td>
                      <td>
                        <button type="button" class="btn btn-success btn-xs btnEditUser" userid="<?php echo $list['UserID'];?>" title="EDIT" data-toggle="modal" data-target="#modal-edit-user"><i class="fa fa-fw fa-edit"></i></button>
                        <button type="button" class="btn btn-warning btn-xs btn-flat" title="LOGIN AS" onclick="window.open('<?php echo base_url();?>login/logAs?id=<?php echo $list['UserID'];?>');"><i class="fa fa-fw fa-user-secret"></i></button>
                      </td>
                    </tr>
              <?php } } ?>
          
              </tbody>
            </table>
          </div>
      </div>
    </div>
  </div>
</section>

<script src="<?php echo base_url();?>assets/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/adminlte/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript">
jQuery( document ).ready(function( $ ) {
    $('#dt_list').DataTable({
    });
});

$('.btnEditUser').on( "click", function() {
  userid  = $(this).attr('userid');
  $('#modal-edit-user').find('input').prop('checked', false)
  $.ajax({
    url: "<?php echo base_url();?>manage_app/get_account_user_detail",
    type : 'POST',
    data: {userid: userid},
    dataType : 'json',
    success : function (response) {
      $('.userid').val(response['UserID'])
      $('.username').val(response['UserFullName'])
      $('.userlogin').val(response['UserName'])
      $('.useremail').val(response['UserEmail'])
      $('.userstatus').val(response['isActive'])
      menu = response['UserMenu'].split(',')
      $.each( menu, function( key, value ) {
        $('#modal-edit-user').find('.menu-'+value).prop('checked', true);
      });
    }
  })
});

</script>