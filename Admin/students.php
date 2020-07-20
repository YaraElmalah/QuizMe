<?php
ob_start();
$pageTitle = "Users";
session_start();
if(isset($_SESSION['username'])){ 
	include 'init.php';
$nav = isset($_GET['nav'])? $_GET['nav']: $nav = 'Main'; 
if($nav == 'Main'){
	     $students = getAllFrom("*", 'users', 'WHERE Rank != 1' , 'id');
						if(!empty($students)){
	?>

	<div class="container">
		<div class="header">
		<h1 class="text-center">Manage Students</h1>
		</div>
	<a href='students.php?nav=Add' class="btn btn-quiz">
	 <i class="fas fa-user-plus"></i> New Student</a>
	<div class="table-responsive">
		<table class="table table-bordered text-center main-table">
			<tr>
				<th class="text-uppercase">#id</th>
				<th class="text-capitalize">full name</th>
				<th class="text-capitalize">class</th>
				<th class="text-capitalize">email</th>
				<th class="text-capitalize">control</th>
			</tr>
				<?php 
					foreach ($students as $stu) {
						 echo "<tr>";
						 echo "<td>" . $stu['id'] . "</td>";
						 echo "<td>" . $stu['fullname'] . "</td>";
						 echo "<td>" . $stu['class'] . "</td>";
						 echo "<td>" . $stu['Email'] . "</td>";
						 echo "<td>" . "<a href='students.php?nav=Edit&userid=" . 
						 $stu['id'] .  "' class='btn btn-success'> <i class=\"fas fa-user-edit\"></i> Edit</a> " . 
					"<a href='students.php?nav=Delete&userid=" . $stu['id'] . "' class='btn btn-danger confirm'> <i class=\"fas fa-user-slash\"></i> Delete</a>"; 

						 echo "</tr>";
					}

			?>
			
		</table>
	</div>
<?php } else{
		echo "<div class='alert alert-info'> There is no Students to show </div>";
} ?>
     </div>
<?php } elseif($nav == 'Add'){ ?>
	<h1 class="text-center">Add New Student</h1>
	<div class="container">
		<form class="form-horizontal form-lg myForm" action="?nav=Insert" method="POST">
			<div class="form-group">
				<!--Start Username-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Username
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Username required to login">
					</div>
				</div>
				<!--End Username-->
				<!--Start Password-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Password
				</label>
				<div class="col-sm-10 col-md-6">
				<input type="password" name="password" class="form-control password" placeholder="Enter Password"
				autocomplete="new-password" required="required" >
				</div>
				</div>
				<!--End Password-->
				<!--Start Confirm Password-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Confirm Password
				</label>
				<div class="col-sm-10 col-md-6">
				<input type="password" name="password-con" class="form-control password" placeholder="Confirm Password"
				autocomplete="new-password" required="required">
				</div>
				</div>
				<!--End Confirm Password-->
				<!--Start Email-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Email
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="email" name="email" class="form-control" autocomplete="off" 
						required="required" placeholder="Email of the User">
					</div>
				</div>
				<!--End Email-->
				<!--Start FullName-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Full Names
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="full-name" class="form-control" autocomplete="off" required="required" placeholder="Student Full Name">
					</div>
				</div>
				<!--End FullName-->
				<!--Start Class-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Class
				    </label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="class" class="form-control" autocomplete="off" required="required" placeholder="Enter the Class Name">
					</div>
				</div>
				<!--End Class-->
				<!--Start Submit-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> 
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="submit" value="Add Student" class="btn btn-quiz btn-lg">
					</div>
				</div>
				<!--End Submit-->
				
			</div>
		</form>
	</div>

<?php } elseif ($nav == "Edit") { 
	$userid = isset($_GET['userid']) 
		&& is_numeric($_GET['userid'])? 
		intval($_GET['userid']): 0; 
		$stmt = $connect->prepare("SELECT * FROM users 
		WHERE id = {$userid}
		 LIMIT 1");
		$stmt->execute();
		$stuInfo = $stmt->fetch();
	    $count   = $stmt-> rowCount();
		if($count > 0 ){ 
			if($stuInfo['Rank'] != 1){
			 echo "<h1 class=\"text-center\">Edit Student</h1>";
			} else{
			echo "<h1 class=\"text-center\">Edit Admin</h1>";
			}?>
				<div class="container">
					<form class="form-horizontal form-lg myForm" action="?nav=Update" method="POST">
					<div class="form-group">
					<input type="hidden" name="userid" value="<?php echo $userid; ?>">
				<!--Start Username-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Username
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Username required to login"
						value="<?php echo $stuInfo['username']?>">
					</div>
				</div>
				<!--End Username-->
				<!--Start Password-->
				<input type="hidden" name="password" value="<?php echo $stuInfo['password']?>">
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Password
				</label>
				<div class="col-sm-10 col-md-6">
				<input type="password" name="new-pass" class="form-control password" placeholder="Enter Here New Password"
				autocomplete="new-password" >
				</div>
				</div>
				<!--End Password-->
				<!--Start Confirm Password-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Confirm Password
				</label>
				<div class="col-sm-10 col-md-6">
				<input type="password" name="password-con" class="form-control password" placeholder="Confirm New Password"
				autocomplete="new-password" >
				</div>
				</div>
				<!--End Confirm Password-->
				<!--Start Email-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Email
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="email" name="email" class="form-control" autocomplete="off" 
						required="required" placeholder="Email of the User"
						value="<?php echo $stuInfo['Email']?>">
					</div>
				</div>
				<!--End Email-->
				<!--Start FullName-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Full Name
				</label>
				
					<div class="col-sm-10 col-md-6">
						<input type="text" name="full-name" class="form-control" autocomplete="off" required="required" placeholder="Student Full Name" value="<?php echo $stuInfo['fullname']?>">
					</div>
				</div>
				<!--End FullName-->
				<!--Start Class-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Class
				    </label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="class" class="form-control" autocomplete="off" required="required" placeholder="Enter the Class Name" value="<?php echo $stuInfo['class'] ?>">
					</div>
				</div>
				<!--End Class-->
				<!--Start Submit-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> 
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="submit" value="Update Info" class="btn btn-primary btn-lg">
						<?php
						if($stuInfo['Rank'] != 1){?>
			              <a href='students.php?nav=Delete&userid=<?php echo $userid ?>' class='btn btn-danger btn-lg confirm'> Delete Student</a>
			             <?php } ?>
					</div>
				</div>
				<!--End Submit-->
				
			</div>
		</form>
	</div> <?php
		} else{
			header('location: students.php');
			exit();
		}
	
        } 
elseif ($nav == "Update") {
	if($_SERVER['REQUEST_METHOD'] === "POST"){
		echo "<h1 class='text-center'>Update Information</h1>"; 
		//Get Variables From the Form
		$id         = $_POST['userid'];
		$username   = $_POST['username'];
		$email      = $_POST['email'];
		$full       = $_POST['full-name'];
		$class      = $_POST['class'];
		$pass = empty($_POST['new-pass'])? $_POST['password'] :sha1($_POST['new-pass']);
		//Validate The Form
		$formErrors = [];
		if(!empty($_POST['new-pass'])){
			if($_POST['new-pass'] != $_POST['password-con']){
				$formErrors[] = "The Two Passwords are <strong> Not </strong> Identical";
			}
		}
		if(empty($username)){
			$formErrors[] = "Username can't be <strong> empty </strong>";
		} 
		if (empty($email)) {
			$formErrors[] = "Username can't be <strong> empty </strong>";
		}
		if (empty($full)) {
			$formErrors[] = "Full Name can't be <strong> empty </strong>";
		} 
		if (strlen($username) < 2) {
			$formErrors[] = "Full Name can't be smaller than <strong> 2 Characters</strong>";
		}
	     	
			//Database Query
			//Check if There is no errors 
			if(empty($formErrors)){
               $myCheck = $connect->prepare("SELECT * FROM users
               	WHERE username = ? AND id != ?");
               $myCheck->execute(array($username, $id));
               $myCheck->fetch();
               $check = $myCheck->rowCount();
	            if($check == 1){
		             $error =  "<div class='container'>
								<div class='alert alert-danger'>The username is already existed</div>";
					 redirectHome('back');
					 echo 	"</div>";
		         } else{
		         	//Update Database with this info
			     $stmt = $connect->prepare("UPDATE users 
				SET username = ? , Email = ? ,  fullname = ?, `password` = ? , 
				class = ?  where id = ?");
		     	$stmt->execute(array($username, $email, $full, $pass, $class , $id));
		     	//Echo Success Message
		     	$success =  " <div class='container'>
							   <div class='alert alert-success'><strong>" .  $stmt->rowCount() . " Student Updated </strong></div>";
							   echo $success;
								  redirectHome('back');
								  echo  "</div>";
		         }
		    
			} else{
				//Get The Errors
	          foreach ($formErrors as $error) {
				echo "<div class='alert alert-danger'>"  . 
				$error . "</div>";
			}
			redirectHome('back');
			}
			
	
	} else{
		header('location: students.php');
		exit();
	}
} 

elseif ($nav == "Insert") {
       if($_SERVER['REQUEST_METHOD'] === "POST"){
		echo "<h1 class='text-center'>Insert </h1>"; 
		//Get Variables From the Form
		$username   = $_POST['username'];
		$email      = $_POST['email'];
		$full       = $_POST['full-name'];
		$class      = $_POST['class'];
		//Validate The Form
		$formErrors = [];
		if(!empty($_POST['password'])){
			if($_POST['password'] != $_POST['password-con']){
				$formErrors[] = "The Two Passwords are <strong> Not </strong> Identical";
			} else{
				$pass = sha1($_POST['password']);
			}
		} 
		if(empty($username)){
			$formErrors[] = "Username can't be <strong> empty </strong>";
		} 
		if (empty($email)) {
			$formErrors[] = "Username can't be <strong> empty </strong>";
		}
		if (empty($full)) {
			$formErrors[] = "Full Name can't be <strong> empty </strong>";
		} 
		if (strlen($username) < 2) {
			$formErrors[] = "Full Name can't be smaller than <strong> 2 Characters</strong>";
		}
		//Database Query
			if(empty($formErrors)){
				$check = checkRecord('username','users', $username);
	            if($check == 1){
		             $error =  "<div class='container'>
								<div class='alert alert-danger'>The username is already existed</div>
								redirectHome('back');
								</div>";
		           
	            } else{
	             	//Insert this info into Database 
				   	$stmt =  $connect->prepare("INSERT INTO users
					   (username, `password`, Email, fullname ,  `Rank` , class) 
				   		VALUES (:user, :pass, :mail, :full, 0 , :class )");
				   	$stmt->execute(array(
				   		':user'  => $username,
				   		':pass'  => $pass,
				   		':mail'  => $email,
					    ':full'  => $full,
						':class' => $class
				   	));
			     	//Echo Success Message
			     echo "<div class='container'>
                     <div class='alert alert-success'><strong>" .  $stmt->rowCount() . " Student Added </strong></div>";
								 redirectHome('back');
								echo   "</div>";
			     	
				}
		    
			} else{
				//Get The Errors
				echo "<div class='container'>";
	          foreach ($formErrors as $error) {
				echo "<div class='alert alert-danger'>"  . 
				$error . "</div>";
			 }
				redirectHome('back');

			}
			
      } else{
		  header('location: student.php');
		  exit();
	}
}
elseif ($nav == "Delete") { ?>
			   <div class="container">
				<h1 class="text-center">Delete Student</h1>
 <?php
		$userid = isset($_GET['userid']) 
		&& is_numeric($_GET['userid'])? 
		intval($_GET['userid']): 0;
		$check = checkRecord( 'id' , 'users', "WHERE id = {$userid}");
		if($check > 0){ 
			//Delete Query
				$stmt = $connect->prepare("DELETE FROM users WHERE
					                        id = ?");
				$stmt->execute(array($userid));
				//Echo Success Message
			 $success =  "<div class='container'>
							<div class='alert alert-success'><strong>" .  $stmt->rowCount() . " Student Deleted </strong></div>";
							echo $success;
							 redirectHome('back');
							 echo "</div>";
		} else{
			header('location: students.php');
			exit();
		}
} 
 else{
	header('location: students.php');
	exit();
}
	include $templates . 'footer.php';
} else{
	header('location:index.php');
	exit();
}
ob_end_flush();
?>