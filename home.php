<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  
  
    <link rel="stylesheet" href="css/old_stylee.css">

<!--Icons-->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<!--link Jquery-->
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">

<!--link javascript-->
<script src="js/main.js"></script>
</head>

<body>

 <!--Header-->
 <header>
        <!--Nav-->
        <div class="nav container">
            <!--Logo-->
            <a href="#" class="logo">Servicios<span>Para</span>Todos</a>
            <!--SearchBar-->
            <div class="search-container">
                <form action="/action_page.php">
                  <input type="text" placeholder="Search.." name="search">
                  <button type="submit"><i class='bx bx-search'></i></button>
                </form>
            </div>
            <!--Loginbtn-->
            <div>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Perfil</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
        </div>    
   
    </header>
    <section class="home" id="home">
        <!--Home-->
        <div class="home-text container">
            <h2 class="home-title">Servicios</h2>
            <span class="home-subtitle">Encuentre aqui todos sus servicios </span>
        </div>
    </section>

    <div class="post-filter container">
        <span class="filter-item active-filter" data-filter='all'>Todo</span>
        <span class="filter-item" data-filter='Educacion'>Educacion</span>
        <span class="filter-item" data-filter='Cultura'>Cultura</span>
        <span class="filter-item" data-filter='Legal'>Legal</span>
        <span class="filter-item" data-filter='Salud'>Salud</span>
        <span class="filter-item" data-filter='Tecnologia'>Tecnologia</span>
        <span class="filter-item" data-filter='Hogar'>Hogar</span>
        <span class="filter-item" data-filter='Mecanica'>Mecanica</span>
        <span class="filter-item" data-filter='Transporte'>Transporte</span>
        <span class="filter-item" data-filter='Eventos'>Eventos</span>
        <span class="filter-item" data-filter='OficiosVarios'>OficiosVarios</span>
    </div>

    <!--Posts-->

   <section class="post container">
   <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM providers";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_array($result)){
                                echo '<div class="post-box '. $row['service_type'].'">';
                                        echo '<img src="images/'. $row['email'].'.jpg" alt="" class="post-img">';
                                        echo '<h2 class="category">'.$row['service_type'].'</h2>';
                                        echo '<a href="service_providers_logged.php?id='.$row['id'].'" class="post-title">';
                                        echo $row['service_name'] ;
                                        echo '</a>';
                                    echo '<p class="post-description">'.$row['personal_descripcion'].'</p>';
                                    echo '';
                                
                                    echo '<!--Profile-->';
                                    echo '<div class="profile">';
                                        echo '<img src="images/'. $row['email'].'.jpg" alt="" class="profile-img">';
                                        echo '<span class="profile-name">'.$row['name'].'</span>';
                                        echo '';
                                    echo '</div>';
                                echo '</div>';
                                }
                             
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
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








   
</body>

</html>