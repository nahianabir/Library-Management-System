<?php

include_once '../../model/Branch.php';

class BranchController {

    public function allBranches() {

        $branch = new Branch();

        return $branch->getBranches();
    }



    public function createBranch() {

        if(isset($_POST['add_branch'])) {

            $name = $_POST['name'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $phone = $_POST['phone'];

            $branch = new Branch();

            $branch->addBranch(

                $name,
                $address,
                $city,
                $phone

            );

            header(
                "Location: ../../view/branches.php"
            );
        }
    }
}

$branch = new BranchController();

$branch->createBranch();

?>