<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css"> 
  .notActive { background: #999999 !important; }
  #form-filter {
    border: 1px solid #0073b7; 
    padding: 4px;
    padding-top: 20px; 
    display: none;
  }
	.linkname {
    font-weight: bold;
    cursor: pointer;
    color: #385895 !important; 
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
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
        <!-- <button type="button" class="btn btn-primary btn-xs" onclick="window.open('<?php echo base_url();?>master/customer_cu/new', '_blank');"><b>+</b> Add Customer</button> -->
        <!-- <button type="button" class="btn btn-primary btn-xs" id="divfilter">Filter By Column</button> -->
        <form id="form-filter" class="form-horizontal">
            <div class="form-group">
                <label for="fullname" class="col-sm-2 control-label">fullname</label>
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
                    <button type="button" id="btn-filter" class="btn btn-sm btn-primary">Filter</button>
                    <button type="button" id="btn-reset" class="btn btn-sm btn-default">Reset</button>
                </div>
            </div>
        </form>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th class=" alignCenter">Contact ID</th>
              <th class=" alignCenter">Customer ID</th>
              <th class=" alignCenter">Company Name</th>
              <th class=" alignCenter">Category</th>
              <th class=" alignCenter" style="width:100px">Phone Number</th>
              <th class=" alignCenter">Address</th>
              <th class=" alignCenter">Sales</th>
              <th class=" alignCenter">Status</th>
              <th> </th>
            </tr>
            </thead>
            <tbody></tbody>
          </table>
      </div>
    </div>
    
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
    <div class="modal fade" id="modal-detail">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Customer Follow Up</h4>
            </div>
            <div class="modal-body">
               <!-- <div class="detailcontentAjax" id="detailcontent" style="background-color: white;"> 
              </div> -->
              <div id="detailcontentAjax"></div>
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
   
  var table = $('#dt_list')
  .on('preXhr.dt', function ( e, settings, data ) {
      if (settings.jqXHR) settings.jqXHR.abort();
  })
  .DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "order": [],
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ 
      { "targets": 7, "orderable": false },
      { "targets": 8, "orderable": false } 
    ], 
    "searchDelay": 1000,
    "processing": true, 
    "language": { processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '}, 
    "serverSide": true, 
    "ajax": {
      "url": "<?php echo site_url('master/customer_list_data2_perbaikan')?>",
      "type": "POST",
      beforeSend: function(){
        // Here, manually add the loading message.
        $('#dt_list > tbody').html(
          '<tr class="odd">' +
            '<td valign="top" class="dataTables_empty"><span class="sr-only">Loading...</span></td>' +
          '</tr>'
        );
      },
      "data": function ( data ) {
          data.page = "filter_customer";
          if (localStorage.getItem("parse_sales_customer") !== null) {
            var parseData = JSON.parse(localStorage.getItem("parse_sales_customer"));
            if (parseData['type'] === 'SalesName') {
              data.search.value = parseData['id'];
            } 
          }
      }
    },
    initComplete : function() {
        var input = $('.dataTables_filter input').unbind(),
            self = this.api(),
            $searchButton = $('<button class="btn btn-flat btn-success ">">')
                       .html('<i class="fa fa-fw fa-search">')
                       .click(function() {
                          self.search(input.val()).draw();
                       }),
            $clearButton = $('<button class="btn btn-flat btn-danger ">')
                       .html('<i class="fa fa-fw fa-remove">')
                       .click(function() {
                          input.val('');
                          $searchButton.click(); 
                       }) 
        $('.dataTables_filter').append($searchButton, $clearButton);
        $('.dataTables_filter input').attr('title', 'press ENTER for apply search');
        init_search()
    },
    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                
        if ( aData[7] == "notActive"){
            // console.log(aData[6]);
            jQuery(nRow).addClass('notActive');
        }               
    }
  });

  function init_search() {
    if (localStorage.getItem("parse_sales_customer") !== null) {
      var parseData = JSON.parse(localStorage.getItem("parse_sales_customer"));
      if (parseData['type'] === 'SalesName') {
        var value = parseData['id'];
        table.search(value)
      } 
      localStorage.removeItem('parse_sales_customer');
    }
  }

  $('#btn-filter').click(function(){ //button filter event click
      table.ajax.reload();  //just reload table
  });
  $('#btn-reset').click(function(){ //button reset event click
      $('#form-filter')[0].reset();
      table.ajax.reload();  //just reload table
  });
  $(document).on('keydown', '.dataTables_filter input', function(e){ //enter to search
    if (e.keyCode == 13) {
      table.search($(this).val()).draw();
      // $("#btn-filter").trigger("click");
    }
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $('.view').live('click',function(e){
    var
      par = $(this).parent().parent();
      id  = par.find("td:nth-child(1)").html();
      get(id);
  });

  $("#divfilter").click(function(){
    $("#form-filter").slideToggle();
  });

  $('button.print_dt').on('click', function() {               
      var fvData = table.rows({ search:'applied', page: 'all' }).data(); 
      $('.div_dt_print').empty().append(
         '<table id="dtTablePrint" class="col">' +
         '<thead>'+
         '<tr>'+
            $.map(table.columns().visible(),
                function(colvisible, colindex){
                   return (colvisible) ? "<th>" + $(table.column(colindex).header()).html() + "</th>" : null;
             }).join("") +
         '</tr>'+
         '</thead>'+
         '<tbody>' +
            $.map(fvData, function(rowdata, rowindex){
               return "<tr>" + $.map(table.columns().visible(),
                  function(colvisible, colindex){
                     return (colvisible) ? "<td class='col"+colindex+"'>" + $('<div/>').text(rowdata[colindex]).text() + "</td>" : null;
                  }).join("") + "</tr>";
            }).join("") +
         '</tbody>' +
         '<tfoot>' +
         '<tr>'+
            $.map(table.columns().visible(),
                function(colvisible, colindex){
                   return (colvisible) ? "<th>" + $(table.column(colindex).footer()).html() + "</th>" : null;
             }).join("") +
         '</tr>'+
         '</tfoot></table>'
      );

      for (var i = 0; i < $('button.print_dt').attr('removeTd'); i++) {
        $("#dtTablePrint th:last-child, #dtTablePrint td:last-child").remove();
      }

      var w = window.open();
      var html = $(".div_dt_print").html();
      $(w.document.body).append('<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">');
      $(w.document.body).append("<link href='<?php echo base_url();?>tool/dtPrint.css' rel='stylesheet' type='text/css' />");
      $(w.document.body).append(html);
  });
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
$(".printso").live('click', function() {
  soid = $(this).attr("soid")
  openPopupOneAtATime(soid);
});
$(".printinv").live('click', function() {
  invid = $(this).attr("invid")
  openPopupOneAtATime2(invid);
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