<?php include("includes/a_config.php");?>

<!DOCTYPE html>
<html>
<head>
	<?php include("includes/head-tag-contents.php");?>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>

</head>
<body>

<?php include("includes/design-top.php");?>
<?php include("includes/navigation.php");?>

<div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php
            if(isset($_GET["error"])){
                switch($_GET["error"]){
                    case "emptyinput":
                        echo'<i style="color:red">Fill in all fields!</i>';
                        break;
                    case "wronglogin":
                        echo'<i style="color:red">Username or password incorect</i>';
                        break;
                    default:
                        break;
                }
            }
        ?>

        <form action="includes/login-inc.php" method="post">
            <div class="form-group ">
                <label>Username / Email</label>
                <input type="text" name="username" class="form-control">
            </div>    

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control">    
            </div>
           
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
        </form>
    </div> 


<?php include("includes/footer.php");?>

</body>
</html>