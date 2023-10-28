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
    $CustomerDrawingLink=$content["CustomerDrawingLink"];
    $LetterLink=$content['LetterLink'];
    $FloorLink=$content['FloorLink'];
    $SampleLink=$content['SampleLink'];
    $OurTechnicalLink=$content['OurTechnicalLink'];
  ?>
  <section class="content">

    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>development/project_edit_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Project Code </label>
              <label class="left2" name="code"> 
                <?php echo $this->input->get_post('ProjectID');?></label>
                <input type="hidden" name="code" value="<?php echo $content['ProjectID']?>">
            </div>
            <div class="form-group">
              <label class="left">Customer</label>
              <label class="left2">
                <?php echo $content['Customer'];?>
              </label>

            </div> 
            <div class="form-group">
              <label class="left">Date</label>
              <label class="left2">
                <?php echo $content['ProjectInput'];?>
              </label>
            </div> 
            <div class="form-group">
              <label class="left">Project Name</label>
              <label class="left2">
                <?php echo $content['ProjectName'];?>
              </label>
            </div> 
            <div class="form-group">
              <label class="left">City</label>
              <label class="left2">
                <?php echo $content['CityName'];?>
              </label>
            </div>          
            <div class="form-group">
              <label class="left">Note</label>
              <span class="left2">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-sticky-note-o"></i>
                  </div>
                  <textarea class="form-control pull-right" rows="2" name="note" id="note"></textarea>
                </div>
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Project Closed</label>
              <span class="left2">
                <div class="input-group">  
                  <input class="form-check-input" type="checkbox" class="form-control input-sm " name="ProjectClose" value="1">
                  </input>             
                </div>
              </span>
            </div>  
          </div>  
          <div class="col-md-6">
            <div class="form-row">
              <div class="form-group col-md-3 kiri">
                <label class="form-check-label">Technical Draw</label>
              </div>
              <div class="form-group col-md-3">
                <?php if($content['CustomerDrawing']==""){ ?>
                  <input class="form-check-input" type="checkbox" class="form-control technical" rows="2" name="technical" value="1">
                  </input>
                <?php } else {echo '<i class="fa  fa-check-square" style="color:#00a65a;"></i><input type="hidden" name="technical" value="1">';}?>
              </div>
              <div class="form-group col-md-6">
                <?php if($content['CustomerDrawingDate']=="0000-00-00"){ ?>
                  <input type="text" class="form-control input-sm date" name="technicaldate" placeholder="Date Customer Technical Drawing">
                <?php } else { ?>
                  <input type="text" class="form-control input-sm" name="technicaldate" value="<?php echo $content['CustomerDrawingDate'];?>" readonly="">
                <?php } ?>  
              </div>
            </div>
            <div class="form-row" >
              <div class="form-group col-md-3 kiri">
                <label>Technical Link</label>
              </div>
              <div class="form-group col-md-9">
                <?php if($content['CustomerDrawingLink']==""){ ?>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-link"></i>
                    </div>
                    <input type="text" class="form-control input-sm technicallink" name="technicallink" ></input>
                  </div>
                  <?php } else { ?>
                  <div class="input-group"> 
                    <div class="input-group-addon">
                      <i class="fa fa-link"></i> 
                    </div>
                      <input type="text" class="form-control input-sm technicallink" name="technicallink" value="<?php echo $CustomerDrawingLink; ?>" readonly="" ></input>
                  </div>  
                <?php } ?>
              </div> 
            </div>
            <div class="form-row">
              <div class="form-group col-md-3 kiri">
                <label class="form-check-label">Letter Of Offer</label>
              </div>
              <div class="form-group col-md-3"> 
                <?php if($content['Letter']==""){ ?>
                  <input class="form-check-input" type="checkbox" class="form-control input-sm letter" name="letter" value="1">
                  </input>
                <?php } else {echo '<i class="fa  fa-check-square" style="color:#00a65a;" ></i><input type="hidden" name="letter" value="1">';}?>
              </div>
              <div class="form-group col-md-6">
                <?php if($content['LetterDate']=="0000-00-00"){ ?>
                  <input type="text" class="form-control input-sm date" name="letterdate" placeholder="Date Letter Of Offer">
                <?php } else { ?>
                  <input type="text" class="form-control input-sm" name="letterdate" value="<?php echo $content['LetterDate'];?>" readonly="" >
                <?php } ?>
              </div>
            </div>
            <div class="form-row" >
              <div class="form-group col-md-3 kiri">
                <label>Letter Link</label>
              </div>
              <div class="form-group col-md-9">
                <?php if($content['LetterLink']==""){ ?>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-link"></i>
                    </div>
                    <input type="text" class="form-control input-sm "  name="letterlink" id="letterlink" ></input>
                  </div>
                  <?php } else { ?>
                  <div class="input-group"> 
                    <div class="input-group-addon">
                      <i class="fa fa-link"></i> 
                    </div>
                      <input type="text" class="form-control input-sm letterlink" name="letterlink" value="<?php echo $LetterLink; ?>" readonly="" ></input>
                  </div>  
                  <?php  } ?>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3 kiri">
                <label class="form-check-label">Floor Plan</label>
              </div>
              <div class="form-group col-md-3"> 
                <?php if($content['Floor']==""){ ?>
                  <input class="form-check-input" type="checkbox" class="form-control input-sm floor" name="floor" value="1"></input>
                <?php } else { echo '<i class="fa  fa-check-square" style="color:#00a65a;" ></i><input type="hidden" name="floor" value="1">';}?>
              </div>
              <div class="form-group col-md-6">
                <?php if($content['FloorDate']=="0000-00-00"){ ?>
                  <input type="text" class="form-control input-sm date" name="floordate" placeholder="Date Floor Of Plan">
                <?php } else { ?>
                  <input type="text" class="form-control input-sm" name="floordate" value="<?php echo $content['FloorDate'];?>" readonly="">
                <?php } ?>
              </div>
            </div>
            <div class="form-row" >
              <div class="form-group col-md-3 kiri">
                <label>Floor Plan Link</label>
              </div>
              <div class="form-group col-md-9">
                <?php if($content['FloorLink']==""){ ?>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-link"></i>
                    </div>
                    <input type="text" class="form-control input-sm"  name="floorlink" id="floorlink"></input>
                  </div>
                <?php } else { ?>
                  <div class="input-group"> 
                    <div class="input-group-addon">
                      <i class="fa fa-link"></i> 
                    </div>
                      <input type="text" class="form-control input-sm floorlink" name="floorlink" value="<?php echo $FloorLink; ?>" readonly="" ></input>
                  </div>  
                  <?php  } ?>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3 kiri">
                <label class="form-check-label">Sample</label>
              </div>
              <div class="form-group col-md-3"> 
                <?php if($content['Sample']==""){ ?>
                  <input class="form-check-input" type="checkbox" class="form-control input-sm sample" name="sample" value="1">
                <?php } else { echo '<i class="fa  fa-check-square" style="color:#00a65a;"></i><input type="hidden" name="sample" value="1">';}?>
              </div>
              <div class="form-group col-md-6">
                <?php if($content['SampleDate']=="0000-00-00"){ ?>
                  <input type="text" class="form-control input-sm date" name="sampledate" placeholder="Date Sample">
                <?php } else { ?>
                  <input type="text" class="form-control input-sm" name="sampledate" value="<?php echo $content['SampleDate'];?>" readonly="">
                <?php } ?>
              </div>
            </div>
            <div class="form-row" >
              <div class="form-group col-md-3 kiri">
                <label>Sample Link</label>
              </div>
              <div class="form-group col-md-9">
                <?php if($content['SampleLink']==""){ ?>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-link"></i>
                      </div>
                      <input type="text" class="form-control input-sm"  name="samplelink" id="samplelink" ></input>
                    </div>
                <?php } else { ?>
                    <div class="input-group"> 
                        <div class="input-group-addon">
                          <i class="fa fa-link"></i> 
                        </div>
                          <input type="text" class="form-control input-sm samplelink" name="samplelink" value="<?php echo $content['SampleLink'] ?>" readonly="" ></input>
                    </div>  
                  <?php  } ?>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3 kiri">
                <label class="form-check-label">Our Technical</label>
              </div>
              <div class="form-group col-md-3"> 
                <?php if($content['OurTechnical']==""){ ?>
                  <input class="form-check-input" type="checkbox" class="form-control ourtechnical" name="ourtechnical" value="1">
                <?php } else {echo '<i class="fa  fa-check-square" style="color:#00a65a;" ></i><input type="hidden" name="ourtechnical" value="1">';}?>
              </div>
              <div class="form-group col-md-6">
                <?php if($content['OurTechnicalDate']=="0000-00-00"){ ?>
                  <input type="text" class="form-control input-sm date" name="ourtechnicaldate" placeholder="Date Our Technical Drawing">
                <?php } else { ?>
                  <input type="text" class="form-control input-sm " name="ourtechnicaldate" value="<?php echo $content['OurTechnicalDate'];?>" readonly="">
                <?php } ?>
              </div> 
            </div>
            <div class="form-row" >
              <div class="form-group col-md-3 kiri">
                <label>OurTechnical</label>
              </div>
              <div class="form-group col-md-9">
                <?php if($content['OurTechnicalLink']==""){ ?>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-link"></i>
                    </div>
                    <input type="text" class="form-control input-sm "  name="ourtechnicallink" id="ourlink" ></input>
                  </div>
                  <?php } else { ?>
                    <div class="input-group"> 
                        <div class="input-group-addon">
                          <i class="fa fa-link"></i> 
                        </div>
                          <input type="text" class="form-control input-sm ourtechnicallink" name="ourtechnicallink" value="<?php echo $content['OurTechnicalLink']; ?>" readonly=""></input>
                    </div> 
                  <?php } ?>  
              </div>
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
  $(".date").datepicker({ 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    todayBtn:  1,
  }) 
});

</script>