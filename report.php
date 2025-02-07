<?php
ob_start();
session_start();
if(isset($_SESSION['students'])){
    include 'init.php';
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $student = $_SESSION['students'];
        $quiz    = $_POST['table'];
        $num     = $_POST['num'];
        $examAns = [];
        $studentInfo = getSpecific("*", "users", "WHERE username = '{$student}'");
        ?>
        <div class="container">
            <div class="header">
            <h1 class="text-center">Quiz Report: <?php echo $quiz ?></h1>
            </div>
            <div class="panel panel-default personal-info">
                <div class="panel-heading">Student Information</div>
            <div class="panel-body">
                <ul class="list-unstyled">
                <li><span><i class="fas fa-id-card fa-fw"></i>Full Name </span>: <?php echo $studentInfo['fullname'] ?></li>
                <li><span><i class="fas fa-users fa-fw"></i>Class </span>: <?php echo $studentInfo['class'] ?></li>
                <li><span><i class="fas fa-envelope fa-fw"></i>Email </span>: <?php echo $studentInfo['Email'] ?></li>
                </ul>
                </div>
           </div>
           <div class="panel panel-default exam-report">
                <div class="panel-heading">
                  Exams Answers
                  <span class="pull-right toggle-show">
							<i class="fas fa-plus"></i>
							</span>
                </div>
                <div class="panel-body">
        <?php
        for($i = 0; $i < $num ; $i++){
            $id = $i + 1;
            $myInfo = getSpecific("*", $quiz, "WHERE quizID = {$id}");
            $correct =  $myInfo['correct' . $i];
            $choice  = $_POST['choice' . $id];
            $examAns[] = ($choice == $correct)? 1 : 0;
            ?> 
                <div class="ques">
                <p><span>Question <?php echo $i + 1 ?></span>: <span><?php echo $myInfo['question' . $i] ?></span></p>
                <p><span>Your Answer is </span>: <span> <?php echo $myInfo[$i . 'for' . ($choice - 1) ] ?></span></p>
                <p><span>The Correct Answer is </span>: <span><?php echo $myInfo[$i . 'for' . ($correct - 1) ] ?></span></p>
                <p><span>Gained Points </span>: <span><?php echo $examAns[$i]?></span></p>
                </div>
                <hr>
            <?php
        }
            $sum = 0;
            for($i = 0; $i < count($examAns); $i++){
                $sum += $examAns[$i];
            }?>
            </div>
           </div>
            <div class="panel panel-success">
            <div class="panel-body">
            <p class="total text-center"><span>Total </span>: <?php echo $sum ?></p>
            </div>
            </div>
            <?php
                $studentID = $studentInfo['id'];
                $myRecord = checkRecord("*", "grades" , "WHERE quizName = '{$quiz}' AND student = '{$studentID}'");
                if($myRecord < 1){
                        //Database
                    $stmt = $connect->prepare("INSERT INTO grades(quizName, student, grade, `Date`)
                    VALUES(:quiz, :stu, :grade, now())");
                    $stmt->execute(array(
                        ":quiz"  => $quiz,
                        ":stu"   => $studentInfo['id'],
                        ":grade" => $sum
                    ));
                    //Sending An Email
                    $admin  = getSpecific("*", "users", "WHERE Rank = 1");
                    $to     = $admin['Email'];
                    $subject = "Quiz Finished ! " ;
                    $message = "Good Morning, 1\r\n" . $studentInfo['fullname'] . " from class: ". $studentInfo['class'] . " take the " . $quiz . " quiz and got a total Score " . $sum;
                    mail($to, $subject, $message);
                } else{
                    ?>
                    <div class="alert alert-danger text-center"><strong>Please Note That Your Results is not Recorded</strong></div>
                    <?php
                }

      ?>
          </div>
      <?php
      include $templates . 'footer.php';
    }else{
        header("location: home.php");
        exit();
    }
} else{
    header('location: index.php');
    exit();
}
?>