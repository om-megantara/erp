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
.table-detail tbody tr td {
  font-size: 12px;
  border-color: #3169c6 !important;
  padding: 2px 5px !important;
  word-break: break-all; 
  white-space: nowrap; 
} 
</style>

<div class="col-md-12" style="overflow-x: auto; background-color: white;">
<?php  if (isset($content)) { ?>
  <table class="table table-bordered table-detail table-responsive nowrap">
    <thead>
      <tr>
        <th>ID</th>
        <th>Customer Name</th>
        <th>Category</th>
        <th>Phone Number</th>
        <th>Maps</th>
        <th>Last Order</th>
        <th>Days CFU</th>
        <th>Days CV</th>
        <th>Sales</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
          foreach ($content as $row => $list) { 
      ?>
          <tr>
              <td>
                <?php echo $list['CustomerID'];?>
              </td>
              <td class="bold">
                <a href="<?php echo base_url();?>master/customer_cu/<?php echo $list['ContactID'];?>" target="_blank"><?php echo $list['Name'];?></a>
              </td>
              <td class="alignCenter"><?php echo $list['Category'];?></td>
              <td class="alignCenter"><?php echo $list['Phone'];?></td>
              <td class="alignCenter bold"><a href="https://www.google.com/maps/search/<?php echo $list['Address'];?>" target="_blank">Link</a></td>
              
              <?php if ($list['Last'] != '') { ?>
              <td class="alignCenter">
              <?php } else { ?>
              <td class="empty">
              <?php } ?>
                <?php echo $list['INVDate']; if ($list['Last'] != ''){echo " (".$list['Last'].")";}else{}?>
              </td>
              <td> <?php echo $list['CFU']; if ($list['lastcfu'] != ''){echo " (".$list['lastcfu'].")";}else{}?>
              </td>
              <td><?php echo $list['CV']; if ($list['lastcv'] != ''){echo " (".$list['lastcv'].")" ;}else{}?></td>
              <?php if ($list['Sales'] != '') { ?>
                <td class="alignCenter"><?php echo wordwrap($list['Sales'],30,"<br>\n");?></td>
              <?php } else { ?>
                <td class="empty"></td>
              <?php } ?>
              <td class="alignCenter">
                <button type="button" class="btn btn-primary btn-xs" onclick="window.open('<?php echo base_url();?>master/customer_cu/<?php echo $list['ContactID'];?>', '_blank');" title='EDIT CUSTOMER'><i class="fa fa-fw fa-edit"></i></button>
                <button type="button" class="btn btn-success btn-xs" onclick="window.open('<?php echo base_url();?>marketing/marketing_activity_add?CustomerID=<?php echo $list['CustomerID'];?>', '_blank');" title='ADD ACTIVITY'><i class="fa fa-fw fa-comment-o"></i></button>
              </td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
<?php } ?>
</div>