<?php
require_once(dirname(__FILE__). '/load.php');
require_once (ABSPATH . 'include/script/filesystem.php');
require_once (ABSPATH . 'include/script/config.php');
require_once (ABSPATH . 'include/script/MysqliDb.php');
$uploaddirectory = ABSPATH . 'upload' . '/';
$yeardirectory = $uploaddirectory . date("Y"). '/';
$monthdirectory = $yeardirectory . date("m") . '/';
$daydirectory = $monthdirectory . date("d") . '/';

//path link file
$path = 'upload'.'/'. date("Y"). '/'.date("m") . '/'.date("d") . '/';

/*
 * check whether client sent file data, $_FILES['usrfiles'] is setted
 * if YES: csave file and send back to client file parametter
 * if NOT: send back to client error
 */
$uploadedfile = array();

if (isset($_FILES['usrfiles'])) 
 {
	 $db = new MysqliDb (DB_HOST, DB_USER, DB_PASS, DB_NAME);
	 createfolderupload(ABSPATH,$uploaddirectory);
		foreach($_FILES['usrfiles']['name'] as $key=>$value)
		{
		   $uploadedfile[$key]['name'] = $_FILES['usrfiles']['name'][$key];
		   $uploadedfile[$key]['type'] = $_FILES['usrfiles']['type'][$key];
		   $uploadedfile[$key]['size'] = $_FILES['usrfiles']['size'][$key];
		   $uploadedfile[$key]['tmp_name'] = $_FILES['usrfiles']['tmp_name'][$key];
		   $uploadedfile[$key]['error'] = $_FILES['usrfiles']['error'][$key];
		   
		   //check file type
		   // not image or pdf file type
		   if (!preg_match('/^image.(jpg|png|bmp|jpeg)$/',$uploadedfile[$key]['type']) && !preg_match('/^application.(pdf)$/',$uploadedfile[$key]['type']))
		   {
			   $err = "";
			   $err = "Check file type of " . $uploadedfile[$key]['name'] ."type is " . $uploadedfile[$key]['type'];
			   echo $err;
			   exit;
		   }
		   //image file and size over
		   if (preg_match('/^image.(jpg|png|bmp|jpeg)$/',$uploadedfile[$key]['type']) && (($uploadedfile[$key]['size']/1048576)>1))
		   {
			   $err = "";
			   $err = "Check file size of image file " . $uploadedfile[$key]['name'] ."size= " . $uploadedfile[$key]['size'] . ">1";
			   echo $err;
			   exit;
		   }
		   //image pdf and size over
		   if (preg_match('/^application.(pdf)$/',$uploadedfile[$key]['type']) && (($uploadedfile[$key]['size'] / 1048576)>1))
		   {
			   $err = "";
			   $err = "Check file size of pdf file " . $uploadedfile[$key]['name'] ."size= " . $uploadedfile[$key]['size'] . ">1";
			   echo $err;
			   exit;
		   }
		   //~ echo $uploadedfile[$key]['type'];
		   //formal image or pdf file
		   $image = false;
		   $pdf = false;
		   if (preg_match('/^image.(jpg|png|bmp|jpeg)$/',$uploadedfile[$key]['type']))
		   {
			   $image = true;
			   $filename = stripslashes($uploadedfile[$key]['name']);
			   if (file_exists($daydirectory . $filename))
			   {
				   $errnum = 1;
				   echo $errnum;
			   }
			   else
			   {
				   move_uploaded_file($uploadedfile[$key]['tmp_name'],$daydirectory . $filename);
				   $data = array("path"=>$path . $filename,
				                  "name"=>$filename,
				                  "size"=>$uploadedfile[$key]['size'],
				                  "createddate"=>$db->now(),
				                  "owner"=>15,
				                  "mimetype"=>$uploadedfile[$key]['type']
				                 );
				   $id = $db->insert('bb_mime',$data);
				   if ($id)
				   {
					   echo $id;
				   }
				   else
				   {
					   echo "error";
				   }
			   }
		   }
		   else
		   {
			   $pdf=true;
			   $filename = stripslashes($uploadedfile[$key]['name']);
			   if (file_exists($daydirectory . $filename))
			   {
				   $errnum = 1;
				   echo $errnum;
			   }
			   else
			   {
				   move_uploaded_file($uploadedfile[$key]['tmp_name'],$daydirectory . $filename);
				   echo $daydirectory . $filename;
			   }
		   }	   
		}
 }
 
 
?>
