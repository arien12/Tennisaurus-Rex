<div id="login">
<? 
$this->load->helper('form');
$attributes = array('id'=>'loginForm');
echo form_open('tenniscontroller/login', $attributes);
?>			
<label for="usernameInput">Username</label>
<? $usernameinput = array(
	'name'=>'usernameInput',
	'id'=>'usernameInput',
	'class'=>'loginInput');
echo form_input($usernameinput);
?>
<label for="passwordInput">Password</label>
<? $passwordinput = array(
	'name'=>'passwordInput',
	'id'=>'passwordInput',
	'class'=>'loginInput');
echo form_password($passwordinput);
$submitvalues = array(
	'name'=>'login',
	'value'=>'Login',
	'class'=>'loginInput'
);
echo form_submit($submitvalues);
echo form_close();
?>
</div>