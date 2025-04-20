<?php
$connection = new mysqli("localhost", "root", "", "employeeinformation");

$Eid = $_GET["Eid"];
$sql = "
    SELECT e.Eid, e.Name, e.Deptcode, d.DeptDescription 
    FROM EmployeeInfo e 
    LEFT JOIN DepartmentInfo d ON e.Deptcode = d.DeptCode 
    WHERE e.Eid = '$Eid'
";
$result = $connection->query($sql);
$employee = $result->fetch_assoc();

$loanSql = "SELECT LoanAmount, Date FROM Loan WHERE Eid = '$Eid'";
$loanResult = $connection->query($loanSql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee's Loan Information Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2>Employee's Loan Information Details</h2>
    <div class="row my-4">
        <div class="col-md-6">
            <p><strong>Employee ID:</strong> <?php echo $employee['Eid']; ?></p>
            <p><strong>Name:</strong> <?php echo $employee['Name']; ?></p>
            <p><strong>Department Code:</strong> <?php echo $employee['Deptcode']; ?></p>
            <p><strong>Department Description:</strong> <?php echo $employee['DeptDescription']; ?></p>
        </div>
        <div class="col-md-6">
            <h5>Break down:</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Loan Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($loan = $loanResult->fetch_assoc()) { ?>
                        <tr>
                            <td>₱<?php echo $loan['LoanAmount']; ?></td>
                            <td><?php echo $loan['Date']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Back button -->
    <a href="index.php" class="btn btn-primary">Back to Employee Information</a>
</div>
</body>
</html>
