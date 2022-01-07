<!-- 
This is a website for a library. This website is also connected to a database and allows to store information about users,books,book categories also what books have been reserved by users.

This page is used when the users selects to view their reserved books under their account. Itl print the books theyve reserved under their username and will give the user an option to delete
their reservation.

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
$Username = $_SESSION['Username'];
$count = 1;

$conn = new mysqli($servername,$username,$password,$dbname);

if ($conn->connect_error){
    die("connection failed: ". $conn->connection_error);
}
// This checks whether or not a user has been logged in and if not will go back till they log in
if (!isset($_SESSION['Validation']))
{
    header('Location: test.php');
    exit;
}

?>
<!-- Button to go back to index.php / home page -->
<form class='f'>
    <p class='a'> 
        <a href = "Index.php" >Home</a>
    </p>
</form>

<?php
// This code joins both the reservation and booktable table to print out all the books that have been reserved by the user and only that user
$sql = "Select * from booktable JOIN reservations ON booktable.ISBN = reservations.ISBN where Username ='$Username'";
$result = $conn->query($sql);
if (isset($_SESSION['Username']))
{
    if($result)
    {
        echo"<br>";
        echo "<table border ='1'>";
        while($row = $result->fetch_assoc()) 
        { 
            while ($count == 1)
            {
                echo "<tr>";
                echo "<th> ISBN </th>"."<th> BookTitle </th>"."<th> Author </th>"."<th> Edition </th>"."<th> Year </th>"."<th> Category </th>"."<th> Update </th>";
                echo "</tr>";
                $count = 0;
            }
            
            echo"<tr><td>";
            echo ($row["ISBN"]);
            echo "</td><td>";
            echo ($row["BookTitle"]);
            echo "</td><td>";
            echo ($row["Author"]);
            echo "</td><td>";
            echo ($row["Edition"]);
            echo "</td><td>";
            echo ($row["Year"]);
            echo "</td><td>";
            echo ($row["Category"]);
            echo "</td><td>";
            $delete = $row["ISBN"];
            echo "<form id = 'deleteform' method='post'>";
            echo "<button name = 'Delete' type = 'submit' id = 'Deletebutton' value = '$delete'>Remove Reservation</button>";
            echo "</td>";
        }
        

    } 

}else{
    echo"You have no books Reserved";
}

// This will remove the reservation from the users account and also change it in the booktable table saying the book can now be reserved
if(isset($_POST['Delete']))
{
    $sql = "UPDATE booktable SET Reserved = 'N' WHERE ISBN = '$delete'";

    if ($conn->query($sql) === TRUE)
    {
        echo "<script>alert('Item has been updated successfully')</script>";
    }
    else
    {
        echo "The Delete was unsuccesful";
    }

    $sql = "DELETE FROM reservations WHERE ISBN ='$delete'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('This book has been successfully reserved')</script>";
        header("Location: index.php");
    }
}



?>





</body>

</html>