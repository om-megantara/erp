<?php
$main = $content['main'];
$product = $content['product'];
?>

<style type="text/css">
  .table-main tr td {
    font-size: 12px;
    padding: 2px 8px !important;
    white-space: nowrap !important;
  }

  .table-display-list { 
    font-size: 12px !important; 
    white-space: nowrap; 
    background: #ffffff;
  }
  .table-display-list td {
    padding: 2px 5px !important;
  }
  #myInput { margin: 10px 0px; width: 100%; }
  .box-body { overflow: auto; }
</style>
 
<div class="row">
  <div class="col-md-6">
    <div class="box box-solid">
        <table class="table table-hover table-main">
          <tr>
            <td>Shop Name</td>
            <td>: <?php echo $main['ShopName'];?></td>
          </tr>
          <tr>
            <td>Shop Link</td>
                      
            <td>: 
            	<a href="<?php echo $main['ShopLink'];?>" class="btn btn-success btn-xs" style="margin: 0px;" target="_blank" title="OPEN LINK"><i class="fa fa-fw fa-link"></i></a>
            	<?php echo $main['ShopLink'];?>
            </td>
          </tr>
        </table>
    </div>
  </div>

  <div class="col-md-6">
    <div class="box box-solid">
        <table class="table table-hover table-main">
          <tr>
            <td>Sales Name</td>
            <td>: <?php echo $main['SalesName'];?></td>
          </tr>
          <tr>
            <td>Shop Note</td>
            <td>: <?php echo $main['ShopNote'];?></td>
          </tr>
        </table> 
    </div>
  </div>
  <div class="col-md-12" style="max-height: 300px;">
    <div class="box box-solid">
      <div class="box-body no-padding">
        <input type="text" class="form-control input-sm" placeholder="SEARCH CONTENT" onkeyup="search_modal();" id="myInput" autocomplete="off">
        <div style="overflow-x:auto; max-height: 250px;">
          <table class="table table-display-list table-bordered" id="table_modal">
            <thead>
              <tr>
                <th class="alignCenter">Product ID</th>
                <th class="alignCenter">Product Name</th>
                <th class="alignCenter">Date Product</th>
                <th class="alignCenter">Link</th>
                <th class="alignCenter">Date Link</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if (isset($content['product'])) {
                foreach ($content['product'] as $row => $list) { 
              ?>
                <tr>
                  <td class="alignCenter"><?php echo $list['ProductID'];?></td>
                  <td class=""><?php echo $list['ProductName'];?></td>
                  <td class="alignCenter"><?php echo $list['InputDate'];?></td>
                  <td class="">
                    <?php if ($list['LinkText'] != "") { ?>
              		    <a href="<?php echo $list['LinkText'];?>" class="btn btn-success btn-xs" style="margin: 0px;" target="_blank" title="OPEN LINK"><i class="fa fa-fw fa-link"></i></a>
                    	<?php echo $list['LinkText'];?> 
                    <?php } ?>
                  </td>
                  <td class="alignCenter"><?php echo $list['LinkDate'];?> </td>
                </tr>
              <?php } } ?>
            </tbody>
          </table>
          
        </div>
      </div>
    </div>
  </div>
</div>
