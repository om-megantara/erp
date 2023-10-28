<style type="text/css">
  .rowlist, .rowtext { 
  	margin-top: 6px; 
  }
  .radio { 
  	display: inline-block !important; 
  	margin: 3px 10px !important; 
  }
  #divSearch { 
  	border: 1px solid #3c8dbc;
  	overflow: auto;
    display: none; 
    padding: 5px;
    margin: 5px 0px;
    width: 100%;
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
    .form-group { margin-bottom: 10px; }
  }
</style>

<div class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row rowtext">
            <div class="input-group input-group-sm">
              <input type="hidden" class="form-control input-sm WarehouseID" name="WarehouseID[]" required="" readonly="">
              <input type="text" class="form-control input-sm WarehouseName" name="WarehouseName[]" required="" readonly="">
              <span class="input-group-btn">
                <button type="button" class="btn btn-danger remove" title="Remove" onclick="$(this).closest('.rowtext').remove();">x</button>
              </span>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<button class="btn btn-primary btn-xs" id="btnSearch" title=""><i class="fa fa-search"></i> Filter</button>

<div id="divSearch">
  <form role="form" action="<?php echo current_url();?>" method="post">
    <div class="col-md-6">
      <div class="form-group">
        <label class="left">Warehouse</label>
        <span class="left2">
          <div class="input-group input-group-sm">
              <select class="form-control input-sm WarehouseList select2" style="width: 100%;" name="WarehouseList" required="">
                <?php foreach ($warehouse as $row => $list) { ?>
                <option value="<?php echo $list['WarehouseID'];?>"><?php echo $list['WarehouseName'] ;?></option>
                <?php } ?>
              </select>
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary add_field" onclick="createList();">+</button>
              </span>
          </div>
        </span>
      </div>
      <div class="form-group WarehouseListInput"></div>
    </div>
    <div class="col-md-6">
    </div>
    <div class="col-md-12">
      <center>
        <button type="submit" class="btn btn-primary btn-sm pull-center">Submit</button>
      </center>
    </div>
  </form>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script type="text/javascript">
$("#btnSearch").click(function(){
  $("#divSearch").slideToggle();
});

function createList() {
  WarehouseID = $(".WarehouseList").val()
  WarehouseName = $(".WarehouseList option:selected").text()
  $(".rowtext:first .WarehouseID").val(WarehouseID);
  $(".rowtext:first .WarehouseName").val(WarehouseName);
  $(".rowtext:first").clone().appendTo('.WarehouseListInput');
}
</script>
