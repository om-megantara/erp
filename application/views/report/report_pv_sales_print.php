<style type="text/css">
  .table-detail thead th, .total {
    text-align: center;
    background: #b5b5b5;
    font-weight: bold;
  }
  .table-detail, .table-detail thead tr th, .table-detail tbody tr td {
    border-collapse: collapse !important;
    padding: 3px 4px !important;
    font-size: 10px;
  }
  .table-detail tbody tr td, .table-detail thead tr th { 
    word-break: break-all; 
    white-space: nowrap; 
    border: 1px solid;
  } 
</style>
<div style="">
  Sales : <?php echo $content['sales']; ?>
  <table class="table table-detail table-bordered table-responsive">
    <thead>
      <tr>
        <th>INV ID</th>
        <th>Product ID</th>
        <th>Product Code</th>
        <th>Qty</th>
        <th>Promo %</th>
        <th>PT %</th>
        <th>PV</th>
        <th>Price</th>
        <th>Total</th>
        <th>PV/Price (%)</th>
        <th>Multiplier</th>
        <th>Late</th>
        <th>Penalty %</th>
        <th>PV Amount</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $totalqty = 0;
        $totalpv = 0;
        $totalpvamount = 0;
        $totalprice = 0;
        foreach ($content['main'] as $row => $list) { 
          $totalqty += $list['ProductQty'];
          $totalpv += $list['PV'];
          $totalpvamount += $list['PV_final'];
          $totalprice += $list['PriceTotal'];
      ?>
          <tr>
              <td class=" alignCenter"><?php echo $list['INVID'];?></td>
              <td class=" alignCenter"><?php echo $list['ProductID'];?></td>
              <td><?php echo $list['ProductCode'];?></td>
              <td class=" alignCenter"><?php echo $list['ProductQty'];?></td>
              <td class=" alignCenter"><?php echo $list['Promo'];?></td>
              <td class=" alignCenter"><?php echo $list['PT'];?></td>
              <td class=" alignCenter"><?php echo number_format($list['PV'],3);?></td>
              <td class="alignRight"><?php echo number_format($list['PriceAmount'],2);?></td>
              <td class="alignRight"><?php echo number_format($list['PriceTotal'],2);?></td>
              <td class=" alignCenter"><?php echo number_format($list['PV_to_price'],3);?></td>
              <td class=" alignCenter"><?php echo $list['ProductMultiplier'];?></td>
              <td class=" alignCenter"><?php echo $list['late'];?></td>
              <td class=" alignCenter"><?php echo $list['penalty'];?></td>
              <td class="alignRight"><?php echo number_format($list['PV_final']);?></td>
          </tr>
      <?php } ?>
        <tr class="total">
          <td colspan="3" class=" alignCenter">Total</td>
          <td class=" alignCenter"><?php echo number_format($totalqty);?></td>
          <td></td>
          <td></td>
          <td class="alignRight"><?php echo number_format($totalpv,3);?></td>
          <td></td>
          <td class="alignRight"><?php echo number_format($totalprice,2);?></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="alignRight"><?php echo number_format($totalpvamount);?></td>
        </tr>
    </tbody>
  </table>
</div>