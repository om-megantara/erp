<div class="row">
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-body box-profile">
        <p class="text-muted"><b>Nama : </b><?php echo $content['pricelist']['PricelistName'];?></p>
        <p class="text-muted"><b>Keterangan : </b><?php echo $content['pricelist']['PricelistNote'];?></p>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-body box-profile">
        <p class="text-muted"><b>Proce Category : </b><?php echo $content['pricelist']['PricecategoryName'];?></p>
		    <p class="text-muted"><b>Start : </b><?php echo $content['pricelist']['DateStart'];?></p>
        <p class="text-muted"><b>End : </b><?php echo $content['pricelist']['DateEnd'];?> </p>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-body box-profile">
        <div class="col-md-10"><b>Product Name</b></div>
        <div class="col-md-2"><b>Percentage</b></div>
        <?php foreach ($content['pricelistd'] as $row => $list) { ?>
    		  <div class="col-md-10"><?php echo $list['ProductID'];?> : <?php echo $list['ProductCode'];?></div>
    		  <div class="col-md-2"><?php echo $list['PriceValue'];?></div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>