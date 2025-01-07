<?php
$servername="localhost"; //Nombre del servidor 
$username="root"; //Nombre de usuario
$password=""; //Contraseña
$dbname="sistema_ventas"; //Nombre de la base de datos

//Linea de codigo que sirve para crear la conexión
$conn=new mysqli($servername, $username, $password, $dbname);

//Linea de codigo para verficar la conexión
if($conn->connect_error){
	die("Conexion Fallida: " . $conn->connect_error);
}
?>

