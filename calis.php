<?php

/*
$mysqli = mysqli_init();
if (!$mysqli) {
    die('Falló mysqli_init');
}

if (!$mysqli->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
    die('Falló la configuración de MYSQLI_INIT_COMMAND');
}

if (!$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
    die('Falló la configuración de MYSQLI_OPT_CONNECT_TIMEOUT');
}

if (!$mysqli->real_connect('127.0.0.1:5432', 'root', 'canela12', 'Cpremier')) {
    die('Error de conexión (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}

echo 'Éxito... ' . $mysqli->host_info . "\n";

$mysqli->close();*/

/// $conn_string = "host=127.0.0.1 port=5432 dbname=Cpremier user=postgres password=canela12"; //jala


$host="localhost";
$port=4404;
$socket="";
$user="root";
$password="canela12";
$dbname="world";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());


    
?>

