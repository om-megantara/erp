<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css"> 

</style>
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
        <a href="#" id="tr-filter" class="btn btn-primary btn-xs tr-filter"><i class="fa fa-search"></i> Filter by Column</a>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th class=" alignCenter">Sales ID</th>
              <th class=" alignCenter">Contact ID</th>
              <th class=" alignCenter">Employee ID</th>
              <th class=" alignCenter">Sales Name</th>
              <th class=" alignCenter">Phone Number</th>
              <th class=" alignCenter">SEC</th>
              <th class=" alignCenter">Status</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
              $no = 0;
              foreach ($content as $row => $list) { 
                $SEC = ($list['SalesParent'] == 0) ? '' : $list['SalesParent']." - ".$content[$list['SalesParent']]['Company'] ;
                if ($list['status'] == "Active") { ?>
                    <tr class="mini">
                  <?php } else { ?>
                    <tr class="mini" style="background-color: #cc8585">
                  <?php }; ?>
                      <td class=" alignCenter"><?php echo $list['SalesID'];?></td>
                      <td class=" alignCenter"><?php echo $list['ContactID'];?></td>
                      <td class=" alignCenter"><?php echo $list['EmployeeID'];?></td>
                      <td><?php echo $list['Company'];?></td>
                      <td><?php echo $list['phone'];?></td>
                      <td><?php echo $SEC;?></td>
                      <td><?php echo $list['status'];?></td>
                      <td>
                        <a href="#" class="dtbutton btn btn-primary btn-xs" id="view" data-toggle="modal" data-target="#modal-contact"><i class="fa fa-fw fa-file-image-o"></i></a>
                      </td>
                    </tr>
            <?php } ?>
            </tbody>
          </table>
      </div> 
    </div>

    <div class="modal fade" id="modal-contact">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail Sales</h4>
          </div>
          <div class="modal-body">
            <div id="detailcontentAjax"></div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
    
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	th_filter_hidden = [0,1,2,5,6,7]
  $('#dt_list thead tr').clone(true).appendTo( '#dt_list thead' );
  $('#dt_list thead tr:eq(0)').addClass('tr-filter-column')
  $('#dt_list thead tr:eq(0) th').each( function (i) {
    if (th_filter_hidden.indexOf(i) < 0) {
      var title = $(this).text();
      $(this).html( '<input type="text" class="input-filter-column input input-sm" placeholder="Search '+title+'" />' );

      $( 'input', this ).on( 'keyup change', function () {
          if ( dtable.column(i).search() !== this.value ) {
              dtable
                  .column(i)
                  .search( this.value )
                  .draw();
          }
      });
    } else {
      $(this).text('')
    }
  });
  $(".tr-filter").click(function(){
    $(".tr-filter-column").slideToggle().focus();
  });

  dtable = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ {
      "targets": 7,
      "orderable": false
    } ],
    "order": [[ 0, "asc" ]]
  });

  var cek_dt = function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);

  $('#view').live('click',function(e){
    //if( $('#detail').length ){ $('#detail').remove() }
    var
      par = $(this).parent().parent();
      id  = par.find("td:nth-child(2)").html();
      //$('<tr id="detail"><td colspan="7"><div id="detailcontentAjax"></div></td></tr>').insertAfter($(this).closest('tr'));
      get(id);
  });
});


function get(id) {
    document.getElementById("detailcontentAjax").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
    xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>master/sales_list_detail"
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