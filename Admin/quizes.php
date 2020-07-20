<?php
ob_start();
$pageTitle = "Quizes";
session_start();
if(isset($_SESSION['username'])){ 
	include 'init.php';
$nav = isset($_GET['nav'])? $_GET['nav']: $nav = 'Main'; 
if($nav == 'Main'){
	?>

	<div class="container">
		<div class="header">
		<h1 class="text-center">Manage Quizes</h1>
     </div>
	<a href='quizes.php?nav=submit' class="btn btn-quiz">
    <i class="fas fa-feather-alt"></i> New Quiz</a>
	<div class="table-responsive">
		<table class="table table-bordered text-center main-table">
			<tr>
				<th class="text-uppercase text-center">quiz name</th>
				<th class="text-capitalize text-center">number of questions</th>
				<th class="text-capitalize text-center">options</th>
			</tr> <?php
				$tables = getAllTables();
	         foreach($tables  as $table => $value){
		        foreach($value as $branch){
			          if($branch != 'users' && $branch != 'grades'){
				       if(!empty($branch)){
				      	?>
							<tr>
							<td><?php echo $branch ?> </td>
							<td><?php echo countRecords('quizID', "`" . $branch . "`" )  ?></td>
							<td>
							<a href="?nav=Edit&quizname=<?php echo  $branch ?>" class='btn btn-success'>Edit Quiz</a>
							<a href="?nav=Delete&quizname=<?php echo $branch ?>" class='btn btn-danger confirm'>Delete Quiz</a>
							</td>
							</tr>
				    	<?php
				}
		break;
	}
		}
	} ?>
	</table>
	</div> 
     </div>
<?php } elseif($nav == 'submit'){ ?>
	<section class="loginform">

	<div class="container">
	<h1 class="text-center">Submit New Quiz</h1>
		<form class="form-horizontal form-lg login" action="?nav=Add" method="POST">
			<div class="row">
				<!--Start Quiz Title-->
				<div class="form-group">
					<label class="col-sm-3 control-label">
					Quiz Title
				</label>
					<div class="col-sm-9">
					<input type="text" name="title" class="form-control" autocomplete="off" required="required" placeholder="Quiz Title">
					</div>
				</div>
				<!--End Quiz Title-->
				<!--Start Questions Number-->
				<div class="form-group">
					<label class="col-sm-3 control-label">
				 Questions 
				</label>
				<div class="col-sm-9">
				<input type="text" name="no" class="form-control" placeholder="Enter Number of questions" required="required">
				</div>
				</div>
				<!--End Questions Numbers-->
				<!--Start Submit-->
				<div class="form-group">
					<label class="col-sm-3 control-label"> 
				</label>
					<div class="col-sm-9">
						<input type="submit" value="Create Quiz" class="btn btn-quiz">
					</div>
				</div>
                 </div>
				<!--End Submit-->
			
         </div>
		</form>
</section>

<?php } elseif($nav == 'Add'){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
         $title   = "`" . $_POST['title'] . "`";
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
		 <form class="form-horizontal form-lg loginform specific" action="?nav=Insert" method="POST">
		 	<input type="hidden" name="title" value="<?php echo $title?>">
			 <input type="hidden" name="no" value="<?php echo $num ?>"> 
            <?php for($i = 0 ; $i < $num ; $i++ ){
?>
		<!--start First Loop-->
				<!--Start Question-->
				<div class="row">
					<div class="col-sm-2">
					<span class="btn-quiz question">Question <?php echo ($i + 1) ?></span>
			</div>
					<div class="col-sm-9 col-xs-8">
						<textarea class="form-control" placeholder="Enter The Question" required name="question<?php echo ($i + 1) ?>"></textarea>
					</div>
				</div>
				<!--End Question-->
				<!--Start First Answer-->
				<div class="row">
			<div class="col-sm-offset-1 col-sm-1 col-xs-offset-1 col-xs-1">
			  <input value="1" class="choice-one" type="radio" name="choice<?php echo ($i + 1) ?>">
			  </div>
			  <div class="col-sm-9 col-xs-9">
				<input data-radio=".choice-one" data-value="1" type="text" name="ans1<?php echo ($i + 1) ?>" class="form-control" placeholder="First Choice" required="required" >
				</div>
		  
		</div>
		
				<!--End First Answer-->
			
				<!--Start Second Answer-->
                <div class="row">
					<div class="col-sm-offset-1 col-sm-1 col-xs-offset-1 col-xs-1">
					<input  value="2" class="choice-two" type="radio" name="choice<?php echo ($i + 1) ?>">
			</div>
				<div class="col-sm-9 col-xs-9">
				<input data-radio=".choice-two" data-value="2" type="text" name="ans2<?php echo ($i + 1) ?>" class="form-control" placeholder="Second Choice" required="required" >
				</div>
				</div>
				<!--End Second Answer-->
				<!--Start Third Answer-->
                <div class="row">
					<div class="col-sm-offset-1 col-sm-1 col-xs-offset-1 col-xs-1">
					<input value="3" class="choice-three" type="radio" name="choice<?php echo ($i + 1) ?>">
			</div>
				<div class="col-sm-9 col-xs-9">
				<input data-radio=".choice-three" data-value="3" type="text" name="ans3<?php echo ($i + 1) ?>" class="form-control" placeholder="Third Choice" required="required" >
				</div>
				</div>
				<!--End Third Answer-->
				<!--Start Fourth Answer-->
                <div class="row">
					<div class="col-sm-offset-1 col-sm-1 col-xs-offset-1 col-xs-1">
					<input value="4" class="choice-four" type="radio" name="choice<?php echo ($i + 1) ?>">
			</div>
				<div class="col-sm-9 col-xs-9">
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
						<input type="submit" name="filled" value="Submit New Quiz" class="btn btn-quiz btn-lg">
					</div>
				</div>
				<!--End Submit-->
			</div>
		</form>
    <?php }else{
        echo "<div class='alert alert-danger'>This Quiz is already exist</div>";
        redirectHome('back' , 5);
    } } else{
        echo "<div class='alert alert-danger'>You should enter Positive Number of Questions</div>";
        redirectHome('back' , 5);
    }



    } else{
		header('location: quizes.php');
		exit();
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
		exit();
	}
} elseif($nav == 'Edit'){
	if( isset($_GET['quizname']) && (tableExist($_GET['quizname']) == 1)){
		$myQuiz = "`" . $_GET['quizname'] . "`";
		?>
		<h1 class="text-center">Quiz Name: <?php echo $myQuiz ?></h1>
		<div class="container">
		<?php
		$numQues = countRecords('quizID', $myQuiz);
		?>
		<form class="form-horizontal form-lg loginform specific" action="?nav=Update" method="POST">
	   <div class="form-group">
	   <input type="hidden" name="table" value="<?php echo $myQuiz ?>">
	   <input type="hidden" name="num" value="<?php echo $numQues ?>">
	   <?php for($i = 0 ; $i < $numQues ; $i++ ){
		   $id = $i+1;
		$myInfo = getSpecific("*", $myQuiz, "WHERE quizID = {$id}");
		?>
   <!--start First Loop-->
		   <!--Start Question-->
		   <div class="row">
			   <div class="col-sm-2">
			   <span class="btn-quiz question"> Question <?php echo ($i + 1) ?> </span>
	   </div>
			   <div class="col-sm-9 col-xs-8">
				   <textarea class="form-control" placeholder="Enter The Question" required name="question<?php echo ($i + 1) ?>"><?php echo $myInfo['question' . $i] ?></textarea>
			   </div>
		   </div>
		   <!--End Question-->
		   <!--Start First Answer-->
		   <div class="row">
			   <div class="col-sm-offset-1 col-sm-1 col-xs-offset-1 col-xs-1">
			   <input value="1" class="choice-one" type="radio" name="choice<?php echo ($i + 1) ?>" <?php if($myInfo['correct' . $i] == 1):echo "checked"; endif; ?>>
	   </div>
		   <div class="col-sm-9 col-xs-9">
		   <input data-radio=".choice-one" data-value="1" type="text" name="ans1<?php echo ($i + 1) ?>" class="form-control" placeholder="First Choice" required="required" value="<?php echo $myInfo[$i . "for0"]?>">
		   </div>
		   </div>
		   <!--End First Answer-->
		   <!--Start Second Answer-->
		   <div class="row">
			   <div class="col-sm-offset-1 col-sm-1 col-xs-offset-1 col-xs-1">
			   <input  value="2" class="choice-two" type="radio" name="choice<?php echo ($i + 1) ?>"  <?php if($myInfo['correct' . $i] == 2):echo "checked"; endif; ?>>
	   </div>
		   <div class="col-sm-9 col-xs-9">
		   <input data-radio=".choice-two" data-value="2" type="text" name="ans2<?php echo ($i + 1) ?>" class="form-control" placeholder="Second Choice" required="required" value="<?php echo $myInfo[$i . "for1"]?>">
		   </div>
		   </div>
		   <!--End Second Answer-->
		   <!--Start Third Answer-->
		   <div class="row">
			   <div class="col-sm-offset-1 col-sm-1 col-xs-offset-1 col-xs-1">
			   <input value="3" class="choice-three" type="radio" name="choice<?php echo ($i + 1) ?>"  <?php if($myInfo['correct' . $i] == 3):echo "checked"; endif; ?>>
	   </div>
		   <div class="col-sm-9 col-xs-9">
		   <input data-radio=".choice-three" data-value="3" type="text" name="ans3<?php echo ($i + 1) ?>" class="form-control" placeholder="Third Choice" required="required" value="<?php echo $myInfo[$i . "for2"]?>">
		   </div>
		   </div>
		   <!--End Third Answer-->
		   <!--Start Fourth Answer-->
		   <div class="row">
			   <div class="col-sm-offset-1 col-sm-1 col-xs-offset-1 col-xs-1">
			   <input value="4" class="choice-four" type="radio" name="choice<?php echo ($i + 1) ?>"  <?php if($myInfo['correct' . $i] == 4):echo "checked"; endif; ?>>
	   </div>
		   <div class="col-sm-9 col-xs-9">
		   <input data-radio=".choice-four" data-value="4" type="text" name="ans4<?php echo ($i + 1) ?>" class="form-control" placeholder="Fourth Choice" required="required" value="<?php echo $myInfo[$i . "for3"]?>">
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
				   <input type="submit" value="Update Quiz" class="btn btn-primary btn-lg">
				   <a href="quizes.php?nav=Delete&quizname=<?php echo str_replace("`", "" , $myQuiz) ?>" class="btn btn-danger btn-lg confirm">Delete Quiz</a>
			   </div>
		   </div>
		   <!--End Submit-->
	   </div>
   </form>
		</div>
		<?php
	}else{
		header('location: quizes.php');
		exit();
	} 
		
} elseif($nav == "Update"){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$table            = $_POST['table'];
		$num              = $_POST['num'];
		for($i = 0 ; $i < $num ; $i++){
			$question     = $_POST['question' . ($i + 1)];
			$correct      = $_POST['choice' . ($i + 1)];
			$firstChoice  = $_POST['ans1' . ($i + 1)];
			$secChoice    = $_POST['ans2' . ($i + 1)];
			$thirdChoice  = $_POST['ans3' . ($i + 1)];
			$fourthChoice = $_POST['ans3' . ($i + 1)];
		$stmt = $connect->prepare("UPDATE {$table} SET question{$i} = ?, 
		correct{$i} = ?, {$i}for0 = ?, {$i}for1 = ?, {$i}for2 = ?, {$i}for3 = ?");
		$stmt->execute(array($question, $correct, $firstChoice, $secChoice, $thirdChoice, $fourthChoice));
		?>
		<div class="container">
		 <div class="alert alert-success"><strong>The Quiz is Updated Successfuly</strong></div>
		<?php
			redirectHome();
			echo "</div>";
		}
	} else{
		header('location: quizes.php');
		exit();
	}
} elseif($nav == "Delete"){
	if(isset($_GET['quizname']) && tableExist($_GET['quizname'])){
			$table = "`" . $_GET['quizname'] . "`";
			$stmt = $connect->prepare("DROP TABLE {$table}");
			$stmt->execute();
			?>
			<div class="container">
				<div class="alert alert-success"><strong>The Quiz Deleted Successfuly</strong></div>
			<?php
				redirectHome('back');
				echo "</div>";
	} else{
		header('location: quizes.php');
		exit();
	}
} else{
	header('location: quizes.php');
	exit();
}
	include $templates . 'footer.php';
} else{
	header('location:index.php');
	exit();
}
ob_end_flush();
?>