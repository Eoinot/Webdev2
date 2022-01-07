<!-- 
This is a website for a library. This website is also connected to a database and allows to store information about users,books,book categories also what books have been reserved by users.

This webpage is used for users to register an account for the library. The information the users enter will be stored in the librarys database which will allow them to log in to the website
giving them acces to all the features it provides.

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


<?php session_start();

include("header.php");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";


$conn = new mysqli($servername,$username,$password,$dbname);

if ($conn->connect_error){
    die("connection failed: ". $conn->connection_error);
}
?>
<!-- 
    form to input the data for the newly registered user 
 -->
<h1>Please fill out the information below : </h1>
<form class='f'  method="post">
    <p>Username: 
        <input type="text" name="Username"/>
    </p>
    <p>Password: 
        <input type="password" name="Password"/>
    </p>
    <p>Check Password: 
        <input type="password" name="Check_Password"/>
    </p>
    <p>First Name: 
        <input type="text" name="FirstName"/>
    </p>
    <p>Surname: 
        <input type="text" name="Surname"/>
    </p>
    <p>Address Line 1: 
        <input type="text" name="AddressLine"/>
    </p>
    <p>Address Line 2: 
        <input type="text" name="AddressLine2"/>
    </p>
    <p>City: 
        <input type="text" name="City"/>
    </p>
    <p>House Phone Number: 
        <input type="text" name="HousePhoneNumber"/>
    </p>
    <p>Mobile Phone Number: 
        <input type="text" name="MobilePhoneNumber"/>
    </p>
    <p>
        <input type="submit" value="Add New"/>
    </p>
</form>


<?php





// Checking if the data was inputed in the form and if it has been insert the data into the users table in the database to add the account
if ( !empty($_POST['Username']) && !empty($_POST['Password']) && !empty($_POST['Password']) && !empty($_POST['FirstName']) && !empty($_POST['Surname']) && !empty($_POST['AddressLine'])&& !empty($_POST['AddressLine2'])&& !empty($_POST['City'])&& !empty($_POST['HousePhoneNumber'])&& !empty($_POST['MobilePhoneNumber'])) {

    
    $un = $_POST['Username'];
    $p = $_POST['Password'];
    $cp = $_POST['Check_Password'];
    $fn = $_POST['FirstName'];
    $sn = $_POST['Surname'];
    $ad1 = $_POST['AddressLine'];
    $ad2 = $_POST['AddressLine2'];
    $c = $_POST['City'];
    $hp = $_POST['HousePhoneNumber'];
    $mp = $_POST['MobilePhoneNumber'];

    if ($p == $cp) {
        $sql = "INSERT INTO users (Username, Password, FirstName, Surname,AddressLine,AddressLine2,City,HousePhoneNumber,MobilePhoneNumber) VALUES ('$un', '$p', '$fn', '$sn', '$ad1', '$ad2', '$c', '$hp', '$mp')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('You have been Succesfully Registered, Please login to use our website')</script>";
            header("Location: Test.php");
        } else {
           echo"Error: Please try entering again";
        }
    }


    

}else{

    echo"<br>Please enter your details above:";
}

$conn->close(); 

include("footer.php");

?>




</body>

</html>