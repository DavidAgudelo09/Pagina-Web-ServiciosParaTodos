<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $lastname= $phonenumber = $email = $password = $birthdate = "";
$name_err = $lastname_err = $phonenumber_err = $email_err = $password_err = $birthdate_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate lastname
    $input_lastname = trim($_POST["lastname"]);
    if(empty($input_lastname)){
        $lastname_err = "Please enter a lastname.";
    } elseif(!filter_var($input_lastname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $lastname_err = "Please enter a valid lastname.";
    } else{
        $lastname = $input_lastname;
    }

    // Validate phonenumber
    $input_phonenumber = trim($_POST["phonenumber"]);
    if(empty($input_phonenumber)){
        $phonenumber_Err = "Please enter an phonenumber.";     
    } else{
        $phonenumber = $input_phonenumber;
    }

    // Validate Email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an email.";     
    } else{
        $email = $input_email;
    }

    // Validate Passowrd
    $input_password = trim($_POST["password"]);
    if(empty($input_password)){
        $password_err = "Please enter an password.";     
    } else{
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }
    
    // Validate birthdate
    $input_birthdate = trim($_POST["birthdate"]);
    if(empty($input_birthdate)){
        $birthdate_err = "Please enter an birthdate.";     
    } else{
        $birthdate = $input_birthdate;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($lastname_err) && empty($phonenumber_err) && empty($email_err) && empty($password_err) && empty($birthdate_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO users (name, lastname, phonenumber, email, password, birthdate) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_name, $param_lastname, $param_phonenumber, $param_email, $param_password, $param_birthdate);
            
            // Set parameters
            $param_name = $name;
            $param_lastname = $lastname;
            $param_phonenumber = $phonenumber;
            $param_email = $email;
            $param_password = $password;
            $param_birthdate = $birthdate;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href="css/style_register.css" rel="stylesheet" type="text/css">

</head>
<body>

<header>
            <!--Nav-->
            <div class="nav container">
                <!--Logo-->
                <a href="#" class="logo">Servicios<span>Para</span>Todos</a>
               
            </div>    
       
        </header>
   

    <div class="register">
			<h1>Registrar</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <label for="name">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" placeholder="Nombre">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>


                <label for="lastname">
					<i class="fas fa-user"></i>
				</label>
                <input type="text" name="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>"value="<?php echo $lastname; ?>"placeholder="Apellido">
                            <span class="invalid-feedback"><?php echo $lastname_err;?></span>


				<label for="phonenumber">
					<i class="fas fa-phone"></i>
				</label>
                <input type="text" name="phonenumber" class="form-control <?php echo (!empty($phonenumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phonenumber; ?>" placeholder="Telefono">
                            <span class="invalid-feedback"><?php echo $phonenumber_err;?></span>


                <label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="Correo">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>


				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" placeholder="Contraseña">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>


            
                <label for="birthdate" class="birthdate-menu"> Fecha de nacimiento:
					<i class="fas fa-cake"></i>
				</label>
                <input type="date" name="birthdate" class="form-control <?php echo (!empty($birthdate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $birthdate; ?>">
                            <span class="invalid-feedback"><?php echo $birthdate_err;?></span>

                <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="choose_user.html" class="btn btn-secondary ml-2">Cancel</a>
			</form>
		</div>
</body>
</html>