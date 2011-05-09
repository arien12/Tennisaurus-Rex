<div id="login">
<? 
$this->load->helper('form');
$attributes = array('id'=>'loginForm');
echo form_open('tenniscontroller/login', $attributes);
?>			
<label for="usernameInput">email</label>
<? $emailInput = array(
	'name'=>'emailInput',
	'id'=>'emailInput',
	'class'=>'loginInput');
echo form_input($emailInput);
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