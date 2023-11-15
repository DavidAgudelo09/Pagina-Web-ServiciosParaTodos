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
$stmt = $con->prepare('SELECT email, name, lastname, phonenumber, birthdate FROM users WHERE id = ?');
// In this case we can use the account ID to get the account info.
$id=$_SESSION['id'];
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result( $email, $name,$lastname,$phonenumber,$birthdate);
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
            <a href="home.php" class="logo">Servicios<span>Para</span>Todos</a>
            <nav class="navtop">
			<div>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Perfil</a>
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
						<td>Fecha de Nacimiento:</td>
						<td><?=$birthdate?></td>
					</tr>

					<tr>
						<td><a href="update_user.php?id=<?php echo $id?>">Actualizar</a></td>

					</tr>

					
				</table>
			</div>
		</div>
	</body>
</html>