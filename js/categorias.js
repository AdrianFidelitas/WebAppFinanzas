function showCategoryModal() {
    document.getElementById("categoryModal").classList.add("is-active");
}
function closeCategoryModal() {
    document.getElementById("categoryModal").classList.remove("is-active");
}
function saveCategory() {
    const categoryName = document.getElementById("categoryName").value;
    const categoryType = document.getElementById("categoryType").value;
    if (categoryName === "") {
        Swal.fire("Error", "El nombre de la categoría no puede estar vacío", "error");
        return;
    }
    const newRow = `<tr>
        <td>#</td>
        <td>${categoryName}</td>
        <td>${categoryType}</td>
        <td>
            <button class='button is-warning is-small' onclick='editCategory()'>Editar</button>
            <button class='button is-danger is-small' onclick='deleteCategory()'>Eliminar</button>
        </td>
    </tr>`;
    document.getElementById("categoryTable").innerHTML += newRow;
    closeCategoryModal();
    Swal.fire("Éxito", "Categoría agregada correctamente", "success");
}
function deleteCategory(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire("Eliminado", "La categoría ha sido eliminada", "success");
        }
    });
}