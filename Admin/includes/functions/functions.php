<?php
$default = 'quiz';
/*
Function to get All Records form specific Table
$field     = the record that You want to get from the table example: * , Name
$table     = the table that you want to get from the records
$where     = the condition that under which you get the records
$orderBy   = the column that you want to order by the data
$orderType = ASC or DESC (ASC is the Default)
*/
function getAllFrom($field, $table, $where = NULL , $orderBy ,
 $orderType = 'ASC'){
 	global $connect;
	$stmt = $connect->prepare("SELECT $field FROM $table $where ORDER BY  $orderBy $orderType");
	$stmt->execute();
	$records = $stmt->fetchAll();
	return $records;
}
/*
This function used to get specific record from database
*/
function getSpecific($field, $table, $where = NULL){
 	global $connect;
	$stmt = $connect->prepare("SELECT $field FROM $table $where LIMIT 1");
	$stmt->execute();
	$records = $stmt->fetch();
	return $records;
}
/*
Function to check record if it exists in Database
[Function accepts Parameters] ==> 
$select -> the item to Select [example: user, item, category]
$from   -> the table to Select from [example: users, items, categories]
$where  -> The condition that the query depends on to get the records from db example[WHERE id = 100] --> [optional]
*/
function checkRecord($select, $from , $where = NULL){
	global $connect; 
	$query = $connect->prepare("SELECT $select FROM $from  $where");
	$query->execute();
	$count = $query-> rowCount();
	return $count;
}
/*
- get the title of the Page by written the title You want in "$pageTitle" on the top of the page 
the final result is => theVariable '$pageTitle' - BrandName 'QuizMe'
- if the variable did not included, the brandName will show 'QuizMe'
*/
function getTitle(){
	global $pageTitle;
	if(isset($pageTitle)){
	 echo $pageTitle . ' - QuizMe';
	} else{ 
		echo 'QuizMe';
	}
}
/*
Parameters of the Function
$seconds  ==> Num of Seconds before redirecting (Default is 3)
$url      ==> link that you want to redirect into
if You didn't pass a parameter in the function then it will redirect into index.php else would redirect to back
*/
function redirectHome($url = null, $seconds = 3){
	if($url === null){
		$url = 'index.php';
		$link = 'homepage';
	} else{
		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
			$url = $_SERVER['HTTP_REFERER'];
			$link = 'Previous Page';
		} else{
			$url = 'index.php';
			$link = 'Previous Page';
		}
	}
 
 echo '<div class=\'alert alert-info\'>You will be redirected to the ' .  $link  . 
 ' after ' .  $seconds .' seconds ...</div>';
 header("refresh: $seconds;url=$url"); //redirect to index.php
 exit();
}
/*
if the table exists it will return 1 and if not existed it will return 0
-- check if the table exists in the db
*/
function tableExist($myTable){
	global $connect;
	global $default;
	$stmt = $connect->prepare("SHOW TABLES FROM $default");
	$stmt->execute();
	$tables = $stmt->fetchAll();
	$flag = FALSE;
	foreach($tables as $table => $value){
		if(in_array($myTable, $value)){
			$flag = TRUE;
		}    
	 }
	return $flag;
}
/*
count the number of the records in specific Table 
$col   ==> the column you want to want count from (reference)
$table ==> the table you want to do that in
*/
function countRecords($col, $table){
	global $connect;
	$stmt2 = $connect->prepare("SELECT COUNT($col) FROM $table");
      $stmt2->execute();
 return $stmt2->fetchColumn();
}
/* Get All the Tables For DB */
function getAllTables(){
	global $connect;
	global $default;
	$stmt = $connect->prepare("SHOW TABLES FROM $default");
	        $stmt->execute();
			$tables = $stmt->fetchAll();
			return $tables;
}