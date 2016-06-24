<?php
require_once(dirname(__FILE__). '/load.php');
require_once (ABSPATH . 'include/script/filesystem.php');
require_once (ABSPATH . 'include/script/config.php');
require_once (ABSPATH . 'include/script/MysqliDb.php');
   
$db = new MysqliDb (DB_HOST, DB_USER, DB_PASS, DB_NAME);
$tbl = $db->get('bb_mime');
$data = array("mimetype" => "image/jpeg"
             );

if ($db->update('bb_mime',$data))
{
	echo 'ok';
	}
	else
	{
		echo 'err';
		};
//~ foreach($data['id'] as $key=>$value)
//~ {
	//~ $db->where($value);
	//~ $db->update('mimetype',$mime);
//~ }
?>
