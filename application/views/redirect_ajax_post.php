<style type="text/css">
	form {
		display: none;
	}
</style>

<form id="myForm" action="<?php echo base_url().$url;?>" method="post">
<?php
	for ($i=0; $i < count($type); $i++) { 
	    echo '<input type="text" name="'.htmlentities($type[$i]).'[]" value="'.htmlentities($value[$i]).'">';
	}
?>
</form>

<script src="<?php echo base_url();?>tool/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
    document.getElementById('myForm').submit();
</script>