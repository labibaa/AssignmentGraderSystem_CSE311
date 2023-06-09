
<?php session_start(); ?>
<?php 
require_once "connect.php";
$id = $_SESSION["id"];
$username = $_SESSION["username"];
$query = "SELECT * FROM students WHERE user_id='".$id."'";
$result = mysqli_query($link, $query);
$flag = 0;
if(mysqli_num_rows($result) == 0){
    echo "<script>alert('Please add your record because here is your no record added');</script>";
    $flag = 1;
}
 ?>

<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>View</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
   
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    
</head>
<body bgcolor="#def28d">
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h3 class="pull-left">Student Details</h3>
                        <h3 class="pull-right text-muted">username:<span class="text-success"><?php echo $username; ?></span></h3>

                    </div>
                    <p>
                        <?php 
                            if ($flag == 1) {
                                echo '<a href="welcome.php" class="text-danger">Click here to insert your record</a></p>';
                            }
                         ?>
                    <?php
                    
                    require_once "connect.php";
                    
                    $sql = "SELECT * FROM students";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Course</th>";
                                        echo "<th>Project ID</th>";
                                        echo "<th>Project Link</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['course'] . "</td>";
                                        echo "<td>" . $row['project_id'] . "</td>";
                                        echo "<td>" . $row['project_link'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='view.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            if ($row['user_id'] == $id) {
                                               echo "<a href='edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='S_main.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                            }
                                            
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div> <center>
    
    <p><h2> <a href="logout.php" > I'm done! Sign out</a></h2>
    </p>
    </center>
</body>
</html>