function showBankModal() {
    document.getElementById("bankModal").classList.add("is-active");
}
function closeBankModal() {
    document.getElementById("bankModal").classList.remove("is-active");
}
function saveBank() {
    const bankName = document.getElementById("bankName").value;
    if (bankName === "") {
        Swal.fire("Error", "El nombre del banco no puede estar vacío", "error");
        return;
    }
    const newRow = `<tr>
        <td>#</td>
        <td>${bankName}</td>
        <td>
            <button class='button is-warning is-small' onclick='editBank()'>Editar</button>
            <button class='button is-danger is-small' onclick='deleteBank()'>Eliminar</button>
        </td>
    </tr>`;
    document.getElementById("bankTable").innerHTML += newRow;
    closeBankModal();
    Swal.fire("Éxito", "Banco agregado correctamente", "success");
}
function deleteBank(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire("Eliminado", "El banco ha sido eliminado", "success");
        }
    });
}