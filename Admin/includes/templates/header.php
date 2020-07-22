<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <!--Start Css Files-->
  <link rel="stylesheet" href= "<?php echo $css ?>bootstrap-min.css" />
  <link rel="stylesheet" href= "<?php echo $css ?>icons.min.css" />
  <link rel="stylesheet" href= "<?php echo $css ?>main.css" />
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Prompt:wght@500&display=swap">
   <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Acme&display=swap">
     <title><?php getTitle(); ?></title>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
   
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-toggle" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">QuizMe <i class="fas fa-feather-alt"></i></a>
    </div>
<?php 
  if(isset($_SESSION['username'])){ ?>
    <div class="collapse navbar-collapse" id="nav-toggle">
      <ul class="nav navbar-nav navbar-right text-uppercase">
      <li><a href="quizes.php?nav=submit">New Quiz<span class="sr-only">(current)</span></a></li>
      <li><a href="grades.php">Grades<span class="sr-only">(current)</span></a></li>
      <li><a href="students.php?nav=Edit&userid=1">Admin Info<span class="sr-only">(current)</span></a></li>
        <li><a href="quizes.php">Quizzes<span class="sr-only">(current)</span></a></li>
       <li><a href="students.php">Students<span class="sr-only">(current)</span></a></li>
        <li><a href="logout.php" title="logout"><i class="fas fa-sign-out-alt"></i><span class="sr-only">(current)</span></a></li>
              </ul>
    </div>
  <?php } elseif(isset($_SESSION['students'])){?>
      <div class="collapse navbar-collapse" id="nav-toggle">
        <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php" title="logout"><i class="fas fa-sign-out-alt"></i><span class="sr-only">(current)</span></a></li>
        </ul>
      </div>

  <?php }?>
  </div>
</nav>
