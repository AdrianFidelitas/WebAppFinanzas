<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cuentas Financieras</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="cuentas.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
  <?php include 'C:\laragon\www\WebAppFinanzas\AvanceF\sidebar.php'; ?>
    <!-- Contenido principal -->
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
  </div>

  <!-- Modal para crear cuenta -->
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

  <!-- Script -->
  <script src="cuentas.js"></script>
</body>
</html>
