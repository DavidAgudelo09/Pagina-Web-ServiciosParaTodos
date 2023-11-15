<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'mainbase';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$id = $_GET['id'];
// We don't have the password or email info stored in sessions, so instead, we can get the results from the database.
$stmt = $con->prepare('SELECT name, lastname, phonenumber, email, password, service_type, company_name, service_name, personal_descripcion FROM providers WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_GET['id']);
$stmt->execute();
$stmt->bind_result( $name, $lastname, $phonenumber, $email, $password, $service_type, $company_name, $service_name, $personal_descripcion);
$stmt->fetch();
$stmt->close();

$responses = [];
// Check if the form was submitted
if (isset($_POST['email'], $_POST['subject'], $_POST['name'], $_POST['msg'])) {
	// Validate email adress
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$responses[] = 'Email is not valid!';
	}
	// Make sure the form fields are not empty
	if (empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['name']) || empty($_POST['msg'])) {
		$responses[] = 'Please complete all fields!';
	} 
	// If there are no errors
	if (!$responses) {
		// Where to send the mail? It should be your email address
		$to  = $email;
		// Send mail from which email address?
		$from = 'noreply@example.com';
		// Mail subject
		$subject = $_POST['subject'];
		// Mail message
		$message = $_POST['msg'];
		// Mail headers
		$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $_POST['email'] . "\r\n" . 'X-Mailer: PHP/' . phpversion();
		// Try to send the mail
		if (mail($to, $subject, $message, $headers)) {
			// Success
			$responses[] = 'Message sent!';		
		} else {
			// Fail
			$responses[] = 'Message could not be sent! Please check your mail server settings!';
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SERVICIOS A TU MANO</title>

<!--CSS-->
<link rel="stylesheet" href="css/style_service.css">

<!--Icons-->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <!---->
    <!--Header-->
    <header>
        <!--Nav-->
        <div class="nav container">
            <!--Logo-->
            <a href="index.php" class="logo">Servicios<span>Para</span>Todos</a>
             
            <!--Loginbtn-->
            <a href="login.html" class="login">Login</a>
        </div>    
   
    </header>
    <section class="home" id="home">
        <!--Home-->
        <div class="home-text container">
            <h2 class="home-title">Servicios</h2>
            <span class="home-subtitle">Encuentre aqui todos sus servicios </span>
        </div>
    </section>
  <!--Post content-->
    <section class="post-header">
        <div class="header-content post-container ">
            <!--back to home-->
            <a href="index.php" class="back-home">Back to home</a>
            <!--Title-->
            <h1 class="header-title"><?=$company_name?></h1>
             <!--Post Image-->
             <img src="images/<?=$email?>.jpg" alt="" class="header-img">

        </div>

    </section>
   
    <!--Posts-->

    <section class="post-content post-container">
        <h2 class="sub-heading"><?=$service_name?></h2>
        <p class="post-text"><?=$personal_descripcion?></p>
        <h3>Ingrese para ver disponibilidad</h3>

               
         
        <form class="contact" method="post" action="">
			<h1>Contactenos</h1>
			<div class="fields">
				<label for="email">
					<i class="fas fa-envelope"></i>
					<input id="email" type="email" name="email" placeholder="Tu correo" required>
				</label>
				<label for="name">
					<i class="fas fa-user"></i>
					<input type="text" name="name" placeholder="Tu nombre" required>
				<label>
				<input type="text" name="subject" placeholder="Asunto" required>
				<textarea name="msg" placeholder="Mensaje" required></textarea>
			</div>
            <?php if ($responses): ?>
            <p class="responses"><?php echo implode('<br>', $responses); ?></p>
            <?php endif; ?>
			<input type="submit">
		</form>

    </section>
   <!--footer-->
   <div class="footer container">
        <p>&#169; David*David All Rights Reserverd</p>
        <div class="social">
            <a href="#"><i class='bx bxl-facebook' ></i></a>
            <a href="#"><i class='bx bxl-instagram-alt' ></i></a>
            <a href="#"><i class='bx bxl-twitter' ></i></a>
        </div>
   </div>




<!--link Jquery-->
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>

<!--link javascript-->
<script src="js/main.js"></script>


</body>
</html>
