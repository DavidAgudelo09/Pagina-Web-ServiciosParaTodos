<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$calenderlink = "";
$calenderlink_err =  "";

// Processing form data when form is submitted
if(isset($_POST["email"]) && !empty($_POST["email"])){
    // Get hidden input value
    $email = $_POST["email"];
    
    // Validate link
    $input_calenderlink = trim($_POST["calenderlink"]);
    if(empty($input_calenderlink)){
        $calenderlink_err = "Please enter a link.";
    } else{
        $calenderlink = $input_calenderlink;
    }
    
   
    
    // Check input errors before inserting in database
    if(empty($calenderlink_err)){
        // Prepare an update statement
        $sql = "UPDATE calender SET link=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_calenderlink);
            
            // Set parameters
            $param_calenderlink = $calenderlink;
                    
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: profile_provider.php");
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
}    else{
    // Check existence of id parameter before processing further
    if(isset($_GET["email"]) && !empty(trim($_GET["email"]))){
        // Get URL parameter
        $email =  trim($_GET["email"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM calender WHERE email = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $calenderlink = $row["link"];

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
    <div class="nav container">
                <!--Logo-->
                <a href="#" class="logo">Servicios<span>Para</span>Todos</a>
               
    </div> 
</header>
<div class="register">
			<h1>Actualizar</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <label for="calenderlink">
					<i class="fas fa-calendar"></i>
				</label>
				<input type="text" name="calenderlink" class="form-control <?php echo (!empty($calenderlink_err)) ? 'is-invalid' : ''; ?>"  placeholder="Link">
                            <span class="invalid-feedback"><?php echo $calenderlink_err;?></span>
              
                <br>

                <input type="hidden" name="email" value="<?php echo $email; ?>"/>
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="profile_provider.php" class="btn btn-secondary ml-2">Cancel</a>
			</form>
		</div>
</body>
</html>