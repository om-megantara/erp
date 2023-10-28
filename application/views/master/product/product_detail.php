<style type="text/css">
.table-detail tbody tr td {
  font-size: 12px;
  font-weight: bold;
  padding: 2px 12px !important;
  word-break: break-all;
  white-space: nowrap; 
}
</style>

<div class="col-md-12" style="overflow-x: auto; background-color: white;">
  <div class="col-md-6">
    <table class="table table-detail table-responsive nowrap">
      <tbody>
        <tr>
          <td>Product ID</td><td>: <?php echo $content['ProductID']; ?></td>
        </tr>
        <tr>
          <td>Product Code</td><td>: <?php echo $content['ProductCode']; ?></td>
        </tr>
        <tr>
          <td>Product Name</td><td>: <?php echo $content['ProductName']; ?></td>
        </tr>
        <tr>
          <td>Product Supplier</td><td>: <?php echo $content['ProductSupplier']; ?></td>
        </tr>
        <tr>
          <td>Product Description</td><td>: <?php echo nl2br(wordwrap($content['ProductDescription'],65,"<br>\n")); ?></td>
        </tr>
        <tr>
          <td>Product Status</td><td>: <?php echo $content['ProductStatusName']; ?></td>
        </tr>
        <tr>
          <td>Price Default</td><td>: <?php echo number_format($content['ProductPriceDefault']); ?></td>
        </tr>
        <tr>
          <td>For Sale</td><td>: <?php echo $content['forSale']; ?></td>
        </tr>
        <tr>
          <td>Status Active</td><td>: <?php echo $content['isActive']; ?></td>
        </tr>
        <tr>
          <td>Country of Origin</td><td>: <?php echo $content['CountryName']; ?></td>
        </tr>
        <tr>
          <td>Code Bar</td>
          <td>
            : <span class="ProductCodeBar"><?php echo $content['ProductCodeBar']; ?></span>
          </td>
        </tr>
        <tr>
          <td>DOCUMENT</td><td>: <br>

            <?php
            if (isset($content['file'])) {
              foreach ($content['file'] as $row => $list) { 
            ?>
              <img width ="300"; height="300"; src="<?php echo base_url();?>assets/ProductFile/<?php echo $list['FileName'];?>"><br>
                <button type="button" class="btn btn-success btn-xs" onclick="window.open('<?php echo base_url();?>assets/ProductFile/<?php echo $list['FileName'];?>', '_blank');"><i class="fa fa-fw fa-file-image-o"></i>View Full Size</button> <br>
            <?php } } ?>

          </td>
        </tr>
      </tbody>
    </table>  
  </div>
  <div class="col-md-6">
    <table class="table table-detail table-responsive nowrap">
      <tbody>
        <tr>
          <td>Product Category</td><td>: <?php echo $content['category'];?></td>
        </tr>
        <tr>
          <td>Product Brand</td><td>: <?php echo $content['brand'];?></td>
        </tr>
        <tr>
          <td>ATRIBUTE</td><td>:<br>
            <?php
              if (isset($content['atribute'])) { 
                foreach ($content['atribute'] as $row => $list2) { 
                  echo $list2['ProductAtributeName']." : ".$list2['AtributeName']."<br>";
                } 
              }
            ?>
          </td>
        </tr>
        <tr>
          <td>RAW Material </td>
          <td>: <br>
            <?php 
            if (isset($content['rawmaterial'])) {
              foreach ($content['rawmaterial'] as $row => $list) { 
              echo $list2['ProductID']." : ".$list['ProductName']."<br>";
            } } ?>
          </td>
        </tr>
      </tbody>
    </table>  
  </div>
</div>

