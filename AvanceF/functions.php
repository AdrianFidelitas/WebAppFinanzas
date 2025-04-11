<?php
function handleTransactionRequests() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete'])) {
            array_splice($_SESSION['transactions'], $_POST['delete'], 1);
        } else {
            $_SESSION['transactions'][] = [
                "description" => $_POST['description'],
                "amount" => $_POST['amount'],
                "date" => $_POST['date'],
                "origin" => $_POST['origin'],
                "destination" => $_POST['destination'],
                "category" => $_POST['category']
            ];
        }
    }
}


