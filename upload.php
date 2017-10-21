<?php

class CsvUpload {

    function upload_csv() {
        if ($_FILES['csv']['error'] == 0) {
            $name = $_FILES['csv']['name'];
            $ext = strtolower(end(explode('.', $name)));
            $type = $_FILES['csv']['type'];
            if ($ext === 'csv') {
                move_uploaded_file($_FILES['csv']['tmp_name'], 'UPLOADS/' . $name);
                header('Location: index.php?filename=' . urldecode($name));
            } else {
                echo 'Invalid file. Please upload valid csv file..';
            }
        }
    }

}

$upd = new CsvUpload();
if (isset($_GET['upload_csv'])) {
    $upd->upload_csv();
}
