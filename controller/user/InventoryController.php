<?php

include_once '../../model/Inventory.php';

class InventoryController {

    public function updateInventory() {

        if(isset($_POST['update_inventory'])) {

            $inventory = new Inventory();

            $inventory->updateInventory(

                $_POST['book_id'],
                $_POST['branch_id'],
                $_POST['total'],
                $_POST['available']

            );

            header(
                "Location: ../../view/inventory_report.php"
            );
        }
    }
}

$inventory = new InventoryController();

$inventory->updateInventory();

?>