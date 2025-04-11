<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistemas Finanzas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.4/css/bulma.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="informes.css">
    <link rel="stylesheet" href="styles.css">
</head>


<body>
  <div class="container">
    <?php include 'sidebar.php'; ?>

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

  <script src="informes.js"></script>
</body>
</html>