<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">
  .form-group { display: block; margin-bottom: 5px !important; }
  #reject { background-color: #dd4b39; }
  .view_detail {
    cursor: pointer;
    margin-right: 3px; }
</style>

<?php
  $actor = $content['actor']['Actor1'] != $EmployeeID ? : "Actor1";
  $actor = $content['actor']['Actor2'] != $EmployeeID ? $actor : "Actor2";
  $actor = $content['actor']['Actor3'] != $EmployeeID ? $actor : "Actor3";
?>

<div class="content-wrapper">
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
      <div class="box-header with-border"></div>
      <div class="box-body form_addcontact">
          <table id="dt_list" class="table table-bordered table-hover nowrap dtapproval" width="100%">
            <thead>
            <tr>
              <th class="alignCenter">No</th>
              <th class="alignCenter">Tanggal</th>
              <th class="alignCenter">Product ID</th>
              <th class="alignCenter">Product</th>
              <th class="alignCenter">Price Default</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
              <?php
                if ($actor!= "1" && !empty($content['list'])) {
                  $no = 0;
                  foreach ($content['list'] as $row => $list) { $no++;?>
                    <tr>
                      <td><?php echo $no;?></td>
                      <td><?php echo $list['Date'];?></td>
                      <td>
                      <a class="view_detail" ProductID="<?php echo $list['ProductID'];?>" data-toggle="modal" data-target="#modal-detail"><?php echo $list['ProductID'];?></a>
                      </td>
                      <td><?php echo $list['ProductName'];?></td>
                      <td><?php echo "Rp ".number_format($list['ProductPriceDefault']);?></td>
                      <td>
                        <?php
                          if ($list[$actor] == "") {
                            echo ($content['actor'][$actor] != "") ? "<a href='#' class='btn btn-primary btn-xs dtbutton' id='approve' data='".$actor."' ActivityID='".$list['ActivityID']."'><i class='fa fa-fw fa-check-square'></i></a>" : "";
                          }
                        ?>
                      </td>
                    </tr>
              <?php } } else {
                  $actor= "Actor".$actor;
                  $no = 0;
                  foreach ($content['list'] as $row => $list) { $no++;?>
                    <tr>
                      <td><?php echo $no;?></td>
                      <td><?php echo $list['Date'];?></td>
                      <td>
                        <a class="view_detail" ProductID="<?php echo $list['ProductID'];?>" data-toggle="modal" data-target="#modal-detail"><?php echo $list['ProductID'];?></a>
                      </td>
                      <td><?php echo $list['ProductName'];?></td>
                      <td><?php echo "Rp ".number_format($list['ProductPriceDefault']);?></td>
                      <td><a href='#' class='btn btn-success btn-xs dtbutton' id='approve' data='<?php echo $list['Actor3']?>' ActivityID='<?php echo $list['ActivityID']?>'><i class='fa fa-fw fa-check-square'></i></a>
                      </td>
                    </tr>
              <?php } } ?>
            </tbody>
          </table>
      </div>
    </div>
  </section>
  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Detail Product</h4>
        </div>
        <div class="modal-body">
          <div class="loader"></div>
          <div id="detailcontentAjax"></div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
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

jQuery( document ).ready(function( $ ) {

  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo '200';?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "scrollX": true,
    "scrollY": true,
    "scrollCollapse": true, 
    "order": [[ 1, "asc" ]]
  })
  // window.setTimeout(function(){location.reload()},60000);
  $('#approve').live('click',function(e){
    var
      user = $(this).attr('data');
      ActivityID = $(this).attr('ActivityID');
      par  = $(this).parent().parent();
      data = {user:user, ActivityID:ActivityID};
      $.ajax({
        url: "<?php echo base_url();?>approval/update_price_list_act/approve",
        type : 'POST',
        data : data,
        success : function (response) {
          window.location.href = "<?php echo current_url(); ?>";
        }
      })
  });

  $(document).on('click', '.cek_link', function(){
    ProductID = $(this).attr("ProductID")
    obj_type  = ['atributeid','atributevalue','atributeConn']
    obj_value = ['ProductID',ProductID,'or ']
    var obj = { type:obj_type, value:obj_value };
    localStorage.removeItem('parse_report_product_general');
    localStorage.setItem('parse_report_product_general', JSON.stringify(obj));
    var win = window.open('<?php echo base_url();?>report/report_product_general', '_blank');
        win.focus();
  });

  $('.view_detail').live('click', function(e){
    $('.loader').slideDown("fast")
    $('#detailcontentAjax').empty()
    id = $(this).attr('ProductID');
    get(id);
  })
  function get(product) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>report/report_product_detail"
      url=url+"?product="+product
      xmlHttp.onreadystatechange=stateChanged
      xmlHttp.open("GET",url,true)
      xmlHttp.send(null)
  }
  function stateChanged(){
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
});

function stateChanged(){
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
</script>