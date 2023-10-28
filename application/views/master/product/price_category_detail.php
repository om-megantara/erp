<div class="row">
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-body box-profile">
        <!-- <h3 class="profile-username text-center">Price List</h3> -->
        <?php foreach ($content as $row => $list) { ?>
          <p class="text-muted"><a href="<?php echo base_url();?>master/price_list/<?php echo $list['PricelistID'];?>" id="edit" class="edit" style="margin: 0px;"target="_blank" title="EDIT"><?php echo $list['PricelistID'];?> : <?php echo $list['PricelistName'];?></a></p>
					<p class="text-muted">Start : <?php echo $list['DateStart'];?> // End : <?php echo $list['DateEnd'];?></p>
          <p class="text-muted"><?php echo $list['PricelistNote'];?> </p>
          <p class="text-muted">-------------------------------------------------------</p>
        <?php } ?>
      </div>
    </div>
  </div>
  
</div>