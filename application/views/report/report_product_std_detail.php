<style type="text/css">
.table-detail tr td {
  font-size: 13px;
  font-weight: bold;
  padding: 2px 6px !important;
  word-break: break-all;
  white-space: nowrap; 
}
.table-detail thead {
  color: white;
  width: 100%;
  text-align: left;
  background: #026bbf;
}
</style>
<div class="col-md-12" style="overflow-x: auto; background-color: white;">
  <div class="col-md-6">
    <table class="table table-detail table-responsive nowrap">
      <tbody>
        <tr><td></td></tr>
        <tr>
          <td class="table-detail">Product ID</td><td class="table-detail">: <?php echo $content['ProductID']; ?></td>
        </tr>
        <tr>
          <td class="table-detail">Product Code</td><td class="table-detail">: <?php echo $content['ProductCode']; ?></td>
        </tr>
        <tr>
          <td class="table-detail">Product Name</td><td class="table-detail">: <?php echo $content['ProductName']; ?></td>
        </tr> 
        <tr>
          <td class="table-detail">STOCK </td>
          <td class="table-detail">: <br>
            <table>
              <?php 
                if (isset($content['stock'])) { 
                  foreach ($content['stock'] as $row => $list2) { 
              ?>
              <tr>
                <td><?php echo $list2['WarehouseName']; ?></td>
                <td>:</td>
                <td><?php echo $list2['Quantity']; ?></td>
              </tr>      
              <?php      
                  } 
                }
              ?>
            </table>
            
          </td>
        </tr>
      </tbody>
    </table>  
  </div>
</div>