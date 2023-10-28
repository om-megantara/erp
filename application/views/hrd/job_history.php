<style type="text/css">
  .table-main {font-size: 12px;}
  thead {font-weight: bold;}
  h3{margin: 0px;}
</style>
<div class="row">
  <div class="col-md-12" style="background-color: white;">
    <h3>Name&ensp;: <?php echo $content['main']['LevelName'];?></h3>
    <h3>Code&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $content['main']['LevelCode'];?></h3>
    <h3>Parent : <?php echo $content['main']['levelparent'];?></h3>
    <br>
    <table class="table table-bordered table-main">
      <thead>
        <tr><td>Date Start</td><td>Date End</td><td>Employee Name</td></tr>
      </thead>
      <tbody>
        <?php
            // echo print_r($content);
            if (!empty($content['detail'])) {
             foreach ($content['detail'] as $row => $list) { ?>
                <td><?php echo $list['StartDate'];?></td>
                <td><?php echo $list['EndDate'];?></td>
                <td><?php echo $list['fullname'];?></td>
              </tr>
        <?php } } ?>
      </tbody>
    </table>
  </div>
</div>