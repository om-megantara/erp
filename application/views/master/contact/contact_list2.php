<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css"> 
  #detailcontentAjax {
    background-color: #dbdbdb;
    padding: 10px;
  }
  #form-filter {
    border: 1px solid #0073b7; 
    padding: 4px;
    padding-top: 20px; 
    display: none;
  }
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
        <button type="button" class="btn btn-primary btn-xs" onclick="window.open('<?php echo base_url();?>master/contact_cu/new', '_blank');"><b>+</b> Add Contact</button>
        <!-- <button type="button" class="btn btn-primary btn-xs" id="divfilter" title="FILTER BY COLUMN">Filter By Column</button> -->
        <p></p>

        <form id="form-filter" class="form-horizontal">
            <div class="form-group">
                <label for="fullname" class="col-sm-2 control-label">Full Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control input-sm" id="fullname">
                </div>
            </div>
            <div class="form-group">
                <label for="Company" class="col-sm-2 control-label">Company</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control input-sm" id="Company">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <button type="button" id="btn-filter" class="btn btn-primary btn-sm">Filter</button>
                    <button type="button" id="btn-reset" class="btn btn-default btn-sm">Reset</button>
                </div>
            </div>
        </form>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
              <tr>
                <th class=" alignCenter">ID</th>
                <th class=" alignCenter">Name</th>
                <th class=" alignCenter">PhoneNumber</th>
                <th class=" alignCenter">Address</th>
                <th></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
      </div>
      <div class="box-footer">
      </div>
    </div>

    <div class="modal fade" id="modal-contact">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail Contact</h4>
          </div>
          <div class="modal-body">
            <div id="detailcontentAjax"></div>
          </div>
          <div class="modal-footer" >
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
	 
  var initDataTable = true;
  tableConfig = {
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "order": [],
    "scrollX": true,
    "scrollY": true,
    "columnDefs": [ 
      {"targets": 0, "width": "1%"},
      {"targets": 1, "width": "20%"},
      {"targets": 2, "width": "20%"},
      {"targets": 4, "orderable": false, "width": "1%"},
    ], 
    "searchDelay": 1000,
    "processing": true, 
    "serverSide": true, 
    initComplete : function() {
      var input = $('.dataTables_filter input').unbind(),
          self = this.api(),
          $searchButton = $('<button class="btn btn-flat btn-success">')
                     .html('<i class="fa fa-fw fa-search">')
                     .click(function() {
                        self.search(input.val()).draw();
                     }),
          $clearButton = $('<button class="btn btn-flat btn-danger">')
                     .html('<i class="fa fa-fw fa-remove">')
                     .click(function() {
                        input.val('');
                        $searchButton.click(); 
                     }) 
      $('.dataTables_filter').append($searchButton, $clearButton);
      $('.dataTables_filter input').attr('title', 'press ENTER for apply search'); 
    }, 
    "ajax": {
      "url": "<?php echo site_url('master/contact_list_data2')?>",
      "type": "POST",
      beforeSend: function(){
        $('#dt_list > tbody').html(
          '<tr class="odd">' +
            '<td valign="top" class="dataTables_empty" colspan="100%" style="font-size: large;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></td>' +
          '</tr>'
        );
      },
      data: function ( data ) {
          data.page = "filter_contact";
          data.initDataTable = initDataTable;
          data.fullname = $('#fullname').val();
          data.Company = $('#Company').val();
      },
      complete: function() {
        if (initDataTable === true) {
          $('#dt_list > tbody').html(
            '<tr class="odd">' +
              '<td valign="top" class="dataTables_empty" colspan="100%" style="font-size: large;"><p>Please input keyword in the search box to continue</p></td>' +
            '</tr>'
          );
          initDataTable = false;
        }
      },
    }, 
  };

  var table = $('#dt_list')
  .on('preXhr.dt', function ( e, settings, data ) {
    if (settings.jqXHR) settings.jqXHR.abort();
  })
  .DataTable(tableConfig) 

  $('#btn-filter').click(function(){ //button filter event click
      table.ajax.reload();  //just reload table
  });
  $('#btn-reset').click(function(){ //button reset event click
      $('#form-filter')[0].reset();
      table.ajax.reload();  //just reload table
  }); 
  $(document).on('keydown', '.dataTables_filter input', function(e){ //enter to search
    if (e.keyCode == 13) {
      table.search($(this).val())
      table.ajax.reload();  //just reload table
    }
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
  
  $('#view').live('click',function(e){
      par = $(this).parent().parent();
      id  = par.find("td:nth-child(1)").html();
      get(id);
  });

  $("#divfilter").click(function(){
    $("#form-filter").slideToggle();
  });
});


function get(id) {
    document.getElementById("detailcontentAjax").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
    xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>master/contact_list_detail"
    url=url+"?a="+id
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