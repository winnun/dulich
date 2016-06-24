<?php
function filepermission($path)
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

$basepath = '/etc/passwd'; //for example
$arrresult = array(
	"file_mode",
	"sut" => array("sid","gid","t"),
	"owner" => array("r","w","x"),
	"group" => array("r","w","x"),
	"other" => array("r","w","x")
	);
$arrresult = filepermission($basepath);
echo $arrresult["file_mode"] . ($arrresult["sut"]["sid"] + $arrresult["sut"]["gid"] + $arrresult["sut"]["t"]) 
     . ($arrresult["owner"]["r"] + $arrresult["owner"]["w"] + $arrresult["owner"]["x"]) 
     . ($arrresult["group"]["r"] + $arrresult["group"]["w"] + $arrresult["group"]["x"]) 
     . ($arrresult["other"]["r"] + $arrresult["other"]["w"] + $arrresult["other"]["x"]);
echo '<br>' . sprintf("%o",fileperms($basepath));

?>
