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
  }
  .table-detail > tbody > tr > td, .table-detail > thead > tr > th,
  .table-detail2 > tbody > tr > td, .table-detail2 > thead > tr > th { 
    word-break: break-all; 
    white-space: nowrap; 
    font-size: 12px;
  } 
</style>
<table class="table table-bordered table-detail table-responsive">
  <thead>
    <tr>
      <th>Product ID</th>
      <th>Product Code</th>
      <th>Qty order</th>
      <th>Detail PO</th>
      <th>Detail DOR</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($content['product'] as $row => $list) { 
      $ProductID = $list['ProductID'];
    ?>
        <tr>
            <td class=" alignCenter"><?php echo $list['ProductID'];?></td>
            <td><?php echo $list['ProductCode'];?></td>
            <td class=" alignCenter"><?php echo $list['ProductQty'];?></td>
            <td>
              <table class="table table-bordered table-detail2 table-responsive">
                <thead>
                  <tr>
                    <th>POID</th>
                    <th>PO Date</th>
                    <th>Shp Date</th>
                    <th>Qty</th>
                    <th>DOR</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $totalpo = 0;
                    $totaldor = 0;
                    if (isset($content['po'][$ProductID])) {
                      foreach ($content['po'][$list['ProductID']] as $row => $list) { 
                        $totalpo += $list['ProductQty'];
                        $totaldor += $list['DORQty'];
                  ?>
                        <tr class=" alignCenter">
                            <td><?php echo $list['POID'];?></td>
                            <td><?php echo $list['PODate'];?></td>
                            <td><?php echo $list['ShippingDate'];?></td>
                            <td><?php echo $list['ProductQty'];?></td>
                            <td><?php echo $list['DORQty'];?></td>
                        </tr>
                  <?php } } ?>
                  <tr class="total">
                    <td colspan="3">Total</td>
                    <td><?php echo $totalpo;?></td>
                    <td><?php echo $totaldor;?></td>
                  </tr>
                </tbody>
              </table>
            </td>
            <td>
              <table class="table table-bordered table-detail2 table-responsive">
                <thead>
                  <tr>
                    <th>POID</th>
                    <th>DORID</th>
                    <th>DOR Date</th>
                    <th>DOR Qty</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $totaldor = 0;
                    if (isset($content['dor'][$ProductID])) {
                      foreach ($content['dor'][$ProductID] as $row => $list) { 
                        $totaldor += $list['ProductQty'];
                  ?>
                        <tr class=" alignCenter">
                            <td><?php echo $list['POID'];?></td>
                            <td><?php echo $list['DORID'];?></td>
                            <td><?php echo $list['DORDate'];?></td>
                            <td><?php echo $list['ProductQty'];?></td>
                        </tr>
                  <?php } } ?>
                  <tr class="total">
                    <td colspan="3">Total</td>
                    <td><?php echo $totaldor;?></td>
                  </tr>
                </tbody>
              </table>
            </td>
        </tr>
    <?php } ?>
  </tbody>
</table>