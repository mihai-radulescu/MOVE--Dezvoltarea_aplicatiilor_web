    <?php include("includes/a_config.php");?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <?php include("includes/head-tag-contents.php");?>
        
        <style type="text/css">
            body{ font: 14px sans-serif; }
            .wrapper{ width: 350px; padding: 20px; }
        </style>
    </head>
    <body>
        <?php include("includes/design-top.php");?>

        <div class="wrapper" id="main-content">

            <form action="includes/reset-inc.php" method="post">

                <div class="form-group">
                    <label>Old password</label>
                    <input type="password" name="oldPassword" class="form-control">    
                </div>
            
                <div class="form-group">
                    <label>New password</label>
                    <input type="password" name="password" class="form-control">    
                </div>

                <div class="form-group">
                    <label>Repeate your new password</label>
                    <input type="password" name="repeatePassword" class="form-control">    
                </div>

                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-success" value="Reset your password">
                </div>
            
            </form>

        </div>

        <?php include("includes/footer.php");?>
    </body>
    </html>