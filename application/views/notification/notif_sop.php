<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">
  .form-group { display: block; margin-bottom: 5px !important; }
  #reject { background-color: #dd4b39; }
  .view_detail { cursor : pointer; margin-right: 3px; }
  .history {cursor : pointer}
  .divfilterdate {
    display: none; 
    margin: 5px 0px;
    border: 1px solid #0073b7; 
    padding: 4px; 
    overflow: auto;
  }
  .detailNote {
    max-width: 300px;
    white-space: normal !important;
  }
  @media (min-width: 768px){
  .form-group label.left {
    float: left;
    width: 130px;
    padding: 5px 0px 5px 0px;
  }
  .form-group span.left2 {
    display: block;
    overflow: hidden;
  }
  .form-group { margin-bottom: 10px; }
}
</style>
</style>

<?php 

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
      <div class="box-header with-border">
      </div>
      <div class="box-body form_addcontact">
          <table id="dt_list" class="table table-bordered table-hover nowrap dtapproval" width="100%">
            <thead>
            <tr>
              <th class="alignCenter">No</th>
              <th class="alignCenter">Date</th>
              <th class="alignCenter">SOP Code</th>
              <th class="alignCenter">Subject</th>
              <th class="alignCenter">Note</th>
              <th class="alignCenter">File/Link</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
              <?php
                if ($content['list']) {
                  $no = 0;
                  foreach ($content['list'] as $row => $list) { $no++;?>
                      <tr>
                        <td class="alignRight"><?php echo $no;?></td>
                        <td class="alignCenter"><?php echo $list['NoteDate'];?></td>
                        <td class="alignCenter"><?php echo $list['SopCode'];?></td>
                        <td class="detailNote"><?php echo $list['Subject'];?></td>
                        <td class="alignCenter"><?php echo $list['NoteDetail'];?></td>
                        <td class="alignCenter">
                          <a href="<?php echo $list['Link'];?>" title="Hyperlink" target='_blank' class="btn btn-primary btn-xs"><i class="fa fa-fw fa-link"></i></a>
                          <a href="<?php echo base_url()."assets/pdf_sop/".$list['FilePDF'];?>" title="Documents" target='_blank' class="btn btn-primary btn-xs"><i class="fa fa-file-pdf-o"></i></a>
                        </td>
                        <td><?php if (in_array("notif_minmax_all", $MenuList)) { } else {?>
                          <a href='#' class='btn btn-success btn-xs dtbutton' id='approve' NoteID='<?php echo $list['NoteID']?>'><i class='fa fa-fw fa-check-square'></i></a><?php } ?>
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
      NoteID = $(this).attr('NoteID');
      par  = $(this).parent().parent();
      data = {user:user, NoteID:NoteID};
      $.ajax({
        url: "<?php echo base_url();?>notification2/notif_sop_act/approve",
        type : 'POST',
        data : data,
        success : function (response) {
          window.location.href = "<?php echo current_url(); ?>";
        }
      })
  });

  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });
  $('.view_detail').live('click', function(e){
    $('.loader').slideDown("fast")
    $('#detailcontentAjax').empty()
    id = $(this).attr('productid');
    get(id);
  })
  
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

</script>
<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>

$('.history').live('click', function(e){
    product   = $(this).attr('product');
    openPopupOneAtATime(product);
});

var popup;
function openPopupOneAtATime(x) {
  if (popup && !popup.closed) {
     popup.focus();
     popup.location.href = '<?php echo base_url();?>transaction/product_stock_history?product='+x;
  } else {
     popup = window.open('<?php echo base_url();?>transaction/product_stock_history?product='+x, '_blank', 'width=850,height=600,left=200,top=20');     
  }
}
</script>