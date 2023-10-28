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
.empty { background-color: #fbcb5b; }
.table-detail { margin-top: 10px; }
.table-detail2 { margin-bottom: 0px !important; }
.table-detail tbody tr td,
.table-detail2 tbody tr td,
.table-detail2 tfoot tr td {
  font-size: 12px;
  border-color: #3169c6 !important;
  padding: 2px 2px !important;
  word-break: break-all; 
  white-space: nowrap; 
  text-align: center;
}
.table-history td,
.table-history th,
.table-history-2 th,
.table-history-2 td {
  font-size: 12px;
  padding: 2px 2px !important;
  word-break: break-all; 
  white-space: nowrap; 
}
.table-history-2 th,
.table-history-2 td {
  text-align: center;
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

<?php
// print_r($data);
// $main = $content['product']['main'];
// $billing  = explode(";",$main['BillingAddress']);
// $shipping = explode(";",$main['ShipAddress']);
?>
<div class="col-md-12" style="overflow-x: auto; background-color: white;">
<?php  if (isset($content)) { ?>
  <table class="table table-bordered table-detail table-responsive nowrap">
    <thead>
      <tr>
        <th>ID</th>
        <th>Customer Name</th>
        <th>Category</th>
        <th>Phone Number</th>
        <th>City</th>
        <th>Last Order</th>
        <th>Previous Omzet</th>
        <th>Latest Omzet</th>
        <th>Total Omzet</th>
        <th>Days</th>
        <th>Sales</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
          foreach ($content as $row => $list) { 
            $ConID=$list['ContactID'];
      ?>
          <tr>
              <td style="text-align:left"><?php echo $list['CustomerID'];?></td>
              <td style="text-align:center"><a href="<?php echo base_url();?>master/customer_cu/<?php echo $ConID;?>" target="_blank"><?php echo wordwrap($list['Name'], 20,"<br>\n");?></a></td>
              <td style="text-align:center"><?php echo $list['Category'];?></td>
              <td style="text-align:center"><?php echo $list['Phone'];?></td>
              <td style="text-align:center"><?php echo $list['City'];?></td>
              <td style="text-align:right"><?php echo $list['INVDate'];?></td>
              <td style="text-align:right"><?php echo number_format($list['total2'],2);?></td>
              <td style="text-align:right"><?php echo number_format($list['total'],2);?></td>
              <td style="text-align:right"><?php echo number_format($list['Omzet'],2);?></td>
              <td style="text-align:right"><?php echo $list['Last'];?></td>

              <?php if ($list['Sales'] != '') { ?>
                <td style="text-align:center" class=""><?php echo wordwrap($list['Sales'],30,"<br>\n");?></td>
              <?php } else { ?>
                <td class="empty"></td>
              <?php } ?>
              <td><button type="button" class="btn btn-primary btn-xs" onclick="window.open('<?php echo base_url();?>master/customer_cu/<?php echo $ConID;?>', '_blank');"> Edit Customer</button></td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
<?php } ?>
</div>