<?php
ob_start();
session_start();
if(isset($_SESSION['students'])){ 
	include 'init.php';
if(isset($_GET['quizname']) && tableExist($_GET['quizname'])== 1){
    $table  = $_GET['quizname'];
	$myInfo = getAllFrom("*", $table, "" , "quizID");
	$num    = countRecords('quizID', $table);
	?>
    <div class='container'>
      <h1 class='text-center'>Quiz: <?php echo $table ?> </h1>
      <form class="form-horizontal form-lg" action="report.php" method="POST">
	   <div class="form-group">
	   <input type="hidden" name="table" value="<?php echo $table ?>">
	   <input type="hidden" name="num" value="<?php echo $num ?>">
   <?php
        for($i = 0 ; $i < $num ; $i++){
             $id = $i + 1;
             $myInfo = getSpecific("*", $table, "WHERE quizID = {$id}");
        ?>
        <!--start First Loop-->
		   <!--Start Question-->
		   <div class="form-group">
			   <label class="col-sm-2 control-label">
			   Question <?php echo ($i + 1) ?>
		   </label>
			   <div class="col-sm-10 col-md-6">
               <p><?php echo $myInfo['question' . $i] ?><p>
			   </div>
		   </div>
		   <!--End Question-->
		   <!--Start First Answer-->
		   <div class="form-group">
			   <label class="col-sm-2 control-label radio">
			   <input value="1" class="choice-one" type="radio" name="choice<?php echo ($i + 1) ?>">
		   </label>
		   <div class="col-sm-10">
           <p><?php echo $myInfo[$i . "for0"]?></p>
		   </div>
		   </div>
		   <!--End First Answer-->
		   <!--Start Second Answer-->
		   <div class="form-group">
			   <label class="col-sm-2 control-label radio">
			   <input  value="2" class="choice-two" type="radio" name="choice<?php echo ($i + 1) ?>">
		   </label>
		   <div class="col-sm-10">
		   <p><?php echo $myInfo[$i . "for1"]?></p>
		   </div>
		   </div>
		   <!--End Second Answer-->
		   <!--Start Third Answer-->
		   <div class="form-group">
			   <label class="col-sm-2 control-label radio">
			   <input value="3" class="choice-three" type="radio" name="choice<?php echo ($i + 1) ?>">
		   </label>
		   <div class="col-sm-10">
		   <p><?php echo $myInfo[$i . "for2"]?></p>
		   </div>
		   </div>
		   <!--End Third Answer-->
		   <!--Start Fourth Answer-->
		   <div class="form-group">
			   <label class="col-sm-2 control-label radio">
			   <input value="4" class="choice-four" type="radio" name="choice<?php echo ($i + 1) ?>">
		   </label>
		   <div class="col-sm-10">
		   <p><?php echo $myInfo[$i . "for3"]?></p>
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
				   <input type="submit" value="Finish Quiz" class="btn btn-success btn-lg">
			   </div>
		   </div>
		   <!--End Submit-->
	   </div>
   </form>
    </div>
    
<?php } else{
    header('location: home.php');
    exit();
}
include $templates . 'footer.php';
} else{
    header('location: index.php');
    exit();
}
ob_end_flush();
?>