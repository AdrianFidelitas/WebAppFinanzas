function showAccountModal() {
  document.getElementById("accountModal").classList.add("is-active");
}

function closeAccountModal() {
  document.getElementById("accountModal").classList.remove("is-active");
}

function saveAccount() {
  const name = document.getElementById("accountName").value.trim();
  const type = document.getElementById("accountType").value;
  const balance = document.getElementById("accountBalance").value.trim();

  if (!name || !type || !balance) {
    Swal.fire("Error", "Todos los campos son obligatorios", "error");
    return;
  }

  const newRow = `<tr>
      <td>${name}</td>
      <td>${type.charAt(0).toUpperCase() + type.slice(1)}</td>
      <td>${parseFloat(balance).toLocaleString()}</td>
      <td>
        <button class='button is-info is-small'  >Editar</button>
        <button class='button is-danger is-small'  >Eliminar</button> 
      </td>
    </tr>`;

  document.getElementById("accountTable").innerHTML += newRow;

  // Limpiar campos
  document.getElementById("accountName").value = "";
  document.getElementById("accountType").value = "";
  document.getElementById("accountBalance").value = "";

  closeAccountModal();

  Swal.fire("Éxito", "Cuenta creada correctamente", "success");
}
