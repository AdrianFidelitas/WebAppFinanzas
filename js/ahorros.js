function showSavingModal() {
    document.getElementById("savingModal").classList.add("is-active");
}
function closeSavingModal() {
    document.getElementById("savingModal").classList.remove("is-active");
}
function saveSaving() {
    const name = document.getElementById("savingName").value;
    const goal = document.getElementById("savingGoal").value;
    const current = document.getElementById("savingCurrent").value;
    if (!name || !goal || !current) {
        Swal.fire("Error", "Todos los campos son obligatorios", "error");
        return;
    }
    const percentage = (current / goal) * 100;
    const newRow = `<tr>
        <td>#</td>
        <td>${name}</td>
        <td>${goal}</td>
        <td>
            <progress class='progress is-primary' value='${percentage}' max='100'></progress>
            <p>${percentage.toFixed(2)}%</p>
        </td>
        <td>
            <button class='button is-warning is-small'>Editar</button>
            <button class='button is-danger is-small'>Eliminar</button>
        </td>
    </tr>`;
    document.getElementById("savingTable").innerHTML += newRow;
    closeSavingModal();
    Swal.fire("Éxito", "Meta de ahorro creada correctamente", "success");
}