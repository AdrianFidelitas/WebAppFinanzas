function showReportModal() {
    document.getElementById("reportModal").classList.add("is-active");
  }
  
  function closeReportModal() {
    document.getElementById("reportModal").classList.remove("is-active");
  }
  
  function generateReport() {
    const type = document.getElementById("reportType").value;
    const start = document.getElementById("startDate").value;
    const end = document.getElementById("endDate").value;
  
    if (!start || !end) {
      Swal.fire("Error", "Por favor, selecciona el rango de fechas.", "error");
      return;
    }
  
    const now = new Date().toLocaleString();
    const table = document.getElementById("reportTable");
  
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${type}</td>
      <td>${start}</td>
      <td>${end}</td>
      <td>${now}</td>
      <td>
        <button class="button is-small is-info" onclick="downloadPDF('${type}', '${start}', '${end}')">
          <i class="fas fa-file-pdf"></i>
        </button>
      </td>
    `;
  
    table.appendChild(row);
    closeReportModal();
  
    Swal.fire("Éxito", "Informe generado correctamente.", "success");
  }
  
  function downloadPDF(type, start, end) {
    Swal.fire({
      title: 'Descargando PDF...',
      html: `Tipo: <strong>${type}</strong><br>Desde: <strong>${start}</strong><br>Hasta: <strong>${end}</strong>`,
      icon: 'info',
      timer: 2000,
      showConfirmButton: false
    });
  
    // Aquí puedes redirigir a tu PHP exportador si ya lo tienes
    // window.location.href = `exportarPDF.php?tipo=${type}&inicio=${start}&fin=${end}`;
  }
  