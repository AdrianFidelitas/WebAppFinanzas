function showAccountModal() {
    document.getElementById("accountModal").classList.add("is-active");
}
function closeAccountModal() {
    document.getElementById("accountModal").classList.remove("is-active");
}
function saveAccount() {
    const accountBank = document.getElementById("accountBank").value;
    const accountType = document.getElementById("accountType").value;
    const accountCurrency = document.getElementById("accountCurrency").value;
    if (accountBank === "" || accountCurrency === "") {
        Swal.fire("Error", "Todos los campos son obligatorios", "error");
        return;
    }
    const newRow = `<tr>
        <td>#</td>
        <td>${accountBank}</td>
        <td>${accountType}</td>
        <td>${accountCurrency}</td>
        <td>
            <button class='button is-warning is-small' onclick='editAccount()'>Editar</button>
            <button class='button is-danger is-small' onclick='deleteAccount()'>Eliminar</button>
        </td>
    </tr>`;
    document.getElementById("accountTable").innerHTML += newRow;
    closeAccountModal();
    Swal.fire("Éxito", "Cuenta agregada correctamente", "success");
}
function deleteAccount(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire("Eliminado", "La cuenta ha sido eliminada", "success");
        }
    });
}