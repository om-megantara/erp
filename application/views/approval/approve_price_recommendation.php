<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style type="text/css">
  .form-group { display: block; margin-bottom: 5px !important; }
  #reject { background-color: #dd4b39; }
  #approve { background-color: #0073b7; }
  .danger {
    color:red;
  }
  .success {
    color:green;
  }
  .detailNote {
    max-width: 200px;
    white-space: normal !important;
  }
  .klik {
    cursor:pointer;
  }
</style>

<?php 
// print_r($content['personal']); 
$actor = $content['actor']['Actor1'] != $EmployeeID ? : "Actor1";
$actor = $content['actor']['Actor2'] != $EmployeeID ? $actor : "Actor2";
$actor = $content['actor']['Actor3'] != $EmployeeID ? $actor : "Actor3";

?>

<div class="content-wrapper">
  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Detail SO </h4>
          </div>
          <div class="modal-body">
            <div class="detailcontentAjax" id="detailcontent" style="background-color: white;">
            </div>
          </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-product">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail Product</h4>
          </div>
          <div class="modal-body">
            <div id="detailcontentAjax" id="detailcontentAjax" ></div>
          </div>
          <div class="modal-footer">
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
      <div class="box-body form_addcontact">
          <table id="dt_list" class="table table-bordered table-hover nowrap dtapproval" width="100%">
            <thead>
            <tr>
              <th class="alignCenter" width="20px">ID</th>
              <th class="alignCenter">ProductName</th>
              <th class="alignCenter">Price</th>
              <th class="alignCenter">HPP</th>
              <th class="alignCenter">Margin</th>
              <th class="alignCenter">Stock</th>
              <th class="alignCenter">Input By</th>
              <th class="alignCenter">Note</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
              <?php
                if ($actor!= "1" && !empty($content['list'])) {
                  foreach ($content['list'] as $row => $list) {
                    if(empty($list['cbd'])){
                      $price=$list['ProductPriceDefault'];
                    } else {
                      $price=$list['cbd'];
                    }
                    if($list['PriceRec']>$list['ProductPriceHPP']){
                      $status="success";
                    } else {
                      $status="danger";
                    }
                    $margin=$price-$list['ProductPriceHPP'];
                    $marginrec=$list['PriceRec']-$list['ProductPriceHPP'];
                    if($marginrec>0){
                      $status2="success";
                    } else {
                      $status2="danger";
                    }
                    ?>
                    <tr>
                      <td><a href="#" class="detail" product="<?php echo $list['ProductID'];?>" data-toggle="modal" data-target="#modal-detail"><?php echo $list['ProductID'];?></a></td>
                      <td><a class="view_detail klik" type="button" product="<?php echo $list['ProductID'];?>" data-toggle="modal" data-target="#modal-product"><div class="detailNote" style="width: 150px;"><?php echo $list['ProductName'];?></div></td>
                      <td class="alignLeft"><?php echo "<b>Current</b> : Rp ".number_format($price)."<br><b>Recommendation</b> : <font class='".$status."'>Rp ".number_format($list['PriceRec'])."</p>";?></td>
                      <td class="alignLeft"><?php echo "Rp ".number_format($list['ProductPriceHPP']);?></td>
                      <td class="alignLeft"><?php echo "<b>Current</b> : Rp ".number_format($margin)."<br> <b>Recommendation</b> : <font class='".$status2."'>Rp ".number_format($marginrec)."</p>";?></td>
                      <td><?php echo $list['stock'];?></td>
                      <td><?php echo $list['fullname'];?></td>
                      <td><div class="detailNote" style="width: 120px;"><?php echo $list['Note'];?></div></td>
                      <td>
                        <?php if(!empty($list['Screenshot'])){?>
                        <a href="<?php echo base_url(); ?>assets/Price_Check/<?php echo $list['Screenshot'];?>" target="_blank" class="btn btn-xs btn-warning Screenshot" title='Screenshot'><i class="fa fa-fw fa-file-image-o"></i></a>
                        <?php } ?>
                        <?php if(!empty($list['Link1'])){?>
                        <a href="<?php echo $list['Link1'];?>" target='_blank' class="btn btn-success btn-xs" title='Link Tokopedia'><i class="fa fa-fw fa-link"></i></a>
                        <?php }?>
                        <?php if(!empty($list['Link2'])){?>
                        <a href="<?php echo $list['Link2'];?>" target='_blank' class="btn btn-warning btn-xs" title='Link Shopee'><i class="fa fa-fw fa-link"></i></a>
                        <?php }?>
                        <a href="<?php echo base_url().'master/price_recommendation_edit?RecID='.$list['RecID']; ?>" target='_blank' class="btn btn-success btn-xs" ><i class="fa fa-tags"></i></a>
                        <?php
                          if ($list[$actor] == "") {
                            echo ($content['actor'][$actor] != "") ? "<a href='#' class='btn btn-primary btn-xs dtbutton' id='approve' data='".$actor."' RecID='".$list['RecID']."' ProductID='".$list['ProductID']."' PriceRec='".$list['PriceRec']."'><i class='fa fa-fw fa-check-square'></i></a>" : "";
                            echo ($content['actor'][$actor] != "") ? " <a href='#' class='btn btn-danger btn-xs dtbutton' id='reject' data='".$actor."' RecID='".$list['RecID']."' ProductID='".$list['ProductID']."'><i class='fa fa-fw fa-minus-square'></i></a>" : "";
                          }
                        ?>
                      </td>
                    </tr>
              <?php } } else {
                $actor= "Actor".$actor;
                $no = 0;
                foreach ($content['list'] as $row => $list) {
                  if(empty($list['cbd'])){
                      $price=$list['ProductPriceDefault'];
                    } else {
                      $price=$list['cbd'];
                    }
                    if($list['PriceRec']>$list['ProductPriceHPP']){
                      $status="success";
                    } else {
                      $status="danger";
                    }
                    $margin=$price-$list['ProductPriceHPP'];
                    $marginrec=$list['PriceRec']-$list['ProductPriceHPP'];
                    if($marginrec>0){
                      $status2="success";
                    } else {
                      $status2="danger";
                    }
              ?>
                    <tr>
                      <td><a href="#" class="detail" product="<?php echo $list['ProductID'];?>" data-toggle="modal" data-target="#modal-detail"><?php echo $list['ProductID'];?></a></td>
                      <td><a class="view_detail klik" type="button" product="<?php echo $list['ProductID'];?>" data-toggle="modal" data-target="#modal-product"><div class="detailNote" style="width: 150px;"><?php echo $list['ProductName'];?></div></td>
                      <td class="alignLeft"><?php echo "<b>Current</b> : Rp ".number_format($price)."<br><b>Recommendation</b> : <font class='".$status."'>Rp ".number_format($list['PriceRec'])."</p>";?></td>
                      <td class="alignLeft"><?php echo "<b>HPP</b> : Rp ".number_format($list['ProductPriceHPP']); ?> </td>
                      <td class="alignLeft"><?php echo "<b>Current</b> : Rp ".number_format($margin)."<br> <b>Recommendation</b> : <font class='".$status2."'>Rp ".number_format($marginrec)."</p>";?></td>
                      <td><?php echo $list['stock'];?></td>
                      <td><?php echo $list['fullname'];?></td>
                      <td><div class="detailNote" style="width: 120px;"><?php echo $list['Note'];?></div></td>
                      <td>
                        <?php if(!empty($list['Screenshot'])){?>
                        <a href="<?php echo base_url(); ?>assets/Price_Check/<?php echo $list['Screenshot'];?>" target="_blank" class="btn btn-xs btn-warning Screenshot" title='Screenshot'><i class="fa fa-fw fa-file-image-o"></i></a>
                        <?php }?>
                        <?php if(!empty($list['Link1'])){?>
                        <a href="<?php echo $list['Link1'];?>" target='_blank' class="btn btn-success btn-xs" title='Link Tokopedia'><i class="fa fa-fw fa-link"></i></a>
                        <?php }?>
                        <?php if(!empty($list['Link2'])){?>
                        <a href="<?php echo $list['Link2'];?>" target='_blank' class="btn btn-warning btn-xs" title='Link Shopee'><i class="fa fa-fw fa-link"></i></a>
                        <?php }?>
                        <?php
                          if(empty($list['Actor1ID'])){
                            echo ($content['actor'][$actor] != "") ? "<a href='#' class='btn btn-primary btn-xs dtbutton' id='approve' data='".$actor."' RecID='".$list['RecID']."' ProductID='".$list['ProductID']."' PriceRec='".$list['PriceRec']."'><i class='fa fa-fw fa-check-square'></i></a>" : "";
                            echo ($content['actor'][$actor] != "") ? " <a href='#' class='btn btn-danger btn-xs dtbutton' id='reject' data='".$actor."' RecID='".$list['RecID']."' ProductID='".$list['ProductID']."'><i class='fa fa-fw fa-minus-square'></i></a>" : "";
                          }
                        ?>
                      </td>
                    </tr>
              <?php } } ?>
            </tbody>
          </table>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
j8  = jQuery.noConflict();
j8( document ).ready(function( $ ) {
   
  $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',

    "scrollX": true,
    "scrollY": true,
    "order": [[ 0, "asc" ]],

  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);

  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});

jQuery( document ).ready(function( $ ) {
  $('.detail').live('click', function(e){
        document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        id  = $(this).attr("product")
        get(id);
  });
  function get(id) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>report/report_product_kpi_so_detail"
      url=url+"?product="+id
      // alert(url);
      xmlHttp.onreadystatechange=stateChanged
      xmlHttp.open("GET",url,true)
      xmlHttp.send(null)
  }
  function stateChanged(){
      if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
          document.getElementById("detailcontent").innerHTML=xmlHttp.responseText
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
  $('.view_detail').live('click', function(e){
    $('#detailcontentAjax').empty()
    id = $(this).attr('product');
    get2(id);
  });
  function get2(id) {
    xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>report/get_product_offline_detail"
    url=url+"?a="+id
    xmlHttp.onreadystatechange=stateChanged2
    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)
  }
  function stateChanged2(){
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
        $('.loader').slideUp("fast")
        document.getElementById("detailcontentAjax").innerHTML=xmlHttp.responseText
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
  // window.setTimeout(function(){location.reload()},60000);
  $('#approve').live('click',function(e){
    var
      user = $(this).attr('data');
      RecID = $(this).attr('RecID');
      ProductID = $(this).attr('ProductID');
      PriceRec = $(this).attr('PriceRec');
      par  = $(this).parent().parent();
      Approval1  = par.find("td:nth-child(4)").html();
      Approval2  = par.find("td:nth-child(5)").html();
      Approval3  = par.find("td:nth-child(6)").html();
      data = {user:user, RecID:RecID, ProductID:ProductID, PriceRec:PriceRec, Approval1:Approval1, Approval2:Approval2, Approval3:Approval3 };
      errornote  = "This Price will be Approved!\nare you sure?"
      var r = confirm(errornote);
      if (r == false) {
        e.preventDefault();
        return false
      } else {
        $.ajax({
          url: "<?php echo base_url();?>approval/approve_price_recommendation_act/approve",
          type : 'POST',
          data : data,
          success : function (response) {
            window.location.href = "<?php echo current_url(); ?>";
          }
        })
      }
  }); 
  $('#reject').live('click',function(e){
    var
      user = $(this).attr('data');
      RecID = $(this).attr('RecID');
      ProductID = $(this).attr('ProductID');
      par  = $(this).parent().parent();
      Approval1  = par.find("td:nth-child(4)").html();
      Approval2  = par.find("td:nth-child(5)").html();
      Approval3  = par.find("td:nth-child(6)").html();
      data = {user:user, RecID:RecID, ProductID:ProductID, Approval1:Approval1, Approval2:Approval2, Approval3:Approval3 };
      errornote  = "This Price will be Reject!\nare you sure?"
      var r = confirm(errornote);
      if (r == false) {
        e.preventDefault();
        return false
      } else {
        $.ajax({
          url: "<?php echo base_url();?>approval/approve_price_recommendation_act/reject",
          type : 'POST',
          data : data,
          success : function (response) {
            window.location.href = "<?php echo current_url(); ?>";
          }
        })
      }
  });  
});   
</script>