<style type="text/css">
.table-detail tbody tr td {
  font-size: 12px;
  font-weight: bold;
  vertical-align: top;
  padding: 2px 5px !important;
  word-break: break-all;
  white-space: nowrap; 
}
.btn2 {
  background-color: Transparent;
  background-repeat:no-repeat;
  border: none;
  cursor:pointer;
  overflow: hidden;
  outline:none;
}
@media (min-width: 768px){
  .card-img-top  {
    width: 100px !important;
  }
}

</style>

<div class="col-md-12" style="overflow-x: auto; background-color: white;">
  <div class="col-md-1">
  </div>
  <div class="col-md-5">
    <div id="myCarousel" class="carousel slide" data-ride="carousel" style=" margin: 20 0 20 0;">
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <?php
          $Key= " active";
          if (isset($content['file'])) {
            foreach ($content['file'] as $row => $list) {
        ?>
        <div class="item <?php echo $Key; ?> " >
          <button type="button" class="btn2" onclick="window.open('<?php echo base_url();?>assets/ProductFile/<?php echo $list['FileName'];?>', '_blank');">
            <img src="<?php echo base_url();?>assets/ProductFile/<?php echo $list['FileName'];?>" alt="<?php echo $content['ProductName']; ?>" width ="50%"; height="100%";>
          </button>
        </div>
        <?php $Key = ""; } } else { ?>
        <div class="item <?php echo $Key; ?> " >
          <button type="button" class="btn2" onclick="window.open('<?php echo base_url();?>assets/ProductFile/No_Image.jpg', '_blank');">
            <img width ="100%" height="100%" src="<?php echo base_url();?>assets/ProductFile/No_Image.jpg"><br>
          </button>
        </div>
        <?php } ?>
      </div>
    </div>
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <div class="col-md-5">
    <div class="card" style="width: 35rem; float: left; margin: 40px;">
      <div class="card-body">
        <h3 class="card-title"><b>Rp. <?php echo number_format($content['ProductPriceDefault']); ?></b></h3>
        <h4 class="card-text"><?php echo $content['ProductName']; ?></h4>
        <h5>ID : <?php echo $content['ProductID']; ?> | Brand : <?php echo $content['brand'];?></h5>
        <h5>Category : <?php echo $content['category'];?></h5>

        <h5><b>Country of Origin</b> : <?php echo $content['CountryName']; ?>
        <h5><b>Source Agent</b> : <?php echo $content['ProductAtributeValueName']; ?></h5>
        <h5><b>Best Before</b> : </h5>
          <table class="table table-striped">
            <tbody>
              <?php
                if (isset($content['expiry'])) {
                  foreach ($content['expiry'] as $row => $list) { ?>
              <tr>
                <td scope="row"><?php echo "Expiry Date";?></td>
                <td scope="row"><?php echo $list['EXPDate']. " (<b>".number_format($list['EXPDays'])." days)</b>";?></td>
              </tr>
              <?php
                  }
                } else { ?>
              <tr>
                <td scope="row"><?php echo "Expiry Date";?></td>
                <td scope="row"><?php echo "N/A";?></td>
              </tr>
              <?php  }
              ?>
            </tbody>
          </table>
<!--             <a href="#" class="btn btn-warning">Detail</a>
          <a href="#" class="btn btn-danger">Beli</a> -->
      </div>
    </div> 
  </div>
  <div class="col-md-1">
  </div> 
</div>

<div class="col-md-12" style="overflow-x: auto; background-color: white;">
  <div class="col-md-1">
  </div>
  <div class="col-md-5">
    <h4 class="alignleft"><b>Key Information</b></h4>
    <h5><?php echo nl2br(wordwrap($content['ProductDescription'],200,"<br>\n")); ?></h5>
  </div>
  <div class="col-md-5">
    <div class="col-md-1">
    </div>
    <h4 class="alignleft"><b>Atribute</b></h4>
    <div>
      <table class="table table-striped table-dark">
        <tbody>
          <?php
            if (isset($content['atribute'])) {
              foreach ($content['atribute'] as $row => $list2) { ?>
                <tr>
                  <td width="35%" style="padding: 0px !important"><?php echo $list2['ProductAtributeName'];?></td>
                  <td width="5%" style="padding: 0px !important">:</td>
                  <td width="60%" style="padding: 0px !important"><?php echo $list2['AtributeName'];?></td>
                </tr>
                <?php
              }
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>
