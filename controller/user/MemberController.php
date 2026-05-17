<?php

include_once __DIR__ . '/../../model/Member.php';

class MemberController {

    public function members() {

        $member = new Member();

        return $member->memberReports();
    }
}

?>