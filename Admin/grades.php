<?php
ob_start();
$pageTitle = "Grades";
session_start();
if(isset($_SESSION['username'])){
    include 'init.php';
    $stmt = $connect->prepare("SELECT grades.*, users.fullname AS user, users.class AS class 
					FROM grades 
					INNER JOIN users
					ON users.id = grades.student
					ORDER BY  id DESC");
					$stmt->execute();
                    $grades = $stmt->fetchAll();
                    if(!empty($grades)){?>
                <div class="container">
                        <h1 class="text-center">Grades</h1>
                    <a href='quizes.php?nav=submit' class="btn btn-quiz">
                    <i class="fas fa-feather-alt"></i>
                    Submit New Quiz</a>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center main-table">
                            <tr>
                                <th class="text-capitalize">full name</th>
                                <th class="text-capitalize">class</th>
                                <th class="text-capitalize">quiz name</th>
                                <th class="text-capitalize">grade</th>
                                <th class="text-capitalize">date</th>
                            </tr>
                    <?php 
                    foreach ($grades as $info) {
                        echo "<tr>";
                        echo "<td>" . $info['user'] . "</td>";
                        echo "<td>" . $info['class'] . "</td>";
                        echo "<td>" . $info['quizName'] . "</td>";
                        echo "<td>" . $info['grade'] . "</td>";
                        echo "<td>" . $info['Date'] . "</td>";
                        echo "</tr>";
                   }
                    
                }
    include $templates . 'footer.php';
} else{
    header("location: index.php");
    exit();
}