index.php
<?php
	/*
		Web Service RESTful en PHP con MySQL (CRUD)
		Maria Tejena
		Códigos de Programación
	*/
	include 'conexion.php';
	
	$pdo = new Conexion();

	//Listar registros y consultar registro
	if($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		if(isset($_GET['id']))
		{
			$sql = $pdo->prepare("SELECT * FROM usuario WHERE id=:id");
			$sql->bindValue(':id', $_GET['id']);
			$sql->execute();
			$resultado = $sql->fetch(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 hay datos");
			echo json_encode($resultado);
			exit;				
			
			} else {
			
			$sql = $pdo->prepare("SELECT * FROM usuario");
			$sql->execute();
			$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 hay datos");
			echo json_encode($resultado);
			exit;		
		}
	}
	
	//Insertar registro
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$sql = "INSERT INTO usuario (nombre, apellido, correo) VALUES(:nombre, :apellido, :correo)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':nombre', $_POST['nombre']);
		$stmt->bindValue(':apellido', $_POST['apellido']);
		$stmt->bindValue(':correo', $_POST['correo']);
		$stmt->execute();
		$idPost = $pdo->lastInsertId(); 
		if($idPost)
		{
			header("HTTP/1.1 200 Ok");
			echo json_encode(array("id" => $idPost));
			exit;
		}
	}
	
	//Actualizar registro
	if($_SERVER['REQUEST_METHOD'] == 'PUT')
	{		
		$sql = "UPDATE usuario SET nombre=:nombre, apellido=:apellido, correo=:correo WHERE id=:id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':nombre', $_GET['nombre']);
		$stmt->bindValue(':apellido', $_GET['apellido']);
		$stmt->bindValue(':correo', $_GET['correo']);
		$stmt->bindValue(':id', $_GET['id']);
		$stmt->execute();
		header("HTTP/1.1 200 Ok");
		exit;
	}
	
	//Eliminar registro
	if($_SERVER['REQUEST_METHOD'] == 'DELETE')
	{
		$sql = "DELETE FROM usuario WHERE id=:id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id', $_GET['id']);
		$stmt->execute();
		header("HTTP/1.1 200 Ok");
		exit;
	}
	
	//Si no corresponde a ninguna opción anterior
	header("HTTP/1.1 400 Bad Request");


	//Consulta
	$sql = $pdo->prepare("SELECT * FROM usuario");
	$sql->execute();
	$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

