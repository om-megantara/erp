<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

<style type="text/css"> 
 
</style>
<div class="content-wrapper">

  <div class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row rowtext">
            <div class="col-xs-4">
              <input type="text" class="form-control input-sm atributeid" name="atributeid[]" readonly>
            </div>
            <div class="col-xs-8">
              <!-- <div class="input-group input-group-sm">                
                <input type="text" class="form-control input-sm atributevalue" name="atributevalue[]" required="">
                <span class="input-group-btn input-group-atributeConn">
                  <select name="atributeConn[]" class="form-control input-sm atributeConn">
                      <option value="or ">OR</option>
                      <option value="and">AND</option>
                  </select>
                </span>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary  add_field" onclick="$(this).closest('.rowtext').remove();">-</button>
                </span>
              </div> -->
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
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle" title="HELP"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <!-- <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="#" id="column" class="btn btn-primary btn-xs column" title="HIDE/SHOW COLUMN">Hide/Show Column</a>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>

        <div id="divhideshow">
          Hide/Show Column :
          <a class="btn btn-xs toggle-vis" data-column="3">Sales Name</a>
          <a class="btn btn-xs toggle-vis" data-column="4">Invoice Date</a>
          <a class="btn btn-xs toggle-vis" data-column="7">Note</a>
        </div>
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Search</label>
                <span class="left2">
                  <div class="input-group input-group-sm">
                      <select class="form-control input-sm atributelist" style="width: 100%;" name="atributelist" required="">
                        <option value="INVID">Invoice ID</option>
                        <option value="DOID">DO ID</option>
                        <option value="SOID">SO ID</option>
                        <option value="Company">Customer Name</option>
                        <option value="Sales">Sales Name</option>
                        <option value="ProductID">Product ID</option>
                        <option value="ShopName">Shop Name</option>
                      </select>
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary  add_field" onclick="createattribute();">+</button>
                      </span>
                  </div>
                </span>
                <label id="atributelabel"></label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Start</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="filterstart">
                </div>
              </div>
              <div class="form-group">
                <label class="left">End</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="filterend">
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-sm pull-center">Submit</button>
            </div>
          </form>
        </div>     
      </div> -->
      
      <div class="box-body">
        <table id="dt_list" class="display table-bordered" style="width: 100% !important;">
          <thead>
            <tr>
              <!-- <th>No</th> -->
              <th>ProductID</th>
              <th>ProductName</th>
              <th>WarehouseID</th>
              <th>Adjustment Qty</th>
              <th>ResultQty</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
            if (isset($content['main'])) {
                foreach ($content['main'] as $row => $list) { ?>
                <tr>
                  <!-- <td class="alignCenter">1</td> -->
                  <!-- <td class="alignCenter"><a class="view_data klik " type="button" product="<?php echo $list['ProductID'];?>" data-toggle="modal" href="" data-target="#modal-detail"><?php echo $list['ProductID'];?></a></td> -->
                  <td class="alignCenter"><a href="<?php echo base_url();?>transaction/product_stock_history?product=<?php echo $list['ProductID'];?>"><?php echo $list['ProductID'];?></a></td>
                  <td class="alignleft"><?php echo $list['ProductName'];?></td>
                  <td class="alignCenter"><?php echo $list['WarehouseID'];?></td>
                  <td class="alignCenter"><?php echo $list['Quantity'];?></td>
                  <td class="alignCenter"><?php echo $list['ResultQty'];?></td>
                  <!-- <td class="alignleft"><?php //echo $list['customer'];?></td> -->
                  <!-- <td>d<?php //echo $list['TotalPaymentPerc']."% / ".number_format($list['TotalPayment'],2);?></td> -->
                  <td>
                       <button type="button" class="btn btn-primary btn-xs history" title="HISTORY" invid="<?php echo $list['ProductID'];?>" data-toggle="modal" data-target="#modal-atribute" ><i class="fa fa-fw fa-history"></i></button>
                       <!-- <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-atribute" title="ATRIBUTE LIST">Atribute List</button> -->
                  </td>
                </tr>
          <?php } } ?>
          </tbody>
          <tfoot>
              <tr>
              <!-- <th>No</th> -->
              <th>ProductID</th>
              <th>ProductName</th>
              <th>WarehouseID</th>
              <th>Quantity</th>
              <th>ResultQty</th>
              <th>Action</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <center><h4 class="modal-title">PRODUCT DETAILS</h4></center>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="loader"></div>
          <div id="detailcontentAjax"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  </section>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<!-- <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script> -->


<!-- <script> -->
<!-- // jQuery( document ).ready(function( $ ) { -->
<script type="text/javascript">
$(document).ready(function() {
    $('#dt_list').DataTable();
} );

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

$('.view_data').click(function(){
      //$('#detailcontentAjax').empty()
      id = $(this).attr('product');
      get(id);
    });
    function get(id) {
      xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>transaction/product_stock_history"
      url=url+"?id="+id
      xmlHttp.onreadystatechange=stateChanged
      xmlHttp.open("GET",url,true)
      xmlHttp.send(null)
    }
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

</script>