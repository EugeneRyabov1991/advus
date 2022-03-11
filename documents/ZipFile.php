<?php
/**
 * Created by PhpStorm.
 * User: eryabov
 * Date: 29.10.2021
 * Time: 14:41
 */

function create_zip($files = array(),$destination = '',$overwrite = false) {
    //if the zip file already exists and overwrite is false, return false
    if(file_exists($destination) && !$overwrite) { return false; }
    //vars
    $valid_files = array();
    //if files were passed in...
    if(is_array($files)) {
        //cycle through each file
        foreach($files as $file) {
            //make sure the file exists
            if(file_exists($file)) {
                $valid_files[] = $file;
            }
        }
    }
    //if we have good files...
    if(count($valid_files)) {
        //create the archive
        $zip = new ZipArchive();
        if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
            return false;
        }
        //add the files
        foreach($valid_files as $file) {
            $zip->addFile($file,$file);
        }
        //debug
        echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

        //close the zip -- done!
        $zip->close();

        //check to make sure the file exists
        return file_exists($destination);
    }
    else
    {
        return false;
    }
}

include("../db_connect.php");

$sSQL = "Select * From documents";

$crsDocs = mysqli_query($link, $sSQL);
$files_to_zip = array();

while ($rowDoc = mysqli_fetch_array($crsDocs)){
  $nId   = $rowDoc['id'];
  $fileName = $rowDoc['file_name'];
  $nChecked = ($_POST["chkDoc".$nId] == "on" ? 1 : 0);
  if ($nChecked == 1){
     array_push($files_to_zip, '../uploads/'.$fileName);
  }
}

//if true, good; if false, zip creation failed
$result = create_zip($files_to_zip,'../uploads/archive.zip', true);
