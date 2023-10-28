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
}
</style>
<div class="col-md-12" style="overflow-x: auto; background-color: white;">
  <div class="col-md-12">
    <?php if (isset($content['pricelist'])) { ?>

      <table class="table table-detail table-responsive nowrap">
        <thead>
          <tr>
            <td class="alignCenter">Product Name</td>
            <td class="alignCenter">Price List Name</td>
            <td class="alignCenter">Price EndUser</td>
            <td class="alignCenter">Price Category</td>
            <td class="alignCenter">Price TOP</td>
            <td class="alignCenter">Price CBD</td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($content['pricelist'] as $row => $list) { ?>
              <tr>
                <td class=""><?php echo $list['ProductName'];?></td>
                <td class=""><?php echo $list['PricelistName'];?></td>
                <td class="alignRight"><?php echo number_format($list['ProductPriceDefault']);?></td>
                <td class="alignRight"><?php echo number_format($list['PriceAfterCategory']);?></td>
                <td class="alignRight" style="color:blue"><?php echo number_format($list['ProductPricePT1']);?></td>
                <td class="alignRight"><?php echo number_format($list['ProductPricePT2']);?></td>
              </tr>
          <?php } ?>
        </tbody>
      </table>  
    <?php } ?>
  </div>
  
</div>