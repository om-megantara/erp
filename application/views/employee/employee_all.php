  
<style type="text/css">
  .profile-user-img {
    /*width: 100%;*/
    max-height: 120px;
  }
  .box-body {
    padding-top: 3px;
    padding-bottom: 3px;
  }
  .list-group-item {padding: 4px 0px !important;}
  .view {
    background-color: #00a65a;
    color: white;
    padding: 2px 5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    font-weight: bold;
  }
  .box-profile {
    height: 200px;
  } 
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
        <?php 
          foreach ($content['divisi'] as $row => $list1) { 
            if ( isset($content['employee'][$list1['DivisiID']]) ) {
        ?>
        <div class="col-md-12">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $list1['DivisiName']; ?></h3>
            </div>
            <div class="box-body" > 
              <?php foreach ($content['employee'][$list1['DivisiID']] as $row => $list2) { ?>
                    <div class="col-md-2 col-xs-6">
                      <div class="box box-solid">
                        <div class="box-body box-profile">
                          <?php
                          if ($list2['image'] != "") { ?>
                          <img src="data:image/jpeg;base64, <?php echo base64_encode( $list2['image'] );?>" class="profile-user-img img-responsive img-circle" alt="User profile picture">
                          <?php } else { ?>
                          <img src="<?php echo base_url();?>tool/profil.png" class="profile-user-img img-responsive img-circle" alt="User profile picture">
                          <?php }; ?>
                          <h3 class="profile-username text-center"><?php echo $list2['fullname']; ?></h3>
                          <p class="text-muted text-center"><?php echo $list2['LevelCode']; ?></p>
                        </div>
                      </div>
                    </div>
              <?php } ?>

            </div>
          </div>
        </div>
        <?php } } ?>
      </div>
    </section>
  </div>