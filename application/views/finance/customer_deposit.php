<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">
  .table-summary {
    font-size: 12px;
    font-weight: bold;

  }
  .table-summary tr td { padding: 4px !important; }
  table.dataTable tr th.select-checkbox.selected::after {
      content: "✔";
      margin-top: -11px;
      margin-left: -4px;
      text-align: center;
      text-shadow: rgb(176, 190, 217) 1px 1px, rgb(176, 190, 217) -1px -1px, rgb(176, 190, 217) 1px -1px, rgb(176, 190, 217) -1px 1px;
  }
  .rowlist, .rowtext { margin-top: 6px; }
  #divFilter, #divBatchRetur { 
    display: none; 
    /*border-bottom: 1px solid #0073b7; */
    padding: 5px;
    margin-top: 5px;
    margin-bottom: 5px;
    width: 100%;
  }
  @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 120px;
        padding: 5px 15px 5px 5px;
      }
      .form-group span.left2 {
        display: block;
        overflow: hidden;
      }
      .form-group { margin-bottom: 5px; }
  }
</style>
<div class="content-wrapper">

  <div class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row rowtext">
            <div class="col-xs-4">
              <input type="hidden" class="form-control input-sm atributeid" name="atributeid[]" readonly>
              <input type="text" class="form-control input-sm atributetype" name="atributetype[]" readonly>
            </div>
            <div class="col-xs-8">
              <div class="input-group input-group-sm">                
                <input type="number" class="form-control input-sm atributevalue" name="atributevalue[]" required="">
                <span class="input-group-btn input-group-atributeConn">
                  <select name="atributeConn[]" class="form-control input-sm atributeConn">
                      <option value="higher">higher</option>
                      <option value="lower">lower</option>
                  </select>
                </span>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary  add_field" onclick="$(this).closest('.rowtext').remove();">-</button>
                </span>
              </div>
            </div>
          </div>
          <div class="row rowlist">
            <div class="col-xs-4">
              <input type="hidden" class="form-control input-sm atributeid" name="atributeid[]" readonly>
              <input type="text" class="form-control input-sm atributetype" name="atributetype[]" readonly>
            </div>
            <div class="col-xs-8">
              <div class="input-group input-group-sm">
                <select class="form-control input-sm atributevalue" name="atributevalue[]" required>
                  <option value="0">--TOP--</option>
                </select>
                <span class="input-group-btn input-group-atributeConn">
                  <select name="atributeConn[]" class="form-control input-sm atributeConn">
                      <option value="higher">higher</option>
                      <option value="lower">lower</option>
                  </select>
                </span>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary  add_field" onclick="$(this).closest('.rowlist').remove();">-</button>
                </span>
              </div>

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
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
        <button type="button" class="btn btn-primary btn-xs batchRetur"><i class="fa fa-fw fa-money"></i> BATCH RETUR</button>
        <button class="btn btn-primary btn-xs" id="search" title=""><i class="fa fa-search"></i> Filter</button>
        
        <div id="divFilter">
          <div class="col-md-12" style="margin-bottom: 10px; border: 1px solid #0073b7; padding: 5px;">
            <div class="col-md-6"> 
              <div class="form-group">
                <label class="left">Filter List</label>
                <span class="left2">
                  <div class="input-group input-group-sm">
                      <select class="form-control input-sm atributelist" style="width: 100%;" name="atributelist" required="">
                        <option value="TotalDeposit_text">TotalDeposit</option>
                        <option value="DepositUsed_text">DepositUsed</option>
                        <option value="TotalBalance_text">TotalBalance</option>
                        <option value="TotalDebt_text">TotalDebt</option>
                      </select>
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary  add_field" onclick="createattribute();">+</button>
                      </span>
                  </div>
                </span>
              </div>
              <label id="atributelabel"></label>
            </div>
            <div class="col-md-12">
              <center style="margin-bottom: 5px;">
                <button type="button" id="btn-filter" class="btn btn-primary btn-sm">Submit</button>
              </center>
            </div>
          </div>
        </div>
        <div id="divBatchRetur">
          <div class="col-md-12" style="margin-bottom: 10px; border: 1px solid #0073b7; padding: 5px;">
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Company</label>
                    <span class="left2">
                      <select class="form-control input-sm company" style="width: 100%;" name="company" required="">
                        <?php foreach ($fill_company as $row => $list) { ?>
                        <option value="<?php echo $list['CompanyID'];?>"><?php echo $list['CompanyName'];?></option>
                        <?php } ?>
                      </select>  
                      <input class="CompanyName" type="hidden" name="CompanyName" required="">
                </span>
              </div>
              <div class="form-group">
                  <label class="left">Type</label>
                  <span class="left2">
                    <select class="form-control input-sm DistributionTypeID" style="width: 100%;" name="type" required="">
                      <option value="0"></option>
                    </select>  
                  </span>
                    <input class="bank2" type="hidden" name="bank2" required="">
              </div> 
            </div>
            <div class="col-md-6"> 
              <center style="margin-bottom: 5px;">
                <button type="button" id="submitbatchRetur" class="btn btn-primary btn-sm">Submit</button>
              </center>
            </div>
          </div>
        </div>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
          <thead>
            <tr>
              <th></th>
              <th class=" alignCenter"> ID</th>
              <th class=" alignCenter"> Company Name</th>
              <th class=" alignCenter"> Total Deposit</th>
              <th class=" alignCenter"> Deposit Used</th>
              <th class=" alignCenter"> Total Balance</th>
              <th class=" alignCenter"> Total Debt</th>
              <th></th>
            </tr>
          </thead>
          <tbody></tbody>
          <tfoot>
              <tr>
                  <th colspan="3">
                    Total Current Page:<br>
                  </th>
                  <th class="alignRight"></th>
                  <th class="alignRight"></th>
                  <th class="alignRight"></th>
                  <th class="alignRight"></th>
                  <th></th>
              </tr>
          </tfoot>
        </table>
      </div>
      <div class="box-footer">
        <div class="col-md-6">
          <table class="table table-bordered table-hover nowrap table-summary">
            <tbody>
                <tr>
                  <td>Total Credit/Deposit</td>
                  <td style="text-align: right;"><?php echo number_format($content['TotalDeposit'],2);?></td>
                </tr>
                <tr>
                  <td>Total Debit</td>
                  <td style="text-align: right;"><?php echo number_format($content['TotalDebit'],2);?></td>
                </tr>
                <tr>
                  <td>Total Credit/Desposit Used</td>
                  <td style="text-align: right;"><?php echo number_format($content['DepositUsed'],2);?></td>
                </tr>
                <tr>
                  <td>Total Balance</td>
                  <td style="text-align: right;"><?php echo number_format($content['TotalBalance'],2);?></td>
                </tr>
            </tbody>
          </table>
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
<script src="<?php echo base_url();?>tool/dataTables.checkboxes.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
  $( ".company" ).trigger( "change" );
   
  var rows_selected = []; // for adding checkbox
  var initDataTable = true; // 1
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
    "searchDelay": 1000,
    "processing": true, 
    "language": { processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '}, 
    "serverSide": true, 
    "ajax": {
      "url": "<?php echo site_url('finance/customer_deposit_list')?>",
      "type": "POST",
      beforeSend: function(){
        // Here, manually add the loading message.
        $('#dt_list > tbody').html(
          '<tr class="odd">' +
            '<td valign="top" class="dataTables_empty" colspan="100%" style="font-size: large;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></td>' +
          '</tr>'
        );
      },
      "data": function ( data ) {
          data.page = "customer_deposit";
          data.initDataTable = initDataTable; //3
          data.atributeid = [];
          data.atributevalue = [];
          data.atributeConn = [];
          $("#divFilter .atributeConn").each(function() {
              data.atributeConn.push($(this).val());
          });
          $("#divFilter .atributeid").each(function() {
              data.atributeid.push($(this).val());
          });
          $("#divFilter .atributevalue").each(function() {
              data.atributevalue.push($(this).val());
          });
      },
      complete: function() {
        uncheckAll()
        if (initDataTable === true) {
          $('#dt_list > tbody').html(
            '<tr class="odd">' +
              '<td valign="top" class="dataTables_empty" colspan="100%" style="font-size: large;"><p>do Filter/Search first!!!</p></td>' +
            '</tr>'
          );
          initDataTable = false;
        }
      },
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
    },
    "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        // Total over this page
        pageTotal6 = api
            .column( 6, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal3 = api
            .column( 3, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal4 = api
            .column( 4, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal5 = api
            .column( 5, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 ); 

        // Update footer
        $( api.column( 6 ).footer() ).html(
            pageTotal6.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
        $( api.column( 3 ).footer() ).html(
            pageTotal3.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
        $( api.column( 4 ).footer() ).html(
            pageTotal4.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
        $( api.column( 5 ).footer() ).html(
            pageTotal5.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
    },
    'columnDefs': [
       {  
          'targets': 0,
          'checkboxes': { 'selectRow': true }
       }
    ],
    'select': {
       'style': 'multi'
    },
	});

  function uncheckAll() {
    table.columns().checkboxes.deselectAll()
  }
  $(document).on('keydown', '.dataTables_filter input', function(e){ //enter to search
    if (e.keyCode == 13) {
      table.search($(this).val()).draw();
      // $("#btn-filter").trigger("click");
    }
  });
  var cek_dt = function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);
  
  $(".batchRetur").click(function(){
    $("#divBatchRetur").slideToggle();
  });
  $("#search").click(function(){
    $("#divFilter").slideToggle();
  });
  $('#btn-filter').click(function(){ //button filter event click
      table.ajax.reload();  //just reload table
  });

  $('#submitbatchRetur').on('click', function(e){
      if ($('.DistributionTypeID').val() == '0') {
        alert('Distribution Type harus dipilih!')
        e.preventDefault();
        return false
      }
      var rows_selected = table.column(0).checkboxes.selected();
      var rows_selected2 = []
      var data_selected = []

      $.each(rows_selected, function(index, rowId){
        data_selected.push(rowId);
      }); 

      if (data_selected.length > 0) {
        var CompanyID = $('.company').val()
        var DistributionTypeID = $('.DistributionTypeID').val()
        var batchReturCustomer = confirm(data_selected.length+" Customer Deposit will be returned.\nDo you really want to Return it?");
        if (batchReturCustomer == true) {
          $.post("<?php echo base_url();?>finance/customer_deposit_batch_retur", {data: data_selected, company: CompanyID, type: DistributionTypeID}, function(result){
            alert( result+' transfer Customer telah di retur!')
            table.ajax.reload();  //just reload table
            // location.reload()
          });
        }
      } else {
        alert('Pilih Customer dulu!')
      }
  }); 

  $('#view').live('click',function(e){
    id = $(this).attr("customer")
    window.open("<?php echo site_url('finance/customer_deposit_detail?id=')?>"+id, '_blank');
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

$(".company").on('change', function() {
  var par = $('.DistributionTypeID')
  $.ajax({
    url: "<?php echo base_url();?>finance/fill_bank_distribution_type",
    type : 'POST',
    data: {CompanyID: $(this).val()},
    dataType : 'json',
    success : function (response) {
      // console.log(response)
      var len = response.length;
      par.empty();
      par.append("<option value='0'></option>");
      for( var i = 0; i<len; i++){
          var DistributionTypeID = response[i]['DistributionTypeID'];
          var DistributionTypeName = response[i]['DistributionTypeName'];
          var BankID = response[i]['BankID'];
          par.append("<option value='"+DistributionTypeID+"' bank='"+BankID+"'>"+DistributionTypeName+"</option>");
      }
    }
  })
});
function createattribute() {
  atributelist = $(".atributelist").val().split("_")
  atributename = $(".atributelist option:selected").text()
  if (atributelist[1] === "text") {
      $(".rowtext:first .atributeid").val(atributelist[0]);
      $(".rowtext:first .atributetype").val(atributename);
      $(".rowtext:first").clone().insertBefore('#atributelabel');
  } 
}
</script>
