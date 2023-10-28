<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Compare Image</title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap.min.css">
	<script src="<?php echo base_url();?>assets/adminlte/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/adminlte/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- cndk.beforeafter.js -->
    <link href="<?php echo base_url();?>assets/cndk.beforeafter.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/cndk.beforeafter.js"></script>

    <script>
        $(document).ready(function () { 
		    if(window.opener && !window.opener.closed) {
		    	arrImage = window.opener.arrImage
		    	$('img.fileBefore').attr('src',arrImage['fileBefore'])
		    	$('img.fileAfter').attr('src',arrImage['fileAfter'])
		    }
            $(".CompareImage").cndkbeforeafter(
                {
                  autoSliding: true,
                  mode: "drag",
                  theme: "dark"
                }
            ); 
        });
    </script>
</head>

<body>
		<div class="CompareImage" style="margin: auto;">
		  <div data-type="data-type-image">
		      <div data-type="before"><img class="fileBefore" src="https://source.unsplash.com/Uy1P7uztd0M/1200x630"></div>
		      <div data-type="after"><img class="fileAfter" src="https://source.unsplash.com/Cy1tY6A8Cbk/1200x630"></div>
		  </div>
		</div>
</body>

</html>
