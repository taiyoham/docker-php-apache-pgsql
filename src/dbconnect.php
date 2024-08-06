<?php

$db_name = "testdb";
$db_host = "db";
$db_password = "testpass";
$db_user = "testuser";
$con_str = sprintf("dbname=%s host=%s password=%s user=%s", $db_name, $db_host, $db_password, $db_user);

    try {
        $con = pg_connect($con_str);
    } catch (PDOException $e) {
        echo "接続に失敗しました";
        exit;
    }

unset($db_name);
unset($db_host);
unset($db_password);
unset($db_user);
unset($con_str);
?>