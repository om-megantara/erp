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
  
  <section class="content">

    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>report/report_customer_complaint_edit_act?ComplaintID=<?php echo $content['ComplaintID'];?>" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Code</label>
              <label class="left2" name="code"> 
                <?php echo $content['ComplaintID'];?></label>   
            </div>
            <div class="form-group">
              <label class="left">CustomerID</label>
              <label class="left2" name="customerid"><?php echo $content['CustomerID'];?>
                </label>
            </div>
            <div class="form-group">
              <label class="left">Customer</label>
              <label class="left2" name="customer"><?php echo $content['Customer'];?>
                </label>
            </div> 
            <div class="form-group">
              <label class="left">Open Date</label>
              <label class="left2" name="Open Date"><?php echo $content['OpenDate'];?></label>
            </div> 
            <div class="form-group">
              <label class="left">PMA Date</label>
              <span class="left2">
                <?php if($content['PMADate']=='0000-00-00'){ ?>
                  <input type="text" class="form-control input-sm date" name="PMAdate"></input>
                <?php } else { ?>
                  <input type="text" class="form-control input-sm" name="PMAdate" value="<?php echo $content['PMADate'];?>" readonly></input>
                <?php } ?>
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Complaint Closed</label>
              <span class="left2">
                <?php if($content['PMADate']=='0000-00-00'){ echo "Not Yet PMA";} else { ?><input class="form-check-input" type="checkbox" class="form-control input-sm " name="ComplaintClose" value="1">
                <?php } ?>
              </span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Sales</label>
              <label class="left2" name="sales">
                <?php echo $sales = $content['Sales'];?></label>
            </div>
            <div class="form-group">
              <label class="left">SOID</label>
              <label class="left2" name="soid">
                <?php echo $content['SOID'];?></label>
            </div> 
            <div class="form-group">
              <label class="left">DOID</label>
              <input type="hidden" name="doid" value="<?php echo $content['DOID'];?>">
              <label class="left2" name="doid">
                <?php echo $content['DOID'];?></label>
            </div>
            <div class="form-group">
              <label class="left">Link</label>
              <span class="left2">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-link"></i>
                  </div>
                  <textarea class="form-control pull-right" rows="2" name="link" id="link" value="" required=""><?php echo $content['ComplaintLink'];?></textarea>
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
<script>
j8 = jQuery.noConflict();
j8( document ).ready(function( $ ) {
  $(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });

  $(".date").datepicker({ 
    // startDate: '-1d',
    autoclose: true, 
    format: 'yyyy-mm-dd',
    todayBtn:  1,
  })
});

</script>