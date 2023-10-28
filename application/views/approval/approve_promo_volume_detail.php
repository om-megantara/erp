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
$percent1 = (isset($content['list1']['percent'])) ? $content['list1']['percent'] : array() ;
$brandcategory1 = (isset($content['list1']['brandcategory'])) ? $content['list1']['brandcategory'] : array() ;

$main2 = $content['list2']['main'];
$percent2 = (isset($content['list2']['percent'])) ? $content['list2']['percent'] : array() ;
$brandcategory2 = (isset($content['list2']['brandcategory'])) ? $content['list2']['brandcategory'] : array() ;

$brand = $content['brand'];
$category = $content['category'];
?>

<form role="form" id="form_promo_volume" action="<?php echo base_url();?>approval/approve_promo_volume_act" method="post" onSubmit="return cek_checkbox(event)">
  <div class="col-md-12">
    <input type="hidden" name="PromoVolID" value="<?php echo $content['PromoVolID']; ?>">
    <input type="hidden" name="ApprovalID" value="<?php echo $content['id']; ?>">
<!--     
    <table class="table table-hover table-main">
      <tr>
        <td>Promo Volume Name</td>
        <td>: <?php echo $main['PromoVolName'];?></td>
        <td>Price Category </td>
        <td>: <?php echo $main['PricecategoryName'];?></td>
      </tr>
      <tr>
        <td>Keterangan</td>
        <td>: <?php echo $main['PromoVolNote'];?></td>
        <td>Product Disc </td>
        <td>: <?php echo $main['PromoDefault'];?> %</td>
      </tr>
      <tr>
        <td>Start - End</td>
        <td>: <?php echo $main['DateStart']." <-> ".$main['DateEnd'];?></td>
        <td></td>
        <td></td>
      </tr>
      </tr>
    </table>
 -->


    <div class="col-md-6">
      <h4>Promo Volume Normal</h4>
      <table class="table table-hover table-main">
        <tr>
          <td>Promo Volume Name</td>
          <td>: <?php echo $main1['PromoVolName'];?></td>
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
                <td>Qty</td>
                <td>Promo</td>
                <td>TOP</td>
                <td>CBD</td>
              </tr>
              <?php
              if (isset($percent1)) {
                foreach ($percent1 as $row => $list) { 
              ?>
                  <tr>
                    <td><?php echo $list['ProductQty'];?></td>
                    <td><?php echo $list['PromoPercent']."%";?></td>
                    <td><?php echo $list['PT1Percent']."%";?></td>
                    <td><?php echo $list['PT2Percent']."%";?></td>
                  </tr>
            <?php } } ?>
            </table>
          </td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td>: <?php echo $main1['PromoVolNote'];?></td>
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
      <h4>Promo Volume Approval</h4>
      <table class="table table-hover table-main">
        <tr>
          <td>Promo Volume Name</td>
          <td>: <?php echo $main2['PromoVolName'];?></td>
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
                <td>Qty</td>
                <td>Promo</td>
                <td>TOP</td>
                <td>CBD</td>
              </tr>
              <?php
              if (isset($percent2)) {
                foreach ($percent2 as $row => $list) { 
              ?>
                  <tr>
                    <td><?php echo $list['ProductQty'];?></td>
                    <td><?php echo $list['PromoPercent']."%";?></td>
                    <td><?php echo $list['PT1Percent']."%";?></td>
                    <td><?php echo $list['PT2Percent']."%";?></td>
                  </tr>
            <?php } } ?>
            </table>
          </td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td>: <?php echo $main2['PromoVolNote'];?></td>
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
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Promo</th>
          <th>TOP</th>
          <th>CBD</th>
          <th>Price EndUser</th>
          <th>Price Category</th>
          <th>Price TOP</th>
          <th>Price CBD</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php 
        if (isset($content['detail'])) {
          foreach ($content['detail'] as $row => $list) { 
        ?>
          <tr>
            <td><?php echo $list['ProductID'];?> : <?php echo $list['ProductCode'];?></td>
            <td class="alignCenter"><?php echo $list['ProductQty'];?></td>
            <td class="alignCenter"><?php echo $list['Promo'];?> %</td>
            <td class="alignCenter"><?php echo $list['PT1Discount'];?> %</td>
            <td class="alignCenter"><?php echo $list['PT2Discount'];?> %</td>
            <td class="alignRight"><?php echo number_format($list['ProductPriceDefault'],2);?></td>
            <td class="alignRight"><?php echo number_format($list['PriceAfterCategory'],2);?></td>
            <td class="alignRight"><?php echo number_format($list['ProductPricePT1'],2);?></td>
            <td class="alignRight"><?php echo number_format($list['ProductPricePT2'],2);?></td>
            <td class="alignCenter" style="display: none;">
              <?php 
                if ($actor == "") {
                  if ($list['isApprove']!=0 or $list['isApprove']===null ) {
              ?>
                <input type="hidden" name="ProductID[]" value="<?php echo $list['ProductID'];?>">
                <input type="hidden" name="ProductQty[]" value="<?php echo $list['ProductQty'];?>">
                <input type="checkbox" class="checkbox_approve" name="approve[]" value="1" checked>
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

