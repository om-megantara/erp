<script src="<?php echo base_url();?>tool/jquery8.js"></script>
    
<style type="text/css">
  .box-body form {
    overflow: auto;
    padding: 5px;
    border: 1px solid #3c8dbc;
  }
  .martop-4 { margin-top: 4px; }
  @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 180px;
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
      <div class="box-body">
          <form role="form" action="<?php echo base_url();?>transaction/adjust_stock_history_act" method="post" >
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Type</label>
                <span class="left2">
                  <select class="form-control input-sm" style="width: 100%;" name="type" required="">
                    <option value="DOR">DOR</option>
                    <option value="DO">DO</option>
                  </select>
                </span>
              </div>
              <div class="form-group">
                <label class="left">Reff</label>
                <span class="left2">
                    <input type="text" class="form-control input-sm" autocomplete="off" name="reff" required="">
                </span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Product ID</label>
                <span class="left2">
                  <input type="number" class="form-control input-sm" autocomplete="off" name="product" id="product" required="">
                </span>
              </div>
              <div class="form-group">
                <label class="left">Product Parent</label>
                <span class="left2">
                  <input type="text" class="form-control input-sm" autocomplete="off" name="parent" id="parent" placeholder="optional">
                </span>
              </div>
              <div class="form-group">
                <label class="left">History ID</label>
                <span class="left2">
                  <input type="number" class="form-control input-sm" autocomplete="off" name="history" id="history" required="">
                </span>
              </div>
              <div class="form-group">
                <label class="left">Qty New</label>
                <span class="left2">
                  <input type="number" class="form-control input-sm" autocomplete="off" name="qty" id="qty" required="">
                </span>
              </div>
              <button type="submit" class="btn btn-primary martop-4">Submit</button>
            </div>
          </form>

          <form role="form" action="<?php echo base_url();?>transaction/adjust_balance_ro" method="post" >
            <div class="col-md-6"> 
              <div class="form-group">
                <label class="left">update outstanding RO ID</label>
                <span class="left2">
                    <input type="text" class="form-control input-sm" autocomplete="off" name="reff" required="">
                </span>
              </div>
            </div>
            <div class="col-md-6"> 
              <button type="submit" class="btn btn-primary martop-4">Submit</button>
            </div>
          </form>

          <form role="form" action="<?php echo base_url();?>transaction/adjust_balance_po" method="post" >
            <div class="col-md-6"> 
              <div class="form-group">
                <label class="left">update outstanding PO ID</label>
                <span class="left2">
                    <input type="text" class="form-control input-sm" autocomplete="off" name="reff" required="">
                </span>
              </div>
            </div>
            <div class="col-md-6"> 
              <button type="submit" class="btn btn-primary martop-4">Submit</button>
            </div>
          </form>

          <form role="form" action="<?php echo base_url();?>transaction/adjust_balance_so" method="post" >
            <div class="col-md-6"> 
              <div class="form-group">
                <label class="left">update outstanding SO ID</label>
                <span class="left2">
                    <input type="text" class="form-control input-sm" autocomplete="off" name="reff" required="">
                </span>
              </div>
            </div>
            <div class="col-md-6"> 
              <button type="submit" class="btn btn-primary martop-4">Submit</button>
            </div>
          </form>

          <form name="form" action="<?php echo base_url();?>transaction/excel_content_cek" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-6"> 
              <div class="form-group">
                <label for="exampleInputFile">Excel content cek</label>
                <input type="file" class="input-file" id="excel" name="excel" required="">
                <p class="help-block"></p>
              </div> 
            </div>
            <div class="col-md-6"> 
              <button type="submit" class="btn btn-primary martop-4">Submit</button>
            </div>
          </form>

          <form role="form" action="#" method="post" >
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Type</label>
                <span class="left2">
                  <select class="form-control input-sm hpp-type" style="width: 100%;" name="type" required="">
                    <option value="DOR_HPP">DOR - HPP</option>
                    <option value="DOR_stock">DOR - stock</option>
                    <option value="DO_HPP">DO - HPP</option>
                    <option value="DO_stock">DO - stock</option>
                    <option value="Adjustment">Adjustment</option>
                    <option value="RAWPO">PO RAW</option>
                  </select>
                </span>
              </div>
              <div class="form-group">
                <label class="left">Reff</label>
                <span class="left2">
                    <input type="text" class="form-control input-sm hpp-reff" autocomplete="off" name="reff" required="">
                </span>
              </div>
            </div>
            <div class="col-md-6"> 
              <h4>Value Check</h4>
              <button type="button" class="btn btn-primary btn-cek-hpp">Submit</button>
            </div>
          </form>

      </div>
    </div>
  </section>
</div>

<script>
jQuery( document ).ready(function( $ ) {
  $(".btn-cek-hpp").click(function(){
    par = $(".btn-cek-hpp").parent().parent()
    type= par.find('.hpp-type').val()
    reff= par.find('.hpp-reff').val()
    $.ajax({
      url: "<?php echo base_url();?>transaction/cek_value",
      type : 'GET',
      data : 'type='+type+'&reff='+reff,
      dataType : 'json',
      success : function (response) {
        alert(response)
      }
    })
  });
});
</script>