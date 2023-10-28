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

  .table-solate { 
    margin-top: 10px;
  }
  .table-solate tr th { background: #49afe3; color: white; }
  .table-solate tr td, .table-solate tr th {
    font-size: 12px;
    padding: 2px 8px !important;
    border-bottom: 1px solid #49afe3;
    white-space: nowrap !important;
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
              <td><strong><i class="fa fa-credit-card margin-r-5"></i> ID Customer </strong></td>
              <td>: <?php echo $content['CustomerID'];?></td>
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

      </div>
      <div class="box-body">
        <strong><i class="fa fa-map-marker margin-r-5"></i> Address : </strong>
        <?php echo $content['address'];?><br>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-solid">
      <div class="box-body box-profile">

        <div class="table-responsive no-padding">
          <table class="table table-hover table-detail">
            <tr>
              <td><strong><i class="fa fa-dollar margin-r-5"></i> Credit Limit </strong></td>
              <td>: <?php echo ($content['CreditLimit']=="")?"0":"Rp.".number_format("$content[CreditLimit]",2,",","."); ?></td>
            </tr>
            <tr>
              <td><strong><i class="fa fa-thumbs-o-up margin-r-5"></i> Payment Term </strong></td>
              <td>: <?php echo ($content['PaymentTerm']=="")?"0":$content['PaymentTerm']." Days";?></td>
            </tr>
            <tr>
              <td><strong><i class="fa fa-object-group margin-r-5"></i> Category </strong></td>
              <td>: <?php echo $content['CustomercategoryName'];?></td>
            </tr>
            <tr>
              <td><strong><i class="fa fa-users margin-r-5"></i> Sales </strong></td>
              <td>: <?php echo $content['sales'];?></td>
            </tr>
            <tr>
              <td><strong><i class="fa fa-object-group margin-r-5"></i> Price Category </strong></td>
              <td>: <?php echo $content['price'];?></td>
            </tr>
            <tr>
              <td><strong><i class="fa fa-circle margin-r-5"></i> PV Multiplier </strong></td>
              <td>: <?php echo $content['CustomerPVMultiplier'];?></td>
            </tr>
            <tr>
              <?php if(in_array("customer_pv_cu", $MenuList)) { ?>
              <td><strong><i class="fa fa-dot-circle-o margin-r-5"></i> SEPV Multiplier </strong></td>
              <td>: <?php echo $content['SEPVMultiplier'];?></td>
              <?php } ?>
            </tr>
          </table>
        </div> 

        <strong><i class="fa fa-files-o margin-r-5"></i> File Uploaded</strong><br>
        <?php
        if (isset($content['file'])) {
          foreach ($content['file'] as $row => $list) {
        ?>
            <button type="button" class="btn btn-primary btn-xs" onclick="window.open('<?php echo base_url();?>assets/ContactFile/<?php echo $list['FileName'];?>', '_blank');"><i class="fa fa-fw fa-file-image-o"></i></button> : <?php echo $list['FileType'];?> <br>
        <?php } } ?>
      </div>
      <div class="box-body">
        <ul class="list-group list-group-unbordered">
          <li class="list-group-item view-partner">
            <b>Edit Customer</b> 
            <button type="button" class="btn btn-primary btn-xs pull-right" title="EDIT CUSTOMER" onclick="window.open('<?php echo base_url();?>master/customer_cu/<?php echo $content['id'];?>', '_blank');">Edit</button>
          </li>
          <!-- <?php if (in_array("customer_pv_cu", $MenuList)) {?>
          <li class="list-group-item view-partner">
            <b>Edit Customer PV Multiplier</b>
            <button type="button" class="btn btn-primary btn-xs pull-right" title="EDIT CUSTOMER" onclick="window.open('<?php echo base_url();?>master/customer_pv_cu/<?php echo $content['id'];?>', '_blank');">Edit</button>
          </li>
          <?php } ?> -->
        </ul>
      </div>

      <div class="box-body" style="overflow-x: auto;">

        <strong><i class="fa fa-dollar margin-r-5"></i> Deposit Free : </strong>
        Rp. <?php echo number_format($content['deposit']['TotalBalance'],2);?><br>

        <?php 
          if (isset($content['invlate'])) { 
            $invlate = $content['invlate'];
        ?>
          <table class="table table-hover table-bordered table-solate ">
            <tr>
              <th colspan="7" style="text-align: center;">Invoice Outstanding</th>
            </tr>
            <tr>
              <th class=" alignCenter">Invoice ID</th>
              <th class=" alignCenter">SO ID</th>
              <th class=" alignCenter">Invoice Date</th>
              <th class=" alignCenter">Due Date</th>
              <th class=" alignCenter">Late</th>
              <th class=" alignCenter">Total Payment</th>
              <th class=" alignCenter">Total Outstanding</th>
            </tr>
            <?php
              foreach ($invlate as $row => $list) { 
            ?>
                <tr>
                  <td>
                    <?php echo $list['INVID'];?>
                    <button type="button" class="btn btn-warning btn-xs printinv" title="PRINT" invid="<?php echo $list['INVID'];?>"><i class="fa fa-fw fa-print"></i></button>
                  </td>
                  <td><?php echo $list['SOID'];?></td>
                  <td class=" alignCenter"><?php echo $list['INVDate'];?></td>
                  <td class=" alignCenter"><?php echo $list['due_date'];?></td>
                  <td><b><?php echo $list['late_date'];?></b> </td>
                  <td><b>(<?php echo $list['TotalPaymentPerc'];?>%) </b> <?php echo $list['TotalPayment'];?></td>
                  <td class="alignRight"><?php echo $list['TotalOutstanding'];?></td>
                  
                </tr>
            <?php } ?>
          </table>
        <?php } ?>
      
        <?php 
          if (isset($content['solate'])) { 
            $solate = $content['solate'];
        ?>
          <table class="table table-hover table-bordered table-solate ">
            <tr>
              <th colspan="5" style="text-align: center;">SO Outstanding</th>
            </tr>
            <tr>
              <th class=" alignCenter">SO ID</th>
              <th class=" alignCenter">Total SO</th>
              <th class=" alignCenter">Total Deposit</th>
              <th class=" alignCenter">Total Payment</th>
              <th class=" alignCenter">Total Outstanding</th>
            </tr>
            <?php
              foreach ($solate as $row => $list) { 
            ?>
                <tr>
                  <td>
                    <?php echo $list['SOID'];?>
                    <?php if (in_array("print_without_header", $MenuList)) {?>
                    <button type="button" class="btn btn-warning btn-xs printso2" title="PRINT OFFLINE" soid="<?php echo $list['SOID'];?>"><i class="fa fa-fw fa-print"></i></button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-warning btn-xs printso" title="PRINT" soid="<?php echo $list['SOID'];?>"><i class="fa fa-fw fa-print"></i></button>
                    <?php } ?>
                  </td>
                  <td class="alignRight"><b><?php echo $list['SOTotal'];?></b> </td>
                  <td><b>(<?php echo $list['TotalDepositPerc'];?>%) </b> <?php echo $list['TotalDeposit'];?></td>
                  <td><b>(<?php echo $list['TotalPaymentPerc'];?>%) </b> <?php echo $list['TotalPayment'];?></td>
                  <td class="alignRight"><?php echo $list['TotalOutstanding'];?></td>
                  
                </tr>
            <?php } ?>
          </table>
        <?php } ?>

        <?php 
          if (isset($content['solatest'])) { 
            $solatest = $content['solatest'];
        ?>
          <table class="table table-hover table-bordered table-solate ">
            <tr>
              <th colspan="4" style="text-align: center;">5 SO Latest</th>
            </tr>
            <tr>
              <th class=" alignCenter">SO ID</th>
              <th class=" alignCenter">SO Date</th>
              <th class=" alignCenter">Total SO</th>
              <th class=" alignCenter">Total Payment</th>
            </tr>
            <?php
              foreach ($solatest as $row => $list) { 
            ?>
                <tr>
                  <td>
                    <?php echo $list['SOID'];?>
                    <?php if (in_array("print_without_header", $MenuList)) {?>
                    <button type="button" class="btn btn-warning btn-xs printso2" title="PRINT OFFLINE" soid="<?php echo $list['SOID'];?>"><i class="fa fa-fw fa-print"></i></button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-warning btn-xs printso" title="PRINT" soid="<?php echo $list['SOID'];?>"><i class="fa fa-fw fa-print"></i></button>
                    <?php } ?>
                  </td>
                  <td class="alignRight"><b><?php echo $list['SODate'];?></b> </td>
                  <td class="alignRight"><b><?php echo $list['SOTotal'];?></b> </td>
                  <td><b>(<?php echo $list['TotalPaymentPerc'];?>%) </b> <?php echo $list['TotalPayment'];?></td>
                  
                </tr>
            <?php } ?>
          </table>
        <?php } ?>

        <?php 
          if (isset($content['donotinv'])) { 
            $donotinv = $content['donotinv'];
        ?>
          <table class="table table-hover table-bordered table-solate ">
            <tr>
              <th colspan="4" style="text-align: center;">DO Not INV</th>
            </tr>
            <tr>
              <!-- <th class=" alignCenter">SO ID</th> -->
              <th class=" alignCenter">Category</th>
              <th class=" alignCenter">DO ID</th>
              <!-- <th class=" alignCenter">DO Date</th> -->
              <th class=" alignCenter">Product Name</th>
              <th class=" alignCenter">Qty</th>
            </tr>
            <?php
              foreach ($donotinv as $row => $list) { 
            ?>
                <tr>
                  <!-- <td><?php echo $list['SOID'];?></td> -->
                  <td><?php echo $list['CategoryName'];?></td>
                  <td><?php echo $list['DOID'];?></td>
                  <!-- <td><?php echo $list['DODate'];?></td> -->
                  <td><?php echo $list['ProductName'];?></td>
                  <td class="alignRight"><?php echo $list['ProductQty'];?></td>
                </tr>
            <?php } ?>
          </table>
        <?php } ?>
      </div>

    </div>
  </div>
</div>