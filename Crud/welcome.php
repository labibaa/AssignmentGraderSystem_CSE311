<?php

session_start();

$user_id = $_SESSION["id"];

require_once "connect.php";
 
$name = $course = $project_id = $project_link = "";
$name_err = $course_err =  $project_id_err = $project_link_err= "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    $input_course = trim($_POST["course"]);
    if(empty($input_course)){
        $course_err = "Please enter your course.";     
    } else{
        $course = $input_course;
    }
    
    $input_project_id = trim($_POST["project_id"]);
    if(empty($input_project_id)){
        $project_id_err = "Please enter your project id.";     
    } else{
        $project_id = $input_project_id;
    }
    
    $input_project_link = trim($_POST["project_link"]);
    if(empty($input_project_link)){
        $project_link_err = "Please enter your project link.";     
    } else{
        $project_link = $input_project_link;
    }
    
    
    if(empty($name_err) && empty($course_err) && empty($project_id_err) && empty($project_link_err)){
        $sql = "INSERT INTO students (name, course, project_id, project_link, user_id) VALUES (?, ?, ?, ?, ?)";
         
         //binding

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sssss", $param_name, $param_course, $param_project_id, $param_project_link,$user);
            
            $param_name = $name;
            $param_course = $course;
            $param_project_id = $project_id;
            $param_project_link= $project_link;
            $user = $user_id;
            if(mysqli_stmt_execute($stmt)){
                header("location: intro.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <center>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <h1 > Hi, <b><?php echo htmlspecialchars($_SESSION["username"]);  ?></b>. Welcome.</h1>
    
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
    </center>
</head>
<body bgcolor="#def28d">
    <center>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add student record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($course_err)) ? 'has-error' : ''; ?>">
                            <label>Course</label>
                            <input type="text" name="course" class="form-control" value="<?php echo $course; ?>">
                            <span class="help-block"><?php echo $course_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($project_id_err)) ? 'has-error' : ''; ?>">
                            <label>Project ID</label>
                            <input type="text" name="project_id" class="form-control" value="<?php echo $project_id; ?>">
                            <span class="help-block"><?php echo $project_id_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($project_link_err)) ? 'has-error' : ''; ?>">
                            <label>Project Link</label>
                            <input type="text" name="project_link" class="form-control" value="<?php echo $project_link; ?>">
                            <span class="help-block"><?php echo $project_link_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="intro.php" class="btn btn-default">Cancel</a>
                        
                    </form>
                </div>
            </div>        
        </div>
    </div> 
    
    </center>
</body>
</html>
