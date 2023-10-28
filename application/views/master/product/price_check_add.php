<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css"> 
@media (min-width: 768px){
  .form-group label.left {
    float: left;
    width: 165px;
    padding: 5px 15px 5px 5px;
  }
  .form-group span.left2 {
    display: block;
    overflow: hidden;
  }
  .form-group { margin-bottom: 10px; }
  .form-group .btn { margin: 2px; }
}
.img_paste { max-width: 400px; max-height: 400px; }
#result { font-size: 12px !important; font-weight: normal !important; white-space: pre; resize: none; }
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
  </section>

  <section class="content">

    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">ProductID</label>
              <label class="left2"><?php echo $content['ProductID']; ?></label>
              <input type="hidden" class="form-control pull-right" name="productid" id="productid" value="<?php echo $content['ProductID']; ?>">
            </div>
            <div class="form-group">
              <label class="left">Product Name</label>
              <label class="left2"><?php echo wordwrap($content['ProductName'],50,"<br>\n"); ?></label>
            </div>
            <div class="form-group">
              <label class="left">Link Tokopedia</label>
              <span class="left2">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-link"></i>
                  </div>
                  <textarea class="form-control pull-right" rows="2" name="link1" id="link1" placeholder="Diawali https://" required=""></textarea>
                </div>
              </span>
            </div>
            <div class="form-group">
              <label class="left">Link Shopee</label>
              <span class="left2">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-link"></i>
                  </div>
                  <textarea class="form-control pull-right" rows="2" name="link2" id="link2" placeholder="Diawali https://" required=""></textarea>
                </div>
              </span>
            </div>
            <div class="form-group">
              <label class="left">Note </label>
              <span class="left2">
                <textarea class="form-control pull-right" rows="2" name="note" id="note" ></textarea>
              </span>
            </div>
            <div class="form-group">
              <label class="left">Compare Price</label>
              <span class="left2">
                <input type="text" class="form-control input-sm" id="keyword" name="keyword" placeholder="KEYWORD">
                <a href='#' class='btn btn-primary btn-xs' id='get_content_olshop'>Get Result</a>
                <a href='#' class='btn btn-primary btn-xs' id='open_content_olshop'>Open Result</a>
                <a href='#' class='btn btn-primary btn-xs' id='get_element_olshop' style="display: none;">Get Element</a>
                <textarea class="form-control pull-right" rows="6" name="result" id="result" required=""></textarea>
              </span>
            </div>
            <div class="form-group">
              <iframe id="frameOlshop" src="google.com" width="100%" height="300" style="display: none;"></iframe>
            </div>

          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Screenshot</label>
              <span class="left2">
                <div class="input-group cls">
                  <input  name="Screen" type="hidden" id="img_puth" required=""/>
                  <div class="input-group-addon" id="box" name="file" style="width:400px;height:400px;border:1px solid;vertical-align: top;text-align: left " contenteditable >
                  </div>
                </div>
              </span>
            </div>
          </div>
          <div class="col-md-12">
            <div class="box-footer" style="text-align: center;">
              <a href='#' class='btn btn-primary dtbutton' class="btn btn-primary" id='approve' ProductID='<?php echo $content['ProductID']; ?>' >Submit</a>
              <a href='#' class='btn btn-primary dtbutton' class="btn btn-primary" id='edit' ProductID='<?php echo $content['ProductID']; ?>'>Submit W/ Price Rec</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
document.getElementsByClassName('cls2').display="none"
jQuery( document ).ready(function( $ ) {
  $('#approve').live('click',function(e){
    var
      link1 = document.forms['form']['link1'].value;
      link2 = document.forms['form']['link2'].value;
      Screen = document.forms['form']['Screen'].value;
      if(Screen ==''){
        alert("Screenshot must be filled out");
        return false;
      } else {
        ProductID = $(this).attr('ProductID');
        Link1 = $("#link1").val();
        Link2 = $("#link2").val();
        Note = $("#note").val();
        Screen = $("#img_puth").val();
        data = {ProductID:ProductID , Link1:Link1, Link2:Link2, Note:Note, Screen:Screen};
        $.ajax({
          url: "<?php echo base_url();?>master/price_check_add_act/approve",
          type : 'POST',
          data : data,
          success : function (response) {
            window.location.href = "<?php echo base_url(); ?>report/report_price_check_list";
          }
        })
      }
  }); 
  $('#edit').live('click',function(e){
    var
      link1 = document.forms['form']['link1'].value;
      link2 = document.forms['form']['link2'].value;
      Screen = document.forms['form']['Screen'].value;
      if(Screen ==''){
        alert("Screenshot must be filled out");
        return false;
      } else {
        ProductID = $(this).attr('ProductID');
        Link1 = $("#link1").val();
        Link2 = $("#link2").val();
        Note = $("#note").val();
        Screen = $("#img_puth").val();
        data = {ProductID:ProductID , Link1:Link1, Link2:Link2, Note:Note, Screen:Screen};
        $.ajax({
          url: "<?php echo base_url();?>master/price_check_add_act/edit",
          type : 'POST',
          data : data,
          success : function (response) {
            window.location.href = "<?php echo base_url(); ?>master/price_recommendation_add?ProductID="+ProductID;
          }
        })
      }
  });  
  $('#get_content_olshop').live('click', function(e){
    keyword  = $("#keyword").val()
    url      = "https://www.telunjuk.com/jual"
    url      = url+"?sort=harga_a&q="+keyword
    $("#frameOlshop").attr('src',url);
    get(url);
  });
  $('#open_content_olshop').live('click', function(e){
    keyword  = $("#keyword").val()
    url      = "https://www.telunjuk.com/jual"
    url      = url+"?sort=harga_a&q="+keyword
    window.open(url, 'ResultOlShop'); 
  });
  $('#get_element_olshop').live('click', function(e){
    resultFrame()
  });
  $('#frameOlshop').on("load", function() {
      resultFrame()
  });
  function resultFrame() {
    info = []
    par = $("#frameOlshop").contents()
    if (par.find("#recomend-title-1").text() !== "") {
      info[1] = par.find("#recomend-title-1").text().replace(/ +(?= )/g,'').replace(/\n|\r/g, "")+'//'
      info[1] += par.find("#recomend-price-1").text().replace(/ +(?= )/g,'').replace(/\n|\r/g, "")+'//'
      info[1] += par.find("#recomend-location-1").text().replace(/ +(?= )/g,'').replace(/\n|\r/g, "")
      info[2] = par.find("#recomend-title-2").text().replace(/ +(?= )/g,'').replace(/\n|\r/g, "")+'//'
      info[2] += par.find("#recomend-price-2").text().replace(/ +(?= )/g,'').replace(/\n|\r/g, "")+'//'
      info[2] += par.find("#recomend-location-2").text().replace(/ +(?= )/g,'').replace(/\n|\r/g, "")
      info[3] = par.find("#recomend-title-3").text().replace(/ +(?= )/g,'').replace(/\n|\r/g, "")+'//'
      info[3] += par.find("#recomend-price-3").text().replace(/ +(?= )/g,'').replace(/\n|\r/g, "")+'//'
      info[3] += par.find("#recomend-location-3").text().replace(/ +(?= )/g,'').replace(/\n|\r/g, "")
    }
    console.log(info.splice(0,1).join("\n"))
    $("#result").val(info.join("\n"))
  }
  function get(url) {

    // document.getElementById("content_tokopedia").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
    // xmlHttp=GetXmlHttpObject()
    // var url="<?php echo base_url();?>transaction/request_order_detail_full"
    // url=url+"?roid="+roid
    // alert(url);
    // xmlHttp.onreadystatechange=stateChanged
    // xmlHttp.open("GET",url,true)
    // xmlHttp.send(null)
  }
  function stateChanged(){
      if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
          document.getElementById("content_tokopedia").innerHTML=xmlHttp.responseText
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
document.querySelector('#box').addEventListener('paste', function(e) {
  if (e.clipboardData && e.clipboardData.items[0].type.indexOf('image') > -1)
  {
    var that = this,
    reader = new FileReader();
    file = e.clipboardData.items[0].getAsFile();

    reader.onload = function(e)
    {
      var xhr = new XMLHttpRequest(),
      fd = new FormData();

      xhr.open('POST', '', true);
      xhr.onload = function ()
      {
        var img = new Image();
        img.src = xhr.responseText;
        explode=img.src
        var myarr = explode.split("/");
        jml=myarr.length
        var filegbr = myarr[jml-1];
        console.log(filegbr);
        document.getElementById("img_puth").value = filegbr;
      }
      fd.append('file', this.result);
      that.innerHTML = '<img src="'+this.result+'" class="img_paste"/>';
      xhr.send(fd);
    }
    reader.readAsDataURL(file);
  }
}, false);
</script>