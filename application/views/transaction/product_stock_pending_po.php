<style type="text/css">
.table-detail thead th,
.table-detail tfoot td {
  background: #3169c6;
  color: #ffffff;
  border-color: #3169c6 !important;
  text-align: center;
  font-size: 12px;
  color: white;
  word-break: break-all; 
  white-space: nowrap; 
  padding: 1px 8px !important;
}
.table-detail tbody tr td,
.table-detail2 tbody tr td {
  font-size: 12px;
  border-color: #3169c6 !important;
  padding: 2px 2px !important;
  word-break: break-all; 
  white-space: nowrap; 
  text-align: center;
}
.table-detail3 { margin-bottom: 5px !important; }
.detailpo2 { display: none; }
.special { background: #ff0; }
</style>
<div class="col-md-12" style="overflow-x: auto; background-color: white;">
<?php if (isset($content['main'])) { ?>
  <table class="table table-bordered table-detail table-responsive nowrap">
    <thead>
      <tr>
        <th>ID</th>
        <th>Date</th>
        <th>PO Shipment</th>
        <th>Note</th>
        <th>Outstanding</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (isset($content['main'])) {
        foreach ($content['main'] as $row => $list) { 
      ?>
        <tr>
            <td><?php echo $list['POID'];?></td>
            <td><?php echo $list['PODate'];?></td>
            <td><?php echo $list['ShippingDate'];?></td>
            <td><?php echo $list['PONote'];?></td>
            <td><?php echo $list['totaldor'];?></td>
            <td>
              <button type='button' class='btn btn-primary btn-xs detailpo' detailid="<?php echo $list['POID'];?>"><i class="fa fa-fw fa-plus-circle"></i></button>
            </td>
        </tr>
        <?php 
          if (isset($content['product'][$list['POID']] )) { 
        ?>
              <tr detailid="<?php echo $list["POID"]; ?>" class="detailpo2">
                <td colspan="6">
                  <table class="table table-bordered table-detail2 table-responsive nowrap" >
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Qty</th>
                        <th>DOR</th>
                        <th>Outstanding</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        foreach ($content['product'][$list['POID']] as $row => $list2) { 
                          if ( $list2['ProductID'] == $content['ProductID'] ) { 
                      ?>
                          <tr class="special">
                        <?php } else { ?>
                          <tr>
                        <?php } ?>
                            <td><?php echo $list2['ProductID'];?></td>
                            <td><?php echo $list2['ProductCode'];?></td>
                            <td><?php echo $list2['ProductQty'];?></td>
                            <td>
                              <table class="table table-bordered table-detail3 table-responsive nowrap">
                                <thead>
                                  <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Qty</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $totaldo = 0;
                                    if (isset($content['dor'][$list['POID']][$list2['ProductID']])) {
                                      foreach ($content['dor'][$list['POID']][$list2['ProductID']] as $row => $list3) { 
                                        $totaldo += $list3['ProductQty'];
                                  ?>
                                        <tr class=" alignCenter">
                                            <td><?php echo $list3['DORID'];?></td>
                                            <td><?php echo $list3['DORDate'];?></td>
                                            <td><?php echo $list3['ProductQty'];?></td>
                                        </tr>
                                  <?php } } ?>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="2">Total</td>
                                    <td><?php echo $totaldo;?></td>
                                  </tr>
                                </tfoot>
                              </table>
                            </td>
                            <td><?php echo $list2['totaldor'];?></td>
                          </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </td>
              </tr>
        <?php } ?>
      <?php } } ?>
    </tbody>
  </table>
<?php } ?>
</div>