<?php
namespace app\controllers;
use app\models\transactionModel;
class transactionsController{
    private $model;

    public function __construct() {
        require_once 'app/models/transactionModel.php';
        $this->model = new transactionModel();
    }

    public function index() {
        $data = [
            'transactions' => $this->model->getTransactions(),
            'totals' => $this->model->getTotals()
        ];
        $this->loadView('transactions/index', $data);
    }

    public function create() {
        $data['cuentas'] = $this->getAccounts(); 
        $this->loadView('transactions/create', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'tipo' => $_POST['tipo'],
                'nombre' => $_POST['nombre'],
                'descripcion' => $_POST['descripcion'],
                'fecha' => $_POST['fecha'],
                'cuenta' => $_POST['cuenta'],
                'monto' => $_POST['monto']
            ];
            
            if ($this->model->createTransaction($data)) {
                $this->redirect('/transactions');
            }
        }
    }

    public function edit($id) {
        $data = [
            'transaction' => $this->model->getTransactionById($id),
            'cuentas' => $this->getAccounts()
        ];
        $this->loadView('transactions/edit', $data);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'tipo' => $_POST['tipo'],
                'nombre' => $_POST['nombre'],
                'descripcion' => $_POST['descripcion'],
                'fecha' => $_POST['fecha'],
                'cuenta' => $_POST['cuenta'],
                'monto' => $_POST['monto']
            ];
            
            if ($this->model->updateTransaction($id, $data)) {
                $this->redirect('/transactions');
            }
        }
    }

    public function delete($id) {
        if ($this->model->deleteTransaction($id)) {
            $this->redirect('/transactions');
        }
    }

    public function search() {
        $term = $_GET['q'] ?? '';
        $data = [
            'transactions' => $this->model->searchTransactions($term),
            'totals' => $this->model->getTotals(),
            'search_term' => $term
        ];
        $this->loadView('transactions/index', $data);
    }

    private function loadView($view, $data = []) {
        extract($data);
        require_once "app/views/{$view}.php";
    }

    private function redirect($url) {
        header("Location: {$url}");
        exit();
    }

    private function getAccounts() {
        return [
            1 => '',
            2 => '',
        ];
    }
}