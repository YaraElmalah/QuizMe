<?php 
ob_start();
session_start();
if(isset($_SESSION['students'])){
    include 'init.php';
    ?>
    <div class="container">
        <h1 class="container text-capitalize text-center">take a quizes</h1>
    </div>
	<?php
include $templates . 'footer.php';
} else{
   header('location: index.php');
   exit();
}

ob_end_flush();
?>