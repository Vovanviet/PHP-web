<?php
// Load đối tượng connection
include_once("config.php");
include("search.php");
// Đọc toàn bộ bản ghi sau đó lưu vào một biến $result
$result = mysqli_query($mysqli, "SELECT * FROM student ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Student Management</title>
</head>

<body>
    <a href="login.php">Login to your account</a>
    <a href="create.php">Add new student</a><br><br>
    <table width="90%" border=1>
        <tr>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Update</th>
        </tr>
        <?php
        //fetch dữ liệu từ $result gán cho thằng $student_data
        while ($student_data = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $student_data['name'] . "</td>";
            echo "<td>" . $student_data['mobile'] . "</td>";
            echo "<td>" . $student_data['email'] . "</td>";
            echo "<td><a href='edit.php?id=$student_data[id]'>Edit</a> |
            <a href='delete.php?id=$student_data[id]'>Delete</a></td></tr>";
        }
        ?>
    </table>

</body>

</html>