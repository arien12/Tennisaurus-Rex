<? 
$attributes = array('id'=>'registerForm', 'class' => 'fstyle');
echo form_open('tenniscontroller/processregistration', $attributes);
?>

  <p>Please enter information below to register:</p>
  <ol>
    <li>
      <label for="fname">First name:</label>
		<? $fname = array(
				'name'=>'fname',
				'id'=>'fname');
			echo form_input($fname);
		?>
    </li>
    <li>
      <label for="lname">Last Name:</label>
		<? $lname = array(
				'name'=>'lname',
				'id'=>'lname');
			echo form_input($lname);
		?>
    </li>
    <li>
    	<label for="password">Password</label>
		<? $password = array(
				'name'=>'password',
				'id'=>'password');
			echo form_password($password);
		?>
    </li>
    <li>
    	<label for="email">Email:</label>
		<input type="email" id="email" name="email" />
    </li>
    <li id="send">
    	<button type="submit" id="registerSubmit">Register</button>
    </li>
  </ol>

</form>