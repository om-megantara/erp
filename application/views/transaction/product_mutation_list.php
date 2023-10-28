<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css"> 
  .divfilterdate {
    display: none; 
    border: 1px solid #0073b7; 
    padding: 4px; 
    overflow: auto;
    margin: 5px 0px;
  }
@media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 100px;
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

  <div class="modal fade" id="modal-cancel">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Cancel Mutation</h4>
          </div>
          <form action="<?php echo base_url();?>transaction/product_mutation_cancel" method="post">
            <div class="modal-body">
              <div class="form-group">
                  <input type="text" class="form-control" id="mutationid" name="mutationid" placeholder="" readonly="">
              </div>
              <div class="form-group">
                <textarea class="form-control" rows="3" id="cancelnote" name="cancelnote" placeholder="Cancel Note"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
      </div>
    </div>
  </div>

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
        <a title="ADD PRODUCT MUTATION" href="<?php echo base_url();?>transaction/product_mutation_add" id="add_mutation" class="btn btn-primary btn-xs add_mutation"><b>+</b> Add Product Mutation </a>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>

        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
              <div class="col-md-6">
                <div class="form-group">
                  <label class="left">Product ID</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm" autocomplete="off" name="productid" id="productid">
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Product Parent</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm" autocomplete="off" name="productparent" id="productparent">
                  </span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="left">Status</label>
                  <span class="left2">
                    <select class="form-control" name="status">
                      <option value="3" >All</option>
                      <option value="0" >Ready</option>
                      <option value="1" >Success</option>
                      <option value="2" >Cancel</option>
                    </select>
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Start</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar">
                        </i>
                      </div>
                      <input type="text" class="form-control input-sm" autocomplete="off" name="input1" id="input1">
                  </div>
                </div>
                <div class="form-group">
                  <label class="left">End</label>
                  <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar">
                        </i>
                      </div>
                      <input type="text" class="form-control input-sm" autocomplete="off" name="input2" id="input2">
                  </div>
                </div>
              </div>
              <div class="col-md-12" style="text-align: center;">
                <button type="submit" class="btn btn-primary">Submit
                </button>
              </div>
          </form>
        </div>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100%;">
          <thead>
            <tr>
              <th class=" alignCenter">Mutation ID</th>
              <th class=" alignCenter">From</th>
              <th class=" alignCenter">To</th>
              <th class=" alignCenter">Schedule</th>
              <th class=" alignCenter">FC</th>
              <th class=" alignCenter">Employee</th>
              <th class=" alignCenter">Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
              if (isset($content)) {
                  foreach ($content as $row => $list) { ?>
                  <tr>
                      <td><?php echo $list['MutationID'];?></td>
                      <td><?php echo $list['from'];?></td>
                      <td><?php echo $list['to'];?></td>
                      <td><?php echo $list['MutationDate'];?></td>
                      <td><?php echo number_format($list['MutationFC'],2);?></td>
                      <td><?php echo $list['fullname'];?></td>
                      <td>
                        <?php if ($list['MutationStatus'] == "1") { ?>
                          <i class="fa fa-fw fa-check-square-o" style="color: green;"></i>
                        <?php } elseif ($list['MutationStatus'] == "2") { ?>
                          <i class="fa fa-fw fa-times" style="color: red;"></i>
                        <?php } ?>
                      </td>
                      <td>
                          <button type="button" class="btn btn-primary btn-xs detail" title="DETAIL" mutationid="<?php echo $list['MutationID'];?>"><i class="fa fa-fw fa-reorder"></i></button>
                        <?php if ($list['MutationStatus'] == "0" && $list['DOQty'] == "0") { ?>
                          <button type="button" class="btn btn-success btn-xs" title="EDIT" onclick="location.href='<?php echo base_url();?>transaction/product_mutation_add?mutationid=<?php echo $list['MutationID']; ?>';"><i class="fa fa-fw fa-edit"></i></button>
                          <button type="button" class="btn btn-danger btn-xs cancel" title="CANCEL" mutationid="<?php echo $list['MutationID']; ?>" data-toggle="modal" data-target="#modal-cancel"><i class="fa fa-fw fa-trash-o"></i></button>
                        <?php } ?>
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
<script>
jQuery( document ).ready(function( $ ) {
	 
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "order": [[ 0, "desc" ]]
  })

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $("#input1").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#input2').datepicker('setStartDate', minDate);
        var date2 = $('#input1').datepicker('getDate');
        $('#input2').datepicker('setDate', date2);
  });
  $("#input2").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    }).on('changeDate', function (selected) {
      var maxDate = new Date(selected.date.valueOf());
      $('#input1').datepicker('setEndDate', maxDate);
  });
  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });

  $('.cancel').live('click',function(e){
    mutationid = $(this).attr("mutationid");
    $('#mutationid').val(mutationid);
  });
  $('.detail').live('click', function(e){
      if( $('#detailcontent').length != 0 ){ 
        $('#detailcontent').remove() 
      } else {
        mutationid  = $(this).attr("mutationid")
        $('<tr><td colspan="8" class="detailcontentAjax" id="detailcontent"></td></tr>').insertAfter($(this).closest('tr'));
        get(mutationid);
      }
  });
  function get(mutationid) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>transaction/product_mutation_detail_full"
      url=url+"?mutationid="+mutationid
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
});
</script>