<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style type="text/css">
  .divfilterdate {
    display: none;
    margin: 5px 10px;
    border: 1px solid #0073b7;
    padding: 4px;
    overflow: auto;
  }
  .form-group { display: block; margin-bottom: 5px !important; }
  #reject { background-color: #dd4b39; }
  #approve { background-color: #0073b7; }
</style>

<?php 
// print_r($content['personal']); 
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
      <div class="box-header">
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
            <div class="col-md-6">
              <div class="form-group">
                  <label class="left">Month Start</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="datestart" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="left">Month End</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="dateend" required="">
                  </div>
                </div>
            </div>
            <div class="col-md-12">
              <center>
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
              </center>
            </div>
          </form>
        </div>
      </div>
      <div class="box-body form_addcontact">
          <table id="dt_list" class="table table-bordered table-hover nowrap dtapproval" width="100%">
            <thead>
            <tr>
              <th id="order" class=" alignCenter">No</th>
              <th class=" alignCenter">Customer Name</th>
              <th class=" alignCenter">Notes</th>
              <th class=" alignCenter">Approval 1</th>
              <th class=" alignCenter">Approval 2</th>
              <th class=" alignCenter">Approval 3</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
              <?php
                if ($actor != "1" && !empty($content['list'])) {
                  $no = 0;
                  foreach ($content['list'] as $row => $list) { $no++;?>
                      <tr>
                        <td class=" alignCenter"><?php echo $list['ApprovalID'];?></td>
                        <td><?php echo $list['fullname'];?></td>
                        <td><?php echo $list['Keterangan'];?></td>
                        <td><?php echo $list['Actor1'];?></td>
                        <td><?php echo $list['Actor2'];?></td>
                        <td><?php echo $list['Actor3'];?></td>
                        <td>
                          <button type="button" id="view" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-contact"  contact="<?php echo $list['ContactID'];?>"><i class="fa fa-fw fa-file-image-o"></i></button>
                          <?php 
                            if ($list[$actor] == "") {
                              echo ($content['actor'][$actor] != "") ? "<a href='#' class='btn btn-primary btn-xs dtbutton' id='approve' data='".$actor."'><i class='fa fa-fw fa-check-square'></i></a>" : "";
                              echo "<a href='#' class='btn btn-primary btn-xs dtbutton' id='reject' data='".$actor."'><i class='fa fa-fw fa-close'></i></a>";
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

  <div class="modal fade" id="modal-contact">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Detail Customer</h4>
        </div>
        <div class="modal-body">
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
j8( document ).ready(function( $ ) {
   
  $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ {
      "targets": 6,
      "orderable": false
    } ],
    "order": [[ 0, "desc" ]]
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
  // window.setTimeout(function(){location.reload()},60000);
  $('#approve').live('click',function(e){
    var
      user = $(this).attr('data');
      par  = $(this).parent().parent();
      id   = par.find("td:nth-child(1)").html();
      Approval1  = par.find("td:nth-child(4)").html();
      Approval2  = par.find("td:nth-child(5)").html();
      Approval3  = par.find("td:nth-child(6)").html();
      data = {user:user, id:id, Approval1:Approval1, Approval2:Approval2, Approval3:Approval3 };
      var r = confirm("Apa Anda yakin ?");
      if (r == true) {
        $.ajax({
          url: "<?php echo base_url();?>approval/upgrade_customer_act/approve",
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
      par  = $(this).parent().parent();
      id   = par.find("td:nth-child(1)").html();
      Approval1  = par.find("td:nth-child(4)").html();
      Approval2  = par.find("td:nth-child(5)").html();
      Approval3  = par.find("td:nth-child(6)").html();
      data = {user:user, id:id, Approval1:Approval1, Approval2:Approval2, Approval3:Approval3 };
      var r = confirm("Apa Anda yakin ?");
      if (r == true) {
        $.ajax({
          url: "<?php echo base_url();?>approval/upgrade_customer_act/reject",
          type : 'POST',
          data : data,
          success : function (response) {
            window.location.href = "<?php echo current_url(); ?>";
          }
        })
      }
  });

  $('#view').live('click',function(e){
      id = $(this).attr("contact");
      get(id);
  });
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

  var popup;
  function openPopupOneAtATime(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/sales_order_print?so='+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/sales_order_print?so='+x, '_blank', 'width=800,height=650,left=200,top=20');     
      }
  }
  function openPopupOneAtATime2(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/print_invoice?id='+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/print_invoice?id='+x, '_blank', 'width=800,height=650,left=200,top=20');     
      }
  }
  function openPopupOneAtATime3(x) {
    if (popup && !popup.closed) {
      popup.focus();
      popup.location.href = '<?php echo base_url();?>transaction/sales_order_print_no?so='+x;
    } else {
      popup = window.open('<?php echo base_url();?>transaction/sales_order_print_no?so='+x, '_blank', 'width=800,height=650,left=200,top=20');     
    }
  }
  $(".printso").live('click', function() {
    soid = $(this).attr("soid")
    openPopupOneAtATime(soid);
  });
  $(".printso2").live('click', function() {
    soid = $(this).attr("soid")
    openPopupOneAtATime3(soid);
  });
  $(".printinv").live('click', function() {
    invid = $(this).attr("invid")
    openPopupOneAtATime2(invid);
  });
});

function get(id) {
  xmlHttp=GetXmlHttpObject()
    document.getElementById("detailcontentAjax").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
    var url="<?php echo base_url();?>master/customer_list_detail"
    url=url+"?a="+id
    // alert(url);
    xmlHttp.onreadystatechange=stateChanged
    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)
}
function stateChanged(){
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
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