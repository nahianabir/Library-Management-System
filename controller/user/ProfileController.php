<?php

include_once __DIR__ . '/../../model/Profile.php';

class ProfileController {

    public function profile($id) {

        $profile = new Profile();

        return $profile->getProfile($id);
    }



    public function update() {

        if(isset($_POST['update_profile'])) {

            $profile_pic = "";

            if(!empty($_FILES['profile_pic']['name'])) {

                $profile_pic =
                time() .
                "_" .
                $_FILES['profile_pic']['name'];

                $tmp =
                $_FILES['profile_pic']['tmp_name'];

                move_uploaded_file(

                    $tmp,

                    "../../assets/profile/" .
                    $profile_pic

                );
            }

            else {

                $profile_pic =
                $_POST['old_image'];
            }

            $profile = new Profile();

            $profile->updateProfile(

                $_POST['user_id'],
                $_POST['name'],
                $_POST['email'],
                $_POST['phone'],
                $profile_pic

            );

            header(
                "Location: ../../view/profile.php"
            );
        }
    }



    public function branches() {

        $profile = new Profile();

        return $profile->allBranches();
    }
}

$profile = new ProfileController();

$profile->update();

?>