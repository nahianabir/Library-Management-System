<?php

include_once '../../model/Policy.php';

class PolicyController {

    public function allPolicies() {

        $policy = new Policy();

        return $policy->getPolicies();
    }



    public function createPolicy() {

        if(isset($_POST['add_policy'])) {

            $branch_id = $_POST['branch_id'];

            $days = $_POST['days'];

            $books = $_POST['books'];

            $fine = $_POST['fine'];

            $renewals = $_POST['renewals'];



            $policy = new Policy();

            $policy->addPolicy(

                $branch_id,
                $days,
                $books,
                $fine,
                $renewals

            );

            header(
                "Location: ../../view/policies.php"
            );
        }
    }
}

$policy = new PolicyController();

$policy->createPolicy();

?>