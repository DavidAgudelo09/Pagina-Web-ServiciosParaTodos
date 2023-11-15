<?php
$email=$_GET["email"];
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href="css/style_register.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="register">
  <form action="save-image.php?email=<?php echo $email?>" method="POST" enctype="multipart/form-data">
  <label for="profile_image" class="custom-file-upload">
  <i class="fas fa-cloud-upload"></i> Foto de Perfil
                </label>
    <input type="file" id="profile_image" name="image"/>
    <input type="submit"/>
  </form>
</body>
</html>

				
                 