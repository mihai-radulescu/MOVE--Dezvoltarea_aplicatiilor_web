<?php include("includes/a_config.php");?>
<!DOCTYPE html>
<html>
<head>
	<?php include("includes/head-tag-contents.php");?>
</head>
<body>

<?php include("includes/design-top.php");?>
<?php include("includes/navigation.php");?>

<div class="container" id="main-content">

    <div class="warper">

    <?php 
                include("includes/functions.php");
            
                if(!isset($_POST["selected"])){
                $result  = readCanceled($conn);
                while($row = mysqli_fetch_assoc($result)){
                    $addressData = readOneAddress($conn, $row["userAddressId"]);
                    $data = mysqli_fetch_assoc($addressData);
        ?>

        <table class='table table-bordered table-striped table-sm'>
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Country</th>
                    <th>Region</th>
                    <th>City</th>
                    <th>Street</th>
                    <th>Client's street</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>
                        <form method="POST" action="request.php">
                            <input type="hidden" name="orderid" value="<?php echo $row["orderId"] ?>">
                            <input type="submit" name="selected" value="Select" class="btn btn-success">
                        </form>
                    </td>
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

        <?php
            }
        }
        else {
            $result  = readOneOrder($conn, $_POST["orderid"]);
                $row = mysqli_fetch_assoc($result);
                    $addressData = readOneAddress($conn, $row["userAddressId"]);
                    $data = mysqli_fetch_assoc($addressData);
        ?>

        <table class='table table-bordered table-striped table-sm'>
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Country</th>
                    <th>Region</th>
                    <th>City</th>
                    <th>Street</th>
                    <th>Client's street</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>
                        <form method="POST" action="includes/request-inc.php">
                            <input type="hidden" name="orderid" value="<?php echo $row["orderId"] ?>">
                            <input type="submit" name="cancel" value="Cancel" class="btn btn-danger">
                        </form>
                    </td>
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
        <?php
                }

        ?>

    </div>

    <br>

</div>

<?php include("includes/footer.php");?>

</body>
</html>