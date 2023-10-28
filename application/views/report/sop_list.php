<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
  .divfilter {
    margin-top: 5px;
    border: 1px solid #367fa9;
    display: none;
  }
  @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 130px;
      }
      .form-group span.left2 {
        display: block;
        overflow: hidden;
      }
      .form-group { margin-bottom: 5px; }
  }
  .Ready { background: #73ba76e0 !important; }
  .Finish { background: #fff !important; }
  .nonPriority{
  background-color: #ef9d9d;
  }
</style>
<div class="content-wrapper">
  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Detail Customer</h4>
          </div>
          <div class="modal-body">
            <div class="detailcontentAjax2" id="detailcontent" style="background-color: white;">
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
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
        <div class="form-button"> 
          <button type="button" class="btn btn-primary btn-xs print_dt" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
          <a href="<?php echo base_url();?>master/sop_list_add" class="btn btn-primary btn-xs addadjustment">Add SOP</a>
          <!-- <a href="#" id="filter" class="btn btn-primary btn-xs filter"><i class="fa fa-search"></i> Filter</a>  -->
        </div> 
        <div class="divfilter">
          <div class="box-body">
            <form name="form" action="<?php echo current_url();?>" method="post" enctype="multipart/form-data" autocomplete="off"> 
              <div class="col-md-6">
                <div class="form-group">
                  <label class="left">Customer</label>
                  <span class="left2">
                    <input type="text" class="form-control customer" autocomplete="off" name="customer" id="customer">
                  </span>  
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="left">Start</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="filterstart" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="left">End</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="filterend" >
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <center style="margin-bottom: 5px;">
                  <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                 </center> 
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Code</th>
                <th>Upload Date</th>
                <th>Departement</th>
                <th>Subject</th>
                <th>Update Date</th>
                <th>Input By</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php
              $no=0;
              if (isset($content)) {
               foreach ($content as $row => $list) { 
                $no++;
            ?>
                  <tr>
                    <td><?php echo $no;?></td>
                    <td><?php echo $list['SopCode'];?></td>
                    <td><?php echo $list['UploadDate'];?></td>
                    <td><?php echo $list['DivisiName'];?></td>
                    <td><?php echo $list['Subject'];?></td>
                    <td><?php echo $list['UpdateDate'];?></td>
                    <td><?php echo $list['FullName'];?></td>
                    <td>
                      <a href="<?php echo $list['Link'];?>" title="Hyperlink" target='_blank' class="btn btn-primary btn-xs"><i class="fa fa-fw fa-link"></i></a>
                      <a href="<?php echo base_url()."assets/pdf_sop/".$list['FilePDF'];?>" title="Documents" target='_blank' class="btn btn-primary btn-xs"><i class="fa fa-file-pdf-o"></i></a>
                       <button type="button" class="btn btn-success btn-xs" title="EDIT" onclick="window.open('<?php echo base_url();?>master/sop_list_edit?id=<?php echo $list['SopID']; ?>', '_blank');"><i class="fa fa-fw fa-edit"></i></button>
                      <button type="button" class="btn btn-danger btn-xs cancel" title="CANCEL" SopID="<?php echo $list['SopID']; ?>"><i class="fa fa-fw fa-trash-o"></i></button>
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
jQuery( document ).ready(function( $ ) {

  var oTable = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "scrollX": true,
     "scrollY": true, 
    "searchDelay": 2000,
    "processing": true, 
    "language": { processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '}, 
    fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {  
        if ( aData[9] !="0000-00-00") { 
          jQuery(nRow).addClass('Finish');
        } else if ( aData[8] == 0 ) { 
          jQuery(nRow).addClass('Finish');
        } else if ( aData[8] < 14 ) {
          jQuery(nRow).addClass('Ready');
        } else if ( aData[8] > 14 ) {
          jQuery(nRow).addClass('nonPriority'); 
        } 
    },
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };

  $('#dt_list').resize(cek_dt);

  $(".filter").click(function(){
    $(".divfilter").slideToggle();
  });

  $("#filterstart").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    todayBtn:  1,
  }).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#filterend').datepicker('setStartDate', minDate);
  });
  $("#filterend").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
  }).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#filterstart').datepicker('setEndDate', maxDate);
  });

  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });  

  $('.detail').live('click', function(e){
      document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
      customer  = $(this).attr("customer")
      customerid  = $(this).attr("customerid")
      $('.modal-title').text("Detail Customer "+customer)
      get(customerid);
  });
  function get(customerid) {
  xmlHttp=GetXmlHttpObject()
    xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>master/customer_list_detail"
    url=url+"?a="+customerid
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

  $('.cancel').live('click',function(e){
      var
        SopID = $(this).attr('SopID');
        data = {SopID:SopID};
        var r = confirm("Apa anda yakin akan menghapus?");
        if (r == true) {
          $.ajax({
            // url: "<?php //echo base_url();?>transaction/stock_adjustment_cancel",
            url: "<?php echo base_url();?>master/sop_list_cancel",
            type : 'POST',
            data : data,
            success : function (response) {
              location.reload();
            }
          })
        }
    });
});

</script>