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
                        <h2 class="pull-left">Student Details</h2>
                    </div>
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
                                        echo "<th>Marks</th>";
                                        echo "<th>Grade</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                $i=0;
                                while($row = mysqli_fetch_array($result)){
                                    $i++;
                                    echo "<tr>";
                                        echo "<td>" . $i . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['course'] . "</td>";
                                        echo "<td>" . $row['project_id'] . "</td>";
                                        echo "<td>" . $row['project_link'] . "</td>";
                                        if ($row['marks'] == 0) {
                                            echo "<td><a href='teacher_edit.php?id=".$row['id']."'>give mark</a></td>";
                                        }else{
                                            echo "<td>" .$row['marks']. "</td>";
                                        }

                                        if ($row['marks'] >= 90) {
                                            echo "<td>A</td>";;
                                        }elseif($row['marks'] >= 87){
                                            echo "<td>A-</td>";
                                        }elseif($row['marks'] >= 80){
                                            echo "<td>B</td>";
                                        }elseif($row['marks'] >= 60){
                                            echo "<td>C+</td>";
                                        }else{
                                            echo "<td>F</td>";
                                        }
                                        
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
    <p><h3><a href="welcome.php">Click here to insert your record</a></h3></p>
    <p><h2> <a href="logout.php" > I'm done! Sign out</a></h2>
    </p>
    </center>
</body>
</html>