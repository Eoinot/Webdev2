<!-- 
This is a website for a library. This website is also connected to a database and allows to store information about users,books,book categories also what books have been reserved by users.

This index.php page is the main page in the website where everything is linked too. On this page you can search for books by typing in the books name or by partialy searching and will come up
with books that contains those letters. You can also search by a drop down menu through the different categories of books that are available to reserve. You can reserve a book from the books that you search for.
You can also choose to logout if needed to switch accounts.

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
//including the header file
include("header.php");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";
$BookTitle ="booktable";
$count = 1;
$ReservedDate = date('y-m-d'); // used to get the current date and time of your system



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
<!-- Log out button -->
<form name= "logout" id ="reg" method="post">
    <p> 
    <button name = "logout"type="submit">Log Out</button>
    </p>
</form>

<!-- Form to search for books -->
<h1>Please fill in the name of the book you want to search for:  </h1>
<form method="post" class='f'>
    <p>Book Title: 
        <input type="text" name="BookTitle"/>
    </p>
    <p>
        <button type="submit" name ='TitleSearch'>Submit</button>
        </br>
    </p>
</form>
<?php
?>

<!-- Drop down menu to search for a book through categories -->
<form method="post" class='f'>
    <select name ="Description">
    <option select>---Select Option---</option>

    <?php

        $sql = "Select CategoryDescription from category";
        $result = $conn->query($sql);

        while($rows = $result ->fetch_assoc())
        {
            $cat_desc = $rows["CategoryDescription"];
            echo"<option value ='$cat_desc'>$cat_desc</option>";
            $selected = $_POST['Description'];
            
        }
        echo"<br>"
        
    ?>  
    </select>
    <button type="submit" name ='CatSearch'>Submit</button>
    
</form>  
<!-- Button to reserve a book for that user -->
<form id ="reg" method="post">
    <p> 
        <a href = "Reserve.php" >Click to view your reserved books</a>
    </p>
</form>

<?php
//bringing username from test.php aka to know what account has been logged in
$Username = $_SESSION['Username'];



if ( isset($_POST['BookTitle'])) {
    $BookTitle = $_POST['BookTitle'];
}


// This will print the books in a table that match the input from the form 
 if( isset($_POST['TitleSearch']))
{ 
    


    $sql = "Select * from booktable where BookTitle like'%$BookTitle%'";
    $result = $conn->query($sql);
    if($result)
    {
        echo"<br>";
        echo "<table border ='1'>";
        while($row = $result->fetch_assoc()) 
        {
            while ($count == 1)
            {
                echo "<tr>";
                echo "<th> ISBN </th>"."<th> BookTitle </th>"."<th> Author </th>"."<th> Edition </th>"."<th> Year </th>"."<th> Category </th>"."<th> Reserved </th>"."<th> Update </th>";
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
            echo ($row["Reserved"]);
            echo "</td><td>";
            if($row["Reserved"] =='N')
            {
                $reserve = $row["ISBN"];
                echo "<form id = 'reserveform' method='post'>";
                echo "<button name = 'Reserve' type = 'submit' id = 'reservebutton' value = '$reserve'>Reserve</button>";

            }
            echo "</td></tr>";


        }
        echo"</table>";
        echo"<br>";
        $count = 1;
    }
        
    

   
} 


// This will print a table containing the books for the category that was selected
if( isset($_POST['CatSearch']))   
{
    $sql3 = "Select * from booktable JOIN category ON booktable.Category = category.CategoryID where CategoryDescription ='$selected'";
    $result = $conn->query($sql3);
    if($result)
    {
        echo"<br>";
        echo "<table border ='1'>";
        while($row = $result->fetch_assoc()) 
        {
            while ($count == 1)
            {
                echo "<tr>";
                echo "<th> ISBN </th>"."<th> BookTitle </th>"."<th> Author </th>"."<th> Edition </th>"."<th> Year </th>"."<th> Category </th>"."<th> Reserved </th>";
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
            echo ($row["Reserved"]);
            echo "</td><td>";
            if($row["Reserved"] =='N')
            {
                $reserve = $row["ISBN"];
                echo "<form id = 'reserveform' method='post'>";
                echo "<button name = 'Reserve' type = 'submit' id = 'reservebutton' value = '$reserve'>Reserve</button>";

            }
            echo "</td></tr>";
        }
        echo"</table>";
        echo"<br>"."<br>";
        $count = 1;
    }
}
//This code below is used to reserve books that have not been reserved before by changing reserved in the booktable to Y to show its been reserved and then adding it to the reserved table
// containing the isbn username and date and time it was reserved
if( isset($_POST['Reserve']))
{
    $ISBN = $_POST['Reserve'];

    {
    
        $sql = "UPDATE booktable SET Reserved = 'Y' WHERE ISBN = '$ISBN'";
    
        if ($conn->query($sql) === TRUE)
        {
            echo "<script>alert('Your book has been reserved')</script>";
        }
        else
        {
            echo "ERROR: " . $sql . "<br>" . $conn->error;
        }
    
        $sql = "INSERT INTO reservations (ISBN, Username,ReservedDate) VALUES ('$ISBN', '$Username', '$ReservedDate')";
        if ($conn->query($sql) === TRUE) {
            
        }else {
    
            echo"<br>";
            echo"This book has already been reserved,Please try again or click exit";
            echo"<br>";
        }
    }
    
}
// To check if the logout button was pressed and if yes log them out
if( isset($_POST['logout']))
{
    
    unset($_SESSION["Username"]);
    unset($_SESSION["Password"]);
    unset($_SESSION['Validation']);
    header("Location: test.php");
    
}
include("footer.php");


?>








</body>

</html>