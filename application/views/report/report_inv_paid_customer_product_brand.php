<style type="text/css">
  .table-detail thead th,
  .table-detail2 thead th,
  .total {
    background: #3169c6;
    color: #ffffff;
    text-align: center;
    color: white;
  }
  .table-detail, 
  .table-detail>thead>tr>th, 
  .table-detail>tbody>tr>td,
  .table-detail2, 
  .table-detail2>thead>tr>th, 
  .table-detail2>tbody>tr>td {
    border-color: #3169c6 !important;
    padding: 2px 5px !important;
    font-size: 12px !important;
  }
  .table-detail > tbody > tr > td, .table-detail > thead > tr > th,
  .table-detail2 > tbody > tr > td, .table-detail2 > thead > tr > th { 
    word-break: break-all; 
    white-space: nowrap; 
  }
  .table-detail > tbody > tr:hover {
    background-color: #597fbe;
  }
</style>
<div style="overflow: auto;">
  <table class="table table-bordered table-detail table-responsive" style="background-color: white;">
    <thead>
      <tr>
        <th>Product Brand</th>
        <th>Total Qty</th>
        <th>Total Price</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $Total_qty = 0;
        $Total_price = 0;
        $main = $content['main'];
        foreach ($content['brand'] as $row => $list) { 
          if (isset($main[$list['ProductBrandID']])) {
            $Total_qty += $main[$list['ProductBrandID']]['ProductQty'];
            $Total_price += $main[$list['ProductBrandID']]['PriceTotal'];
      ?>
            <tr>
                <td class=""><?php echo $list['ProductBrandName'];?></td>
                <td class="alignRight"><?php echo number_format($main[$list['ProductBrandID']]['ProductQty']);?></td>
                <td class="alignRight"><?php echo number_format($main[$list['ProductBrandID']]['PriceTotal'],2);?></td>
            </tr>
      <?php } } ?>
          <tr><td colspan="3"></td></tr>
          <tr>
              <td class="alignCenter">TOTAL </td>
              <td class="alignRight"><?php echo number_format($Total_qty);?></td>
              <td class="alignRight"><?php echo number_format($Total_price,2);?></td>
          </tr>
    </tbody>
  </table>
</div>