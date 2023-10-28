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
  <?php
    $MenuList = $this->session->userdata('MenuList');
    $data=$content['isi'];
    $Departement=$content['dept'];
  ?>
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>master/sop_list_edit_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="form-group" id="dept2">
              <label class="left">Departement</label>
              <label class="left2" >
                  <?php
                    if (in_array("print_without_header", $MenuList)){
                      $idc=4;
                    }else{
                      $idc=1;
                    }
                    foreach ($Departement as $row) {
                      if ($row['CompanyID']==$idc){
                        if (!empty($row['DivisiIDp'])){
                            $checked="checked";
                          }else{
                            $checked="";
                          }
                        ?>
                        <input type="checkbox" class="divisiidx" name="divisiidx[]" <?php echo $checked;?> value="<?php echo $row['DivisiID'];?>"><?php echo $row['DivisiName'];?>
                        <br />
                      <?php
                      }
                    }
                    ?>
              </label>
            </div>
            <div class="form-group">
              <label class="left">Code</label>
              <label class="left2" name="codeid"> 
                <input type="hidden" class="form-control input-sm id" name="id" required="" readonly="" value="<?php echo $data[0]['SopID'];?>">
                <input type="hidden" class="form-control input-sm no" name="no" required="" readonly="" value="<?php echo $data[0]['No'];?>">
                <input type="text" class="form-control input-sm codeid" name="codeid" required="" readonly="" value="<?php echo $data[0]['SopCode'];?>">
              </label>
            </div>
            <div class="form-group">
              <label class="left">Subject</label>
              <label class="left2" name="subject"> 
                <input type="text" class="form-control input-sm " name="subject" required="" value="<?php echo $data[0]['Subject'];?>">
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Input By</label>
              <input type="hidden" name="employeeid" value="<?php echo $data[0]['InputBy'];?>">
              <label class="left2" name="employeeid">
                <?php echo $data[0]['FullName']; ?></label>
            </div>
            <div class="form-group">
              <label class="left" >File PDF</label>
              <span class="left2">
                <input type="text" class="form-control input-sm label2" name="label2" id="label2" required="" readonly="" value="<?php echo $data[0]['FilePDF'];?>">
                <input type="file" accept=".pdf" class="form-control-file input-file" id="label" name="label">
                <p class="help-block">Item type must be PDF and 1Mb maximum size.</p>
              </span>
            </div>
            <div class="form-group">
              <label class="left">Link</label>
              <span class="left2">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-link"></i>
                  </div>
                  <textarea class="form-control pull-right" rows="2" name="link" id="link" placeholder="Diawali https://" required=""><?php echo $data[0]['Link'];?></textarea>
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
<script>
j8 = jQuery.noConflict();

function generate_code(el){
  SOPCode = el.value
  $.ajax({
    url: "<?php echo base_url();?>master/get_code",
    type : 'GET',
    data : 'code='+SOPCode,
    dataType : 'json',
    success : function (response) {
      console.log(response)
      $(".codeid").val(response['codeid']);
      $(".no").val(response['no']);
    }
  })
}
j8("#cek_code").on('click', function() {
  var SOPCode=new Array();
  $("input:checkbox[class=divisiidx]:checked").each(function(){
    SOPCode.push($(this).val());
  });
  idc=$('.idc').val()
  $.ajax({
    url: "<?php echo base_url();?>master/get_code",
    type : 'GET',
    data : 'code='+SOPCode+'&idc='+idc,

    dataType : 'json',
    success : function (response) {
      console.log(response)
      $(".codeid").val(response['codeid']);
      $(".no").val(response['no']);
    }
  })
});
</script>