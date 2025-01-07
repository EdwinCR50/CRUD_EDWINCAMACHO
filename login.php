<?php
session_start();
include 'conexion.php'; //Se necesita para que exista la conexion con la base de datos.

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$username = $_POST ['username'];
	$password = md5($_POST['password']); //Cifrado simple de contraseña con md5 (recomendado usar password_hast en producción)
	
	$sql= "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password'";
	$result = $conn->query($sql); //hace la consulta para verficar si existe ese registro en la base de datos
	
	
	if ($result->num_rows > 0){
		$_SESSION['username'] = $username;
		header("Location: ventas.php"); //Si se cumple la condición redirige a la pagina de ventas
		exit();
		} else {
			 echo '<script>alert("NOMBRE DE USUARIO O CONTRASEÑA INCORRECTA");</script>';
			 echo "<script>window.location.href='login.php';</script>"; //Si no se cumple la condicion mandara una alerta de usuario y contraseña incorrecta y redirige a la misma pagina de login
			}
	}
	?>
    
	
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login</title>
<!-- A partir de aquí se hace todo el diseño ´para el login  -->
<style>   
     
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333333; 
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #666666; 
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd; 
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            background-color: #f7f7f7; 
        }

        input:focus {
            border-color: #4CAF50; 
            background-color: #ffffff; 
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049; 
        }

       
        @media (max-width: 480px) {
            form {
                padding: 20px;
            }

            h2 {
                font-size: 20px;
                margin-bottom: 15px;
            }

            button {
                font-size: 14px;
            }
        }
</style>  
<!-- Aquí termina el diseño -->
</head>
<body>

 <!--Formulario que se muestra en la pagina que va a permitir el acceso o denegar el acceso a la siguiente pagina, por medio de todo el codigo de al principio-->
<h2>INICIAR SESIÓN</h2>
<form method="POST" action="login.php">
<label>Usuario:</label>
<input type="text" name="username" required>
<br>
<label>Contraseña:</label>
<input type="password" name="password" required>
<br>
<button type="submit">Ingresar</button>
</form>
</body>
</html>



