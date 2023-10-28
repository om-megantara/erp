<style type="text/css">
.table-detail { font-size: 12px; }
.table-detail tr td { padding: 2px !important; }
</style>

<div class="row">
  <div class="col-md-6">
    <div class="box box-solid">
      <div class="box-body box-profile">
		  <h3 class="profile-username text-center"><b><?php echo $content['AssetName']; ?></b></h3>
        <h5 class="text-center"><i><?php echo "(". $content['employeename'].")"; ?></i></h5>
        <table class="table table-detail nowrap">
          <tr><td><i class="fa fa-list margin-r-5"></i> Model Number</td><td>:</td><td><?php echo $content['ModelNumber'];?></td></tr>
          <tr><td><i class="fa fa-list margin-r-5"></i> Serial Number</td><td>:</td><td><?php echo $content['SerialNumber'];?></td></tr>
          <tr><td><i class="fa fa-list margin-r-5"></i> Asset Colour</td><td>:</td><td><?php echo $content['assetcolour'];?></td></tr>
          <tr><td><i class="fa fa-list margin-r-5"></i> Date In</td><td>:</td><td><?php echo $content['DateIn'];?></td></tr>
          <tr><td><i class="fa fa-list margin-r-5"></i> Asset Price</td><td>:</td><td><?php echo number_format($content['Price']);?></td></tr>
          <tr><td><i class="fa fa-list margin-r-5"></i> Asset Condition</td><td>:</td><td><?php echo $content['assetcondition'];?></td></tr>
          <tr><td><i class="fa fa-list margin-r-5"></i> Asset Note</td><td>:</td><td><?php echo $content['AssetNote'];?></td></tr>
        </table>
      </div>
	</div>
  </div>
  <div class="col-md-6">
    <div class="box box-solid">
      <div class="box-body">
        <ul class="list-group list-group-unbordered">
          <li class="list-group-item view-partner">
            <b>Edit Asset</b> <a target="_blank" class="dtbutton btn btn-primary btn-xs pull-right" href="<?php echo base_url();?>hrd/asset_cu/<?php echo $content['AssetID'];?>" class="pull-right view" >Edit</a>
          </li>
          <li class="list-group-item view-partner">
            <b>Asset Assignment</b> <a target="_blank" class="dtbutton btn btn-primary btn-xs pull-right" href="<?php echo base_url();?>hrd/asset_assignment/<?php echo $content['AssetID'];?>" class="pull-right view" >View</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>