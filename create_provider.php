<?php

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $lastname= $phonenumber = $email = $password = $servicetype = $companyname = $servicename = $personaldescripcion = "";
$name_err = $lastname_err = $phonenumber_err = $email_err = $password_err = $servicetype_err = $companyname_err = $servicename_err = $personaldescripcion_err = "";

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
    
    // Validate service type
    $input_servicetype = trim($_POST["servicetype"]);
    if(empty($input_servicetype)){
        $servicetype_err = "Please enter an service type.";     
    } else{
        $servicetype = $input_servicetype;
    }
    
    // Validate company name
    $input_companyname = trim($_POST["companyname"]);
    if(empty($input_companyname)){
        $companyname_err = "Please enter an company name.";     
    } else{
        $companyname = $input_companyname;
    }

    // Validate service name
    $input_servicename = trim($_POST["servicename"]);
    if(empty($input_servicename)){
        $servicename_err = "Please enter an service name.";     
    } else{
        $servicename = $input_servicename;
    }

    // Validate personal descripcion
    $input_personaldescripcion = trim($_POST["personaldescripcion"]);
    if(empty($input_personaldescripcion)){
        $personaldescripcion_err = "Please enter an personal descripcion.";     
    } else{
        $personaldescripcion = $input_personaldescripcion;
    }
    

    // Check input errors before inserting in database
    if(empty($name_err) && empty($lastname_err) && empty($phonenumber_err) && empty($email_err) && empty($password_err) && empty($servicetype_err) && empty($companyname_err) && empty($servicename_err) && empty($personaldescripcion_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO providers (name, lastname, phonenumber, email, password, service_type, company_name, service_name, personal_descripcion) VALUES (?, ?, ?, ?, ?, ?, ?, ? ,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssss", $param_name, $param_lastname, $param_phonenumber, $param_email, $param_password, $param_servicetype, $param_companyname, $param_servicename, $param_personaldescripcion);
            
            // Set parameters
            $param_name = $name;
            $param_lastname = $lastname;
            $param_phonenumber = $phonenumber;
            $param_email = $email;
            $param_password = $password;
            $param_servicetype = $servicetype;
            $param_companyname = $companyname;
            $param_servicename = $servicename;
            $param_personaldescripcion = $personaldescripcion;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: pictureForm.php?email=$email");
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
                <input type="text" name="phonenumber" class="form-control <?php echo (!empty($phonenumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phonenumber; ?>"placeholder="Telefono">
                            <span class="invalid-feedback"><?php echo $phonenumber_err;?></span>


                <label for="email">
					<i class="fas fa-envelope"></i>
				</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>"placeholder="Correo">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>

				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>"placeholder="Constraseña">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>


                <label for="servicetype">
					<i class="fas fa-briefcase"></i>
				</label>
                <input list="services" name="servicetype" class="form-control <?php echo (!empty($servicetype_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $servicetype; ?>"placeholder="Tipo de Servicio">
                        <datalist id="services">
                            <option value="Educacion">
                            <option value="Cultura">
                            <option value="Legal">
                            <option value="Salud">
                            <option value="Tecnologia">
                            <option value="Hogar">
                            <option value="Mecanica">
                            <option value="Transporte">
                            <option value="Eventos">
                            <option value="OficiosVarios">
                        </datalist>            
                <span class="invalid-feedback"><?php echo $servicetype_err;?></span>
                  
                <label for="companyname">
					<i class="fas fa-briefcase"></i>
				</label>
				<input type="text" name="companyname" class="form-control <?php echo (!empty($companyname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $companyname; ?>"placeholder="Nombre de Empresa">
                            <span class="invalid-feedback"><?php echo $companyname_err;?></span>


                <label for="service_name">
					<i class="fas fa-briefcase-clock"></i>
				</label>
				<input type="text" name="servicename" class="form-control <?php echo (!empty($servicename_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $servicename; ?>" placeholder="Nombre de Servicio">
                            <span class="invalid-feedback"><?php echo $servicename_err;?></span>


                <textarea name="personaldescripcion" placeholder="Descripcion"class="form-control <?php echo (!empty($personaldescripcion_err)) ? 'is-invalid' : ''; ?>"><?php echo $personaldescripcion; ?></textarea>
                            <span class="invalid-feedback"><?php echo $personaldescripcion_err;?></span>

			
                    
                <br>
                

				<input type="submit" class="btn btn-primary" value="Crear cuenta">
                        <a href="choose_user.html" class="btn btn-secondary ml-2">Cancelar</a>
			</form>
		</div>
</body>
</html>