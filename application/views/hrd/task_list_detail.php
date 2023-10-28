<div class="row">
  <div class="col-md-12">
    <div class="box box-solid">
      <div class="box-body box-profile">
        <p class="text-muted"><b>Task Name : </b><?php echo $content['task']['TaskName'];?></p>
        <p class="text-muted"><b>Task Description : </b><?php echo $content['task']['TaskDescription'];?></p>
      </div>
    </div>
    <div class="col-md-6">
		<div class="box box-solid">
		  <div class="box-body box-profile">
			<p class="text-muted"><b>Task Created : </b><?php echo $content['task']['TaskCreatedDate'];?></p>
				<p class="text-muted"><b>Task Due Date : </b><?php echo $content['task']['TaskDueDate'];?></p>
			<p class="text-muted"><b>Task Closed Date : </b><?php echo $content['task']['TaskCloseDate'];?> </p>
		  </div>
		</div>
	</div>
	<div class="col-md-6">
    <div class="box box-solid">
      <div class="box-body box-profile">
      	<p class="text-muted"><b>Task Giver : </b><?php echo $content['task']['LevelName'];?></p>
      	<p class="text-muted"><b>Task Appointed : </b><?php echo $content['task']['LevelAssignedName'];?></p>
      	<p class="text-muted"><b>Task Cc : </b><?php echo $content['task']['LevelCcName'];?></p>
      </div>
    </div>
  </div>
  </div>
</div>