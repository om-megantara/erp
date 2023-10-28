  
<style type="text/css">
  .profile-user-img {
    width: 100%;
    max-height: 350px;
  }
  .box-body {
    padding-top: 3px;
    padding-bottom: 10px;
  }
  .box-body p { margin-bottom: 10px; }
  .list-group-item {padding: 4px 0px !important;}
  .view {
    background-color: #0073b7;
    color: white;
    padding: 2px 5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    font-weight: bold;
  }
  .view-partner { display: none; }
</style>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
          <?php echo $PageTitle.' - '. $MainTitle; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-4">
          <div class="box box-solid">
            <div class="box-body box-profile">
              <img src="data:image/jpeg;base64, <?php echo base64_encode( $content_profile['image'] );?>" class="profile-user-img img-responsive img-circle" alt="User profile picture">
              <h3 class="profile-username text-center"><?php echo $content_profile['fullname']; ?></h3>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <div class="box-body">
              <strong><i class="fa fa-birthday-cake margin-r-5"></i> Birthday</strong>
              <p class="text-muted"><?php echo $content_profile['Birthday'];?> </p>
              <hr>
              <strong><i class="fa fa-transgender margin-r-5"></i> Gender / Age / Religion / Marital Status</strong>
              <p class="text-muted"><?php echo $content_profile['gender']." / ".$content_profile['age']." tahun / ".$content_profile['religion']." / ".$content_profile['maritalstatus'];?> </p>
              <hr>
              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
              <p class="text-muted"><?php echo $content_profile['homeaddress'];?> </p>
              <hr>
              <strong><i class="fa fa-phone-square margin-r-5"></i> Mobile Phone</strong>
              <p class="text-muted">
                <?php echo $content_profile['Phone'];?>
              </p>
              <hr>
              <strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>
              <p class="text-muted"><?php echo $content_profile['Email'];?></p>
              <hr>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Employee Information</h3>
            </div>
            <div class="box-body">
              <strong><i class="fa fa-file-text-o margin-r-5"></i> Join Date</strong>
              <p><?php echo $content_profile['JoinDate'];?></p>
              <strong><i class="fa fa-file-text-o margin-r-5"></i> ID Card Number</strong>
              <p><?php echo $content_profile['KTP'];?></p>
              <strong><i class="fa fa-file-text-o margin-r-5"></i> NPWP</strong>
              <p><?php echo $content_profile['NPWP'];?></p>
              <strong><i class="fa fa-file-text-o margin-r-5"></i> NIP</strong>
              <p><?php echo $content_profile['NIP'];?></p>
              <strong><i class="fa fa-file-text-o margin-r-5"></i> BIO ID</strong>
              <p><?php echo $content_profile['BIOID'];?></p>
              <strong><i class="fa fa-file-text-o margin-r-5"></i> Employment Status:</strong>
              <p><?php echo $content_profile['Status'];?></p>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Company</b> <a class="pull-right"><?php echo $content_profile['Company'];?></a>
                </li>
                <li class="list-group-item">
                  <b>Departement</b> <a class="pull-right"><?php echo $content_profile['Department'];?></a>
                </li>
                <li class="list-group-item">
                  <b>Job Titles</b><br> <a class=""><?php echo $content_profile['JobTitleCode'];?></a>
                </li>
                <li class="list-group-item view-partner">
                  <b>View Full List Employee</b> <a target="_blank" href="<?php echo base_url();?>employee/employee_all" class="pull-right view" >View</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Family Information</h3>
            </div>
            <div class="box-body">
              <strong><i class="fa fa-users margin-r-5"></i> Status</strong>
              <p><?php echo $content_profile['FamilyStatus'];?></p>
              <strong><i class="fa fa-file-text-o margin-r-5"></i> Name</strong>
              <p><?php echo $content_profile['FamilyName'];?></p>
              <strong><i class="fa fa-venus-mars margin-r-5"></i> Gender</strong>
              <p><?php echo $content_profile['FamilySex'];?></p>
              <strong><i class="fa fa-suitcase margin-r-5"></i> Job</strong>
              <p><?php echo $content_profile['FamilyJob'];?></p>
              <strong><i class="fa fa-map-marker margin-r-5"></i> Address</strong>
              <p><?php echo $content_profile['FamilyAddress'];?></p>
              <strong><i class="fa fa-phone-square margin-r-5"></i> Phone</strong>
              <p><?php echo $content_profile['FamilyPhone'];?></p>
              <strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>
              <p><?php echo $content_profile['FamilyEmail'];?></p>
            </div>
          </div>
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Penalty Information</h3>
            </div>
            <div class="box-body">
              <?php
              foreach ($content_profile['penalty'] as $row => $list) {?>
                <p><?php echo $list['Date'];?> | <?php echo $list['Quantity'];?> <?php echo $list['PenaltyName'];?> / <?php echo $list['Note'];?></p>
              <?php } ?>
              <strong><a class="btn btn-danger" href="<?php echo base_url();?>employee/employee_penalty/<?php echo $content_profile['id'];?>"><i class="fa fa-plus-square margin-r-5"></i> Penalty Order</a></strong>  
              <strong><a class="btn btn-warning" href="<?php echo base_url();?>employee/employee_penalty_point/<?php echo $content_profile['id'];?>"><i class="fa fa-plus-square margin-r-5"></i> Penalty Point Order </a></strong>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Document Information</h3>
            </div>
            <div class="box-body">
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>CV</b>
                  <?php if ($content_profile['cv']=="ADA") { ?>
                    <a target="_blank" href="<?php echo base_url();?>" class="pull-right view" onclick="return new_window('<?php echo $content_profile['id'];?>_cv')">View</a>
                  <?php } ?>
                </li>
                <li class="list-group-item">
                  <b>Appraisal</b>
                  <?php if ($content_profile['appraisal']=="ADA") { ?>
                    <a target="_blank" href="<?php echo base_url();?>" class="pull-right view" onclick="return new_window('<?php echo $content_profile['id'];?>_appraisal')">View</a>
                  <?php } ?>
                </li>
                <li class="list-group-item">
                  <b>Certificate</b>
                  <?php if ($content_profile['ijazah']=="ADA") { ?>
                    <a target="_blank" href="<?php echo base_url();?>" class="pull-right view" onclick="return new_window('<?php echo $content_profile['id'];?>_ijazah')">View</a>
                  <?php } ?>
                </li>
                <li class="list-group-item">
                  <b>ID Card</b>
                  <?php if ($content_profile['ktp']=="ADA") { ?>
                    <a target="_blank" href="<?php echo base_url();?>" class="pull-right view" onclick="return new_window('<?php echo $content_profile['id'];?>_ktp')">View</a>
                  <?php } ?>
                </li>
                <li class="list-group-item">
                  <b>KSK</b>
                  <?php if ($content_profile['ksk']=="ADA") { ?>
                    <a target="_blank" href="<?php echo base_url();?>" class="pull-right view" onclick="return new_window('<?php echo $content_profile['id'];?>_ksk')">View</a>
                  <?php } ?>
                </li>
                <li class="list-group-item">
                  <b>SKCK</b>
                  <?php if ($content_profile['skck']=="ADA") { ?>
                    <a target="_blank" href="<?php echo base_url();?>" class="pull-right view" onclick="return new_window('<?php echo $content_profile['id'];?>_skck')">View</a>
                  <?php } ?>
                </li>
                <li class="list-group-item">
                  <b>Domicile</b>
                  <?php if ($content_profile['domisili']=="ADA") { ?>
                    <a target="_blank" href="<?php echo base_url();?>" class="pull-right view" onclick="return new_window('<?php echo $content_profile['id'];?>_domisili')">View</a>
                  <?php } ?>
                </li>
                <li class="list-group-item">
                  <b>Reference</b>
                  <?php if ($content_profile['referensi']=="ADA") { ?>
                    <a target="_blank" href="<?php echo base_url();?>" class="pull-right view" onclick="return new_window('<?php echo $content_profile['id'];?>_referensi')">View</a>
                  <?php } ?>
                </li>
              </ul>
            </div>
          </div>
        </div>
		    <div class="col-md-4">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Asset Information</h3>
            </div>
            <div class="box-body">
            	<strong><i class="fa fa-list margin-r-5"></i> Asset Name / Status / Date In </strong>
      			  <?php
      				foreach ($content_profile['asset'] as $row => $list) {?>
      				  <p><?php echo $list['AssetName'];?> / <?php echo $list['StatusIn'];?> / <?php echo $list['DateInD'];?></p>
      				<?php } ?>
              
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <script>
    function new_window($val) {
      var myview = window.open('<?php echo base_url();?>employee/employee_view_file/'+$val, 'view_file', 'width=800,height=600');
      return false;
    }
  </script>