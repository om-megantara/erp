<style type="text/css">
  .table-main tr td {
    font-size: 12px;
    padding: 2px 8px !important;
    white-space: nowrap !important;
  }

  .table-display-list { 
    font-size: 12px !important; 
    white-space: nowrap; 
    background: #ffffff;
  }
  .table-display-list td {
    padding: 2px 5px !important;
  }
  #myInput { margin: 10px 0px; width: 100%; }
  .box-body { overflow: auto; }
</style>

<?php

$main1 = $content['promo'];
$percent1 = $content['percent'];
$brandcategory1 = (isset($content['brandcategory'])) ? $content['brandcategory'] : array() ;

$brand = $content['brand'];
$category = $content['category'];

?>

<div class="row">
  <div class="col-md-6">
    <div class="box box-solid">
        <table class="table table-hover table-main">
          <tr>
            <td>Prmo Volume Name</td>
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
            <td>Keterangan</td>
            <td>: <?php echo $main1['PromoVolNote'];?></td>
          </tr>
        </table>
    </div>
  </div>

  <div class="col-md-6">
    <div class="box box-solid">
      <table class="table table-hover table-main"> 
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
          <td>Category / Brand</td>
          <td>
            <table>
              <?php
              if (isset($brandcategory1)) {
                foreach ($brandcategory1 as $row => $list) { 
              ?>
                    <tr>
                        <td><?php echo $category[$list['ProductCategoryID']]['ProductCategoryName'];?></td>
                        <td><?php echo $brand[$list['ProductBrandID']]['ProductBrandName'];?></td>
                    </tr> 
              <?php } } ?>
            </table>
          </td>
        </tr> 
      </table>
    </div>
  </div>
  <div class="col-md-12" style="max-height: 300px;">
    <div class="box box-solid">
      <div class="box-body no-padding">
        <input type="text" class="form-control input-sm" placeholder="SEARCH CONTENT" onkeyup="search_modal();" id="myInput" autocomplete="off">
        <div style="overflow-x:auto; max-height: 250px;">
          <table class="table table-display-list table-bordered" id="table_modal">
            <thead>
              <tr>
                <th class=" alignCenter">Product Name</th>
                <th class=" alignCenter">Quantity</th>
                <th class=" alignCenter">Promo</th>
                <th class=" alignCenter">TOP</th>
                <th class=" alignCenter">CBD</th>
                <th class=" alignCenter">Price Default</th>
                <th class=" alignCenter">Price TOP</th>
                <th class=" alignCenter">Price CBD</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if (isset($content['promod'])) {
                foreach ($content['promod'] as $row => $list) { 
              ?>
                <tr>
                  <td><?php echo $list['ProductID'];?> : <?php echo $list['ProductCode'];?></td>
                  <td class=" alignCenter"><?php echo $list['ProductQty'];?></td>
                  <td class=" alignCenter"><?php echo $list['Promo'];?> %</td>
                  <td class=" alignCenter"><?php echo $list['PT1Discount'];?> %</td>
                  <td class=" alignCenter"><?php echo $list['PT2Discount'];?> %</td>
                  <td class="alignRight"><?php echo number_format($list['ProductPriceDefault'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['ProductPricePT1'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['ProductPricePT2'],2);?></td>
                </tr>
              <?php } } ?>
            </tbody>
          </table>
          
        </div>
      </div>
    </div>
  </div>
</div>
