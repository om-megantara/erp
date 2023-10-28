<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css"> 
@media (min-width: 768px){
  .form-group label.left {
    float: left;
    width: 130px;
    padding: 5px 15px 5px 5px;
  }
  .form-group span.left2 {
    display: block;
    overflow: hidden;
  }
  .form-group { margin-bottom: 10px; }
  .kiri { margin-left: -10px; }
}
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>
  <?php 
    $PenaltyID=$content["PenaltyID"];
    $PenaltyName=$content["PenaltyName"];
    $PenaltyType=$content['PenaltyType'];
    $Quantity=$content['Quantity'];
    $PenaltyCategory=$content['PenaltyCategory'];
    $Note=$content['Note'];
  ?>
  <section class="content">

    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>master/penalty_edit_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Penalty Name</label>
              <span class="left2">
                <input type="text" class="form-control input-sm name" name="name" required="" value="<?php echo $PenaltyName;?>" readonly>
                <input type="hidden" class="form-control input-sm id" name="id" required="" value="<?php echo $PenaltyID;?>" readonly>
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Type</label>
              <span class="left2">
                <select class="form-control input-sm type" id="type" name="type" required=""> 
                  <?php if ($PenaltyType=="adm"){ ?>
                    <option value="<?php echo $PenaltyType;?>">Administrative</option>
                    <option value="pnt">Point</option>
                  <?php } else if ($PenaltyType=="pnt"){ ?>
                    <option value="pnt">Point</option>
                    <option value="adm">Administrative</option>
                  <?php } ?>
                </select>
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Point</label>
              <span class="left2">
                <input type="text" class="form-control input-sm quantity" name="quantity" required="" value="<?php echo $Quantity;?>">
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Category</label>
              <span class="left2">
                <select class="form-control input-sm category" id="category" name="category" required=""> 
                  <?php if ($PenaltyCategory=="bonus"){ ?>
                    <option value="bonus">Bonus</option>
                    <option value="gaji">Gaji</option>
                  <?php } else if ($PenaltyCategory=="gaji"){  ?>
                    <option value="gaji">Gaji</option>
                    <option value="bonus">Bonus</option>
                  <?php } ?>
                </select>
              </span>
            </div>          
            <div class="form-group">
              <label class="left">Note</label>
              <span class="left2">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-sticky-note-o"></i>
                  </div>
                  <textarea class="form-control pull-right" rows="2" name="note" id="note" ><?php echo $Note;?></textarea>
                </div>
              </span>
            </div> 
          </div>   
          <div class="col-md-12">
            <div class="box-footer" style="text-align: center;">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>