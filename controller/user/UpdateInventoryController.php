<?php

include_once '../../model/update_inventory.php';

class InventoryController {

    public function updateInventory() {

        if(isset($_POST['update_inventory'])) {

            $book_id = $_POST['book_id'];

            $branch_id = $_POST['branch_id'];

            $total = $_POST['total'];

            $available = $_POST['available'];

            $inventory = new Inventory();

            $inventory->updateInventory(

                $book_id,
                $branch_id,
                $total,
                $available

            );

            header(
                "Location: ../../view/update_inventory.php"
            );
        }
    }
}

$inventory = new InventoryController();

$inventory->updateInventory();

?>