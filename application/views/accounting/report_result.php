<link rel="stylesheet" href="<?php echo base_url();?>tool/jstree/dist/themes/default/style.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style type="text/css">  
  .divfilterdate {
    /*display: none; */
    margin: 5px 0px;
    border: 1px solid #0073b7; 
    padding: 4px;
    overflow: auto;
  }
  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 80px;
      padding: 5px 15px 5px 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 5px; }
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
            <div class="box-header">
                <div class="divfilterdate">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="left">Report</label>
                        <span class="left2">
                            <select class="form-control input-sm ReportList" style="width: 100%;" name="ReportList" required="">
                              <?php foreach ($content as $row => $list) { ?>
                                  <option value="<?php echo $list['ReportID'];?>" Aname="<?php echo $list['ReportName'];?>"><?php echo $list['ReportName'];?></option>
                              <?php } ?>
                            </select> 
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">Month</label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control input-sm datestart" autocomplete="off" name="datestart" id="datestart" required="">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6"> 
                      <button class="btn btn-primary btn-sm pull-center generate">GENERATE</button>
                    </div>
                </div>
            </div>
            <div class="box-body"> 
              <div class="resultBody" id="resultBody"></div>
            </div>
        </div>
    </section>

</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
jQuery(function($) {

  $("#datestart").datepicker({ 
    format: "yyyy-mm-dd",
    // viewMode: "months", 
    // minViewMode: "months"
  }).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#dateend').datepicker('setStartDate', minDate);
  });
  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });
}); 
$('.generate').live('click', function(e){
  ReportID = $(".ReportList option:selected").val()
  ReportDate = $(".datestart").val()
  if (ReportDate != "") {
    get(ReportID, ReportDate);
  }
});


function get(ReportID, ReportDate) {
    // $("#resultBody").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ')
    // xmlHttp=GetXmlHttpObject()
    // var url="<?php echo base_url();?>accounting/report_result_detail"
    // url=url+"?ReportID="+ReportID+"&ReportDate="+ReportDate

    var url="<?php echo base_url();?>accounting/report_formula_detail"
    url=url+"?report="+ReportID+"&ReportDate="+ReportDate
    var win = window.open(url, '_blank');
    if (win) {
        win.focus();
    } else {
        alert('Please allow popups for this website');
    }

    // xmlHttp.onreadystatechange=stateChanged
    // xmlHttp.open("GET",url,true)
    // xmlHttp.send(null)
} 
function stateChanged(){
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
        document.getElementById("resultBody").innerHTML=xmlHttp.responseText
    }
}
function GetXmlHttpObject(){
    var xmlHttp=null;
    try{
        xmlHttp=new XMLHttpRequest();
    }catch(e){
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xmlHttp;
}
</script>