
<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importing</title>
    <link rel="stylesheet" href="../stylesheet/createlist.css">
</head>

<body>
    <?php 
        require_once '../templates/nav.php';
    ?>
    <div class = "notif-create-con">

        <div class = "notif-create">

            <?php
            require_once 'xlsx.php'; // Include the SimpleXLSX library
            require_once '../dbConnection/db.php';

            if (isset($_POST['submit'])) {
            // Check if a file was uploaded
                if (isset($_FILES['excel']['name'])) {


                    if ($conn) {
                        $excel = SimpleXLSX::parse($_FILES['excel']['tmp_name']);
                        echo "<pre>";
                        // print_r($excel->rows(1));
                        print_r($excel->dimension(4));
                        print_r($excel->sheetNames());
                        for ($sheet = 0; $sheet < sizeof($excel->sheetNames()); $sheet++) {
                            $rowcol = $excel->dimension($sheet);
                            $i = 0;
                            if ($rowcol[0] != 1 && $rowcol[1] != 1) {
                                $sheetName = $excel->sheetNames()[$sheet];
                                if ($sheetName == "LISTING") { // Check if the sheet name matches the table name
                                    foreach ($excel->rows($sheet) as $key => $row) {
                                        $q = "";
                                        foreach ($row as $key => $cell) {
                                        //   if ($i == 0) {
                                            //  $q .= "ID INT AUTO_INCREMENT PRIMARY KEY,";
                                            if ($i == 1) {
                                                $q .= ",";
                                            } elseif ($i == 2) {
                                                $q .= ",";
                                            } elseif ($i == 3) {
                                                $q .= ",";
                                            } elseif ($i == 4) {
                                                $q .= ",";
                                            } elseif ($i == 5) {
                                                $q .= ",";
                                            } elseif ($i == 6) {
                                                $q .= ",";
                                            } elseif ($i == 7) {
                                                $q .= ",";
                                            }
                                            $i++;
                                        }
                                        if ($i > 7) {
                                        //   $q = rtrim($q, ",");
                                            $SCHOOL_ID = $row[1];
                                            $FULLNAME = $row[2];
                                            $YLEVEL = $row[3];
                                            $COURSE = $row[4];
                                            $DEPARTMENT = $row[5];
                                            $SY = $row[6];
                                            $SEMESTER = $row[7];

                                            $check_query = "SELECT * FROM STUDENT_LISTING WHERE SCHOOL_ID = '$SCHOOL_ID' and YLEVEL = '$YLEVEL' and SEMESTER = '$SEMESTER';";
                                            $check_result = mysqli_query($conn, $check_query);
                                            $check_row = mysqli_fetch_assoc($check_result);
                                            if (!$check_row) {
                                                $query = "INSERT INTO STUDENT_LISTING (	SCHOOL_ID, FULLNAME, YLEVEL, COURSE, DEPARTMENT, SY, SEMESTER) VALUES ('$SCHOOL_ID', '$FULLNAME', '$YLEVEL', '$COURSE', '$DEPARTMENT', '$SY', '$SEMESTER');";
                                                if (mysqli_query($conn, $query)) {
                                                    echo "<span><label>Data inserted successfully.</label></span><br>";
                                                }
                                            } else {
                                                echo "<span><p>School ID $FULLNAME already exists in the database. Ignoring this entry.</p></span><br>";
                                            }
                                        }
                                    }
                                } else {
                                    echo "<span><p>Excel sheet $sheetName does not match the name of the database table. Ignoring this sheet.</p></span><br>";
                                }
                            }
                        }
                    }
                }
            }
        ?>

        </div>

    </div>
    
    
</body>

</html>




