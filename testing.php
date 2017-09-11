<?php
error_reporting( E_ALL );

include('Db.class.php');

$db = Db::get();
if (isset($db))
{
    echo 'Success';
}
echo $db::errorInfo();




?>