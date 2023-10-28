<style type="text/css">
@media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 124px;
        padding: 5px 15px 0px 5px;
      }
      .form-group span.left2 {
        display: block;
        overflow: hidden;
      }
      .form-group { margin-bottom: 5px; }
      .detailcontentAjax {
        text-align: left;
      }
  }
</style>
<form name="form" action="<?php echo base_url();?>transaction/sales_order_file_attach_act" method="post" enctype="multipart/form-data" autocomplete="off">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label class="left">SO ID</label>
        <span class="left2">
          <input type="text" class="form-control input-sm" name="soid" readonly="" value="<?php echo $content['SOID'];?>">
        </span>
      </div>
      <div class="form-group">
        <label class="left">Invoice MP</label>
        <span class="left2">
          <input class="form-control invmp" rows="3" name="invmp" placeholder="Invoice Market Place" value="<?php echo $content['INVMP'];?>"></input>
        </span>
      </div>
      <div class="form-group">
        <span class="formFile">
          <div class="col-xs-6">
              <select class="form-control input-sm fileT" name="fileT[]" required="">
                <option value="SHOP DRAWING"> SHOP DRAWING</option>
                <option value="DENAH"> DENAH</option>
                <option value="APPROVAL GAMBAR"> APPROVAL GAMBAR</option>
              </select>
          </div>
          <div class="col-xs-6">
              <div class="input-group input-group-sm fileU">
                <input class="inputFile fileN" name="fileN[]" type="file"\>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary add_field_file">+</button>
                  <button type="button" class="btn btn-primary remove_field_file">-</button>
                </span>
              </div>
          </div>
        </span>
      </div>
    </div>
    <div class="col-md-6">
      <?php if($content['Label']!=""){?>
      <div class="form-group">
        <label class="left" >Shipping Label</label>
        <span class="left2">
          <a href="<?php echo base_url(); ?>assets/PDFLabel/<?php echo $content['Label'];?>" target="_blank" class="btn btn-xs btn-warning PrintLabel left2" title='PRINT DROPSHIP'><i class="fa fa-fw fa-print"></i></a>
        </span>
      </div>
      <?php } else {?>
      <div class="form-group">
        <label class="left" >Shipping Label</label>
        <span class="left2">
          <input type="file" accept="image/jpeg,image/jpg,image/png,.pdf" class="form-control-file input-file" id="label" name="label">
          <p class="help-block">Item type must be JPG, PNG, PDF and 1Mb maximum size.</p>
        </span>
      </div>
      <?php } ?>
      <div class="form-group">
        <?php 
          if (isset($content['file'])) {
            foreach ($content['file'] as $row => $list) { 
        ?>
          <span class="formFileOld">
            <div class="col-xs-12">
              <div class="input-group input-group-sm fileU">
                <input type="hidden" class="form-control input-sm SOFileID" name="SOFileID[]" readonly="" value="<?php echo $list['SOFileID'];?>">
                <input type="text" class="form-control input-sm fileT" name="fileTold[]" readonly="" value="<?php echo $list['FileType'];?>">
                <input type="hidden" class="form-control input-sm fileNold" name="fileNold[]" readonly="" value="<?php echo $list['FileName'];?>">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary " onclick="window.open('<?php echo base_url();?>tool/so/<?php echo $list['SOID'].'/'.$list['FileName'];?>', '_blank')"><i class="fa fa-fw fa-file-image-o" title="<?php echo $list['FileName'];?>"></i></button>
                  <button type="button" class="btn btn-primary" onclick=" $(this).closest('.formFileOld').remove();">-</button>
                </span>
              </div>
            </div>
          </span>
        <?php } } ?> 
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <br><center><button type="submit" class="btn btn-primary">Save changes</button></center>
      </div> 
    </div>
  </div>
</form>