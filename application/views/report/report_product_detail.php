<style type="text/css">
.table-detail tr td {
  font-size: 12px;
  font-weight: bold;
  padding: 2px 12px !important;
  word-break: break-all;
  white-space: nowrap; 
}
.table-detail thead {
  color: white;
  background: #026bbf;
}.Yes { background: #ffc0cb !important; }
</style>
<div class="col-md-12" style="overflow-x: auto; background-color: white;">
  <div class="col-md-6">
    <table class="table table-detail table-responsive nowrap">
      <tbody>
        <tr>
          <td>Product ID</td><td>: <?php echo $content['ProductID']; ?></td>
        </tr>
        <tr>
          <td>Product Code</td><td>: <?php echo $content['ProductCode']; ?></td>
        </tr>
        <tr>
          <td>Product Name</td><td>: <?php echo $content['ProductName']; ?></td>
        </tr> 
        <tr>
          <td>Product Description</td><td>: <?php echo wordwrap($content['ProductDescription'],85,"<br>\n"); ?></td>
        </tr>
        <tr>
          <td>Product Status</td><td>: <?php echo $content['ProductStatusName']; ?></td>
        </tr>
        <tr>
          <td>Price Default</td><td>: <?php echo number_format($content['ProductPriceDefault']); ?></td>
        </tr>
        <tr>
          <td>For Sale</td><td>: <?php echo $content['forSale']; ?></td>
        </tr>
        <tr>
          <td>Status Active</td><td>: <?php echo $content['isActive']; ?></td>
        </tr>
        <tr>
          <td>Country of Origin</td><td>: <?php echo $content['CountryName']; ?></td>
        </tr>
        <tr>
          <td>CATEGORY</td><td>: <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".$content['category']; ?></td>
        </tr>
        <tr>
          <td>BRAND </td><td>: <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".$content['brand']; ?> </td>
        </tr>
        <tr>
          <td>STOCK </td>
          <td>: <br>
            <?php 
              if (isset($content['stock'])) {
                foreach ($content['stock'] as $row => $list2) {
                  echo "&nbsp;&nbsp;&nbsp;&nbsp;".$list2['WarehouseName']." : ".$list2['Quantity']."<br>";
                }
              }
            ?>
          </td>
        </tr>
        <tr>
          <td>ATRIBUTE</td><td>:<br>
            <?php
              if (isset($content['atribute'])) {
                foreach ($content['atribute'] as $row => $list2) {
                  echo "&nbsp;&nbsp;&nbsp;&nbsp;".$list2['ProductAtributeName']." : ".$list2['AtributeName']."<br>";
                }
              }
            ?>
          </td>
        </tr>
        <tr>
          <td>RAW Material </td>
          <td>: <br>
            <?php
              if (isset($content['raw'])) {
                foreach ($content['raw'] as $row => $list2) {
                  echo $list2['ProductID']." : ".$list2['ProductCode']."<br>";
                }
              }
            ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="col-md-1">
    <center><b>Foto</b></center>
  </div>
  <div class="col-md-4">
    <div id="myCarousel" class="carousel slide" data-ride="carousel" style="padding:30px;">
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <?php
          $Key= " active";
          if (isset($content['file'])) {
            foreach ($content['file'] as $row => $list) {
        ?>
        <div class="item <?php echo $Key; ?> ">
          <button type="button" class="btn2" onclick="window.open('<?php echo base_url();?>assets/ProductFile/<?php echo $list['FileName'];?>', '_blank');">
            <img src="<?php echo base_url();?>assets/ProductFile/<?php echo $list['FileName'];?>" alt="<?php echo $content['ProductName']; ?>" width ="300"; height="300";>
          </button>
        </div>
        <?php $Key = ""; }}else {?>
          <img class="card-img-top" width ="300"; height="300"; src="<?php echo base_url();?>assets/ProductFile/No_Image.jpg"><br>
        <?php }?>
      </div>
    </div>
  </div>
  <div class="col-md-1">
  </div>
  <div class="col-md-12">
    <?php if (isset($content['pricelist'])) {?>
      <table class="table table-detail table-responsive nowrap">
        <thead>
          <tr>
            <td class="alignCenter" colspan=10>PRICE LIST</td>
          </tr>
          <tr>
            <!-- <td class="alignCenter">Price Category Name</td> -->
            <td class="alignCenter">Price List Name</td>
            <td class="alignCenter">Qty</td>
            <td class="alignCenter">Promo Category</td>
            <td class="alignCenter">Promo</td>
            <td class="alignCenter">TOP</td>
            <td class="alignCenter">CBD</td>
            <td class="alignCenter">Price EndUser</td>
            <td class="alignCenter">Price Category</td>
            <td class="alignCenter">Price TOP</td>
            <td class="alignCenter">Price CBD</td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($content['pricelist'] as $row => $list) {?>
              <tr>
                <!-- <td class=""><?php echo $list['PricecategoryName'];?></td> -->
                <td class=""><?php echo '('.$list['PricelistID'].') '.$list['PricelistName'];?></td>
                <td class=""><?php echo $list['ProductQty'];?></td>
                <td class=""><?php echo $list['PromoCategory'];?> %</td>
                <td class=""><?php echo $list['Promo'];?> %</td>
                <td class=""><?php echo $list['PT1Discount'];?> %</td>
                <td class=""><?php echo $list['PT2Discount'];?> %</td>
                <td class="alignRight"><?php echo number_format($list['ProductPriceDefault']);?></td>
                <td class="alignRight"><?php echo number_format($list['PriceAfterCategory']);?></td>
                <td class="alignRight"><?php echo number_format($list['ProductPricePT1']);?></td>
                <td class="alignRight"><?php echo number_format($list['ProductPricePT2']);?></td>
              </tr>
          <?php }?>
        </tbody>
      </table>
    <?php }?>
  </div>
  <div class="col-md-12">
    <?php if (isset($content['minmaxhistory'])) {?>
      <table class="table table-detail table-responsive nowrap">
        <thead>
          <tr>
            <td class="alignCenter" colspan=4>MIN MAX HISTORY</td>
          </tr>
          <tr>
            <!-- <td class="alignCenter">Price Category Name</td> -->
            <td class="alignCenter">No</td>
            <td class="alignCenter">Min Stock</td>
            <td class="alignCenter">Max Stock</td>
            <td class="alignCenter">Date</td>
          </tr>
        </thead>
        <tbody>
          <?php $no= 0; foreach ($content['minmaxhistory'] as $row => $list) {$no++; ?>
              <tr>
                <!-- <td class=""><?php echo $list['PricecategoryName'];?></td> -->
                <td class="alignCenter"><?php echo $no;?></td>
                <td class="alignCenter"><?php echo $list['MinStock'];?></td>
                <td class="alignCenter"><?php echo $list['MaxStock'];?></td>
                <td class="alignCenter"><?php echo $list['InputDate'];?></td>
              </tr>
          <?php }?>
        </tbody>
      </table>  
    <?php }?>
  </div>
  <div class="col-md-12">
    <?php if (isset($content['promohistory'])) {?>
      <table class="table table-detail table-responsive nowrap">
        <thead>
          <tr>
            <td class="alignCenter" colspan=12>PROMO HISTORY</td>
          </tr>
          <tr>
            <!-- <td class="alignCenter">Price Category Name</td> -->
            <td class="alignCenter">Promo Name</td>
            <td class="alignCenter">Qty</td>
            <td class="alignCenter">Date</td>
            <td class="alignCenter">NonActiveDate</td>
            <td class="alignCenter">Promo Category</td>
            <td class="alignCenter">Promo</td>
            <td class="alignCenter">TOP</td>
            <td class="alignCenter">CBD</td>
            <td class="alignCenter">Price EndUser</td>
            <td class="alignCenter">Price Category</td>
            <td class="alignCenter">Price TOP</td>
            <td class="alignCenter">Price CBD</td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($content['promohistory'] as $row => $list) {?>
              <tr>
                <!-- <td class=""><?php echo $list['PricecategoryName'];?></td> -->
                <td class=""><?php echo '('.$list['PromoID'].') '.$list['PromoName'];?></td>
                <td class=""><?php echo $list['ProductQty'];?></td>
                <td class=""><?php echo $list['InputDate'];?></td>
                <td class=""><?php echo $list['NonActiveDate'];?></td>
                <td class=""><?php echo $list['PromoCategoryPercent'];?> %</td>
                <td class=""><?php echo $list['Promo'];?> %</td>
                <td class=""><?php echo $list['PT1Discount'];?> %</td>
                <td class=""><?php echo $list['PT2Discount'];?> %</td>
                <td class="alignRight <?php echo $list['isActiveDate'];?>"><?php echo number_format($list['ProductPriceDefault']);?></td>
                <td class="alignRight <?php echo $list['isActiveDate'];?>"><?php echo number_format($list['PriceAfterCategory']);?></td>
                <td class="alignRight <?php echo $list['isActiveDate'];?>"><?php echo number_format($list['ProductPricePT1']);?></td>
                <td class="alignRight <?php echo $list['isActiveDate'];?>"><?php echo number_format($list['ProductPricePT2']);?></td>
              </tr>
          <?php }?>
        </tbody>
      </table>
    <?php }?>
  </div>
  <div class="col-md-12">
    <?php if (isset($content['shop'])) {?>
      <table class="table table-detail table-responsive nowrap">
        <thead>
          <tr>
            <td class="alignCenter" colspan=5>SHOP</td>
          </tr>
          <tr>
            <td class="alignCenter">Shop Name</td>
            <td class="alignCenter">Input Date</td>
            <td class="alignCenter">Last Update Link</td>
            <td class="alignCenter">Last Check</td>
            <td class="alignCenter">Link Text</td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($content['shop'] as $row => $list) {?>
              <tr>
                <td class=""><?php echo $list['ShopName'];?></td>
                <td class="alignCenter"><?php echo $list['InputDate'];?></td>
                <td class="alignCenter"><?php echo $list['LinkDate'];?></td>
                <td><?php echo $list['CheckDate'];?></td>
                <td class="">
                  <a href="<?php echo $list['LinkText'];?>" class="btn btn-primary btn-xs" style="margin: 0px;" target="_blank" title="OPEN LINK"><i class="fa fa-fw fa-link"></i></a>
                  <?php if (in_array("product_link_list", $MenuList)) {?>
                  <a title="APPROVE LINK" href="#" id="approve" class="btn btn-success btn-xs approve" style="margin: 0px;" target="_blank" OrderID="<?php echo $list['OrderID'];?>"><i class="fa fa-fw fa-check-square"></i></a></i></a>
                  <a title="REJECT LINK" href="<?php echo base_url().'master/product_link_reject?OrderID='.$list['OrderID'];?>" target="_blank" id="reject" class="btn btn-danger btn-xs reject" style="margin: 0px;" OrderID="<?php echo $list['OrderID'];?>"><i class="fa fa-fw fa-minus-square"></i></a>
                  <?php }?>
                </td>
              </tr>
          <?php }?>
        </tbody>
      </table>  
    <?php }?>
  </div>
  <div class="col-md-6">
    <?php if (isset($content['exp'])) {?>
      <table class="table table-detail table-responsive nowrap">
        <thead>
          <tr>
            <td class="alignCenter" colspan=5>Expiry Date</td>
          </tr>
          <tr>
            <td class="alignCenter">DOR</td>
            <td class="alignCenter">Expiry Date</td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($content['exp'] as $row => $list) {?>
              <tr>
                <td class=""><?php echo $list['NoReff'];?></td>
                <td class="alignCenter"><?php echo $list['EXPDate'];?></td>
              </tr>
          <?php }?>
        </tbody>
      </table>
    <?php } ?>
  </div>
  <div class="col-md-6">
  </div>
</div>