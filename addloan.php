<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Employee Information</h2>

        <!-- Search Form -->
        <form method="GET" class="mb-3 d-flex" style="max-width: 1300px;">
            <input type="text" class="form-control me-2" name="search" placeholder="Search employee..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <a class="btn btn-primary mb-3" href="create.php">Add Employee</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Salary</th>
                    <th>Age</th>
                    <th>Address</th>
                    <th>Department Code</th>
                    <th>Total Loan Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $connection = new mysqli("localhost", "root", "", "employeeinformation");

                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                $search = isset($_GET['search']) ? $connection->real_escape_string($_GET['search']) : "";

                $sql = "
                    SELECT 
                        e.Eid,
                        e.Name,
                        e.Position,
                        e.Salary,
                        e.Age,
                        e.Address,
                        e.Deptcode,
                        d.DeptDescription,
                        IFNULL(SUM(l.LoanAmount), 0) AS Loanamount
                    FROM EmployeeInfo e
                    LEFT JOIN DepartmentInfo d ON e.Deptcode = d.DeptCode
                    LEFT JOIN Loan l ON e.Eid = l.Eid
                ";

                if (!empty($search)) {
                    $sql .= " WHERE 
                        e.Eid LIKE '%$search%' OR
                        e.Name LIKE '%$search%' OR
                        e.Position LIKE '%$search%' OR
                        e.Salary LIKE '%$search%' OR
                        e.Age LIKE '%$search%' OR
                        e.Address LIKE '%$search%' OR
                        e.Deptcode LIKE '%$search%'
                    ";
                }

                $sql .= " GROUP BY e.Eid";

                $result = $connection->query($sql);

                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>{$row['Eid']}</td>
                            <td>{$row['Name']}</td>
                            <td>{$row['Position']}</td>
                            <td>{$row['Salary']}</td>
                            <td>{$row['Age']}</td>
                            <td>{$row['Address']}</td>
                            <td>{$row['Deptcode']}</td>
                            <td>₱{$row['Loanamount']}</td>
                            <td>
                                <a class='btn btn-info btn-sm' href='view.php?Eid={$row['Eid']}'>View</a>
                                <a class='btn btn-success btn-sm' href='addloan.php?Eid={$row['Eid']}'>Add</a>
                                <a class='btn btn-primary btn-sm' href='edit.php?Eid={$row['Eid']}'>Edit</a>
                                <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirmDeleteModal{$row['Eid']}'>Delete</button>
                            </td>
                        </tr>

                        <!-- Delete Confirmation Modal -->
                        <div class='modal fade' id='confirmDeleteModal{$row['Eid']}' tabindex='-1'>
                          <div class='modal-dialog'>
                            <div class='modal-content'>
                              <div class='modal-header'>
                                <h5 class='modal-title'>Confirm Delete</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                              </div>
                              <div class='modal-body'>
                                Are you sure you want to delete this employee's record? This action cannot be undone.
                              </div>
                              <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                <a href='delete.php?Eid={$row['Eid']}' class='btn btn-danger'>Delete</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        ";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
