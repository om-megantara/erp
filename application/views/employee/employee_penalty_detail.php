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
.table-detail { margin-top: 10px; }
.table-detail tbody tr td {
  font-size: 12px;
  border-color: #3169c6 !important;
  padding: 2px 6px !important;
  word-break: break-all; 
  white-space: nowrap; 
  text-align: center;
}
.table-detail tbody tr:hover {
  background-color: #3c8dbc;
  font-weight: bold;
  color: white;
}
.table-history td,
.table-history th {
  font-size: 12px;
  padding: 2px 6px !important;
  word-break: break-all; 
  white-space: nowrap; 
} 
.table-main { margin-bottom: 5px !important; }
.table-main tbody>tr>td {
  font-size: 12px;
  padding: 2px 12px !important;
  /*word-break: break-all; */
  white-space: nowrap; 
  word-wrap: break-word;
  max-width: 400px;
  vertical-align: top;
}
.table-main td.longLast  {
  white-space: normal !important;
  word-wrap: break-word !important;
}
</style>

<div class="col-md-12" style="overflow-x: auto; background-color: white;">
  <table class="table table-bordered table-detail table-responsive nowrap">
    <thead>
      <tr>
        <th>Penalty Order ID</th>
        <th>Date</th>
        <th>Penalty</th>
        <th>Point</th>
        <th>Nominal</th>
        <th>Created By</th>
        <th>Note</th>
        <th>Link</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($content as $row => $list) { 
      ?>
          <tr>
              <td style="text-align:center"><?php echo $list['PenaltyOrderID'];?></td>
              <td style="text-align:center"><?php echo $list['Date'];?></td>
              <td style="text-align:center"><?php echo $list['PenaltyName'];?></td>
              <?php if($list['PenaltyType']=='pnt'){?>
              <td style="text-align:center"><?php echo $list['Poin'];?></td>
              <td style="text-align:center"><?php echo "Rp ".number_format($list['Nominal']);?></td>
              <?php } else {?>
              <td style="text-align:center"><?php echo $list['Quantity'];?></td>
              <td style="text-align:center"><?php echo "Rp ".number_format($list['Nominal'])." + ".$list['Potongan'];?></td>
              <?php } ?>
              <td style="text-align:center;"><?php echo $list['fullname'];?></td>
              <td style="text-align:center;"><?php echo $list['Note'];?></td>
              <td style="text-align:center;"><a href="<?php echo $list['Link'];?>" target="_blank" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-fw fa-link"></i></a></td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
</div>