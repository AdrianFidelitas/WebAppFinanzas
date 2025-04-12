<?php
use app\controllers\reportsController;

$controller = new reportsController();
$cuentas = $controller->getAccounts(); // Asegúrate que esta función devuelva un array de cuentas
?>

<div class="dashboard-content">
      <h2 class="title has-text-white">Gestión de Informes</h2>
      <button class="button is-link" onclick="showReportModal()">
        <i class="fas fa-file-alt mr-2"></i> Generar Informe
      </button>

      <h3 class="title is-4 has-text-white mt-5">Historial de Informes</h3>
      <table class="table is-fullwidth is-striped is-hoverable mt-3">
        <thead>
          <tr>
            <th>Tipo</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Generado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="reportTable">
          <!-- Informes generados dinámicamente -->
        </tbody>
      </table>
    </div>

<!-- Modal para crear informe -->
  <div id="reportModal" class="modal">
    <div class="modal-background" onclick="closeReportModal()"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Generar Informe Financiero</p>
        <button class="delete" aria-label="close" onclick="closeReportModal()"></button>
      </header>
      <section class="modal-card-body">
        <div class="field">
          <label class="label">Tipo de Informe</label>
          <div class="control">
            <div class="select is-fullwidth">
              <select id="reportType">
                <option value="financiero">Informe Financiero</option>
                <option value="mensual">Resumen Mensual</option>
                <option value="historico">Historial Completo</option>
              </select>
            </div>
          </div>
        </div>

        <div class="field">
          <label class="label">Fecha de Inicio</label>
          <div class="control">
            <input class="input" type="date" id="startDate">
          </div>
        </div>

        <div class="field">
          <label class="label">Fecha de Fin</label>
          <div class="control">
            <input class="input" type="date" id="endDate">
          </div>
        </div>
      </section>
      <footer class="modal-card-foot">
        <button class="button is-success" onclick="generateReport()">Generar</button>
        <button class="button" onclick="closeReportModal()">Cancelar</button>
      </footer>
    </div>
  </div>