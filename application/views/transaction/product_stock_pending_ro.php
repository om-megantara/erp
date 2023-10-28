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
.detailro2 { display: none; }
.special { background: #ff0; }
</style>
<div class="col-md-12" style="overflow-x: auto; background-color: white;">
<?php if (isset($content['main'])) { ?>
  <table class="table table-bordered table-detail table-responsive nowrap">
    <thead>
      <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Outstanding</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($content['main'] as $row => $list) { 
      ?>
        <tr>
            <td><?php echo $list['ROID'];?></td>
            <td><?php echo $list['RODate'];?></td>
            <td><?php echo $list['Outstanding'];?></td>
            <td>
              <button type='button' class='btn btn-primary btn-xs detailro' detailid="<?php echo $list['ROID'];?>"><i class="fa fa-fw fa-plus-circle"></i></button>
            </td>
        </tr>
        <?php 
          if (isset($content['product'][$list['ROID']] )) { 
        ?>
              <tr detailid="<?php echo $list["ROID"]; ?>" class="detailro2">
                <td colspan="6">
                  <table class="table table-bordered table-detail2 table-responsive nowrap" >
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Qty</th>
                        <th>PO</th>
                        <th>Outstanding</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        foreach ($content['product'][$list['ROID']] as $row => $list2) { 
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
                              <table class="table table-bordered table-detail3 table-responsive">
                                <thead>
                                  <tr>
                                    <th>POID</th>
                                    <th>PO Date</th>
                                    <th>Shp Date</th>
                                    <th>Qty</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $totalpo = 0;
                                    if (isset($content['po'][$list['ROID']][$list2['ProductID']])) {
                                      foreach ($content['po'][$list['ROID']][$list2['ProductID']] as $row => $list3) { 
                                        $totalpo += $list3['ProductQty'];
                                  ?>
                                        <tr class=" alignCenter">
                                            <td><?php echo $list3['POID'];?></td>
                                            <td><?php echo $list3['PODate'];?></td>
                                            <td><?php echo $list3['ShippingDate'];?></td>
                                            <td><?php echo $list3['ProductQty'];?></td>
                                        </tr>
                                  <?php } } ?>
                                </tbody>
                                <tfoot>
                                  <tr class="total">
                                    <td colspan="3">Total</td>
                                    <td><?php echo $totalpo;?></td>
                                  </tr>
                                </tfoot>
                              </table>
                            </td>
                            <td><?php echo $list2['ProductPO'];?></td>
                          </tr> 
                      <?php } ?>
                    </tbody>
                  </table>
                </td>
              </tr>
        <?php } ?>
      <?php } ?>
    </tbody>
  </table>
<?php } ?>
</div>