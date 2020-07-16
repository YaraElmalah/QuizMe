<?php
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
