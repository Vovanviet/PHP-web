<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to index page

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

require_once "config.php";

// Define cariables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($mysqli, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password

                if (mysqli_stmt_num_rows($stmt) === 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, then start a new session
                            session_start();

                            // Store data in session variables

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            header("location: index.php");
                        } else {
                            // Password is invalid
                            $login_err = "Invalid username or password";
                        }
                    }
                } else {
                    // Username doesn't exists
                    $login_err = "Invalid username or password";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later";
            }
            // Close stmt
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($mysqli);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        * {
            margin: 0;
            padding: 0;
            font: inherit;
        }

        body {
            line-height: 1.5;
        }

        img,
        picture,
        video,
        canvas,
        svg {
            display: block;
            max-width: 100%;
        }

        input,
        button,
        textarea,
        select {
            outline: none;
        }

        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            overflow-wrap: break-word;
        }

        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@200&family=Lato:wght@300;400&family=Open+Sans:ital,wght@0,400;0,500;1,300;1,400&family=Oswald:wght@200;300;400;500&family=Roboto:ital,wght@0,300;0,400;0,500;1,400&family=Source+Code+Pro:ital,wght@0,300;0,400;0,500;1,300;1,400&display=swap');

        html {
            font-size: 62.5%;
        }

        body {
            font-family: "Poppins", "roboto", sans-serif;
            font-size: 1.6rem;
        }

        .wrapper {
            width: 500px;
            margin: 5rem auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login</p>

        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control
                <?php echo (!empty($username_err)) ? "is-invalid" : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Login" class="btn btn-primary">
                <p>Don't have an account? </p> <a href="register.php">Sign up now</a>
            </div>
        </form>
    </div>
</body>

</html>