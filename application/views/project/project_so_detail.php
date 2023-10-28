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
  <table class="table table-bordered table-detail table-responsive nowrap">
    <thead>
      <tr>
        <th>ProjectID</th>
        <th>SOID</th>
      </tr>
      <?php
        if (isset($content)) {
          foreach ($content as $row => $list) { 
            ?>
            <tr>
              <td><?php echo $list['ProjectID'];?></td>
            </tr>
      <?php } } ?>      
    </thead>
    <tbody>
      
    </tbody>
  </table>
</div>