<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/datatables/media/css/jquery.dataTables.css">
<style type="text/css">
  .formadd {
    margin: 10px;
    background-color: #0073b7;
    color: white;
    padding: 2px 5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    font-weight: bold;
  }
  .form-formadd, .form-edit {
    display: none;
  }
  .atribute, .atribute2 {margin-top: 2px;}
  #detailcontentAjax {
    background-color: #dbdbdb;
	  padding: 10px;}
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
              <div class="col-md-12 form-formadd with-border">
                <form role="form" action="<?php echo base_url();?>master/productpricecategory_add" method="post" >
                  <div class="box box-primary ">
                    <div class="box-header">
                      <h3 class="box-title">Add Price Category</h3>
                      <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label>Price Category Name</label>
                            <input type="text" class="form-control" placeholder="price category Name" autocomplete="off" name="pcname" id="pcname">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label>Price Category Note</label>
                            <textarea class="form-control" rows="3" placeholder="price category note" name="pcnote" id="pcnote"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <!-- end form add-->

              <!-- form edit data -->
              <div class="col-md-12 form-edit with-border">
                <form role="form" action="<?php echo base_url();?>master/productpricecategory_edit" method="post" >
                  <div class="box box-primary ">
                    <div class="box-header">
                      <h3 class="box-title">Edit Price Category</h3>
                      <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label>ID</label>
                          <input type="text" class="form-control" placeholder="price category ID" autocomplete="off" name="id" id="id" readonly>
                        </div>
                        <div class="form-group">
                          <label>Price Category Name</label>
                            <input type="text" class="form-control" placeholder="price category Name" autocomplete="off" name="pcname2" id="pcname2" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label>Price Category Note</label>
                            <textarea class="form-control" rows="3" placeholder="price category note" name="pcnote2" id="pcnote2"></textarea>
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
  </section>

  <section class="content">
    <div class="box with-border">
      <div class="box-header">
        <a href="#" id="formadd" class="formadd" data-toggle="modal" data-target="#scrollmodal"><b>+</b> Add Price Category</a><br>
        
        
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover" width="100%">
            <thead>
            <tr>
              <th id="order">NO</th>
              <th> Price Category Name</th>
              <th> Price Category Note</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($content as $row => $list) {?>
                  <tr>
                    <td><?php echo $list['PricecategoryID'];?></td>
                    <td><?php echo $list['PricecategoryName'];?></td>
                    <td><?php echo $list['PricecategoryNote'];?></td>
                    <td>
                      <a href="#" class="dtbutton" id="view" data-toggle="modal" data-target="#modal-contact">VIEW</a>
                      <a href="#" class="dtbutton edit" id="edit" data-toggle="modal" data-target="#scrollmodal">EDIT</a>
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
<script language="javascript" src="<?php echo base_url();?>tool/datatables/media/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	$( "li.menu_master" ).addClass( "active" );
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
    "order": [[ 0, "desc" ]]
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
  	pcname  = par.find("td:nth-child(2)").html();
  	pcnote  = par.find("td:nth-child(3)").html();
    $("#id").val(id);
    $("#pcname2").val(pcname);
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