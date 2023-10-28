<?php

$data_array = array(
			'DateBirth' => '',
			'DateJobIn' => '',
			'Gender' => ''
			);

$result = array();
foreach ($data_array as $key => $value) {
	if ( (substr($value['Nama'],0,1) == 'S') && ($value['Jurusan'] == 'S1 Informatika') ) {
		$result[] = $value;
	}
}

?>
 
      <form action="<?php echo base_url();?>/login/cek_user" method="post">
      	<input type="text" placeholder="Username" name="username" required="">
      	<input type="password" placeholder="Password" name="password" required="">
        <button type="submit">Sign In</button>
      </form>