<style type="text/css">
  
  .table-detail td {
    padding: 2px 5px !important;
    font-size: 12px;
    border: 0px !important;
  }
  .table-detail td:first-child {
    font-weight: 700;
    width: 150px;
  }
 
</style>

<div class="row">
  <div class="col-md-6">
    <div class="box box-solid">
      <div class="box-body box-profile">
        <h3 class="profile-username text-center"><?php echo $content['fullname']; ?></h3>

        <div class="table-responsive no-padding">
          <table class="table table-hover table-detail">
            <tr>
              <td><strong><i class="fa fa-credit-card margin-r-5"></i> ID Contact </strong></td>
              <td>: <?php echo $content['ContactID'];?></td>
            </tr>
            <tr>
              <td><strong><i class="fa fa-credit-card margin-r-5"></i> ID Expedition </strong></td>
              <td>: <?php echo $content['ExpeditionID'];?></td>
            </tr>
            <?php if ($content['isCompany'] == 0) { ?>
            <tr>
              <td><strong><i class="fa fa-venus-mars margin-r-5"></i> Gender </strong></td>
              <td>: <?php echo $content['gender'];?></td>
            </tr>
            <tr>
              <td><strong><i class="fa fa-globe margin-r-5"></i> Religion </strong></td>
              <td>: <?php echo $content['religion'];?></td>
            </tr>
            <tr>
              <td><strong><i class="fa fa-credit-card margin-r-5"></i> ID Card Number </strong></td>
              <td>: <?php echo $content['KTP'];?></td>
            </tr>
            <?php } ?>
            <tr>
              <td><strong><i class="fa fa-credit-card margin-r-5"></i> NPWP Number </strong></td>
              <td>: <?php echo $content['NPWP'];?></td>
            </tr>
            <tr>
              <td><strong><i class="fa  fa-shopping-cart margin-r-5"></i> Shop Name </strong></td>
              <td>: <?php echo $content['ShopName'];?></td>
            </tr>
            <tr>
              <td><strong><i class="fa fa-users margin-r-5"></i> Contact Person </strong></td>
              <td><?php echo $content['contact_person'];?></td>
            </tr>
          </table>
        </div>

 
      </div>
      <div class="box-body">
        <ul class="list-group list-group-unbordered">
          <li class="list-group-item view-partner">
            <b>Edit Expedition</b> <a target="_blank" class="btn btn-primary btn-xs pull-right" title="EDIT EXPEDITION" href="<?php echo base_url();?>master/expedition_cu/<?php echo $content['id'];?>" class="pull-right view">Edit</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-solid">
      <div class="box-body">

        <div class="table-responsive no-padding">
          <table class="table table-hover table-detail"> 
            <tr>
              <td><i class="fa fa-phone-square margin-r-5"></i> Phone Number </strong></td>
              <td><?php echo $content['Phone'];?></td>
            </tr>
            <tr>
              <td><strong><i class="fa fa-envelope margin-r-5"></i> Email </strong></td>
              <td><?php echo $content['Email'];?></td>
            </tr>
          </table>
        </div> 

        <strong><i class="fa fa-map-marker margin-r-5"></i> Address : </strong><br>
        <?php echo $content['address'];?><br> 
      </div>
    </div>
  </div>
</div>