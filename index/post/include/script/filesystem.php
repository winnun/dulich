<?php
/*
 * function check file permission
 * Input: path to the file need to check
 * Output: array(
	"file_mode",
	"sut" => array("sid","gid","t"),
	"owner" => array("r","w","x"),
	"group" => array("r","w","x"),
	"other" => array("r","w","x")
	)
 */
 function getfilepermission($path)
{
	$arrperm = array(
	"file_mode",
	"sut" => array("sid","gid","t"),
	"owner" => array("r","w","x"),
	"group" => array("r","w","x"),
	"other" => array("r","w","x")
	);
	
	$perm = fileperms($path);
	
	/*
	 * check file type
	 */
	$var = ($perm & 0170000);
	if ($var == 0140000) {
		//socket
		$arrperm["file_mode"] = 's';
	}
	elseif ($var == 0120000) {
		//symbol link
		$arrperm["file_mode"] = 'l';
	}
	elseif($var == 0100000) {
		//regular file
		$arrperm["file_mode"] = '-';
	}
	elseif($var == 0060000) {
		//block device
		$arrperm["file_mode"] = 'b';
	}
	elseif($var == 0040000) {
		//deirectory 
		$arrperm["file_mode"] = 'd';
	}
	elseif($var == 0020000) {
		//character device
		$arrperm["file_mode"] = 'c';
	}
	elseif($var == 0010000) {
		//FIFO
		$arrperm["file_mode"] = 'f';
	}
	
	else {
		//unspecified
		$arrperm["file_mode"] = 'u';
	}
	
	/*
	 * check sid, gid, sticky bit
	 */
	if($perm & 0004000) {
		//set uid
		$arrperm["sut"]["sid"] = 4;
	}
	else $arrperm["sut"]["sid"] = 0;
	if($perm & 0002000) {
		//set gid
		$arrperm["sut"]["gid"] = 2;
	}
	else $arrperm["sut"]["gid"] = 0;
	if($perm & 0001000) {
		//sticky bit
		$arrperm["sut"]["t"] = 1;
	}
	else $arrperm["sut"]["t"] = 0;
	
	/*
	 * owner
	 */
	 if($perm & 0000400) {
		 //owner read
		 $arrperm["owner"]["r"] = 4 ;
	 }
	 else $arrperm["owner"]["r"] = 0 ;
	 if ($perm & 0000200) {
		 //owner write
		 $arrperm["owner"]["w"] = 2;
	 }
	 else $arrperm["owner"]["w"] = 0;
	 if ($perm & 0000100) {
		 //owner excute
		 $arrperm["owner"]["x"] = 1;
	 }
	 else $arrperm["owner"]["x"] = 0;
	 
	 /*
	  * group owner
	  */
	  if($perm & 0000040) {
		 //group owner read
		 $arrperm["group"]["r"] = 4 ;
	  }
	  else $arrperm["group"]["r"] = 0 ;
	  if ($perm & 0000020) {
		 //group owner write
		 $arrperm["group"]["w"] = 2;
	  }
	  else $arrperm["group"]["w"] = 0;
	  if ($perm & 0000010) {
		 //group owner excute
		 $arrperm["group"]["x"] = 1;
	  }
	  else $arrperm["group"]["x"] = 0;
	  
	  /*
	   * other
	   */
	  if($perm & 0000004) {
		 //other read
		 $arrperm["other"]["r"] = 4 ;
	  }
	  else $arrperm["other"]["r"] = 0 ;
	  if ($perm & 0000002) {
		 //other write
		 $arrperm["other"]["w"] = 2;
	  }
	  else $arrperm["other"]["w"] = 0;
	  if ($perm & 0000001) {
		 //other excute
		 $arrperm["other"]["x"] = 1;
	  }
	  else $arrperm["other"]["x"] = 0;
	  
	  return $arrperm;	
}

/*
 * 
 * check whether upload directories exists, create if not
 * 
 */
function createfolderupload($ABSPATH, $uploaddirectory)
{
	
	$yeardirectory = $uploaddirectory . date("Y"). '/';
	$monthdirectory = $yeardirectory . date("m") . '/';
	$daydirectory = $monthdirectory . date("d") . '/';
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
						  if (!mkdir($daydirectory, 0777, true))
						     echo "Don't have wrire permission to creat" . $monthdirectory;
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
					  if (!mkdir($daydirectory, 0777, true))
					     echo "Don't have wrire permission to creat" . $yeardirectory;
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
				  if (!mkdir($daydirectory, 0777, true))
				    echo "Don't have wrire permission to creat" . $uploaddirectory;
			  }
			  else echo "Don't have wrire permission to creat" . $uploaddirectory;
		  }
	  }
	  //does not exists $uploaddirectory
	 else
	 {
		 $arrresult = getfilepermission($ABSPATH);
		 if  ($arrresult["owner"]["w"] = 2 ) 
		 {
			 if (!mkdir($daydirectory, 0777, true))
			   echo "Don't have wrire permission to creat" . $uploaddirectory;     
		 }
		 else echo "Don't have wrire permission to creat" . $ABSPATH;
	 }
}
?>

