<script src="<?php echo base_url();?>tool/jquery8.js"></script>
    
<style type="text/css">
.form-excel {
  border-left: 1px solid #3c8dbc;
  border-bottom: 1px solid #3c8dbc;
  margin-bottom: 10px;
  padding-right: 10px;
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
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_supplier" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel supplier</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for supplier</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_customer" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel Customer</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for Customer</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_employee" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel Employee</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for Employee</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_expedition" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel Expedition</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for Expedition</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_fc" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel FC</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for FC</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_product" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel Product</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for Product</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_se" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel SE</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for Product</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_inv_main" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel INV main paid</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for INV</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_inv_main_unpaid" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel INV main unpaid</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for INV</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_inv_detail" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel INV detail</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for INV detail</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_ro_main" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel RO MAIN</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for RO MAIN</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_ro_product" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel RO PRODUCT</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for RO PRODUCT</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_ro_raw" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel RO raw</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for RO raw</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>

        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_po_main" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel po_main</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for po_main</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_po_product" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel po_product</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for po_product</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_po_raw" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel po_raw</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for po_raw</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>

        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_so_main" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel so_main</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for so_main</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_so_detail" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel so_detail</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for so_detail</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>

        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_do_main" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel do_main</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for do_main</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_do_detail" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel do_detail</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for do_detail</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_dp_free" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel dp_free</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for dp_free</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_kw2" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel kw2</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for kw2</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
		    <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_asset_main" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel Asset Main</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for asset main</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
		    <div class="col-md-6 form-excel">
          <form name="form employee_add" action="<?php echo base_url();?>excel/excel_asset_detail" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <div class="form-group">
              <label for="exampleInputFile">Upload Excel Asset Detail</label>
              <input type="file" class="input-file" id="excel" name="excel">
              <p class="help-block">for asset detail</p>
              <input class="submit" type="submit" value="Submit">
            </div>
          </form>
        </div>
      </div>
      <div class="box-footer">
      </div>
    </div>
  </section>
</div>

<script>
jQuery( document ).ready(function( $ ) {
	$( "li.menu_excel" ).addClass( "active" );
});
</script>