<?php

if (isset($_POST['Submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    //Load đối tượng connection
    include_once("config.php");

    // Add bản ghi
    $result = mysqli_query($mysqli, "INSERT INTO student(name,email,mobile) VALUES ('$name','$email','$mobile')");
    // Hiển thị sau khi add thành công
    echo "User added successfully";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
</head>

<body>
    <a href="index.php">Go to home</a>
    <br><br>

    <form action="create.php" method="post" name="form">
        <table width="25%" border=0>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name"></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="email" name="email"></td>
            </tr>
            <tr>
                <td>Mobile</td>
                <td><input type="text" name="mobile"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="Submit" value="Add"></td>
            </tr>
        </table>
    </form>
</body>

</html>