<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $lastname= $phonenumber = $email = $password = $birthdate = "";
$name_err = $lastname_err = $phonenumber_err = $email_err = $password_err = $birthdate_err ="";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
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
        $nwpassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
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
        // Prepare an update statement
        $sql = "UPDATE users SET name=?, lastname=?, phonenumber=?, email=?, password=?, birthdate=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_name, $param_lastname, $param_phonenumber, $param_email, $param_password, $param_birthdate, $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_lastname = $lastname;
            $param_phonenumber = $phonenumber;
            $param_email = $email;
            $param_password = $nwpassword;
            $param_birthdate = $birthdate;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: profile.php");
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["name"];
                    $lastname = $row["lastname"];
                    $phonenumber = $row["phonenumber"];
                    $email = $row["email"];
                    $password = $row["password"];
                    $birthdate = $row["birthdate"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
			<h1>Actualizar</h1>
            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

                <label for="name">
					<i class="fas fa-user"></i>
				</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>

                <label for="lastname">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>">
                     <span class="invalid-feedback"><?php echo $lastname_err;?></span>


				<label for="phonenumber">
					<i class="fas fa-phone"></i>
				</label>
				<input type="text" name="phonenumber" class="form-control <?php echo (!empty($phonenumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phonenumber; ?>">
                            <span class="invalid-feedback"><?php echo $phonenumber_err;?></span>


                <label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" readonly>
                            <span class="invalid-feedback"><?php echo $email_err;?></span>


				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>



                <label for="birthdate" class="birthdate-menu"> Fecha de nacimiento:
					<i class="fas fa-cake"></i>
				</label>
                <input type="date" name="birthdate" class="form-control <?php echo (!empty($birthdate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $birthdate; ?>">
                            <span class="invalid-feedback"><?php echo $birthdate_err;?></span>

                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="profile.php" class="btn btn-secondary ml-2">Cancel</a>
			</form>
		</div>
</body>
</html>