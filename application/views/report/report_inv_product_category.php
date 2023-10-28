<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css">
  .divfilterdate {
    display: none; 
    margin: 5px 0px;
    border: 1px solid #0073b7; 
    padding: 4px; 
    overflow: auto;
  }
  #chartContainer2,
  #chartContainer {
    min-height: 450px;
  }
  .CategoryListInput .rowtext {
    margin-top: 2px;
  }
  .canvasjs-chart-credit { display: none; }

@media (min-width: 768px){
  .form-group label.left {
    float: left;
    width: 100px;
    padding: 5px 15px 5px 5px;
  }
  .form-group span.left2 {
    display: block;
    overflow: hidden;
  }
  .form-group { margin-bottom: 10px; }
}
</style>

<?php
$category = $content['category'];
if (isset($content['main'])) {
  $main = $content['main']['main'];
  $detail = $content['main']['detail'];
}
?>

<div class="content-wrapper">
  
  <div class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row rowtext"> 
              <div class="input-group input-group-sm">                
                <input type="hidden" class="form-control input-sm CategoryID" name="CategoryID[]" required="" readonly="">
                <input type="text" class="form-control input-sm CategoryName" name="CategoryName[]" required="" readonly="">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-danger remove" title="Remove" onclick="$(this).closest('.rowtext').remove();">x</button>
                </span>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle" title="HELP"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    
    <div class="box box-solid">
      <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Category</label>
                <span class="left2">
                  <div class="input-group input-group-sm">
                      <select class="form-control input-sm CategoryList select2" style="width: 100%;" name="CategoryList" required="">
                        <?php foreach ($category as $row => $list) { ?>
                        <option value="<?php echo $list['ProductCategoryID'];?>"><?php echo $list['ProductCategoryName'] ;?></option>
                        <?php } ?>
                      </select>
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary  add_field" onclick="createList();">+</button>
                      </span>
                  </div> 
                </span>
              </div> 
              <div class="form-group CategoryListInput"></div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Month Start</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="datestart" id="datestart" required="">
                </div>
              </div>
              <div class="form-group">
                <label class="left">Month End</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="dateend" id="dateend" required="">
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <center>
                <button type="submit" class="btn btn-primary btn-sm pull-center">Submit</button>
              </center>
            </div>
          </form>
        </div>
      </div>
      <div class="box-body"> 
        <div id="chartContainer"></div>
        <div id="chartContainer2"></div>
      </div>
    </div>

  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/canvas/canvasjs.min.js"></script>
<script>
jQuery( document ).ready(function( $ ) {

  $('.select2').select2();
  $("#datestart").datepicker({ 
    format: "yyyy-mm-dd",
    viewMode: "months", 
    minViewMode: "months"
  }).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#dateend').datepicker('setStartDate', minDate);
  });
  $("#dateend").datepicker({ 
    format: "yyyy-mm-dd",
    viewMode: "months", 
    minViewMode: "months"
  }).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#datestart').datepicker('setEndDate', maxDate);
  });
  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });
   
});

function createList() {
  CategoryID = $(".CategoryList").val()
  CategoryName = $(".CategoryList option:selected").text()
  $(".rowtext:first .CategoryID").val(CategoryID);
  $(".rowtext:first .CategoryName").val(CategoryName);
  $(".rowtext:first").clone().appendTo('.CategoryListInput'); 
}

window.onload = function () {
  var chart = new CanvasJS.Chart("chartContainer", {
    exportEnabled: true,
    animationEnabled: true,
    title:{
      text: "By Quantity"
    },
    subtitles: [{
      text: "Click Category to Hide or Unhide Data Series"
    }], 
    axisX: {
      title: "Months"
    },
    // axisY: {
    //   title: "Quantity",
    //   titleFontColor: "#4F81BC",
    //   lineColor: "#4F81BC",
    //   labelFontColor: "#4F81BC",
    //   tickColor: "#4F81BC"
    // },
    // axisY2: {
    //   title: "Clutch - Units",
    //   titleFontColor: "#C0504E",
    //   lineColor: "#C0504E",
    //   labelFontColor: "#C0504E",
    //   tickColor: "#C0504E"
    // },
    toolTip: {
      shared: true
    },
    legend: {
      cursor: "pointer",
      itemclick: toggleDataSeries
    },
    data: [
      <?php if (isset($main)) { ?>
        <?php foreach ($main as $row => $list) { ?>
          {
            type: "column",
            name: "<?php echo $list['CategoryName'];?>",
            showInLegend: true,      
            yValueFormatString: "#,##0.# pcs",
            dataPoints: [
              <?php if (isset($detail[$list['CategoryID']])) { ?>
                <?php foreach ($detail[$list['CategoryID']] as $row => $list) { ?>
                  { label: "<?php echo $list['MONTH'];?>",  y: <?php echo $list['ProductQty'];?> },
                <?php } ?>
              <?php } ?>
            ]
          }, 
        <?php } ?>
      <?php } ?> 
    ]
  });
  chart.render();

  var chart2 = new CanvasJS.Chart("chartContainer2", {
    exportEnabled: true,
    animationEnabled: true,
    title:{
      text: "By Revenue"
    },
    subtitles: [{
      text: "Click Category to Hide or Unhide Data Series"
    }], 
    axisX: {
      title: "Months"
    },
    // axisY: {
    //   title: "Quantity",
    //   titleFontColor: "#4F81BC",
    //   lineColor: "#4F81BC",
    //   labelFontColor: "#4F81BC",
    //   tickColor: "#4F81BC"
    // },
    // axisY2: {
    //   title: "Clutch - Units",
    //   titleFontColor: "#C0504E",
    //   lineColor: "#C0504E",
    //   labelFontColor: "#C0504E",
    //   tickColor: "#C0504E"
    // },
    toolTip: {
      shared: true
    },
    legend: {
      cursor: "pointer",
      itemclick: toggleDataSeries
    },
    data: [
      <?php if (isset($main)) { ?>
        <?php foreach ($main as $row => $list) { ?>
          {
            type: "column",
            name: "<?php echo $list['CategoryName'];?>",
            showInLegend: true,      
            yValueFormatString: "#,##0.# Rp",
            dataPoints: [
              <?php if (isset($detail[$list['CategoryID']])) { ?>
                <?php foreach ($detail[$list['CategoryID']] as $row => $list) { ?>
                  { label: "<?php echo $list['MONTH'];?>",  y: <?php echo $list['PriceTotal'];?> },
                <?php } ?>
              <?php } ?>
            ]
          }, 
        <?php } ?>
      <?php } ?> 
    ]
  });
  chart2.render();

  function toggleDataSeries(e) {
    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
      e.dataSeries.visible = false;
    } else {
      e.dataSeries.visible = true;
    }
    e.chart.render();
  }
}
</script>