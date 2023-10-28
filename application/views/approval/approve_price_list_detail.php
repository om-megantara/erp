<?php
// $main   = $content['main'];
// $detail = $content['detail'];
$actor  = $content['actor'];
?>

<style type="text/css">
  .table-main tr td {
    font-size: 12px;
    padding: 2px 8px !important;
    white-space: nowrap !important;
  }
  .table-detail thead th, .total {
    background: #3169c6;
    color: #ffffff;
    text-align: center;
    color: white;
  }
  .table-detail, 
  .table-detail>thead>tr>th, 
  .table-detail>tbody>tr>td {
    border-color: #3169c6 !important;
    padding: 2px 2px !important;
    font-size: 12px;
  }
  .table-detail > tbody > tr > td, .table-detail > thead > tr > th { 
    word-break: break-all; 
    white-space: nowrap; 
  }

  input[type='checkbox'] {
    -webkit-appearance:none;
    width:15px;
    height:15px;
    background:white;
    border-radius:3px;
    border:1px solid #555;
  }
  input[type='checkbox']:checked {
    background: #3c8dbc;
  }
</style>

<?php

$detail = isset($content['detail']) ? $content['detail'] : array();

$main1 = $content['list1']['main'];
$percent1 = $content['list1']['percent'];
$brandcategory1 = (isset($content['list1']['brandcategory'])) ? $content['list1']['brandcategory'] : array() ;

$main2 = $content['list2']['main'];
$percent2 = $content['list2']['percent'];
$brandcategory2 = (isset($content['list2']['brandcategory'])) ? $content['list2']['brandcategory'] : array() ;

$brand = $content['brand'];
$category = $content['category'];
?>

<form role="form" action="<?php echo base_url();?>approval/approve_price_list_act" method="post" >
  <div class="col-md-12">
    <input type="hidden" name="PricelistID" value="<?php echo $content['PricelistID']; ?>">
    <input type="hidden" name="ApprovalID" value="<?php echo $content['id']; ?>">
<!-- 
    <table class="table table-hover table-main">
      <tr>
        <td>Pricelist Name</td>
        <td>: <?php echo $main['PricelistName'];?></td>
        <td>Price Category </td>
        <td>: <?php echo $main['PricecategoryName'];?></td>
      </tr>
      <tr>
        <td>Keterangan</td>
        <td>: <?php echo $main['PricelistNote'];?></td>
        <td>Product Disc </td>
        <td>: <?php echo $main['PromoDefault'];?> %</td>
      </tr>
      <tr>
        <td>Start - End</td>
        <td>: <?php echo $main['DateStart']." <-> ".$main['DateEnd'];?></td>
        <td></td>
        <td></td>
      </tr>
    </table>
-->
    <div class="col-md-6">
      <h4>Pricelist Normal</h4>
      <table class="table table-hover table-main">
        <tr>
          <td>Pricelist Name</td>
          <td>: <?php echo $main1['PricelistName'];?></td>
        </tr>
        <tr>
          <td>Price Category </td>
          <td>: <?php echo $main1['PricecategoryName'];?></td>
        </tr>
        <tr>
          <td>Product Disc </td>
          <td>: <?php echo $main1['PromoDefault'];?> %</td>
        </tr>
        <tr>
          <td>Start - End</td>
          <td>: <?php echo $main1['DateStart']." <-> ".$main1['DateEnd'];?></td>
        </tr>
        <tr>
          <td>Percentage</td>
          <td>
            <table style="text-align: center;">
              <tr>
                <td>Promo</td>
                <td>TOP</td>
                <td>CBD</td>
              </tr>
              <tr>
                <td><?php echo $percent1['PromoPercent']."%";?></td>
                <td><?php echo $percent1['PT1Percent']."%";?></td>
                <td><?php echo $percent1['PT2Percent']."%";?></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td>: <?php echo $main1['PricelistNote'];?></td>
        </tr>
        <tr>
          <td>Status</td>
          <td>: <?php echo $main1['isActive'];?></td>
        </tr>
      </table>
      <table class="table table-bordered table-detail table-responsive" id="table_detail">
        <thead>
          <tr>
            <th>Product Category Name </th>
            <th>Product Brand Name </th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($brandcategory1)) {
            foreach ($brandcategory1 as $row => $list) { 
          ?>
              <tr>
                  <td><?php echo $category[$list['ProductCategoryID']]['ProductCategoryName'];?></td>
                  <td><?php echo $brand[$list['ProductBrandID']]['ProductBrandName'];?></td>
              </tr>
          <?php } } ?>
        </tbody>
      </table>
    </div>

    <div class="col-md-6">
      <h4>Pricelist Approval</h4>
      <table class="table table-hover table-main">
        <tr>
          <td>Pricelist Name</td>
          <td>: <?php echo $main2['PricelistName'];?></td>
        </tr>
        <tr>
          <td>Price Category </td>
          <td>: <?php echo $main2['PricecategoryName'];?></td>
        </tr>
        <tr>
          <td>Product Disc </td>
          <td>: <?php echo $main2['PromoDefault'];?> %</td>
        </tr>
        <tr>
          <td>Start - End</td>
          <td>: <?php echo $main2['DateStart']." <-> ".$main2['DateEnd'];?></td>
        </tr>
        <tr>
          <td>Percentage</td>
          <td>
            <table style="text-align: center;">
              <tr>
                <td>Promo</td>
                <td>TOP</td>
                <td>CBD</td>
              </tr>
              <tr>
                <td><?php echo $percent2['PromoPercent']."%";?></td>
                <td><?php echo $percent2['PT1Percent']."%";?></td>
                <td><?php echo $percent2['PT2Percent']."%";?></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td>: <?php echo $main2['PricelistNote'];?></td>
        </tr>
        <tr>
          <td>Status</td>
          <td>: <?php echo $main2['isActive'];?></td>
        </tr>
      </table>
      <table class="table table-bordered table-detail table-responsive" id="table_detail">
        <thead>
          <tr>
            <th>Product Category Name </th>
            <th>Product Brand Name </th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($brandcategory2)) {
            foreach ($brandcategory2 as $row => $list) { 
          ?>
              <tr>
                  <td><?php echo $category[$list['ProductCategoryID']]['ProductCategoryName'];?></td>
                  <td><?php echo $brand[$list['ProductBrandID']]['ProductBrandName'];?></td>
              </tr> 
          <?php } } ?>
        </tbody>
      </table>
    </div>
  </div>

  <input type="text" class="form-control input-sm" placeholder="SEARCH CONTENT" onkeyup="search_table_detail();" id="myInput" autocomplete="off">
  <div style="overflow-x: auto;">
    <table class="table table-bordered table-detail table-responsive" id="table_detail">
      <thead>
        <tr>
          <th>Product Name </th>
          <th>Price EndUser </th>
          <th>Price Category </th>
          <th>Promo </th>
          <th>TOP </th>
          <th>CBD </th>
          <th>Price TOP </th>
          <th>Price CBD </th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $a=0;
        if (isset($content['detail'])) {
          foreach ($content['detail'] as $row => $list) { 
        $a++;
        ?>
            <tr>
                <td><?php echo $list['ProductID'];?> : <?php echo $list['ProductCode'];?></td>
                <td><?php echo number_format($list['ProductPriceDefault'],2);?></td>
                <td><?php echo number_format($list['PriceAfterCategory'],2);?></td>
                <td><?php echo $list['Promo'];?> %</td>
                <td><?php echo $list['PT1Discount'];?> %</td>
                <td><?php echo $list['PT2Discount'];?> %</td>
                <td><?php echo number_format($list['ProductPricePT1'],2);?></td>
                <td><?php echo number_format($list['ProductPricePT2'],2);?></td>
                <td class="alignCenter" style="display: none;">
                  <?php 
                    if ($actor == "") {
                      if ($list['isApprove']!=0 or $list['isApprove']===null ) {
                  ?>
                    <input type="checkbox" id="<?php echo $list['ProductID'];?>" name="ProductID[]" value="<?php echo $list['ProductID'];?>" checked>
                  <?php } else { ?>
                    <i class="fa fa-fw fa-close"></i>
                  <?php } } ?>
                </td>
            </tr>
        <?php } } ?>
      </tbody>
    </table>
  </div>
  <div style="text-align: center;">
    <?php if ($actor == "") { ?>
      <button type="submit" class="btn btn-primary btn-submit approve" name="action" value="approve">Approve</button>
      <button type="submit" class="btn btn-danger btn-submit reject" name="action" value="reject">Reject</button>
    <?php } ?>
  </div>
</form>


