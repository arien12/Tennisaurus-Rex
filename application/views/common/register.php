<!--
<script type="text/javascript">
$(document).ready(function() {
	$("#registerForm").submit(function() {
		alert("fuck");
		var fname = $("#name").val(); 
		var password = $("#password").val(); 
		var passwordvalidation = $("#passwordvalidation").val(); 
		var email = $("#email").val(); 
		$.post("<?php $this->load->helper('url');echo site_url('tenniscontroller/processregistration'); ?>", { name:name, password:password, passwordvalidation:passwordvalidation, email:email },
		function(data){
			alert(data);
			$("#name_error").html(data.name);
			$("#password_error").html(data.password);
			$("#email_error").html(data.email);
		},'json');
	});
});

</script>
-->
<?php echo validation_errors(); ?>
<? 
$attributes = array('id'=>'registerForm', 'class' => 'fstyle');
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
			echo form_input($name, set_value('name'));
		?>
    </li>
    <li>
    	<label for="password">Password:</label>
    	<span id="password_error" class="error"></span>
		<? $password = array(
				'name'=>'password',
				'id'=>'password');
			echo form_password($password);
		?>
    </li>
    <li>
    	<label for="passwordvalidation">Retype Password:</label>
		<? $rpassword = array(
				'name'=>'passwordvalidation',
				'id'=>'passwordvalidation');
			echo form_password($rpassword);
		?>
    </li>
    <li>
    	<label for="email">Email:</label>
    	<span id="email_error" class="error"></span>
    	<? $email = array(
				'name'=>'email',
				'id'=>'email');
			echo form_input($email, set_value("email"));
		?>
    </li>
    <li id="send">
    	<input type="submit" value="Submit" />
    </li>
  </ol>

</form>