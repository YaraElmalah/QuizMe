<?php 
ob_start();
  include 'init.php';
session_start();
 if(isset($_SESSION['students'])){
  	header('location: home.php');
 }
  	//Check if The User Coming from HTTP POST Method
  	if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Getting The Info From the Form
    $username   = $_POST['username'];
	$securePass = sha1($_POST['password']);	
	$formError  = [];
    //Check if the user existed on the database
    $stmt = $connect->prepare("SELECT username, `password` , id 
  FROM users where username =? And password =? LIMIT 1");
    $stmt->execute(array($username, $securePass));
     $row = $stmt-> fetch();
    $count = $stmt-> rowCount();
    if($count > 0){
        $_SESSION['students'] = $username; 
        header('location: home.php'); 
        exit(); 
	} else{
		$formError[] = "Username or Password are not Correct";
	}
}
?> 
<section class="loginform">
	<div class="container">
		<h1 class="text-center text-capitalize"><span
            class="login" data-class='.login'>login <i class="fas fa-feather-alt"></i></span> 
        </h1>
			<!--Start Login Form-->
			<form class="form-horizontal login" method="POST" 
			action= "<?php echo $_SERVER['PHP_SELF']?>">
			<div class="row">
				<div class="form-group">
					<div class="col-sm-12">
				     	<input type="text" name="username" class="form-control"
				     	placeholder="Username" autocomplete="off">
				    </div>
				</div>
					<div class="form-group">
					<div class="col-sm-12">
				     	<input type="password" name="password" 
				     	class="form-control"
				     	placeholder="Password" autocomplete="new-password">
				    </div>
				</div>
					<div class="form-group">
					<div class="col-sm-12">
				     	<input type="submit" name="login" value="Login" 
				     	class="btn btn-quiz btn-block">
				    </div>
				</div>
				<?php
				if(!empty($formError)){
				echo "<div class='alert alert-danger text-center'>";
				foreach($formError as $error){
					echo "<strong>" . $error . "</strong>";
				}
				echo  "</div>";
			}
			?>
			</form>
			<!--End Login Form-->
		
	</div>
</section>
<?php include $templates . 'footer.php';
  ob_end_flush();
 ?>