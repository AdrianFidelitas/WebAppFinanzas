<?php
use app\controllers\accountsController;

$controller = new accountsController();
$cuentas = $controller->getAccounts(); // Asegúrate que esta función devuelva un array de cuentas
?>

<div class="dashboard-content">
      <h1 class="title is-3 has-text-white">Cuentas Financieras</h1>

      <!-- Botón para crear cuenta -->
      <button class="button is-primary mb-4" onclick="showAccountModal()">+ Crear nueva cuenta</button>

      <!-- Tabla de cuentas -->
      <table class="table is-fullwidth is-striped is-hoverable">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Saldo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="accountTable">
          <!-- Cuentas se agregarán dinámicamente -->
        </tbody>
      </table>
    </div>

    <div id="accountModal" class="modal">
    <div class="modal-background" onclick="closeAccountModal()"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Nueva Cuenta Financiera</p>
        <button class="delete" aria-label="close" onclick="closeAccountModal()"></button>
      </header>
      <section class="modal-card-body">
        <div class="field">
          <label class="label">Nombre de la cuenta</label>
          <div class="control">
            <input class="input" type="text" id="accountName" placeholder="Ej. Cuenta Principal">
          </div>
        </div>

        <div class="field">
          <label class="label">Tipo</label>
          <div class="control">
            <div class="select is-fullwidth">
              <select id="accountType">
                <option value="">Seleccionar tipo</option>
                <option value="activo">Activo</option>
                <option value="ingreso">Ingreso</option>
                <option value="gasto">Gasto</option>
                <option value="pasivo">Pasivo</option>
              </select>
            </div>
          </div>
        </div>

        <div class="field">
          <label class="label">Moneda</label>
          <div class="control">
            <div class="select is-fullwidth">
              <select id="savingCurrency">
                <option value="">Seleccionar moneda</option>
                <option value="USD">$ - Dólares (USD)</option>
                <option value="CRC">₡ - Colones (CRC)</option>
              </select>
            </div>
          </div>
        </div>

        <div class="field">
          <label class="label">Saldo inicial</label>
          <div class="control">
            <input class="input" type="number" id="accountBalance" placeholder="Monto" min="0">
          </div>
        </div>
      </section>
      <footer class="modal-card-foot">
        <button class="button is-success" onclick="saveAccount()">Guardar</button>
        <button class="button" onclick="closeAccountModal()">Cancelar</button>
      </footer>
    </div>
  </div>