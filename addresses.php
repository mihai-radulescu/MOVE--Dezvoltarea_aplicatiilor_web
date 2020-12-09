<?php
    include("includes/a_config.php");
?>

<!DOCTYPE html>
<html>
<head>

    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>

	<?php include("includes/head-tag-contents.php");?>
</head>
<body>

<?php include("includes/design-top.php");?>
<?php include("includes/navigation.php");?>

<div class="container" id="main-content">

<br>
<div class="d-flex justify-content-center">
    <a class="btn btn-success btn-lg btn-block" href="address-form.php" >+ Add an address</a>
</div>
<br>

<div class="warper">
<?php
    include("includes/functions.php");

    $i = 1;
    $result = readAddresses($conn, $_SESSION["userid"]); 
    while($row = mysqli_fetch_assoc($result)){
        ?>
            <table class='table table-bordered table-striped table-sm'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Country</th>
                        <th>Region</th>
                        <th>City</th>
                        <th>Street</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $row["country"];?></td>
                        <td><?php echo $row["region"];?></td>
                        <td><?php echo $row["city"];?></td>
                        <td><?php echo $row["street"];?></td>
                        <td>
                        <?php
                            if(!isset($_POST["selectAddress"])){
                        ?>
                        <form method="POST" action="includes/addresses-inc.php">
                            <input type="hidden" name="addressid" value="<?php echo $row["addressId"] ?>">
                            <input type="submit" name="delAddress" value="Delete" class="btn btn-danger">
                            <input type="submit" name="updateAddress" value="Update" class="btn btn-info" formaction="address-form.php">
                        </form>
                            <?php } else{ ?>
                            <form method="POST" action="order-form.php">
                                <input type="hidden" name="addressid" value="<?php echo $row["addressId"] ?>">
                                <input type="submit" name="selectedAddress" value="Select" class="btn btn-success">
                            </form>
                            <?php } ?>
                        </td>
                    </tr>
                </tbody>
            </table>
    <?php
        $i++;
    }
?>
</div>

<br>

</div>

<?php include("includes/footer.php");?>

</body>
</html>