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

<br>
<div>
    <a class="btn btn-success" href="address-form.php">+ Add an address</a>
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
                        <td>Butoane</td>
                    </tr>
                </tbody>
            </table>
    <?php
        $i++;
    }
?>
</div>

<br>

<?php include("includes/footer.php");?>

</body>
</html>