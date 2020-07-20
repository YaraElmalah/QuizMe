<?php 
ob_start();
session_start();
if(isset($_SESSION['username'])){
    $pageTitle = 'Dashboard';
    include 'init.php';
	?>
	<section class="home-stats">
		<div class="container">
		<div class="header">
		<h1 class="text-capitalize text-center">admin dashboard</h1>
        </div>
		<!--Start Fast Links --> 
		<div class="small-nav text-center">
		<div class="row">
			<div class="col-sm-3 col-xs-6">
				<a href="students.php?nav=Add" class="btn btn-quiz btn-lg text-capitalize">add new student</a>
			</div>
			<div class="col-sm-3 col-xs-6">
				<a href="quizes.php?nav=submit" class="btn btn-quiz btn-lg text-capitalize">add new Quiz</a>
			</div>
			<div class="col-sm-3 col-xs-6">
				<a href="students.php"class="btn btn-quiz btn-lg text-capitalize">manage students</a>
			</div>
			<div class="col-sm-3 col-xs-6">
				<a href="grades.php" class="btn btn-quiz btn-lg text-capitalize">students grades</a>
			</div>
			
			
		 </div>
    </div>
		<!--End Fast Links-->
		<div class="row">
		<!--Start Grades Panel-->
		<div class="col-sm-12 col-xs-12">
				<div class="panel panel-default show-panel">
				<div class="panel-heading text-capitalize">
					latest grades
					<span class="pull-right toggle-show">
							<i class="fas fa-plus"></i>
							</span>
				</div>
				<div class="panel-body">
					<?php
					$stmt = $connect->prepare("SELECT grades.*, users.fullname AS user 
					FROM grades 
					INNER JOIN users
					ON users.id = grades.student
					ORDER BY  id DESC LIMIT 10 ");
					$stmt->execute();
					$grades = $stmt->fetchAll(); ?>
				    <ul class='list-unstyled'>
						<?php 
						foreach($grades as $stu){?>
							<li class="row">
							<span class="col-sm-3 col-xs-3"><?php echo $stu['user']?></span>
							<span class="col-sm-3 col-xs-3"><?php echo $stu['quizName']?></span>
							<span class="col-sm-3 col-xs-3"><?php echo $stu['grade']?></span>
							<span class="col-sm-3 col-xs-3"><?php echo $stu['Date']?></span>
							</li>
						<?php }
						?>
					</ul>
				</div>
				</div>
			</div>
			<!--End grades Panel-->
		</div>
		<div class="row">
			<!--Start First Panel-->
			<div class="col-sm-6">
				<div class="panel panel-default show-panel">
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
							if($myQuiz != 'users' && $myQuiz != 'grades'){
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
				<div class="panel panel-default show-panel">
				<div class="panel-heading text-capitalize">
					students
					<span class="pull-right toggle-show">
							<i class="fas fa-plus"></i>
							</span>
				</div>
				<div class="panel-body">
					<ul class="list-unstyled">
				<?php 
				$students = getAllFrom('*', 'users', "WHERE Rank != 1 " , 'id' , 'DESC');
				foreach($students as $student){
					echo "<li>" . "<span class='pull-left'>"  . $student['fullname'] . "</span>";
					echo "<span>" .  $student['class'] . 
					"</span>";
					echo "</li>";
				}
				?>
				</ul>
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