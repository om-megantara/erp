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
    padding: 2px 2px !important;
    font-size: 12px !important;
  }
  .table-detail > tbody > tr > td, .table-detail > thead > tr > th,
  .table-detail2 > tbody > tr > td, .table-detail2 > thead > tr > th { 
    word-break: break-all; 
    white-space: nowrap; 
  }
</style>
<div style="overflow: auto;">
  <table class="table table-bordered table-detail table-responsive" style="background-color: white;">
    <thead>
      <tr>
        <th>Invoice ID</th>
        <th>Product ID</th>
        <th>Product Code</th>
        <th>Quantity</th>
        <th>Promo %</th>
        <th>PT %</th>
        <th>PV</th>
        <th>Price</th>
        <th>PV/Price (%)</th>
        <th>Multiplier</th>
        <th>Late</th>
        <th>Penalty %</th>
        <th>Total PV</th>
        <th>INV Percent</th>
        <th>Total Omzet</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $Total_qty = 0;
        $Total_pv = 0;
        $Total_omzet = 0;
        $Total_pv_omzet = 0;
        foreach ($content as $row => $list) { 
          $Total_pv += $list['PV_final'];
          $Total_qty += $list['ProductQty'];

          $omzet = $list['PriceAmount'] * $list['ProductQty'];
          $Total_omzet += $omzet;

      ?>
          <tr>
              <td class="alignCenter"><?php echo $list['INVID'];?></td>
              <td class="alignCenter"><?php echo $list['ProductID'];?></td>
              <td><?php echo $list['ProductCode'];?></td>
              <td class="alignCenter"><?php echo $list['ProductQty'];?></td>
              <td class="alignCenter"><?php echo $list['Promo'];?></td>
              <td class="alignCenter"><?php echo $list['PT'];?></td>
              <td class="alignCenter"><?php echo number_format($list['PV'],2);?></td>
              <td class="alignRight"><?php echo number_format($list['PriceAmount'],2);?></td>
              <td class="alignCenter"><?php echo number_format($list['PV_to_price'],2);?></td>
              <td class="alignCenter"><?php echo $list['ProductMultiplier'];?></td>
              <td class="alignCenter"><?php echo $list['late'];?></td>
              <td class="alignCenter"><?php echo $list['penalty'];?></td>
              <td class="alignRight"><?php echo number_format($list['PV_final'],2);?></td>
              <td class="alignRight"><?php echo number_format($list['PercentINV'],2).' %';?></td>
              <td class="alignRight"><?php echo number_format($omzet,2);?></td>
          </tr>
      <?php } 
          $Total_pv_omzet = ($Total_pv / $Total_omzet) *100 ;
      ?>
          <tr><td colspan="14"></td></tr>
          <tr>
              <td class="alignCenter" colspan='3'>TOTAL </td>
              <td class="alignCenter"><?php echo number_format($Total_qty);?></td>
              <td class="alignCenter" colspan='4'></td>
              <td class="alignCenter"><?php echo number_format($Total_pv_omzet,2);?></td>
              <td class="alignCenter" colspan='3'></td>
              <td class="alignRight"><?php echo number_format($Total_pv,2);?></td>
              <td></td>
              <td class="alignRight"><?php echo number_format($Total_omzet,2);?></td>
          </tr>
    </tbody>
  </table>
</div>