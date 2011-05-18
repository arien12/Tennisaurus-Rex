<script type="text/javascript">
$(document).ready(function() {
	$("#form").submit(function() {
		var fname = $("#nname").val(); 
		var password = $("#password").val(); 
		var passwordvalidation = $("#passwordvalidation").val(); 
		var email = $("#email").val(); 
		$.post("tenniscontroller/processregistration", { name:name, password:password, passwordvalidation:passwordvalidation, email:email },
		function(data){
			$("#name_error").html(data.name);
			$("#password_error").html(data.password);
			$("#email_error").html(data.email);
		},'json');
	});
});

</script>
<? 
$attributes = array('id'=>'registerForm', 'class' => 'fstyle','onsubmit'=>"return false;");
echo form_open('tenniscontroller/processregistration', $attributes);
?>

  <p>Please enter information below to register:</p>
  <ol>
    <li>
      <label for="name">Name:</label>
      <span id="name_error" class="error"></span>
		<? $name = array(
				'name'=>'name',
				'id'=>'name');
			echo form_input($name);
		?>
    </li>
    <li>
    	<label for="password">Password</label>
    	<span id="password_error" class="error"></span>
		<? $password = array(
				'name'=>'password',
				'id'=>'password');
			echo form_password($password);
		?>
    </li>
    <li>
    	<label for="passwordvalidation">Retype Password</label>
		<? $rpassword = array(
				'name'=>'passwordvalidation',
				'id'=>'passwordvalidation');
			echo form_password($rpassword);
		?>
    </li>
    <li>
    	<label for="email">Email:</label>
    	<span id="email_error" class="error"></span>
		<input type="email" id="email" name="email" />
    </li>
    <li id="send">
    	<button type="submit" id="registerSubmit">Register</button>
    </li>
  </ol>

</form>