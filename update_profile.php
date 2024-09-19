<?php
include 'db3.php';
require 'studentnav.php';
?>

<?php
if (isset($_POST['userProfile_submit']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
    $c_userId = $_SESSION['id'];
    $p_first = $_POST["u_first"];
    $p_last = $_POST["u_last"];
    $p_cnic = $_POST["u_cnic"];
    $p_dob = $_POST["u_dob"];
    $p_mobile = $_POST["u_mobile"];
    $p_gender = $_POST["u_gender"];
    $p_domicile = $_POST["u_domicile"];
    $p_province = $_POST["u_province"];
    $p_postalCode = $_POST["u_postalCode"];
    $p_address = $_POST["u_address"];
    $p_city = $_POST["u_city"];
    $p_seat = $_POST["u_seatNo"];
    // $p_section = $_POST["u_section"];

    $inserted = "UPDATE `userdata` SET `First` = '$p_first', `Last` = '$p_last', `CNIC` = '$p_cnic', `DOB` = '$p_dob', `Mobile` ='$p_mobile', `Gender` ='$p_gender', `Domicile` ='$p_domicile', `Province` ='$p_province', `Postal Code` ='$p_postalCode', `Address` ='$p_address', `City` ='$p_city', `Seat` ='$p_seat' WHERE `userdata`.`user_id` = $c_userId";
    $query = mysqli_query($con, $inserted);
    if ($query) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        User Profile Updated Successfully!
          <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
?>
        <script>
            setTimeout(() => {
                window.location = `profile.php`;
            }, 1000);
        </script>
<?php
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        User Data Incomplete or Failed to Update!
          <button type="button" class="close close__box_shadow_none" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
    }
} else {
    //echo "no click";
}

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Update Profile</title>

    <link rel="stylesheet" href="assets/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

</head>

<body>

    <div class="container">
        <div class="row">
            <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                <div class="mt-3 col-md-8 offset-md-2 card mb-5 px-3 py-2" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                    <h4 class="text-primary mb-3 mt-3 pb-2">User Profile</h4>
                    <?php
                    require 'db3.php';
                    $user_currentId = $_SESSION['id'];
                    $userdata_select = "SELECT * FROM `userdata` WHERE user_id= '{$user_currentId}'";
                    $userdata_query = mysqli_query($con, $userdata_select);
                    while ($result = mysqli_fetch_array($userdata_query)) {
                    ?>
                        <div class="row">
                            <div class="col">
                                <label>First Name</label>
                                <input type="text" class="form-control" id="u_first" name="u_first" placeholder="First Name" value=<?php echo $result['First'] ?>>
                            </div>
                            <div class="col">
                                <label>Last Name</label>
                                <input type="text" class="form-control" id="u_last" name="u_last" placeholder="Last Name" value=<?php echo $result['Last'] ?>>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label>CNIC</label>
                                <input type="number" class="form-control" id="u_cnic" name="u_cnic" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="13" placeholder="00000-0000000-0" value=<?php echo $result['CNIC'] ?>>
                            </div>
                            <div class="col">
                                <label>DOB</label>
                                <input type="date" class="form-control" id="u_dob" name="u_dob" max="<?php echo date("Y-m-d"); ?>" value=<?php echo $result['DOB'] ?>>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label>Mobile #</label>
                                <input type="number" class="form-control" id="u_mobile" name="u_mobile" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="11" placeholder="Mobile Number" value=<?php echo $result['Mobile'] ?>>
                            </div>
                            <div class="col">
                                <label>Gender</label>
                                <select class="form-control" name="u_gender" id="u_gender" value=<?php echo $result['Gender'] ?>>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label>Domicile</label>
                                <input type="text" class="form-control" id="u_domicile" name="u_domicile" placeholder="Sindh etc" value=<?php echo $result['Domicile'] ?>>
                            </div>
                            <div class="col">
                                <label>Province</label>
                                <input type="text" class="form-control" id="u_province" name="u_province" placeholder="Province Name" value=<?php echo $result['Province'] ?>>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label>Postal Code</label>
                                <input type="number" class="form-control" id="u_postalCode" name="u_postalCode" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="6" placeholder="Postal Code" value=<?php echo $result['Postal Code'] ?>>
                            </div>
                            <div class="col">
                                <label>Address</label>
                                <input type="text" class="form-control" id="u_address" name="u_address" placeholder="Address" value=<?php echo $result['Address'] ?>>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label>City</label>
                                <input type="text" class="form-control" id="u_city" name="u_city" placeholder="City Name" value=<?php echo $result['City'] ?>>
                            </div>
                            <div class="col">
                                <label>Seat #</label>
                                <input type="text" class="form-control" id="u_seatNo" name="u_seatNo" placeholder="Seat No" value=<?php echo $result['Seat'] ?>>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label>Section</label>
                                <input type="text" class="form-control" disabled value=<?php echo $result['section'] ?>>
                                <!-- <select class="form-control" id="u_section" name="u_section">
                                    <option value="a">Section A</option>
                                    <option value="b">Section B</option>
                                    <option value="c">Section C</option>
                                    <option value="d">Section D</option>
                                </select> -->
                            </div>
                            <div class="col">
                                <label>Student ID</label>
                                <input type="text" class="form-control" id="u_" name="u_" placeholder="Student ID" disabled value=<?php echo $result['Student_number'] ?>>
                            </div>
                        </div>
                        <!-- <div class="mt-4">
                            <input type="file" class="form-control" id="u_image_upload" name="u_image_upload">
                        </div> -->
                        <div class="float-right w-100 text-right mt-3">
                            <a href="profile.php" class="btn btn-secondary btn-sm text-white mt-3 mb-3 pl-4 pr-4 pb-1 pt-1">Back to Profile</a>
                            <button type="submit" class="btn btn-success btn-sm ml-1 mt-3 mb-3 pl-4 pr-4 pb-1 pt-1" name="userProfile_submit">Update Changes</button>
                        </div>

                    <?php
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Connecting Bootstrap -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>