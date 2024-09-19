<?php
include 'db3.php';
require 'adminnav.php';
?>

<!-- Update Permissions -->
<?php
if (isset($_POST['admin_permissionBtn']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
    $admin_rId = $_POST['r_admin_id'];
    $admin_userId = $_POST['admin_permissionBtn'];
    $permission_sql = "UPDATE `admin_permissions` SET `permission` = $admin_userId WHERE `admin_permissions`.`id` = '{$admin_rId}'";
    $e_result = mysqli_query($con, $permission_sql);
    if ($e_result) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Permission Updated Successfully!
          <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Permission Failed to update, please try again later!
          <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Manage Admin Permisions</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="container mt-3 col-lg-12 col-md-12 col-sm-12">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-primary ml-2 mt-2">Administration Permissions</h4>
            </div>
        </div>
    </div>
    <div class="container mt-3 mb-5 px-3 py-1 align-center">
        <div class="table-responsive col-lg-12 col-md-12 col-sm-6 card pt-3 pb-3">
            <div class="align-center">
                <table class="table" id="adminPermissionsTable">
                    <thead>
                        <tr>
                            <th scope="col">Sr #</th>
                            <th scope="col">Title</th>
                            <th scope="col">Assigned to</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $select = "SELECT * FROM `admin_permissions`";
                        $query = mysqli_query($con, $select);
                        while ($result = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $result['id'] ?></td>
                                <td><?php echo $result['title'] ?></td>
                                <td><?php echo $result['role'] ?></td>
                                <td>
                                    <?php
                                    if (isset($result['permission']) && $result['permission'] == 1) {
                                        echo '<span class="badge badge-success">Approved</span>';
                                    } else {
                                        echo '<span class="badge badge-danger">Pending</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <form action="admin_permissions.php" method="post">
                                        <input type="hidden" name="r_admin_id" id="r_admin_id" value="<?php echo $result['id'] ?>">
                                        <?php
                                        if (isset($result['permission']) && $result['permission'] == 1) {
                                        ?>
                                            <button class="btn btn-danger btn-sm btn-inline text-light" name="admin_permissionBtn" value="0">Deny Permission</button>
                                        <?php
                                        } else {
                                        ?>
                                            <button class="btn btn-success btn-sm btn-inline text-light" name="admin_permissionBtn" value="1">Approve Permission</button>
                                        <?php
                                        }
                                        ?>
                                    </form>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script>
        // Datatable
        $(document).ready(function() {
            $(' #adminPermissionsTable').DataTable();
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>