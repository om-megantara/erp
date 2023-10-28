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
.detailraw2 { display: none; }
.special { background: #ff0; }
</style>
<div class="col-md-12" style="overflow-x: auto; background-color: white;">
<?php if (isset($content['po']['main'])) { ?>
  <table class="table table-bordered table-detail table-responsive nowrap">
    <thead>
      <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Shipping</th>
        <th>Note</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($content['po']['main'] as $row => $list) { 
      ?>
        <tr>
            <td>PO <?php echo $list['POID'];?></td>
            <td><?php echo $list['PODate'];?></td>
            <td><?php echo $list['ShippingDate'];?></td>
            <td><?php echo $list['PONote'];?></td>
            <td>
              <button type='button' class='btn btn-primary btn-xs detailraw' detailid="<?php echo $list['POID'];?>"><i class="fa fa-fw fa-plus-circle"></i></button>
            </td>
        </tr>
        <?php 
          if (isset($content['po']['raw'][$list['POID']] )) { 
        ?>
            <tr detailid="<?php echo $list["POID"]; ?>" class="detailraw2">
              <td colspan="6">
                <table class="table table-bordered table-detail2 table-responsive nowrap" >
                  <thead>
                    <tr>
                      <th>Raw ID</th>
                      <th>Product Code</th>
                      <th>Qty Requested</th>
                      <th>Qty Sent</th>
                      <th>Pending</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($content['po']['raw'][$list['POID']])) {
                      foreach ($content['po']['raw'][$list['POID']] as $row => $list2) { 
                        if ( $list2['RawID'] == $content['ProductID'] ) { 
                      ?>
                          <tr class="special">
                        <?php } else { ?>
                          <tr>
                        <?php } ?>
                            <td><?php echo $list2['RawID'].'('.$list2['ProductID'].')';?></td>
                            <td><?php echo $list2['RawName'].'<br>('.$list2['ParentName'].')';?></td>
                            <td><?php echo $list2['RawQty'];?></td>
                            <td><?php echo $list2['RawSent'];?></td>
                            <td><?php echo $list2['RawQty']-$list2['RawSent'];?></td>
                        </tr>
                    <?php } } ?>
                  </tbody>
                </table>
              </td>
            </tr>
        <?php } ?>
      <?php } ?>
    </tbody>
  </table>
<?php } ?>
<br> 
<?php if (isset($content['ro']['main'])) { ?>
  <table class="table table-bordered table-detail table-responsive nowrap">
    <thead>
      <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Note</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($content['ro']['main'] as $row => $list) { 
      ?>
        <tr>
            <td>RO <?php echo $list['ROID'];?></td>
            <td><?php echo $list['RODate'];?></td>
            <td><?php echo $list['RONote'];?></td>
            <td>
              <button type='button' class='btn btn-primary btn-xs detailraw' detailid="<?php echo $list['ROID'];?>"><i class="fa fa-fw fa-plus-circle"></i></button>
            </td>
        </tr>
        <?php 
          if (isset($content['ro']['raw'][$list['ROID']] )) { 
        ?>
            <tr detailid="<?php echo $list["ROID"]; ?>" class="detailraw2">
              <td colspan="6">
                <table class="table table-bordered table-detail2 table-responsive nowrap" >
                  <thead>
                    <tr>
                      <th>Product ID</th>
                      <th>Raw ID</th>
                      <th>Qty Requested</th>
                      <th>Qty PO</th>
                      <th>Pending</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($content['ro']['raw'][$list['ROID']])) {
                      foreach ($content['ro']['raw'][$list['ROID']] as $row => $list2) { 
                        if ( $list2['RawID'] == $content['ProductID'] ) { 
                      ?>
                          <tr class="special">
                        <?php } else { ?>
                          <tr>
                        <?php } ?>
                            <td><?php echo $list2['ProductID'];?></td>
                            <td><?php echo $list2['RawID'];?></td>
                            <td><?php echo $list2['RawQty'];?></td>
                            <td><?php echo $list2['total'];?></td>
                            <td><?php echo $list2['RawQty']-$list2['total'];?></td>
                        </tr>
                    <?php } } ?>
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