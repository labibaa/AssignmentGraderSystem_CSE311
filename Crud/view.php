<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "connect.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM students WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $name = $row["name"];
                $course = $row["course"];
                $project_id = $row["project_id"];
            } 
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    echo "Oops! Something went wrong. Please try again later.";
    exit();
}
?>
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    
</head>
<body bgcolor="#def28d">
    <center>
    
                        <h1>View Record</h1>
                    
                   
                        <b>Name:</b> <?php echo $row["name"]; ?> 
                    <p>
                    
                        <b>Course:</b> <?php echo $row["course"]; ?>
                    </p>
                    <p>
                        <b>Project ID:</b> <?php echo $row["project_id"]; ?>
                        </p>
                       <p>
                        <b>Project Link:</b><?php echo $row["project_link"]; ?>
                    </p>
                    <p><a href="intro.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
    </center>
</body>
</html>