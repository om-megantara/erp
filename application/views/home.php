<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<style type="text/css">
  .loading_home_dashboard {
    text-align: center;
    margin: 10px 0px;
  }
</style>

<?php
$link_summary_so_outstanding_do = base_url()."report/report_so_outstanding_do";
$link_summary_so_warehouse = base_url()."report/report_so_outstanding_do_product";
$link_summary_do_not_inv = base_url()."report/report_do_not_inv";
$link_summary_inv_unpaid = base_url()."report/report_inv_unpaid";
$link_summary_ro_outstanding = base_url().(($this->auth->cek5('purchase_order_add')) ? "transaction/request_to_purchase" : "report/report_ro_outstanding_po" );
$link_summary_po_outstanding = base_url()."report/report_po_outstanding_dor";
$link_summary_ro_suggestion = base_url()."transaction/product_stock_list?rosugestion=NZMX";
?>


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
    <div class="row report-summary" id="report-summary" >
      <!-- <meta http-equiv="refresh" content="300"> -->

      <?php if ($this->auth->cek5('summary_so_outstanding_do')) { ?>
      <div class="col-lg-3 col-xs-6 summary_so_outstanding_do">
        <div class="small-box bg-aqua">
          <div class="inner">
            <p><b>SO Outstanding DO</b></p>
            <h3> <span class="line1">0</span> </h3>
            <p>SO Late : <span class="line2">0</span> </p>
            <p>Qty Product : <span class="line3">0</span> </p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="<?php echo $link_summary_so_outstanding_do;?>" class="small-box-footer" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <?php } ?>
      <?php if ($this->auth->cek5('summary_so_warehouse')) { ?>
      <div class="col-lg-3 col-xs-6 summary_so_warehouse">
        <div class="small-box bg-aqua">
          <div class="inner">
            <p><b>SO Outstanding by Warehouse</b></p>
            <br>
            <p>SO PUTAT : <span class="line1">0</span> </p>
            <p>SO MARGOMULYO : <span class="line2">0</span> </p>
            <p>Not Ready : <span class="line3">0</span> </p>
          </div>
          <div class="icon">
            <i class="fa fa-cubes"></i>
          </div>
          <a href="<?php echo $link_summary_so_warehouse;?>" class="small-box-footer" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <?php } ?>

      <?php if ($this->auth->cek5('summary_do_not_inv')) { ?>
      <div class="col-lg-3 col-xs-6 summary_do_not_inv">
        <div class="small-box bg-green">
          <div class="inner">
            <p><b>DO not INV</b></p>
            <h3><span class="line1">0</span></h3>
            <p>DO Sales : <span class="line2">0</span></p>
            <p>DO Consignment : <span class="line3">0</span></p>
          </div>
          <div class="icon">
            <i class="ion ion-ios-cart"></i>
          </div>
          <a href="<?php echo $link_summary_do_not_inv;?>" class="small-box-footer" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <?php } ?>

      <?php if ($this->auth->cek5('summary_inv_unpaid')) { ?>
      <div class="col-lg-3 col-xs-6 summary_inv_unpaid">
        <div class="small-box bg-yellow">
          <div class="inner">
            <p><b>INV Unpaid</b></p>
            <h3><span class="line1">0</span></h3>
            <p>INV Late : <span class="line2">0</span></p>
            <p>Unpaid Amount : <span class="line3">0</span></p>
          </div>
          <div class="icon">
            <i class="ion ion-cash"></i>
          </div>
          <a href="<?php echo $link_summary_inv_unpaid;?>" class="small-box-footer" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <?php } ?>

      <?php if ($this->auth->cek5('summary_ro_outstanding')) { ?>
      <div class="col-lg-3 col-xs-6 summary_ro_outstanding">
        <div class="small-box bg-purple">
          <div class="inner">
            <p><b>RO Outstanding</b></p>
            <h3><span class="line1">0</span></h3>
            <p>RAW ready all : <span class="line2">0</span></p>
            <p>RAW ready Partial : <span class="line3">0</span></p>
          </div>
          <div class="icon">
            <i class="ion ion-compose"></i>
          </div>
          <a href="<?php echo $link_summary_ro_outstanding;?>" class="small-box-footer" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <?php } ?>

      <?php if ($this->auth->cek5('summary_po_outstanding')) { ?>
      <div class="col-lg-3 col-xs-6 summary_po_outstanding">
        <div class="small-box bg-teal">
          <div class="inner">
            <p><b>PO Outstanding</b></p>
            <h3><span class="line1">0</span></h3>
            <p>RAW not Sent : <span class="line12">0</span></p>
            <p>PO late : <span class="line3">0</span></p>
          </div>
          <div class="icon">
            <i class="ion ion-clipboard"></i>
          </div>
          <a href="<?php echo $link_summary_po_outstanding;?>" class="small-box-footer" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <?php } ?>

      <?php if ($this->auth->cek5('summary_ro_suggestion')) { ?>
      <div class="col-lg-3 col-xs-6 summary_ro_suggestion">
        <div class="small-box bg-aqua">
          <div class="inner">
            <p><b>Product - RO sugestion</b></p>
            <h3><span class="line1">0</span></h3>
            <p>Product Under Min : <span class="line2">0</span></p>
            <!-- <p>Qty sum all : <span class="line3">0</span></p> -->
            <br>
          </div>
          <div class="icon">
            <i class="ion ion-ios-cart"></i>
          </div>
          <a href="<?php echo $link_summary_ro_suggestion;?>" class="small-box-footer" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <?php } ?>
      <!-- <div class="col-md-12 loading_home_dashboard"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div> -->
    </div>

    <div class="callout callout-danger">
      <h4>PERHATIAN!</h4>
      <p><?php echo nl2br($this->session->userdata('MainWarning'));?></p>

    </div>
    <div class="callout callout-info">
      <h4>Tip!</h4>
      <p><?php echo nl2br($this->session->userdata('MainInfo'));?></p>
      <!-- <p><?php echo nl2br($this->session->userdata('HeaderFaktur1'));?></p> -->
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="box box-solid">
          <div class="box-body" style="overflow: auto; padding: 5px;">
            <!-- <img src="<?php echo base_url();?>tool/angzcommerz.jpg" style="width:100%;"> -->
            <?php 
              // print_r($MenuList); 
              // $parts = parse_url( $_SERVER['HTTP_REFERER'] );
              // echo $parts['host'];
            ?>

            <ul class="" style="margin-left: -20px !important; min-width: 450px;">
              <?php 
              if (isset($content['birthday'])) {
                foreach ($content['birthday'] as $row => $list2) { 
                  $BirthDate = strtotime($list2['BirthDate']);
                  $newBirthDate = date('d M',$BirthDate);
              ?>
                <li>
                    <a href="#"><?php echo $list2['fullname'];?></a> - <?php echo $list2['LevelName'];?>
                    <span style="float: right;"><i class="fa fa-birthday-cake"></i> <?php echo $newBirthDate;?>
                </li>
              <?php } } ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-solid">
          <div class="box-body" style="overflow: auto; padding: 5px;">
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
jQuery( document ).ready(function( $ ) {
  $( "li.menu_dashboard" ).addClass( "active" );
  setTimeout(function() {
    runSummary()
    setInterval(function() {
      runSummary()
    }, 300*1000)
  }, 10*1000)
});

function runSummary() {
    summary_so_outstanding_do()
    summary_so_warehouse()
    summary_do_not_inv()
    summary_inv_unpaid()
    summary_po_outstanding()
    summary_ro_outstanding()
    summary_ro_suggestion()
}
function summary_so_outstanding_do() {
  if ($(".summary_so_outstanding_do").length) {
    $.ajax({
      url: "<?php echo base_url();?>main/home_dashboard",
      type : 'GET',
      data : 'data=summary_so_outstanding_do',
      dataType : 'json',
      success : function (result) {
        $(".summary_so_outstanding_do").find(".line1").html(result['CountSO'])
        $(".summary_so_outstanding_do").find(".line2").html(result['SO_late'])
        $(".summary_so_outstanding_do").find(".line3").html(result['CountQty'])
      },
      error : function () {
         console.log("Error !, summary_so_outstanding_do");
      }
    })
  }
}
function summary_so_warehouse() {
  if ($(".summary_so_warehouse").length) {
    $.ajax({
      url: "<?php echo base_url();?>main/home_dashboard",
      type : 'GET',
      data : 'data=summary_so_warehouse',
      dataType : 'json',
      success : function (result) {
        $(".summary_so_warehouse").find(".line1").html(result['CountPutat'])
        $(".summary_so_warehouse").find(".line2").html(result['CountMargo'])
        $(".summary_so_warehouse").find(".line3").html(result['CountSO'])
      },
      error : function () {
         console.log("Error !, summary_so_warehouse");
      }
    })
  }
}
function summary_do_not_inv() {
  if ($(".summary_do_not_inv").length) {
    $.ajax({
      url: "<?php echo base_url();?>main/home_dashboard",
      type : 'GET',
      data : 'data=summary_do_not_inv',
      dataType : 'json',
      success : function (result) {
        $(".summary_do_not_inv").find(".line1").html(result['CountDO'])
        $(".summary_do_not_inv").find(".line2").html(result['CountSales'])
        $(".summary_do_not_inv").find(".line3").html(result['CountConsignment'])
      },
      error : function () {
         console.log("Error !, summary_do_not_inv");
      }
    })
  }
}
function summary_inv_unpaid() {
  if ($(".summary_inv_unpaid").length) {
    $.ajax({
      url: "<?php echo base_url();?>main/home_dashboard",
      type : 'GET',
      data : 'data=summary_inv_unpaid',
      dataType : 'json',
      success : function (result) {
        CountUnpaid = Number(result['CountUnpaid']).toLocaleString( undefined, { minimumFractionDigits: 2 } ); 
        $(".summary_inv_unpaid").find(".line1").html(result['CountINV'])
        $(".summary_inv_unpaid").find(".line2").html(result['CountINVLate'])
        $(".summary_inv_unpaid").find(".line3").html( CountUnpaid )
      },
      error : function () {
         console.log("Error !, summary_inv_unpaid");
      }
    })
  }
}
function summary_ro_outstanding() {
  if ($(".summary_ro_outstanding").length) {
    $.ajax({
      url: "<?php echo base_url();?>main/home_dashboard",
      type : 'GET',
      data : 'data=summary_ro_outstanding',
      dataType : 'json',
      success : function (result) {
        $(".summary_ro_outstanding").find(".line1").html(result['CountRO'])
        $(".summary_ro_outstanding").find(".line2").html(result['RAW_Ready_all'])
        $(".summary_ro_outstanding").find(".line3").html(result['RAW_Ready_Partial'])
      },
      error : function () {
         console.log("Error !, summary_ro_outstanding");
      }
    })
  }
}
function summary_po_outstanding() {
  if ($(".summary_po_outstanding").length) {
    $.ajax({
      url: "<?php echo base_url();?>main/home_dashboard",
      type : 'GET',
      data : 'data=summary_po_outstanding',
      dataType : 'json',
      success : function (result) {
        $(".summary_po_outstanding").find(".line1").html(result['CountPO'])
        $(".summary_po_outstanding").find(".line2").html(result['RAW_not_sent'])
        $(".summary_po_outstanding").find(".line3").html(result['PO_late'])
      },
      error : function () {
         console.log("Error !, summary_po_outstanding");
      }
    })
  }
}
function summary_ro_suggestion() {
  if ($(".summary_ro_suggestion").length) {
    $.ajax({
      url: "<?php echo base_url();?>main/home_dashboard",
      type : 'GET',
      data : 'data=summary_ro_suggestion',
      dataType : 'json',
      success : function (result) {
        $(".summary_ro_suggestion").find(".line1").html(result['CountProduct'])
        $(".summary_ro_suggestion").find(".line2").html(result['CountProductUnderMin'])
        // $(".summary_ro_outstanding").find(".line3").html(result['RAW_Ready_Partial'])
      },
      error : function () {
         console.log("Error !, summary_ro_suggestion");
      }
    })
  }
}

function get_home_dashboard() {
    document.getElementById("report-summary").innerHTML='<div class="col-md-12 loading_home_dashboard"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>'
    xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>main/home_dashboard"
    xmlHttp.onreadystatechange=stateChanged
    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)
}
function stateChanged(){
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
        document.getElementById("report-summary").innerHTML=xmlHttp.responseText
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