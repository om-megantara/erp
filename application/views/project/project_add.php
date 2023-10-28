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

  <section class="content">

    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>development/project_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Project Code </label>
              <label class="left2" name="code"> 
                <?php $no=$content['no']; $nourut=$no+1; $bulan=date("m"); $tahun=date("y"); echo $ProjectID="P.".str_pad($nourut, 4,"0",STR_PAD_LEFT).".".$bulan.".".$tahun;?></label>
            <input type="hidden" name="code" value="<?php echo $ProjectID?>">
            <input type="hidden" name="no" value="<?php echo $nourut?>">    
            </div>
            <div class="form-group">
              <label class="left">Customer</label>
              <span class="left2">
                <select class="form-control customer" name="customer" required=""></select>
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Date</label>
              <span class="left2">
                <input type="text" class="form-control input-sm date" name="date" required="">
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Project Name</label>
              <span class="left2">
                <input type="text" class="form-control input-sm projectname" name="projectname" required="">
              </span>
            </div> 
            <div class="form-group">
              <label class="left">City</label>
              <span class="left2">
                <select class="form-control input-sm cityid" id="cityid" name="cityid" required=""> 
                  <?php 
                    foreach ($content['citylist'] as $row => $list) { 
                  ?>
                  <option value="<?php echo $list['CityID'];?>"><?php echo $list['CityName'];?></option>
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
                  <textarea class="form-control pull-right" rows="2" name="note" id="note"></textarea>
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
                <input class="form-check-input" type="checkbox" class="form-control technical" rows="2" name="technical" value="1">
              </div>
              <div class="form-group col-md-6">
                <input type="text" class="form-control input-sm date" name="technicaldate" placeholder="Date Customer Technical Drawing">
              </div>
            </div>
            <div class="form-row" >
              <div class="form-group col-md-3 kiri">
                <label>Technical Link</label>
              </div>
              <div class="form-group col-md-9">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-link"></i>
                  </div>
                  <input type="text" class="form-control input-sm technicallink" name="technicallink" >
                </div>
              </div> 
            </div>
            <div class="form-row">
              <div class="form-group col-md-3 kiri">
                <label class="form-check-label">Letter Of Offer</label>
              </div>
              <div class="form-group col-md-3"> 
                <input class="form-check-input" type="checkbox" class="form-control input-sm letter" name="letter" value="1">
              </div>
              <div class="form-group col-md-6">
                <input type="text" class="form-control input-sm date" name="letterdate" placeholder="Date Letter Of Offer">
              </div>
            </div>
            <div class="form-row" >
              <div class="form-group col-md-3 kiri">
                <label>Letter Link</label>
              </div>
              <div class="form-group col-md-9">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-link"></i>
                  </div>
                  <input type="text" class="form-control input-sm"  name="letterlink" id="letterlink"></input>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3 kiri">
                <label class="form-check-label">Floor Plan</label>
              </div>
              <div class="form-group col-md-3"> 
                <input class="form-check-input" type="checkbox" class="form-control input-sm floor" name="floor" value="1">
              </div>
              <div class="form-group col-md-6">
                <input type="text" class="form-control input-sm date" name="floordate" placeholder="Date Floor Of Plan">
              </div>
            </div>
            <div class="form-row" >
              <div class="form-group col-md-3 kiri">
                <label>Floor Plan Link</label>
              </div>
              <div class="form-group col-md-9">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-link"></i>
                  </div>
                  <input type="text" class="form-control input-sm"  name="floorlink" id="floorlink"></input>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3 kiri">
                <label class="form-check-label">Sample</label>
              </div>
              <div class="form-group col-md-3"> 
                <input class="form-check-input" type="checkbox" class="form-control input-sm sample" name="sample" value="1">
              </div>
              <div class="form-group col-md-6">
                <input type="text" class="form-control input-sm date" name="sampledate" placeholder="Date Sample">
              </div>
            </div>
            <div class="form-row" >
              <div class="form-group col-md-3 kiri">
                <label>Sample Link</label>
              </div>
              <div class="form-group col-md-9">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-link"></i>
                  </div>
                  <input type="text" class="form-control input-sm"  name="samplelink" id="samplelink"></input>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3 kiri">
                <label class="form-check-label">Our Technical</label>
              </div>
              <div class="form-group col-md-3"> 
                <input class="form-check-input" type="checkbox" class="form-control input-sm ourtechnical" name="ourtechnical" value="1">
              </div>
              <div class="form-group col-md-6">
                <input type="text" class="form-control input-sm date" name="ourtechnicaldate" placeholder="Date Our Technical Drawing">
              </div>
            </div>
            <div class="form-row" >
              <div class="form-group col-md-3 kiri">
                <label>OurTechnical</label>
              </div>
              <div class="form-group col-md-9">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-link"></i>
                  </div>
                  <input type="text" class="form-control input-sm"  name="ourlink" id="ourlink"></input>
                </div>
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

  <?php if (isset($content)) { ?>
    var data = {
        id: '<?php echo $content['CustomerID']; ?>',
        text: '<?php echo $content['Company2']; ?>',
    };
    var newOption = new Option(data.text, data.id, false, false);
    $('.customer').append(newOption).trigger('change');
  <?php } ?>
  $('#cityid').select2();
});


j8('.customer').select2({
  placeholder: 'Minimum 3 char, Company',
  minimumInputLength: 3,
  ajax: {
    url: '<?php echo base_url();?>general/search_customer_city',
    dataType: 'json',
    delay: 1000,
    processResults: function (data) {
      return {
        results: data
      };
    },
    cache: true
  }
}); 

</script>