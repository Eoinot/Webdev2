<!-- 
This is a website for a library. This website is also connected to a database and allows to store information about users,books,book categories also what books have been reserved by users.

This page Test.php is the page for users to log in. It checks what the users entered to the data inside of the database and if the passwords and username match it will log you into the website
if not it will print out an appropriate error message telling the user why you could not be logged in.

Author = Eoin O'Toole Carrick
Date = 24/11/2021

-->

<!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhmtl1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=iso-8859-1" />
    <title>Library</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<?php  session_start(); 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";
// To connect to the database and check if its succesfull or not
$conn = new mysqli($servername,$username,$password,$dbname);

if ($conn->connect_error){
    die("connection failed: ". $conn->connection_error);
}
 
?>

<!-- This form takes in the input for users to log in -->
<form method="post" class='f'>

    <h2 class='title'>LOGIN</h2>

    <?php if (isset($_GET['error'])) { ?>

        <p class="error"><?php echo $_GET['error']; ?></p>

    <?php } ?>

    <label>User Name</label>

    <input type="text" name="Username" placeholder="UserName"><br>

    <label>Password</label>

    <input type="password" name="Password" placeholder="Password"><br> 

    <button type="submit">Login</button>
    <a href = "Register.php">Register</a>



</form>

    <?php 
//The following code checks through the database to see if the username and password that the user has entered is within the users table in the database

    if (isset($_POST['Username']) && isset($_POST['Password'])) {

        function validate($data){

            $data = trim($data);
     
            $data = stripslashes($data);
     
            $data = htmlspecialchars($data);
     
            return $data;
    }
    $Username = validate($_POST['Username']);

    $Password = validate($_POST['Password']); 

    if (empty($Username)) {

        header("Location: Test.php?error=Username is required");
        exit();

      

    }else if(empty($Password)){

        header("Location: Test.php?error=Password is required");

        exit();

    }else{

        $sql = "SELECT * FROM users WHERE Username='$Username' AND Password='$Password'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['Username'] === $Username && $row['Password'] === $Password) {

                echo "Logged in!";
                
                $_SESSION['Validation']=true;
                $_SESSION['Username'] = $Username;


                header("Location: Index.php"); 

                exit();

            }else{

                header("Location: Test.php?error=Incorect User name or password");
                

                exit();

            }

        }else{

            header("Location: Test.php?error=Incorect User name or password");
            exit();

        }

    }
}

mysqli_close($conn);





?>

</body>

</html>