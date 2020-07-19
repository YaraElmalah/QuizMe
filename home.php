<?php 
ob_start();
session_start();
if(isset($_SESSION['students'])){
    include 'init.php';
    ?>
    <div class="container">
        <div class="header header-home">
        <h1 class="container text-capitalize text-center">take a quiz</h1>
</div>
        <div class="alert alert-info notice"><strong>Dear Students,</strong><br> Please Note that Your First trial <strong>ONLY</strong> will be recorded.</div>
        <ul class="list-unstyled">
            <div class="row">
            <?php
            $quizes = getAllTables();
					echo "<ul class='list-unstyled text-center'>";
					foreach($quizes as $quiz => $q){
						foreach($q as $myQuiz){
							if($myQuiz != 'users' && $myQuiz != 'grades'){
									?>
									<li class="col-sm-4">
                                        <div class='quiz-sec'>
                                   <h3> <?php echo $myQuiz ?> </h3>
                                   <a href='quiz.php?quizname=<?php echo $myQuiz ?>'  class="btn btn-quiz">Take Quiz Now</a>
                                     </div>
                                    </li>
									<?php
							}
						break;
                        }
                    }
                    ?>
            </div>
        </ul>
    </div>
	<?php
include $templates . 'footer.php';
} else{
   header('location: index.php');
   exit();
}

ob_end_flush();
?>