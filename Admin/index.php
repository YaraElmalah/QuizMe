<?php
ob_start();
  session_start();
  if(isset($_SESSION['username'])):
  	header('location: dashboard.php');
  endif;
  include 'init.php';
  	//Check if The User Coming from HTTP POST Method
  	if($_SERVER['REQUEST_METHOD'] == 'POST'):
  			//Getting The Info From the Form
  		$username   = $_POST['user'];
  		$securePass = sha1($_POST['pass']);	
  		//Check if the user existed on the database
  		$stmt = $connect->prepare("
        SELECT username, password, id 
        from users 
        where username =? And password =? And Rank = 1 
        LIMIT 1");
  		$stmt->execute(array($username, $securePass));
        $row = $stmt-> fetch();
  		$count = $stmt-> rowCount();
  		if($count > 0):
  			$_SESSION['username'] = $username; 
  			header('location: dashboard.php'); 
  			exit(); 
  		endif;
  	endif;
 ?>
	  <!--Start Login Form-->
	  <section class="loginform">
    <div class="container">
		<div class="header">
	<h1 class="text-capitalize text-center">admin login</h1>
        </div>
 	<form class="login" method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">
 		<input class="form-control input-lg" type="text" name="user"
 		 autocomplete="off" placeholder="Username">
 		<input class="form-control input-lg" type="password" name="pass" autocomplete="new-password" placeholder="Password">
 		<input class="btn btn-success btn-block" type="submit" value="Login">
 	</form>
	 </div>
</section>
 	<!--End Login Form-->
<?php
  include $templates . 'footer.php';
  ob_end_flush();
 ?>
