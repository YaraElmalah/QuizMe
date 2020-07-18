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
		<!--Start Fast Links --> 
		<div class="row">
			<div class="col-sm-3">
				<a href="students.php?nav=Add" class="btn btn-default btn-lg text-capitalize">add new student</a>
			</div>
			<div class="col-sm-3">
				<a href="quizes.php?nav=submit" class="btn btn-default btn-lg text-capitalize">add new Quiz</a>
			</div>
			<div class="col-sm-3">
				<a href="students.php"class="btn btn-default btn-lg text-capitalize">manage students</a>
			</div>
			<div class="col-sm-3">
				<a href="quizes.php" class="btn btn-default btn-lg text-capitalize">manage quizes</a>
			</div>
			
			
         </div>
		<!--End Fast Links-->
		<div class="row">
			<!--Start First Panel-->
			<div class="col-sm-6">
				<div class="panel panel-default">
				<div class="panel-heading text-capitalize">
					quizes
					<span class="pull-right toggle-show">
							<i class="fas fa-plus"></i>
							</span>
				</div>
				<div class="panel-body">
					<?php
					$quizes = getAllTables();
					echo "<ul class='list-unstyled'>";
					foreach($quizes as $quiz => $q){
						foreach($q as $myQuiz){
							if($myQuiz != 'users'){
								if(!empty($myQuiz)){
									?>
									<li><?php echo $myQuiz ?></li>
									<?php
								}
							}
						break;
						}
					}
					?>
					</ul>
				</div>
				</div>
			</div>
			<!--End First Panel-->
			<!--Start Second Panel-->
			<div class="col-sm-6">
				<div class="panel panel-default">
				<div class="panel-heading text-capitalize">
					students
					<span class="pull-right toggle-show">
							<i class="fas fa-plus"></i>
							</span>
				</div>
				<div class="panel-body">
				<?php 
				$students = getAllFrom('username', 'users', "WHERE Rank != 1 " , 'id');
				foreach($students as $student){
					echo $student['username'] . "<br>";
				}
				?>
				</div>
				</div>
			</div>
			<!--End Second Panel-->

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