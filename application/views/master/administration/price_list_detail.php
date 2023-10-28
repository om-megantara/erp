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
  #myInput { margin: 10px 0px; }
  .box-body { overflow: auto; }
</style>

<?php

$main1 = $content['main'];
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
            <td>Promo Piece Name</td>
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
            <td>Keterangan</td>
            <td>: <?php echo $main1['PricelistNote'];?></td>
          </tr>
        </table>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-solid">
      <div class="box-body box-profile">
        <table class="table table-hover table-main"> 
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
  </div>
  <div class="col-md-12" style="max-height: 300px;">
    <div class="box box-solid">
      <div class="box-body no-padding">
        <input type="text" class="form-control input-sm" placeholder="SEARCH CONTENT" onkeyup="search_modal();" id="myInput" autocomplete="off">
        <div style="overflow-x:auto; max-height:250px;">
          <table class="table table-display-list table-bordered table_modal" id="table_modal">
            <tr>
              <th class=" alignCenter">Product Name</th>
              <th class=" alignCenter">Promo</th>
              <th class=" alignCenter">TOP</th>
              <th class=" alignCenter">CBD</th>
              <th class=" alignCenter">Price Default</th>
              <th class=" alignCenter">Price TOP</th>
              <th class=" alignCenter">Price CBD</th>
            </tr>
            <?php 
            if (isset($content['pricelistd'])) {
              foreach ($content['pricelistd'] as $row => $list) { 
            ?>
              <tr>
                <td><?php echo $list['ProductID'];?> : <?php echo $list['ProductCode'];?></td>
                <td class=" alignCenter"><?php echo $list['Promo'];?> %</td>
                <td class=" alignCenter"><?php echo $list['PT1Discount'];?> %</td>
                <td class=" alignCenter"><?php echo $list['PT2Discount'];?> %</td>
                <td class="alignRight"><?php echo number_format($list['ProductPriceDefault'],2);?></td>
                <td class="alignRight"><?php echo number_format($list['ProductPricePT1'],2);?></td>
                <td class="alignRight"><?php echo number_format($list['ProductPricePT2'],2);?></td>
              </tr>
            <?php } } ?>
        </table>
          
        </div>
      </div>
    </div>
  </div>
</div>