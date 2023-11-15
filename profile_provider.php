<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'mainbase';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions, so instead, we can get the results from the database.
$stmt = $con->prepare('SELECT name, lastname, phonenumber, email, password, service_type, company_name, service_name, personal_descripcion FROM providers WHERE id = ?');
// In this case we can use the account ID to get the account info.
$id=$_SESSION['id'];
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result( $name, $lastname, $phonenumber, $email, $password, $service_type, $company_name, $service_name, $personal_descripcion);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="css/style_profile.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">


	<header>
        <!--Nav-->
        <div class="nav container">
            <!--Logo-->
            <a href="#" class="logo">Servicios<span>Para</span>Todos</a>
            <nav class="navtop">
			<div>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
        </div>    
   
    </header>

		<div class="content">
			<h2>Profile Page</h2>
			<div>
				<h2>Detalles de tu Cuenta:</h2>
				<table>
					<tr>
						<td>Nombre:</td>
						<td><?=$name?></td>
					</tr>
					<tr>
						<td>Apellido:</td>
						<td><?=$lastname?></td>
					</tr>
					<tr>
						<td>Telefono:</td>
						<td><?=$phonenumber?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$email?></td>
					</tr>
					
					<tr>
						<td>Tipo de Servicio:</td>
						<td><?=$service_type?></td>
					</tr>

					
					<tr>
						<td>Nombre de Empresa:</td>
						<td><?=$company_name?></td>
					</tr>
					
					<tr>
						<td>Nombre de Servicio:</td>
						<td><?=$service_name?></td>
					</tr>
					
					<tr>
						<td>Description Personal:</td>
						<td><?=$personal_descripcion?></td>
					</tr>

					
					<tr>
						<td><a href="update_provider.php?id=<?php echo $id?>">Actualizar Datos</a></td>
						<td><a href="pictureForm.php?email=<?php echo $email?>">Photo</a></td>

					</tr>

					<tr>

						<td>Connectate a Leadmonk</td>
						<td><a href="https://www.leadmonk.io/" target="_blank"><img src="images/leadmonk.png" height="50" width="50"></a> </td>
					</tr>
					<tr>
					<td>Calendario</td>
					</tr>
					<tr>
				
					</tr>
					
				</table>
				<?php
					$can = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
					$changelink='<a href='.'"update_calender.php?email='.$email.'">Cambiar Calendario</a>';

					if (mysqli_connect_errno()) {
						exit('Failed to connect to MySQL: ' . mysqli_connect_error());
					}

					$ctmt = $can->prepare('SELECT link FROM calender WHERE email = ?');

					$ctmt->bind_param('s', $email);
					$ctmt->execute();
					$ctmt->bind_result( $link);
					$ctmt->fetch();
					$ctmt->close();
					if(is_null($link)){
						
						echo '<a href='.'"create_calender.php?email='.$email.'">Crear Calendario</a>';
					}
					else{
					echo $link;
					echo '<a href='.'"update_calender.php?email='.$email.'">Cambiar Calendario</a>';

					 
					}
					?>
					

			</div>
		</div>
	</body>
</html>