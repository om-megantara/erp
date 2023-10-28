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
        <form name="form" id="form" action="<?php echo base_url();?>marketing/marketing_activity_edit_act?ActivityID=<?php echo $content['ActivityID'];?>" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Customer</label>
              <span class="left2">
                <input type="hidden" value="<?php echo $content['ActivityReffNo'];?>" name="customerid"> </input>
                <label ><?php echo $content['Customer'];?></label>
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Date</label>
              <span class="left2">
                <input type="text" class="form-control input-sm date" name="date" value="<?php echo $content['ActivityDate'];?>" readonly></input>
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Type</label>
              <span class="left2">
                <input type="text" class="form-control input-sm type" name="type" value="<?php echo $content['ActivityType'];?>" readonly></input>
              </span>
            </div> 
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Link</label>
              <span class="left2">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-link"></i>
                  </div>
                  <textarea class="form-control pull-right" rows="2" name="link" id="link" required=""><?php echo $content['ActivityLink'];?></textarea>
                </div>
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Note</label>
              <span class="left2">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-sticky-note-o"></i>
                  </div>
                  <textarea class="form-control pull-right" rows="2" name="note" id="note"><?php echo $content['ActivityNote'];?></textarea>
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
<script src="//apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>

</script>