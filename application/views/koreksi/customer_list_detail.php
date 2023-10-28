<div class="row">
  <div class="col-md-6">
    <div class="box box-solid">
      <div class="box-body box-profile">
        <h3 class="profile-username text-center"><?php echo $content['fullname']; ?></h3>
        <h5 class="text-center"><?php echo ($content['Company']=="")?"":"(".$content['Company'].")"; ?></h5>
        <strong><i class="fa fa-credit-card margin-r-5"></i> ID Contact / Customer </strong>
        <p class="text-muted"><?php echo $content['ContactID']." / ".$content['CustomerID'];?> </p>
        <strong><i class="fa fa-credit-card margin-r-5"></i> Shop Name </strong>
        <p class="text-muted"><?php echo $content['ShopName'];?> </p>
        <strong><i class="fa fa-credit-card margin-r-5"></i> Gender / Religion </strong>
        <p class="text-muted"><?php echo $content['gender']." / ".$content['religion'];?> </p>
        <strong><i class="fa fa-credit-card margin-r-5"></i> No KTP </strong>
        <p class="text-muted"><?php echo $content['KTP'];?> </p>
        <strong><i class="fa fa-credit-card margin-r-5"></i> NPWP </strong>
        <p class="text-muted"><?php echo $content['NPWP'];?> </p>
        <strong><i class="fa fa-phone-square margin-r-5"></i> Mobile Phone</strong>
        <p class="text-muted"><?php echo $content['Phone'];?>   </p>
        <strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>
        <p class="text-muted"><?php echo $content['Email'];?></p>
      </div>
      <div class="box-body">
        <strong><i class="fa fa-map-marker margin-r-5"></i> Address</strong>
        <p class="text-muted"><?php echo $content['address'];?> </p>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-solid">
      <div class="box-body box-profile">
       	<strong><i class="fa fa-users margin-r-5"></i> Credit Limit </strong>
        <p class="text-muted"><b><?php echo ($content['CreditLimit']=="")?"0":"Rp.".number_format("$content[CreditLimit]",2,",","."); ?></b></p>
        <strong><i class="fa fa-users margin-r-5"></i> Payment Term </strong>
        <p class="text-muted"><b><?php echo ($content['PaymentTerm']=="")?"0":$content['PaymentTerm']." Days";?></b></p>
        <strong><i class="fa fa-users margin-r-5"></i> Category </strong>
        <p class="text-muted"><b><?php echo $content['CustomercategoryName'];?></b></p>
        <strong><i class="fa fa-users margin-r-5"></i> SE </strong>
        <p class="text-muted"><?php echo $content['sales'];?> </p>
        <strong><i class="fa fa-users margin-r-5"></i> Price </strong>
        <p class="text-muted"><?php echo $content['price'];?> </p>
      </div>
      <div class="box-body">
        <ul class="list-group list-group-unbordered">
          <li class="list-group-item view-partner">
            <b>Edit Customer</b> 
            <button type="button" class="btn btn-primary btn-xs pull-right" onclick="window.open('<?php echo base_url();?>koreksi/customer_cu/<?php echo $content['id'];?>', '_blank');">Edit</button>
          </li>
          <li class="list-group-item view-partner">
            <b>View All SO</b> 
            <button type="button" class="btn btn-primary btn-xs pull-right">View</button>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>