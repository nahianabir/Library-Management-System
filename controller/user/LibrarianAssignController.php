<?php

include_once '../../model/LibrarianAssign.php';

class LibrarianAssignController {

    public function assign() {

        if(isset($_POST['assign_branch'])) {

            $user_id = $_POST['user_id'];

            $branch_id = $_POST['branch_id'];

            $assign = new LibrarianAssign();

            $assign->assignBranch(

                $user_id,
                $branch_id

            );

            header(
                "Location: ../../view/librarian.php"
            );
        }
    }
}

$assign = new LibrarianAssignController();

$assign->assign();

?>