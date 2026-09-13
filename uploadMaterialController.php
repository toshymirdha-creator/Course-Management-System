<?php
$filename = $_FILES['material']['name'];
$basePath = $_FILES['material']['tmp_name'];

$fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

if ($fileExtension == "pdf" || $fileExtension == "pptx") {

    move_uploaded_file($basePath, "uploads/" . $filename);

}
else {

    echo "Only pdf and pptx files can be uploaded";

}

?>