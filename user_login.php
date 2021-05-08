<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CleaningServices</title>

    <link type="text/css" rel="stylesheet" href="bootstrap-4.3.1/css/style.css"/>
    <link type="text/css" rel="stylesheet" href="bootstrap-4.3.1/css/bootstrap.css"/>
    <link type="text/css" rel="stylesheet" href="bootstrap-4.3.1/js/bootstrap.bundle"/>
    <link type="text/css" rel="stylesheet" href="bootstrap-4.3.1/js/bootstrap.js.map"/>
    
    <!-- fontawesome icon -->
    <link type="text/css" rel="stylesheet" href="fontawesome-free-5.8.1-web\css\all.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> 

</head>
<body>

    <!--------password show and hide ----->
    <script>
         function showpw() {
             var pw = document.getElementById('showpw');
             if (pw.type == "text")
                 pw.type = "password";
             else
                 pw.type = "text";
         }
     </script>
     <!------------------->
        
     <?php
         require('server.php');
         $fname="";
         $lname="";
         $phone="";
         $email="";
         $pass="";
         $errors = array();

         if(isset($_POST['button-VoterRegister'])) {
             $fname=mysqli_real_escape_string($conn,$_POST['f_name']);
             $lname=mysqli_real_escape_string($conn,$_POST['l_name']);
             $phone=mysqli_real_escape_string($conn,$_POST['phone']);
             $email=mysqli_real_escape_string($conn,$_POST['email']);
             $pass=mysqli_real_escape_string($conn,$_POST['password']);
             $pass2=mysqli_real_escape_string($conn,$_POST['cpassword']);

             if($pass!=$pass2){
                array_push($errors, "The two passwords do not match");
             }

            $user_check_query = "SELECT * FROM tbl_user WHERE email='$email' LIMIT 1";
            $result = mysqli_query($conn, $user_check_query);
            $user = mysqli_fetch_assoc($result);

            if ($user) { // if user exists            
                if ($user['email'] === $email) {
                  array_push($errors, "email already exists");
                }
              }

              if (count($errors) == 0) {
                $password = md5($password_1);//encrypt the password before saving in the database
          
                $query = "INSERT INTO tbl_user (first_name,last_name,phone, email, password) 
                          VALUES('$fname','$lname','$phone', '$email', '$password')";
                mysqli_query($conn, $query);
                $_SESSION['email'] = $email;
                $_SESSION['success'] = "You are now logged in";
                header('location: home.php');
            }

         }

         //for login

         if(isset($_POST['login'])){
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($dconn, $_POST['password']);

            // if (empty($email)) {
            //     array_push($errors, "email is required");
            // }
            // if (empty($password)) {
            //     array_push($errors, "Password is required");
            // }

            if (count($errors) == 0) {
                $password = md5($password);
                $query = "SELECT * FROM tbl_user WHERE email='$email' AND password='$password'";
                $results = mysqli_query($conn, $query);
                if (mysqli_num_rows($results) == 1) {
                $_SESSION['email'] = $email;
                $_SESSION['success'] = "You are now logged in";
                header('location: home.php');
                }else {
                    array_push($errors, "Wrong email/password combination");
                }
            }

         }

     
     ?>
         
     <!-- <img class="login-body" src="image/background.png"> -->
    
     <div class="login-box">   
         <img src=images/l2.png> 
         <form method="POST" action="">
         <div class="text-box">
             <i class="far fa-envelope"></i>
             <input type="email" placeholder="Email" name="email" required>
         </div>
         <div class="text-box">
             <i class="fas fa-lock"></i>
             <input type="password" placeholder="password" name="password" id="showpw" required />
             <a onclick="showpw();"><i class="fa fa-eye"></i></a>
         </div>
 
         <input class="btn1" class="btn" type="submit" name="login" value="LOGIN">
         
         <hr><a href="#Vregister" data-target="#Vregister" data-toggle="modal">Sign Up For New Account</a></hr>
         <a href="logout.php">LOGOUT</a><div class="hr-line"></div>
         </form>
     </div>


     <div class="modal fade" id="Vregister">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <h3 class="modal-title">User Sign Up</h3>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                 </div>
                 <div class="modal-body">
                     <form method="POST" action="user_login.php">
                     
                         <div class="form-group voter-register">
                             <i class="fas fa-user-tie icon"></i>
                             <input type="text" id="fname" class="input-field" placeholder="Enter First Name" id="fname" name="f_name" value="<?php echo $fname; ?>" class="form-control">
                         </div>
                         <span id="first-name" class="text-danger"></span>

                         <div class="form-group voter-register">
                             <i class="fas fa-user icon"></i>
                             <input type="text" class="input-field" id="lname" placeholder="Enter Last Name" name="l_name" value="<?php echo $lname; ?>" class="form-control">
                         </div>
                         <span id="last-name" class="text-danger"></span>

                         <div class="form-group voter-register">
                             <i class="fas fa-map-marker-alt icon"></i>
                             <input type="number" class="input-field" id="phone" placeholder="Enter Your Phone Number" name="phone" value="<?php echo $phone; ?>" class="form-control">
                         </div><span id="phone" class="text-danger"></span>

                         <div class="form-group voter-register">
                             <i class="fas fa-envelope icon"></i>
                             <input type="email" class="input-field" id="emails" placeholder="Enter Your Email" name="email" value="<?php echo $email; ?>" class="form-control">
                         </div>
                         <span id="email" class="text-danger"></span>

                         <div class="form-group voter-register">
                             <i class="fas fa-key icon"></i>
                             <input type="password" class="input-field" id="psw" placeholder="Enter Your Password" name="password" value="<?php echo $pass; ?>" class="form-control" />
                         </div>
                         <span id="pass" class="text-danger"></span>

                         <div class="form-group voter-register">
                             <i class="fas fa-key icon"></i>
                             <input type="password" class="input-field" id="cpasword" placeholder="Re-Type Password" name="cpassword" value="" class="form-control">
                         </div>
                         <span id="cpass" class="text-danger"></span>

                         <div class="register-btn">
                             <input type="submit" name="button-VoterRegister" id="submit" value="Register" class="btn btn-outline-light btn-lg bg-primary" onClick="_setAge();">
                         </div>

                         <div class="register-btn" class="modal-footer">
                             <button type="button" class="btn btn-outline-light btn-lg btn-danger" data-dismiss="modal">Cancel</button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
     
     
    
</body>
</html>