<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">
  #detailcontentAjax {
    background-color: #dbdbdb;
    padding: 10px;
  }
  .notActive { background: #999999 !important; }
</style>
<style type="text/css">
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a title="HELP" class="btn btn-warning btn-xs" href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-header with-border">
        <a title="ADD PROMO VOLUME" href="<?php echo base_url();?>master/promo_volume_cu/new" id="addEmployee" class="addEmployee btn btn-primary btn-sm" style="margin-top: -22px;" target="_blank"><b>+</b> Add Promo Volume</a>
        <div class="form_cek_used_code" style="display: inline-grid;">
          <div class="input-group input-group-sm">
            <div class="input-group-btn">
              <button type="button" class="btn btn-primary btn-sm" id="cek_product_promovol" title="CHECK">Check</button>
            </div>
            <input type="text" class="form-control input-sm" id="ProductID" name="ProductID" placeholder="Insert Product ID in ProVol" autocomplete="off">
          </div>
        </div>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th class=" alignCenter"> NO</th>
              <th class=" alignCenter"> Promo Name</th>
              <th class=" alignCenter"> Promo Start</th>
              <th class=" alignCenter"> Promo End</th>
              <th class=" alignCenter"> Count ID / All</th>
              <th class=" alignCenter"> Note</th>
              <th class=" alignCenter"> Price Category</th>
              <th class=" alignCenter"> Status</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (isset($content)) {
              foreach ($content as $row => $list) {
                $status = ($list['isActive'] == 1 ? "Active" : "notActive");
            ?>
                <tr>
                  <td class=" alignCenter"><?php echo $list['PromoVolID'];?></td>
                  <td><?php echo $list['PromoVolName'];?></td>
                  <td class=" alignCenter"><?php echo $list['DateStart'];?></td>
                  <td class=" alignCenter"><?php echo $list['DateEnd'];?></td>
                  <td class=" alignCenter"><?php echo $list['CountID'].' / '.$list['CountAll'];?></td>
                  <td><?php echo $list['PromoVolNote'];?></td>
                  <td><?php echo $list['PricecategoryName'];?></td>
                  <td class=" alignCenter"><?php echo $status;?></td>
                  <td>
                    <a href="#" class="btn btn-success btn-xs dtbutton" id="view" data-toggle="modal" data-target="#modal-info"><i class="fa fa-fw fa-eye"></i></a>
                    <?php if($list['isComplete']==1) {?>
                    <a href="<?php echo base_url();?>master/promo_volume_cu/<?php echo $list['PromoVolID'];?>" id="edit" class="btn btn-success btn-xs edit" style="margin: 0px;" target="_blank" title="EDIT"><i class="fa fa-fw fa-edit"></i></a>
                    <?php } ?>
                    <a href="#" class="btn btn-success btn-xs add_product_by_filter" promovolid="<?php echo $list['PromoVolID'];?>"  title="UPDATE PRODUCT FILTER"><i class="fa fa-fw fa-gears"></i></a>
                    <a href="#" class="btn btn-danger btn-xs clear_promo_volume" promovolid="<?php echo $list['PromoVolID'];?>"  title="Empty Product"><i class="fa fa-fw fa-trash"></i></a>
                  </td>
                </tr>
            <?php } } ?>
            </tbody>
          </table>
      </div>
      <div class="box-footer">
      </div>
    </div>

    <div class="modal fade" id="modal-info">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail Promo Volume</h4>
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
   
  var oTable = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ 
      // {"targets": 6,"orderable": false} 
    ],
    "order": [[ 0, "asc" ]],
    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                
        if ( aData[7] == "notActive"){
            jQuery(nRow).addClass('notActive');
        }               
    },
  });
  $("#table_modal").dataTable();

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
  
  $('#view').live('click',function(e){
    var
      par = $(this).parent().parent();
      id  = par.find("td:nth-child(1)").html();
      get(id);
  });
});

$('#cek_product_promovol').click( function() {
  ProductID = $('#ProductID').val()
  $.ajax({
    url: "<?php echo base_url();?>master/cek_product_promovol",
    type : 'POST',
    data: {ProductID: ProductID},
    dataType : 'json',
    success : function (response) {
      len = response.length;
      note = ""
      if (len>0) {
        note += "Product ID is in the following pricelist :\n"
        for( var i = 0; i<len; i++){
          note += "-> "+response[i]['PromoVolID']+", "+response[i]['PromoVolName']+"\n"
        }
        alert(note)
      } else {
        alert("Not in any promo volume.")
      }
    }
  })
});

function get(id) {
  xmlHttp=GetXmlHttpObject()
  var url="<?php echo base_url();?>master/promo_volume_detail"
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

function search_modal() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("table_modal");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    tdlength = 3;
    for (x = 0; x < tdlength; x++) {
      if (td[x]) {
        txtValue = td[x].textContent || td[x].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break;
        } else {
          tr[i].style.display = "none";
        }
      }
    }       
  }
}


$('.add_product_by_filter').live('click',function(e){
  promovolid = $(this).attr('promovolid');
  $.ajax({
    url: "<?php echo base_url();?>master/update_product_promovol_by_filter",
    type : 'GET',
    data : 'promovolid=' + promovolid,
    dataType : 'json',
    success : function (response) {
      alert(response)
    }
  })
})
$('.clear_promo_volume').live('click',function(e){
  $("#modal-loading-ajax").modal({
    show: true,
    backdrop: 'static',
    keyboard: false
  });
  promovolid = $(this).attr('promovolid');

  errornote = "Delete Product in this Promo \nare you sure?"
  var r = confirm(errornote);
  if (r == false) {
    e.preventDefault();
  } else {
    $.ajax({
      url: "<?php echo base_url();?>master/clear_promo_volume",
      type : 'GET',
      data : 'promovolid=' + promovolid,
      dataType : 'json',
      success : function (response) {
        $("#modal-loading-ajax").modal('hide');
        alert(response)
      }
    })
  } 

})
</script>