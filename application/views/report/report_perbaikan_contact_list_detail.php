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
        <h5 class="text-center"><?php echo ($content['ShopName']=="")?"":"(".$content['ShopName'].")"; ?></h5>

        <div class="table-responsive no-padding">
          <table class="table table-hover table-detail">
            <tr>
              <td><strong><i class="fa fa-credit-card margin-r-5"></i> ID Contact </strong></td>
              <td>: <?php echo $content['ContactID'];?></td>
            </tr>
            <?php if ($content['isCompany'] == 0) { ?>
            <tr>
              <td><strong><i class="fa fa-venus-mars margin-r-5"></i> Gender </strong></td>
              <td>: <?php echo $content['gender'];?></td>
            </tr>
            <tr>
              <td><strong><i class="fa fa-birthday-cake margin-r-5"></i> Birth Day </strong></td>
              <td>: <?php echo $content['BirthDate'];?></td>
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

        <ul class="list-group list-group-unbordered">
          <li class="list-group-item view-partner">
            <b>Edit Contact</b> 
            <button type="button" class="btn btn-primary btn-xs pull-right" title="EDIT" onclick="window.open('<?php echo base_url();?>master/contact_cu/<?php echo $content['id'];?>', '_blank');">Edit</button>
          </li>
          <!-- ============================================= -->
          <?php 
          if (in_array("view_profile", $MenuList)) {
            if ($content['isEmployee'] == "1") { 
          ?>
          <li class="list-group-item view-partner">
            <b>View in Employee</b> 
            <button type="button" class="btn btn-primary btn-xs pull-right" title="VIEW" onclick="window.open('<?php echo base_url();?>employee/view_profile/<?php echo $content['EmployeeID'];?>', '_blank');">View</button>
          </li>
          <?php } } ?>
          <!-- ============================================= -->
          <?php 
          if (in_array("customer_list", $MenuList)) {
            if ($content['isCustomer'] == "1") { 
          ?>
          <li class="list-group-item view-partner">
            <b>View in Customer</b> 
            <button type="button" class="btn btn-primary btn-xs pull-right" title="VIEW">View</button>
          </li>
          <?php } else { ?>
          <li class="list-group-item view-partner">
            <b>Set as Customer</b> 
            <button type="button" class="btn btn-primary btn-xs pull-right" title="SETUP" onclick="window.open('<?php echo base_url();?>master/customer_cu/<?php echo $content['id'];?>', '_blank');">SetUP</button>
          </li>
          <?php } } ?>
          <!-- ============================================= -->
          <?php 
          if (in_array("supplier_list", $MenuList)) {
            if ($content['isSupplier'] == "1") { 
          ?>
          <li class="list-group-item view-partner">
            <b>View in Supplier</b> 
            <button type="button" class="btn btn-primary btn-xs pull-right" title="VIEW">View</button>
          </li>
          <?php } else { ?>
          <li class="list-group-item view-partner">
            <b>Set as Supplier</b> 
            <button type="button" class="btn btn-primary btn-xs pull-right" title="SETUP" onclick="window.open('<?php echo base_url();?>master/supplier_set/<?php echo $content['id'];?>', '_blank');">SetUP</button>
          </li>
          <?php } } ?>
          <!-- ============================================= -->
          <?php 
          if (in_array("expedition_list", $MenuList)) {
            if ($content['isExpedition'] == "1") { 
          ?>
          <li class="list-group-item view-partner">
            <b>View in Expedition</b> 
            <button type="button" class="btn btn-primary btn-xs pull-right" title="VIEW">View</button>
          </li>
          <?php } else { ?>
          <li class="list-group-item view-partner">
            <b>Set as Expedition</b> 
            <button type="button" class="btn btn-primary btn-xs pull-right" title="SETUP" onclick="window.open('<?php echo base_url();?>master/expedition_set/<?php echo $content['id'];?>', '_blank');">SetUP</button>
          </li>
          <?php } } ?>
          <!-- ============================================= -->
          <?php 
          if (in_array("sales_cu", $MenuList)) {
            if ($content['isSales'] == "1") { 
          ?>
          <li class="list-group-item view-partner">
            <b>View in Sales</b> 
            <button type="button" class="btn btn-primary btn-xs pull-right" title="VIEW">View</button>
          </li>
          <?php } else { ?>
          <li class="list-group-item view-partner">
            <b>Set as Sales</b> 
            <button type="button" class="btn btn-primary btn-xs pull-right" title="SETUP" onclick="window.open('<?php echo base_url();?>master/sales_set/<?php echo $content['id'];?>', '_blank');">SetUP</button>
          </li>
          <?php } } ?>
          <!-- ============================================= -->
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

        <strong><i class="fa fa-map-marker margin-r-5"></i> Location : </strong><br>
        <?php echo $content['address'];?>
      </div>
    </div>
  </div>
</div>