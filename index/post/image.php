<?php
require_once(dirname(__FILE__). '/load.php');
require_once (ABSPATH . 'include/script/filesystem.php');
$uploaddirectory = ABSPATH . 'upload' . '/';
$yeardirectory = $uploaddirectory . date("Y"). '/';
$monthdirectory = $yeardirectory . date("m") . '/';
$daydirectory = $monthdirectory . date("d") . '/';


/*
 check whether upload directories exists, create if not
 */
 if (file_exists($uploaddirectory)) 
  {
	  //exists $uploaddirectory
	  if (file_exists($yeardirectory)) 
	  {
		  //exists   $yeardirectory
		  if (file_exists($monthdirectory))
		  {
			  //exists $monthdirectory
			  if (file_exists($daydirectory))
			  {
				  //exists $daydirectory
			  }
			  else
			  {
				  //does not exists $daydirectory
				  $arrresult = getfilepermission($monthdirectory);
				  if  ($arrresult["owner"]["w"] = 2 ) 
				  {
					  //create folder
					  mkdir($daydirectory, 0777, true);
				  }
				  else echo "Don't have wrire permission to creat" . $monthdirectory;
				  }
		  }
		  else
		  {
			  //does not exists $monthdirectory
			  $arrresult = getfilepermission($yeardirectory);
			  if  ($arrresult["owner"]["w"] = 2 ) 
			  {
				  //create folder
				  mkdir($daydirectory, 0777, true);
			  }
			  else echo "Don't have wrire permission to creat" . $yeardirectory;
		  }
	  }
	  else
	  {
		  //does not exists $yeardirectory
		  $arrresult = getfilepermission($uploaddirectory);
		  if  ($arrresult["owner"]["w"] = 2 ) 
		  {
			  //create folder
			  mkdir($daydirectory, 0777, true);
		  }
		  else echo "Don't have wrire permission to creat" . $uploaddirectory;
	  }
  }
  //does not exists $uploaddirectory
 else
 {
	 $arrresult = getfilepermission(ABSPATH);
	 if  ($arrresult["owner"]["w"] = 2 ) 
	 {
		 //create folder
		 mkdir($daydirectory, 0777, true);
	 }
	 else echo "Don't have wrire permission to creat" . ABSPATH;
 }
 
?>
