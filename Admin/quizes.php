<?php
ob_start();
$pageTitle = "Quizes";
session_start();
if(isset($_SESSION['username'])){ 
	include 'init.php';
$nav = isset($_GET['nav'])? $_GET['nav']: $nav = 'Main'; 
if($nav == 'Main'){?>

	<div class="container">
		<h1 class="text-center">Manage Quizes</h1>
	<a href='quizes.php?nav=submit' class="btn btn-primary">
    <i class="fas fa-feather-alt"></i> New Quiz</a>
     </div>
<?php } elseif($nav == 'submit'){ ?>

	<h1 class="text-center">Submit New Quiz</h1>
	<div class="container">
		<form class="form-horizontal form-lg" action="?nav=add" method="POST">
			<div class="form-group">
				<!--Start Quiz Title-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Quiz Title
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="title" class="form-control" autocomplete="off" required="required" placeholder="Quiz Title">
					</div>
				</div>
				<!--End Quiz Title-->
				<!--Start Questions Number-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Number of Questions 
				</label>
				<div class="col-sm-10 col-md-6">
				<input type="number" name="no-q" class="form-control" placeholder="Number of Questions" required="required">
				</div>
				</div>
				<!--End Questions Numbers-->
				<!--Start Submit-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> 
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="submit" value="Go" class="btn btn-primary btn-lg">
					</div>
				</div>
				<!--End Submit-->
			</div>
		</form>
	</div>

<?php } elseif($nav = 'Add'){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $title   = $_POST['title'];
        $num     = $_POST['no-q'];
        if($num > 0){
        $sql = $connect->prepare("CREATE TABLE {$title}(
            quizID INT NOT NULL PRIMARY KEY AUTO_INCREMENT)");    
        $sql->execute();
        for($i = 0 ; $i < $num ; $i++){
          $ques = $connect->prepare("ALTER TABLE {$title} ADD `question{$i}` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
          $ques->execute();
          for($j = 0 ; $j < 4 ; $j++){
            $ans = $connect->prepare("ALTER TABLE {$title} ADD `{$i}for{$j}` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
            $ans->execute();
          }
        }?>
       <?php //Start The Entry of The Quiz ?>
        <h1 class="text-center">Quiz: <?php echo $title ?></h1>
	      <div class="container">
		 <form class="form-horizontal form-lg" action="?nav=Insert" method="POST">
			<div class="form-group">
            <?php for($i = 0 ; $i < $num ; $i++ ){
?>
        <!--start First Loop-->
				<!--Start Question-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Question <?php echo ($i + 1) ?>
				</label>
					<div class="col-sm-10 col-md-6">
						<textarea class="form-control" placeholder="Enter The Question" required name="question<?php echo ($i + 1) ?>"></textarea>
					</div>
				</div>
				<!--End Question-->
				<!--Start First Answer-->
				<div class="form-group">
					<label class="col-sm-2 control-label radio">
					<input type="radio" name="choice<?php echo ($i + 1) ?>">
				</label>
				<div class="col-sm-10 col-md-6">
				<input type="text" name="ans1<?php echo ($i + 1) ?>" class="form-control" placeholder="First Choice" required="required" >
				</div>
				</div>
				<!--End First Answer-->
				<!--Start Second Answer-->
                <div class="form-group">
					<label class="col-sm-2 control-label radio">
					<input type="radio" name="choice<?php echo ($i + 1) ?>">
				</label>
				<div class="col-sm-10 col-md-6">
				<input type="text" name="ans2<?php echo ($i + 1) ?>" class="form-control" placeholder="Second Choice" required="required" >
				</div>
				</div>
				<!--End Second Answer-->
				<!--Start Third Answer-->
                <div class="form-group">
					<label class="col-sm-2 control-label radio">
					<input type="radio" name="choice<?php echo ($i + 1) ?>">
				</label>
				<div class="col-sm-10 col-md-6">
				<input type="text" name="ans3<?php echo ($i + 1) ?>" class="form-control" placeholder="Third Choice" required="required" >
				</div>
				</div>
				<!--End Third Answer-->
				<!--Start Fourth Answer-->
                <div class="form-group">
					<label class="col-sm-2 control-label radio">
					<input type="radio" name="choice<?php echo ($i + 1) ?>">
				</label>
				<div class="col-sm-10 col-md-6">
				<input type="text" name="ans4<?php echo ($i + 1) ?>" class="form-control" placeholder="Fourth Choice" required="required" >
				</div>
				</div>
				<!--End Fourth Answer-->
            <!--End First Loop-->
            <?php }?>
				<!--Start Submit-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> 
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="submit" value="Submit New Quiz" class="btn btn-primary btn-lg">
					</div>
				</div>
				<!--End Submit-->
			</div>
		</form>
	</div>
    <?php } else{
        echo "<div class='alert alert-danger'>Please enter a Positive Number</div>";
        redirectHome('back');
    }
        


    } else{
        header('location: quizes.php');
    }
}
else{
	header('location: quizes.php');
}
	include $templates . 'footer.php';
} else{
	header('location:index.php');
	exit();
}
ob_end_flush();
?>