<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!--<link type="text/css" rel="stylesheet" href="http://www.dreamtemplate.com/dreamcodes/comment_boxes/css/tsc_comment_boxes.css" />-->
<style type="text/css">
  #dttask_list tbody,
  #dttask_list thead,
  .dataTables_scrollHeadInner thead,
  #dttask_list tfoot{
    font-size: 12px !important;
  }
  #dttask_list tbody td {
    padding: 4px;
    vertical-align: text-top;
  }
  .addtask, .edit, .dtbutton, #show, .view, .done {
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
  .form-addtask, .form-edittask {
    display: none;
  }
	.atribute, .atribute2 {margin-top: 2px;}
	.tsc_clear { clear:both; padding:0; margin:0; width:100%; font-size:0px; line-height:0px;}
	.tsc_clean_comment { margin-bottom:16px; width:400px;}
	.tsc_clean_comment .avatar_box { float:left; width:80px;}
	.tsc_clean_comment .avatar { background:#fff; padding:4px; border:1px solid #d8d8d8; margin-top:10px; position:relative;}
	.tsc_clean_comment .username { color:#383838; font-weight:bold; clear:left;}
	.tsc_clean_comment .comment_box { floar:right; padding-bottom:8px; width:310px; height:auto; background:#fff; border:1px solid #d8d8d8; position:relative;}
	.tsc_clean_comment .comment_box:before { content:''; width:13px; height:13px; background:#fff; border-left:1px solid #d8d8d8; border-bottom:1px solid #d8d8d8; position:absolute; top:24px; left:-8px; transform:rotate(45deg); -webkit-transform:rotate(45deg); -moz-transform:rotate(45deg); -ms-transform:rotate(45deg); -o-transform:rotate(45deg);}
	.tsc_clean_comment .comment_paragraph { color:#454545; line-height:14px; margin:4px 10px 25px 15px;}
	.tsc_clean_comment .comment_paragraph:focus { outline:none;}
	.tsc_clean_comment .reply {	font-size:0.85em; color:#b7b7b7; margin-left:23px; text-decoration:none; margin-top:8px; position:relative; padding-bottom:10px;}
	.tsc_clean_comment .reply:before {	content:url(../images/bubble.png); width:13px; height:11px; position:relative; left:-7px; top:2px;}
	.tsc_clean_comment .date { float:right; font-size:0.85em; color:#454545; margin-top:-10px; margin-right:15px;}

</style>
<!--
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>tool/summernote-lite.css">
  <script src="<?php echo base_url();?>tool/summernote-lite.js"></script>
  <script>
    $(document).ready(function() {
      $('.summernote').summernote({
        height: 150,
        tabsize: 1
      });
    });
  </script>
-->
<div class="content-wrapper">

<!-- POP UP -->
<!--
<div class="modal-body">
	<div class="col-md-12 form-addtask with-border">
	  <form role="form" action="" method="post" >
		<div class="box box-solid ">
		  <div class="box-header">
			<h3 class="box-title">Add Comment</h3>
			<button type="submit" class="btn btn-primary pull-right">Submit</button>
		  </div>
		  <div class="box-body">
			<div class="col-md-12">
			  <div class="form-group">
				<label>Comment</label>
				<textarea class="form-control" rows="5" placeholder="Task Comment" name="body" id="body"></textarea>
			  </div>
			</div>
		  </div>
		</div>
	  </form>
	</div>
</div>
-->

<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <div class="col-md-12 form-addtask with-border">
                  <form role="form" action="<?php echo base_url();?>hrd/task_comment_act" method="post" >
                    <div class="box box-solid ">
                      <div class="box-header">
                        <h3 class="box-title">Add comment</h3>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
						  <input type="hidden" name="levelid" value="<?php echo $content['task']['JobLevelID'];?>"></input>
                     	  <input type="hidden" name="taskid" value="<?php echo $content['task']['TaskID'];?>"></input>
                      </div>
                      <div class="col-md-6">
                          <div class="box-body">
                            <div class="form-group">
<!--                              <label>Comment</label>-->
                              <textarea class="summernote" rows="7" cols="55" placeholder="Comment" name="comment" id="comment"></textarea><br>
                            </div>
                          </div>
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
<!-- END POP UP -->

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
      <div class="box-header">
<!--        <a href="<?php echo base_url();?>hrd/task_cu/new" id="addtask" class="addtask" target="_blank"><b>+</b> Add Task</a>-->
<!--        <a href="#" id="addtask" class="addtask" data-toggle="modal" data-target="#scrollmodal"><b>+</b> Add Comment</a><br>-->
        <a href="#" id="addtask" class="addtask" data-toggle="modal" data-target="#scrollmodal"><b>+</b> Add Comment</a>
        <a href="<?php echo base_url();?>hrd/task_done?idt=<?=$content['task']['TaskID'];?>" id="addtask" class="addtask" style="display: <?php echo $content['task']['DisplayDone']; ?>"><b>+</b> Make it Done!</a>
        <a href="<?php echo base_url();?>hrd/task_on?idt=<?=$content['task']['TaskID'];?>" id="addtask" class="addtask" style="display: <?php echo $content['task']['Displayo']; ?>"><b>+</b> Make it On!</a>
      </div>
      <div class="row">
		  <div class="col-md-12">
			<div class="box box-solid">
			  <div class="box-body box-profile">
				<p class="text-muted"><b>Task Description : </b><?php echo $content['task']['TaskDescription'];?></p>
				<p class="text-muted"><b>Task Giver : </b><?php echo $content['task']['LevelName'];?> || <b>Task Appointed : </b><?php echo $content['task']['LevelAssignedName'];?> || <b>Task Cc : </b><?php echo $content['task']['LevelCcName'];?></p>
				<p class="text-muted"><b>Task Created Date : </b><?php echo $content['task']['TaskCreatedDate'];?></p>
				<p style="display: <?php echo $content['task']['Displaycls']; ?>" class="text-muted"><b>Task Close Date : </b><?php echo $content['task']['TaskCloseDate'];?></p>
			  </div>
			</div>
		  </div>
		</div>
      <div class="box-body">
          <?php
                // echo count($content);
                foreach ($content['comment'] as $row => $list) {?>
                  
                  <div class="tsc_clean_comment">
					  <div class="avatar_box box-solid">
						<p class="username"><?php echo $list['NameNow'];?></p>
					  </div>
					  <div class="comment_box fr" style="margin-left: 80px;">
						<p class="comment_paragraph" contenteditable="true"><?php echo $list['TaskCommentDescription'];?></p>
						<span class="date"><?php echo $list['TaskCommentDate'] ?></span> </div>
					  <div class="tsc_clear"></div>
					</div>
            <?php } ?>
      </div>
      <div class="box-footer">
      </div>
    </div>
    
    <div class="modal fade" id="modal-contact">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail Task</h4>
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	 
  $('#dttask_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ {
      "targets": 8,
      "orderable": false
    } ],
    "order": [[ 0, "desc" ]],
    "aaSorting": []
  });

  setTimeout( function order() {
    $('.table-bordered th#order').click();
  }, 100) //force to order and fix header width

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dttask_list').resize(cek_dt);

  $(".addtask").click(function(){
      $(".form-addtask").slideDown();
  });
  $(".addtask").click(function(){
    $(".form-addtask").slideDown();
    $(".form-editwarehouse").slideUp();
  });
  
  $('#view').live('click',function(e){
    var
      par = $(this).parent().parent();
      id  = par.find("td:nth-child(1)").html();
      get(id);
  });
});
	
function get(id) {
  xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>hrd/task_list_detail"
    url=url+"?a="+id
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