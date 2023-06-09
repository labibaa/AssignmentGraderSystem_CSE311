<?php
// Include config file
require_once "connect.php";
 //$link = mysqli_connect('localhost', 'root', '', 'login');
// Define variables and initialize with empty values
$name = $course = $project_id = $project_link= "";
$name_err = $course_err = $project_id_err = $project_link_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["submit"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    $sql = "UPDATE students SET marks='".$_POST['marks']."' WHERE id='".$id."'";
    $result = mysqli_query($link, $sql);
    if ($result) {
        header("Location:teacher.php");
    }
    print_r($_POST);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM students WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
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
                    $project_link = $row["project_link"];
                    $marks = $row["marks"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    echo ("error");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        echo("error");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Record</title>
    
</head>
<body bgcolor="#ccc">
    <center>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($course_err)) ? 'has-error' : ''; ?>">
                            <label>Course</label>
                            <input type="text" name="course" class="form-control" value="><?php echo $course; ?>">
                            <span class="help-block"><?php echo $course_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($project_id_err)) ? 'has-error' : ''; ?>">
                            <label>Project ID</label>
                            <input type="text" name="project_id" class="form-control" value="<?php echo $project_id; ?>">
                            <span class="help-block"><?php echo $project_id_err;?></span>
                        </div>
                         <div class="form-group <?php echo (!empty($project_link_err)) ? 'has-error' : ''; ?>">
                            <label>Project link</label>
                            <input type="text" name="project_link" class="form-control" value="<?php echo $project_link; ?>">
                            <span class="help-block"><?php echo $project_link_err;?></span>
                        </div>
                        <div>
                            <label>Marks</label>
                            <input type="text" name="marks" class="form-control" value="<?php echo $marks; ?>">
                            <span class="help-block"><?php echo $project_link_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                        <a href="intro.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
    </center>
</body>
</html>