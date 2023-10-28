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
            <td class="alignCenter">Customer</td>
            <td class="alignCenter">Product Name</td>
            <td class="alignCenter">SOID</td>
            <td class="alignCenter">SO Date</td>
            <td class="alignCenter">SO Category</td>
            <td class="alignCenter">Qty</td>
            <td class="alignCenter">Price</td>
            <td class="alignCenter">Status</td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($content['pricelist'] as $row => $list) { ?>
              <tr>
                <td class=""><?php echo $list['Company2'];?></td>
                <td class=""><?php echo $list['ProductName'];?></td>
                <td class=""><?php echo $list['SOID'];?></td>
                <td class=""><?php echo $list['SODate'];?></td>
                <td class=""><?php echo $list['CategoryName'];?></td>
                <td class="alignRight"><?php echo number_format($list['ProductQty']);?></td>
                <td class="alignRight"><?php echo number_format($list['PriceAmount']);?></td>
                <td class="alignCenter"><?php if($list['SOConfirm2']==0){echo "SO Pending";} else {echo "SO Confirmed";};?></td>
              </tr>
          <?php } ?>
        </tbody>
      </table>  
    <?php } ?>
  </div>
  
</div>