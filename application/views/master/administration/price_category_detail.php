<style type="text/css">
.table-detail thead th {
  background: #3169c6;
  color: #ffffff;
  text-align: center;
  color: white;
}
.table-detail { margin-top: 10px; }
.table-detail>thead>tr>th, 
.table-detail>tbody>tr>td {
  font-size: 12px;
  border-color: #3169c6 !important;
  padding: 2px 2px !important;
}
.table-detail > tbody > tr > td, .table-detail > thead > tr > th {
  word-break: break-all; 
  white-space: nowrap; 
}
</style>
<div class="row">
  <div class="col-md-12">
    <div class="box box-solid">
      <div class="box-body box-profile table-responsive">
        <table class="table table-bordered table-detail table-hover">
          <thead>
            <tr>
              <th>Type</th>
              <th>Name</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              foreach ($content as $row => $list) { 
                if ($list['type'] == "price") {
            ?>
                <tr>
                    <td>PriceList</td>
                    <td><?php echo $list['PricelistID']." - ".$list['PricelistName'];?></td>
                    <td><?php echo $list['DateStart']." // ".$list['DateEnd'];?></td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td>PromoVolume</td>
                    <td><?php echo $list['PricelistID']." - ".$list['PricelistName'];?></td>
                    <td><?php echo $list['DateStart']." // ".$list['DateEnd'];?></td>
                </tr>
            <?php } } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>