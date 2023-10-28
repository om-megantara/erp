<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">
  .form-formadd, .form-edit {
    display: none;
  }
  .atribute, .atribute2 { margin-top: 2px; }
  #detailcontentAjax {
    background-color: #dbdbdb;
	  padding: 10px;
  }
  @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 150px;
        padding: 5px 15px 5px 5px;
      }
      .form-group span.left2 {
        display: block;
        overflow: hidden;
      }
      .form-group { margin-bottom: 5px; }
  }
</style>
<style type="text/css">
</style>
<div class="content-wrapper">

<!-- POP UP -->
<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

              <!-- form add data -->
              <div class="col-md-12 form-formadd with-border" style="background-color: white;">
                <form role="form" action="<?php echo base_url();?>master/productpricecategory_add" method="post" >
                  <div class="box box-solid ">
                    <div class="box-header">
                      <h3 class="box-title">Add Price Category</h3>
                      <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label class="left">Price Category Name</label>
                          <span class="left2">
                            <input type="text" class="form-control input-sm" placeholder="Price Category Name" autocomplete="off" name="pcname" id="pcname">
                          </span>
                        </div>
                        <div class="form-group">
                          <label class="left">Promo Default %</label>
                          <span class="left2">
                            <input type="number" class="form-control input-sm" placeholder="Promo Default %" autocomplete="off" name="promo" id="promo">
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label class="left">Price Category Note</label>
                          <span class="left2">
                            <textarea class="form-control input-sm" rows="3" placeholder="Price Category Note" name="pcnote" id="pcnote"></textarea>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <!-- end form add-->

              <!-- form edit data -->
              <div class="col-md-12 form-edit with-border" style="background-color: white;">
                <form role="form" action="<?php echo base_url();?>master/productpricecategory_edit" method="post" >
                  <div class="box box-solid ">
                    <div class="box-header">
                      <h3 class="box-title">Edit Price Category</h3>
                      <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label class="left">ID</label>
                          <span class="left2">
                            <input type="text" class="form-control input-sm" placeholder="Price Category ID" autocomplete="off" name="id" id="id" readonly>
                          </span>
                        </div>
                        <div class="form-group">
                          <label class="left">Price Category Name</label>
                          <span class="left2">
                            <input type="text" class="form-control input-sm" placeholder="Price Category Name" autocomplete="off" name="pcname2" id="pcname2" readonly>
                          </span>
                        </div>
                        <div class="form-group">
                          <label class="left">Promo Default %</label>
                          <span class="left2">
                            <input type="number" class="form-control input-sm" placeholder="Promo Default %" autocomplete="off" name="promo2" id="promo2">
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label class="left">Price Category Note</label>
                          <span class="left2">
                            <textarea class="form-control" rows="3" placeholder="Price Category Note" name="pcnote2" id="pcnote2"></textarea>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <!-- end form edit-->
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- END POP UP -->
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
      <div class="box-header">
        <a title="ADD PRICE CATEGORY" href="#" id="formadd" class="btn btn-primary btn-xs formadd" data-toggle="modal" data-target="#scrollmodal"><b>+</b> Add Price Category</a><br>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th id="order" class=" alignCenter">NO</th>
              <th class=" alignCenter"> Price Category Name</th>
              <th class=" alignCenter"> Promo Default %</th>
              <th class=" alignCenter"> Price Category Note</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($content as $row => $list) {?>
                  <tr>
                    <td class=" alignCenter"><?php echo $list['PricecategoryID'];?></td>
                    <td><?php echo $list['PricecategoryName'];?></td>
                    <td class=" alignCenter"><?php echo $list['PromoDefault'];?></td>
                    <td><?php echo $list['PricecategoryNote'];?></td>
                    <td>
                      <a href="#" class="btn btn-success btn-xs dtbutton" id="view" data-toggle="modal" data-target="#modal-contact" title="VIEW">View</a>
                      <a href="#" class="btn btn-success btn-xs dtbutton edit" id="edit" data-toggle="modal" data-target="#scrollmodal" title="EDIT">Edit</a>
                    </td>
                  </tr>
            <?php } ?>
        
            </tbody>
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
            <h4 class="modal-title">Detail Price Category</h4>
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
	 
  $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ {
      "targets": 3,
      "orderable": false
    } ],
    "order": [[ 1, "asc" ]]
  });

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

  $(".formadd").click(function(){
    $(".form-formadd").slideDown();
    $(".form-edit").slideUp();
  });
  $('#edit').live('click',function(e){
    par   = $(this).parent().parent();
    id    = par.find("td:nth-child(1)").html();
  	pcname = par.find("td:nth-child(2)").html();
    promo  = par.find("td:nth-child(3)").html();
  	pcnote = par.find("td:nth-child(4)").html();
    $("#id").val(id);
    $("#pcname2").val(pcname);
    $("#promo2").val(promo);
    $("#pcnote2").val(pcnote);

    $( ".form-formadd" ).slideUp();
    $( ".form-edit" ).slideDown();
  });

  $('.form-edit form').live('submit', function() {
      $(this).find(':disabled').removeAttr('disabled');
  });
});

function get(id) {
  xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>master/price_category_detail"
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