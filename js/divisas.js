function showCurrencyModal() {
    document.getElementById("currencyModal").classList.add("is-active");
}
function closeCurrencyModal() {
    document.getElementById("currencyModal").classList.remove("is-active");
}
function saveCurrency() {
    const currencyName = document.getElementById("currencyName").value;
    const currencySymbol = document.getElementById("currencySymbol").value;
    const currencyValue = document.getElementById("currencyValue").value;
    if (currencyName === "" || currencySymbol === "" || currencyValue === "") {
        Swal.fire("Error", "Todos los campos son obligatorios", "error");
        return;
    }
    const newRow = `<tr>
        <td>#</td>
        <td>${currencyName}</td>
        <td>${currencySymbol}</td>
        <td>${currencyValue}</td>
        <td>
            <button class='button is-warning is-small' onclick='editCurrency()'>Editar</button>
            <button class='button is-danger is-small' onclick='deleteCurrency()'>Eliminar</button>
        </td>
    </tr>`;
    document.getElementById("currencyTable").innerHTML += newRow;
    closeCurrencyModal();
    Swal.fire("Éxito", "Divisa agregada correctamente", "success");
}
function deleteCurrency(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire("Eliminado", "La divisa ha sido eliminada", "success");
        }
    });
}