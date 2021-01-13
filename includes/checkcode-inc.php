    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <style>
        #main-content {
            margin-top:20px;
        }
        .footer {
            font-size: 14px;
            text-align: center;
        }
        </style>
        </head>
        <body>
        <?php include("design-top.php");?>       
<?php

require_once 'db_config.php';
include 'functions.php';

if(isset($_POST["submitCode"])){
    $code = $_POST["deliveryCode"];

    $row = checkCode($conn, $code);
    if($row !== false){

        $data = readUser($conn, $row["courierId"]);
        $courier = mysqli_fetch_assoc($data);
        
?>

<div class="container" id="main-content">

    <div class="warper">
        <?php

        $i = 1;
        $addressData = readOneAddress($conn, $row["userAddressId"]);
        $data = mysqli_fetch_assoc($addressData);
        ?>
        <table class='table table-bordered table-striped table-sm'>
            <thead>
                <tr>
                    <th>Courier Name</th>
                    <th>Country</th>
                    <th>Region</th>
                    <th>City</th>
                    <th>Street</th>
                    <th>Client's street</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td><?php echo $courier["name"] ?></td>
                    <td><?php echo $data["country"]; ?></td>
                    <td><?php echo $data["region"]; ?></td>
                    <td><?php echo $data["city"]; ?></td>
                    <td><?php echo $data["street"]; ?></td>
                    <td><?php echo $row["clientStreet"]; ?></td>
                </tr>
            </tbody>

            <thead>
                    <tr>
                        <th>Code</th>
                        <th>Client's Name</th>
                        <th>Client's Phone</th>
                        <th>Client's Email</th>
                        <th>Date</th>
                        <th>Package Weight</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td><?php echo $row["code"]; ?></td>
                        <td><?php echo $row["clientName"]; ?></td>
                        <td><?php echo "0" . $row["clientPhone"]; ?></td>
                        <td><?php echo $row["clientEmail"]; ?></td>
                        <td><?php echo $row["date"]; ?></td>
                        <td><?php echo $row["weight"]; ?></td>
                    </tr>
                </tbody>

        </table>
    </div>

    <br>
    <div class="d-flex justify-content-center">
        <form>
            <input type="hidden" name="code" value= <?php echo $code;?>> 
		    <input type="submit" class="btn btn-primary" formaction="../index.php" value="Go Home">
            <input type="submit" class="btn btn-secondary" formaction="../pdf.php" formmethod="POST" value="Invoice">
        </form>
	</div>
    <br>
</div>

<?php 
} else{
    header("location: ../index.php?error=nocode");
    exit;
}
}
?>

<?php include("footer.php");?>

</body>
</html>


