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
    $Departement=$content['dept'];
    $user=$content['user'];
  ?>
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>master/sop_list_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
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
                      if ($row['CompanyID']==$idc){ ?>
                        <input type="checkbox" class="divisiidx" name="divisiidx[]" value="<?php echo $row['DivisiID'];?>"><?php echo $row['DivisiName'];?>
                        <br />
                      <?php
                      }
                    }
                  ?>
              </label>
              <div class="form-group">
                <label class="left"></label>
                <label class="left2" name="codeid">
                  <button type="button" class="btn btn-sm btn-primary" title="GET CODE" id="cek_code">Get Code</button>
                </label>
              </div>
            </div>
            <div class="form-group">
              <label class="left">Code</label>
              <label class="left2" name="codeid"> 
                <input type="hidden" class="form-control input-sm no" name="no" required="" readonly="">
                <input type="hidden" class="form-control input-sm idc" name="idc" required="" value="<?php echo $idc;?>" readonly="">
                <input type="text" class="form-control input-sm codeid" name="codeid" required="" readonly="">
              </label>
            </div>
            <div class="form-group">
              <label class="left">Subject</label>
              <label class="left2" name="subject"> 
                <input type="text" class="form-control input-sm " name="subject" required="">
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Input By</label>
              <input type="hidden" name="employeeid" value="<?php echo $user['EmployeeID'];?>">
              <label class="left2" name="employeeid">
                <?php echo $user['FullName']; ?></label>
            </div>
            <div class="form-group">
              <label class="left" >File PDF</label>
              <span class="left2">
                <input type="file" accept=".pdf" class="form-control-file input-file" id="label" name="label" required="">
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
                  <textarea class="form-control pull-right" rows="2" name="link" id="link" placeholder="Diawali https://" required=""></textarea>
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

<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script>
j8 = jQuery.noConflict();

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