<?php

class FileUpload {

    public function uploadImage(
        $file
    ) {

        $target =
        "../assets/images/" .
        basename($file['name']);

        move_uploaded_file(
            $file['tmp_name'],
            $target
        );

        return $file['name'];
    }
}
?>