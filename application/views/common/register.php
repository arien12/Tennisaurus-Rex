<? 
$this->load->helper('form');
$attributes = array('id'=>'registerForm');
echo form_open('tenniscontroller/processregistration', $attributes);
?>
<label for="fname">First name:</label>
<? $fname = array(
		'name'=>'fname',
		'id'=>'fname');
echo form_input($fname);
?>
<label for="lname">Last Name:</label>
<? $lname = array(
		'name'=>'lname',
		'id'=>'lname');
echo form_input($lname);
?>
<label for="password">password</label>
<? $password = array(
		'name'=>'password',
		'id'=>'password');
echo form_password($password);
?>
<label for="email">email:</label>
<input type="email" id="email" name="email" />
<? echo form_submit('registerSubmit', 'Register');
echo form_close();
?>