<?php 
ob_start();
session_start();
if(isset($_SESSION['username'])){
    $pageTitle = 'Dashboard';
    include 'init.php';
	?>
	<section class="home-stats text-center">
		<div class="container">
			<h1 class="text-capitalize">admin dashboard</h1>
			<div class="row">
				<div class="col-sm-6">
					<div class="stat st-students">
						<a href="students.php">
							<h3 class="text-capitalize">students</h3>
							<div class="info">
							<i class="fas fa-user-graduate"></i>
							<span class='pull-right'>
							<?php 
							echo checkRecord('*', 'users' , "WHERE Rank != 1");
							?>
							</span>
							</div>
						</a>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="stat st-quizes">
						<a href="quizes.php?do=Manage">
						<h3 class="text-capitalize">quizes </h3>
						<div class="info">
						<i class="fas fa-pen"></i>
						<span class='pull-right'>15</span>

					</div>
					</a>
					</div>
				</div>
		</div>
	</section>
	<!--End Navs-->
    <?php
    include $templates . 'footer.php';
} else{
   header('location: index.php');
   exit();
}

ob_end_flush();
?>