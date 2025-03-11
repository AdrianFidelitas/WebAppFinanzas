function showCrudModal() {
    document.getElementById("crudModal").classList.add("is-active");
}
function closeCrudModal() {
    document.getElementById("crudModal").classList.remove("is-active");
}
function saveUser() {
    const userName = document.getElementById("userName").value;
    const userRole = document.getElementById("userRole").value;
    if (userName === "") {
        Swal.fire("Error", "El nombre no puede estar vacío", "error");
        return;
    }
    const newRow = `<tr>
        <td>#</td>
        <td>${userName}</td>
        <td>${userRole}</td>
        <td>
            <button class='button is-warning is-small' onclick='editUser()'>Editar</button>
            <button class='button is-danger is-small' onclick='deleteUser()'>Eliminar</button>
        </td>
    </tr>`;
    document.getElementById("userTable").innerHTML += newRow;
    closeCrudModal();
    Swal.fire("Éxito", "Usuario agregado correctamente", "success");
}
function deleteUser(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire("Eliminado", "El usuario ha sido eliminado", "success");
        }
    });
}