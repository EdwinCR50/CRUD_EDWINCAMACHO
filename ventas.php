 <?php
 session_start();
 ob_start(); //Para manejar la salida antes de los encabezados
 include 'conexion.php';
 
 //Verificacion de sesión
 if(!isset($_SESSION['username'])){
	 header("Location: login.php");
	 exit();
 }
 
 //Manejo de acciones de formulario 
 if($_SERVER["REQUEST_METHOD"] == "POST")  {
	 $action = $_POST['action'];
	 
	 if ($action == 'agregar')  {
		 $producto = $_POST['producto'];
		 $cantidad = $_POST['cantidad'];
		 $precio = $_POST['precio'];
		 
		 $stmt = $conn ->prepare("INSERT INTO ventas (producto, cantidad, precio) VALUES (?, ?, ?)"); //hace la insercción del registro en la base de datos 
		 $stmt->bind_param("sid", $producto, $cantidad, $precio);
		 
		 if ($stmt->execute()) {
			  echo '<script>alert("REGISTRO GUARDADO");</script>';
			 echo "<script>window.location.href='ventas.php';</script>";
			 exit();
		 } else {
			 echo "Error al agregar la venta: " . $conn->error;
		 }
		 
		 //Para esta acción se va a hacer una interacción con el formulario y si al llenar los campos se cumple se va añadir a la base de datos y se va a visualizar en la tabla, además de mostrar una alerta que el registro fue guardado, de lo contrario marcará un error al agregar la venta
		 
		 $stmt->close();
		 
	 }elseif ($action == 'modificar') {
		 $id = $_POST ['id'];
		 $producto = $_POST ['producto'];
		  $cantidad = $_POST['cantidad'];
		 $precio = $_POST['precio'];
		 
		  $stmt = $conn ->prepare("UPDATE ventas SET producto=?, cantidad=?, precio=? WHERE id=?"); //actualiza el registro en la base de datos
		 $stmt->bind_param("sidi", $producto, $cantidad, $precio, $id);
		 
		 if ($stmt->execute()) {
			  echo '<script>alert("REGISTRO MODIFICADO");</script>';
			 echo "<script>window.location.href='ventas.php';</script>";
			 exit();
		} else {
			 echo "Error al modificar la venta: " . $conn->error;
		 }
		 
		 		 //Para esta acción se va a hacer una interacción con la tabla y si al pulsar el boton de modificar, mostrará una alerta que se modifico el registro y si no se cumple la condición mandará un error al modificar.

		 
		 $stmt->close();
		}elseif ($action == 'eliminar') {
		 $id = $_POST ['id'];
		 
		  $stmt = $conn ->prepare("DELETE FROM ventas WHERE id=?"); //elimina el registro en la base de datos
		 $stmt->bind_param("i", $id);
		 
		  if ($stmt->execute()) {
			   echo '<script>alert("REGISTRO ELIMINADO");</script>';
			 echo "<script>window.location.href='ventas.php';</script>";
			 exit();
		} else {
			 echo "Error al eliminar la venta: " . $conn->error;
		 }
		 
		 //Para esta acción se va a hacer una interacción con la tabla y si al pulsar el boton de eliminar,  se mostrará una alerta que se eliminó el registro y si no se cumple la condición mandará un error al eliminar.
		 
		  $stmt->close();
		}
 }
 
 //Consulta para mostrar todas las ventas
 $result = $conn->query("SELECT * FROM ventas");
 ?>
 
 <!DOCTYPE html>
 <html lang="es">
 <head>
 	<meta charset="UTF-8">
    <title>Sistema de ventas</title>
    <!-- A partir de aquí se hace todo el diseño de la página ventas  -->
    <style>
        
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9; 
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
		 input[name="producto"] {
            width: 150px;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd; 
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            background-color: #f7f7f7; 
    }
	
	 input[name="cantidad"] {
            width: 50px;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd; 
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            background-color: #f7f7f7; 
    }
	
	input[name="precio"] {
            width: 100px;
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
			text-justify:center;
            width: 110px;
			height: 55px;
            padding: 9px;
            background-color: #4CAF50;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 2px;
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
 	<h2>ABARROTERIA "CAMACHO"</h2>
 	<h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
    
    <!--Formulario para agregar una venta -->
    <form method="post" action="ventas.php">
    	<input type="hidden" name="action" value="agregar">
        Producto: <input type="text" name="producto" required>
        <br>
        Cantidad: <input type="number" name="cantidad" required>
        Precio: <input type="number" step="0.01" name="precio" required>
        <button type="submit">Agregar Venta</button>
        </form>
        <br>
        <br>
        
        <p>
          <!-- Tabla para mostrar ventas y fromularios para modificar/eliminar -->
        </p>
        <table border="1">
        <tr>
        	<th>ID</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
        	<form method="POST" action="ventas.php">
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><input type="text" name="producto" value="<?php echo htmlspecialchars($row['producto']); ?>" required> </td>
            <td><input type="number" name="cantidad" value="<?php echo htmlspecialchars($row['cantidad']); ?>" required> </td>
              <td><input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($row['precio']); ?>" required> </td>
              <td><?php echo htmlspecialchars($row['fecha']); ?></td>
              <td>
                  <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                  <button type="submit" name="action" value="modificar">Modificar</button>
                   <button type="submit" name="action" value="eliminar">Eliminar</button>
                   </td>
              </form>
            </tr>
            <?php endwhile; ?>
            </table>
            
            <a href="login.php">Cerrar Sesión</a>
</body>
</html>
                  
                  
              
            
            
        
    
    
		 
		 
			 
		 
			 