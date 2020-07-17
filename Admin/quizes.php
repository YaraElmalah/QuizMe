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
		<form class="form-horizontal form-lg" action="?nav=Add" method="POST">
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
				<input type="text" name="no" class="form-control" placeholder="Number of Questions" required="required">
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

<?php } elseif($nav == 'Add'){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
         $title   = $_POST['title'];
		 $num     = $_POST['no'];
        if($num > 0){
           if(tableExist($title)!= 1){
        $sql = $connect->prepare("CREATE TABLE {$title}(
            quizID INT NOT NULL PRIMARY KEY AUTO_INCREMENT)");    
        $sql->execute();
        for($i = 0 ; $i < $num ; $i++){
		  $ques = $connect->prepare("ALTER TABLE {$title} ADD `question{$i}` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
		  ");
		  $ques->execute();
		  $cor = $connect->prepare("ALTER TABLE {$title} ADD `correct{$i}` INT(11) ");
		  $cor->execute();
		  
          for($j = 0 ; $j < 4 ; $j++){
            $ans = $connect->prepare("ALTER TABLE {$title} ADD `{$i}for{$j}` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
            $ans->execute();
          }
        }?>
            <?php //Start The Entry of The Quiz ?>
        <h1 class="text-center">Quiz: <?php echo $title ?></h1>
	      <div class="container">
		 <form class="form-horizontal form-lg" action="?nav=Insert" method="POST">
		 	<input type="hidden" name="title" value="<?php echo $title?>">
			 <input type="hidden" name="no" value="<?php echo $num ?>"> 
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
					<input value="1" class="choice-one" type="radio" name="choice<?php echo ($i + 1) ?>">
				</label>
				<div class="col-sm-10">
				<input data-radio=".choice-one" data-value="1" type="text" name="ans1<?php echo ($i + 1) ?>" class="form-control" placeholder="First Choice" required="required" >
				</div>
				</div>
				<!--End First Answer-->
				<!--Start Second Answer-->
                <div class="form-group">
					<label class="col-sm-2 control-label radio">
					<input  value="2" class="choice-two" type="radio" name="choice<?php echo ($i + 1) ?>">
				</label>
				<div class="col-sm-10">
				<input data-radio=".choice-two" data-value="2" type="text" name="ans2<?php echo ($i + 1) ?>" class="form-control" placeholder="Second Choice" required="required" >
				</div>
				</div>
				<!--End Second Answer-->
				<!--Start Third Answer-->
                <div class="form-group">
					<label class="col-sm-2 control-label radio">
					<input value="3" class="choice-three" type="radio" name="choice<?php echo ($i + 1) ?>">
				</label>
				<div class="col-sm-10">
				<input data-radio=".choice-three" data-value="3" type="text" name="ans3<?php echo ($i + 1) ?>" class="form-control" placeholder="Third Choice" required="required" >
				</div>
				</div>
				<!--End Third Answer-->
				<!--Start Fourth Answer-->
                <div class="form-group">
					<label class="col-sm-2 control-label radio">
					<input value="4" class="choice-four" type="radio" name="choice<?php echo ($i + 1) ?>">
				</label>
				<div class="col-sm-10">
				<input data-radio=".choice-four" data-value="4" type="text" name="ans4<?php echo ($i + 1) ?>" class="form-control" placeholder="Fourth Choice" required="required" >
				</div>
				</div>
				<!--End Fourth Answer-->
            <!--End First Loop-->
            <?php }?>
				<!--Start Submit-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> 
				</label>
					<div class="col-sm-10">
						<input type="submit" name="filled" value="Submit New Quiz" class="btn btn-primary btn-lg">
					</div>
				</div>
				<!--End Submit-->
			</div>
		</form>
	</div>
    <?php }else{
        echo "<div class='alert alert-danger'>This Quiz is already exist</div>";
        redirectHome('back' , 5);
    } } else{
        echo "<div class='alert alert-danger'>You should enter Positive Number of Questions</div>";
        redirectHome('back' , 5);
    }



    } else{
        header('location: quizes.php');
    }
} elseif($nav == 'Insert'){
	if($_SERVER['REQUEST_METHOD'] === "POST"){
	  $iteration    = $_POST['no'];
	  $quizName     = $_POST['title'];
		for($i = 0 ; $i < $iteration ; $i++){
			//Start First Loop
			 //Start Question
			$question    = $_POST['question' . ($i + 1)];
			 //End Question
			 //start correct Answer
			 $correct     = $_POST['choice' . ($i + 1)];
			 //Choices
			 $firstChoice  = $_POST['ans1' . ($i + 1)];
			 $secondChoice = $_POST['ans2' . ($i + 1)];
			 $thirdChoice  = $_POST['ans3' . ($i + 1)];
			 $fourthChoice = $_POST['ans4' . ($i + 1)];
		$stmt = $connect->prepare("INSERT INTO {$quizName}(question{$i}, correct{$i}, {$i}for0, {$i}for1, {$i}for2, {$i}for3 )
		VALUES(:question{$i}, :correct{$i}, :ans1, :ans2, :ans3, :ans4)");
		$stmt->execute(array(
			":question{$i}" => $question,
			":correct{$i}"  => $correct,
			":ans1"         => $firstChoice,			
			":ans2"         => $secondChoice,			
			":ans3"         => $thirdChoice,			
			":ans4"         => $fourthChoice			
		));
		};	
		?>
		<div class="container">
		<div class="alert alert-success">The Quiz is now Live!</div>
		<?php
		redirectHome('back', 6);
		echo "</div>";
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