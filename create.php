<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "employeeinformation";

$connection = new mysqli($servername, $username, $password, $database);

$Eid = "";
$Name = "";
$Position = "";
$Salary = "";
$Age = "";
$Address = "";
$DeptCode = "";

$errorMessage = "";
$successMessage = "";

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $Eid = $_POST["Eid"];
    $Name = $_POST["Name"];
    $Position = $_POST["Position"];
    $Salary = $_POST["Salary"];
    $Age = $_POST["Age"];
    $Address = $_POST["Address"];
    $DeptCode = $_POST["DeptCode"];
    
    do {
        if ( empty($Eid) || empty($Name) || empty($Position) || empty($Salary) || empty($Age) || empty($Address) || empty($DeptCode) ) {
            $errorMessage = "All the fields are required.";
            break;
        }

        $sql = "INSERT INTO EmployeeInfo (Eid, Name, Position, Salary, Age, Address, DeptCode) " .
                "VALUES ('$Eid', '$Name', '$Position', '$Salary', '$Age', '$Address', '$DeptCode')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connectionn->error;
            break;
        }

        $Eid = "";
        $Name = "";
        $Position = "";
        $Salary = "";
        $Age = "";
        $Address = "";
        $DeptCode = "";

        $successMessage = "Employee successfully added.";

        header("location: /employeeinformation/index.php");
        exit;

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Add New Employee</h2>

        <?php
        if ( !empty($errorMessage) ) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Employee ID</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Eid" value="<?php echo $Eid; ?>">
                </div>
            </div> 
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Name" value="<?php echo $Name; ?>">
                </div>
            </div> 
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Position</label>
                <div class="col-sm-6">
                    <select class="form-select" name="Position">
                        <option value="">Select Position</option>
                        <option value="Manager" <?php if($Position == "Manager") echo "selected"; ?>>Manager</option>
                        <option value="Secretary" <?php if($Position == "Secretary") echo "selected"; ?>>Secretary</option>
                        <option value="Sales" <?php if($Position == "Sales") echo "selected"; ?>>Sales</option>
                    </select>
                </div>
            </div> 
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Salary</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Salary" value="<?php echo $Salary; ?>">
                </div>
            </div> 
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Age</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Age" value="<?php echo $Age; ?>">
                </div>
            </div> 
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Address" value="<?php echo $Address; ?>">
                </div>
            </div> 
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Department Code</label>
                <div class="col-sm-6">
                    <select class="form-select" name="DeptCode">
                        <option value="">Select Department</option>
                        <option value="BPD" <?php if($DeptCode == "BPD") echo "selected"; ?>>BPD</option>
                        <option value="CRD" <?php if($DeptCode == "CRD") echo "selected"; ?>>CRD</option>
                        <option value="SD" <?php if($DeptCode == "SD") echo "selected"; ?>>SD</option>
                    </select>
                </div>
            </div> 

            <?php
            if ( !empty($successMessage) ) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>   
                </div>
                ";
            }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/employeeinformation/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    <div>
</body>
</html>
