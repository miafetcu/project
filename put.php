
<?php
    include 'conn.php';
    $conn = OpenCon();
    if(
        isset($_POST['id_houses']) && isset($_POST['id_register'])
        &&
        !empty($_POST['id_houses']) && !empty($_POST['id_register'])
    )
    {
        $insert1= $conn->query(
            "INSERT INTO Relationship (id_register,id_houses) VALUE ( {$_POST['id_register']}, {$_POST['id_houses']} )"
        );
        if(!$insert1)
        {
            echo mysqli_error($conn);
        }
        
    }

    $sql = "SELECT register.* FROM register LEFT JOIN Relationship ON register.id_register = Relationship.id_register WHERE Relationship.id_register is NULL LIMIT 1";

    $result_houses = $conn->query("SELECT * FROM houses");

    if ($result_houses) {
        $result_houses = $result_houses -> fetch_all(MYSQLI_ASSOC);
    }

    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link rel="stylesheet" href="assets/style-put.css">
</head>
<body>
<br>
<?php   // LOOP TILL END OF DATA 
$found = false; 
if ($result) {
    while($row = $result->fetch_assoc()) { $found = true; ?>
        <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
            <div class="card p-4">
                <div class=" image d-flex flex-column justify-content-center align-items-center">
                    <button class="btn">
                        <img src="assets/images/profile.png" height="100" width="100" />
                    </button> 
                    <span class="name mt-3">
                        <?php echo $row['fname'];?> <?php echo $row['lname'];?>'s Profile
                    </span>
                    <br />
                    <span class="idd">
                        <?php echo $row['fname'];?> <?php echo $row['lname'];?>
                    </span>
                    <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                        <span class="idd1">Age:
                            <?php echo $row['age'];?>
                        </span>
                        <span>
                            <i class="fa fa-copy"></i>
                        </span>
                    </div>
                    <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                        <span class="idd1">Gender:
                            <?php echo $row['gender'];?>
                        </span>
                        <span>
                            <i class="fa fa-copy"></i>
                        </span>
                    </div>
                    <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                        <span class="idd1">Description:
                            <?php echo $row['bio'];?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>

        <form action="" method="post" >
            <input type="hidden" name="id_register" value="<?php echo $row['id_register']; ?>">
            <input type="hidden" name="id_houses" value="">
            <?php
                $count_rows = $conn->query("SELECT COUNT(*) as count FROM Relationship")->fetch_all(MYSQLI_ASSOC)[0]['count'] + 0;
                foreach ( $result_houses as $house ) {
                    $count_house = $conn->query("SELECT COUNT(*) as count FROM Relationship WHERE id_houses = ".$house["id_houses"]." ")->fetch_all(MYSQLI_ASSOC)[0]['count'] + 0;
                    ?><button id="button" value="<?php echo $house['id_houses']; ?>">This is a <?php echo htmlspecialchars($house['house']); ?><?php echo $count_rows ? ' - '.floor(100 * $count_house / $count_rows).'%' : ''; ?></button><br><br><?php
                }
            ?>
        </form>
    <?php }
}

if (!$found) {
    $count_rows = $conn->query("SELECT COUNT(*) as count FROM Relationship")->fetch_all(MYSQLI_ASSOC)[0]['count'] + 0;
    if ($count_rows)
    foreach ( $result_houses as $house ) {
        $count_house = $conn->query("SELECT COUNT(*) as count FROM Relationship WHERE id_houses = ".$house["id_houses"]." ")->fetch_all(MYSQLI_ASSOC)[0]['count'] + 0;
        ?><?php echo htmlspecialchars($house['house']); ?> - <?php echo floor(100 * $count_house / $count_rows); ?>%<br><?php
    }
} ?>
<script type="text/javascript">
    Array.prototype.slice.call(
        document.querySelectorAll('form button[value]')
    ).forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            event.stopPropagation();
            insert(button.getAttribute("value"));
        });
    });
    function insert(id_house) {
        document.querySelector('form input[name="id_houses"]').value = id_house;
        document.querySelector('form').submit();
    }
</script>
</body>
</html>
<?php
$conn->close();
?>

