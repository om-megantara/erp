<?php
$main = $content['main'];
?>

<style type="text/css">
.thumbnail{
    height: 50px;
    margin: 5px !important; 
    float: left;
}
.timeline-footer { border-top: 1px solid #c0c0c0; }
#result { display: inline-flex; }
#resultdoc {
  display: block;
  font-weight: bold;
  font-size: 12px;
  margin-left: 10px;
  margin-right: 10px;
}
.viewFile { margin: 0px 5px; }
.timeline-footer > span.time { float: right; font-size: 12px; color: #999; }
.form-comment { margin-top: 10px; }
</style>

<div class="modal fade" id="modal-gnl">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="timeline-footer form-comment">
          <form name="form" class="form-horizontal" id="form" action="<?php echo base_url();?>marketing/daily_report_add_coment" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group margin-bottom-none">
              <div class="col-sm-9">
                <input type="hidden" name="daily" class="DailyID" value="<?php echo $this->input->get('id');?>">
                <input type="hidden" name="commentID" class="commentInput">
                <textarea class="form-control input-sm" name="comment" placeholder="Comment disini" rows="4"></textarea>
              </div>
              <div class="col-sm-3">
                <label for="img" class="btn btn-primary btn-block btn-sm">Select Image</label>
                <label for="doc" class="btn btn-primary btn-block btn-sm">Select Doc</label>
                <button type="submit" class="btn btn-danger btn-block btn-sm">Send</button>
                <input style="visibility:hidden;" class="upload_doc" name="doc[]" type="file" multiple="" accept=".doc,.docx,.xls,.xlsx,.pdf"/>
                <input style="visibility:hidden;" class="upload_img" name="img[]" type="file" multiple="" />
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" data-dismiss="modal">
    <div class="modal-content"  >              
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" style="width: 100%;" >
      </div> 
    </div>
  </div>
</div>

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

    <div class="row">
      <div class="col-md-12">
        <ul class="timeline">
          <li>
            <i class="fa fa-user bg-blue"></i>
            <div class="timeline-item">
              <span class="time"><i class="fa fa-clock-o"></i> <?php echo $main['CreatedDate']; ?></span>
              <h3 class="timeline-header"><b><?php echo $main['fullname']; ?> - <?php echo $main['Company']; ?></b></h3>
              <div class="timeline-body">
                <?php echo $main['Note']; ?>
                <a class="btn btn-primary btn-xs comment pull-right" comment="0" ><i class="fa fa-comments"></i></a><br>
              </div>
            </div>
          </li>

          <?php
            if (isset($content['comment'][0])) {
              foreach ($content['comment'][0] as $row => $list) { 
                $file = explode(";", $list['CommentFile']);
          ?>
                <li>
                  <i class="fa fa-comments bg-yellow"></i>
                  <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> <?php echo $list['CommentDate']; ?></span>
                    <div class="timeline-body">
                      <?php echo "<b>".$list['CommentBy']."</b> - ".$list['CommentNote']; ?>
                      <a class="btn btn-primary btn-xs comment pull-right" comment="<?php echo $list['CommentID']; ?>" ><i class="fa fa-comments"></i></a>

                      <br>
                      <?php foreach ($file as $row => $listF) { ?>
                        <a href="#" class="viewFile" valFile="<?php echo $list['CommentID'].'/'.$listF;?>"><?php echo $listF;?></a> 
                      <?php } ?>
                    </div>

                    <?php
                      if (isset($content['comment'][$list['CommentID']])) {
                        foreach ($content['comment'][$list['CommentID']] as $row => $list) {  
                          $file = explode(";", $list['CommentFile']);
                    ?>
                      <div class="timeline-footer">
                        <span class="time"><i class="fa fa-clock-o"></i> <?php echo $list['CommentDate']; ?></span>
                        <?php echo "<b>".$list['CommentBy']."</b> - ".$list['CommentNote']; ?>
                        <br>
                        <?php foreach ($file as $row => $listF) { ?>
                          <a href="#" class="viewFile" valFile="<?php echo $list['CommentID'].'/'.$listF;?>"><?php echo $listF;?></a> 
                        <?php } ?>
                      </div>
                    <?php } } ?>

                  </div>
                </li>
          <?php } } ?>

          <li>
            <i class="fa fa-clock-o bg-gray"></i>
          </li>
        </ul>
      </div>
    </div>

  </section>
</div>


<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>

$('#img').live("change", function(event) {
    var files = event.target.files; //FileList object
    var output = document.getElementById("result");
    for(var i = 0; i< files.length; i++) {
        var file = files[i];
        // Only pics
        // if(!file.type.match('image'))
        if(file.type.match('image.*')){
          var picReader = new FileReader();
          picReader.addEventListener("load",function(event){
              var picFile = event.target;
              var div = document.createElement("div");
              div.innerHTML = "<a href='#' class='pop'><img class='thumbnail' src='" + picFile.result + "'" +
                      "title='preview image'/></a>";
              output.append(div);            
          });
          $('#clear, #result').show();
          picReader.readAsDataURL(file);
        } else {
          alert("You can only upload image file.");
          $(this).val("");
        }
    }                               
});
$('#doc').live("change", function(event) {
  $('#resultdoc').remove()
  var newdoc = $( "<div id='resultdoc'></div>" )
  var docFiles = ""
  len = this.files.length;
  for( i = 0; i<len; i++){
    docFiles += this.files[i].name + "<br>"
  }
  newdoc.append(docFiles)
  $('#result').append(newdoc);
})
$('#img').live("click", function() {
    $('.thumbnail').parent().parent().remove();
    $(this).val("");
});
$('.pop').live('click', function() {
    $('.imagepreview').attr('src', $(this).find('img').attr('src'));
    $('#imagemodal').modal('show');   
});
$("a.comment").live('click', function() {
  $("a.comment").css("display", "inline-flex")
  $(this).css("display", "none")
  commentVal = $(this).attr("comment")
  if ($(".form-comment").length > 1) {
    $(".form-comment:last").remove()
  }
  par = $(this).parent()
  $(".form-comment:first").clone().insertAfter(par);
  $(".form-comment:last").find(".upload_img").attr('id', 'img');
  $(".form-comment:last").find(".upload_doc").attr('id', 'doc');
  $(".form-comment:last").find(".commentInput").val(commentVal);
  var newdiv = $( "<div id='result' class='col-md-12'></div>" )
  $(".form-comment:last").find("textarea").after( newdiv );
});

$('.viewFile').live( 'click', function (e) {
    val = $(this).attr("valFile")
    var myview = window.open('<?php echo base_url();?>tool/CommentFile/'+val, 'view_file', 'width=800,height=600');
});
</script>
