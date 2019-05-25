<?php
// Upload
if (!empty($_FILES) && !FM_READONLY) {
    $override_file_name = false;
    $f = $_FILES;
    $path = FM_ROOT_PATH;
    $ds = DIRECTORY_SEPARATOR;
    if (FM_PATH != '') {
        $path .= '/' . FM_PATH;
    }

    $errors = 0;
    $uploads = 0;
    $allowed = (FM_EXTENSION) ? explode(',', FM_EXTENSION) : false;

    $filename = $f['file']['name'];
    $tmp_name = $f['file']['tmp_name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $isFileAllowed = ($allowed) ? in_array($ext, $allowed) : true;

    $targetPath = $path . $ds;
    $fullPath = $path . '/' . $_REQUEST['fullpath'];
    $folder = substr($fullPath, 0, strrpos($fullPath, "/"));

    if(file_exists ($fullPath) && !$override_file_name) {
        $ext_1 = $ext ? '.'.$ext : '';
        $fullPath = str_replace($ext_1, '', $fullPath) .'_'. date('ymdHis'). $ext_1;
    }

    if (!is_dir($folder)) {
        $old = umask(0);
        mkdir($folder, 0777, true);
        umask($old);
    }

    if (empty($f['file']['error']) && !empty($tmp_name) && $tmp_name != 'none' && $isFileAllowed) {
        if (move_uploaded_file($tmp_name, $fullPath)) {
            die('Successfully uploaded');
        } else {
            die(sprintf('Error while uploading files. Uploaded files: %s', $uploads));
        }
    }
    exit();
}
