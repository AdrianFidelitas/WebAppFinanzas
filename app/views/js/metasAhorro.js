document.addEventListener("DOMContentLoaded", () => {
    document.querySelector(".button.is-success").addEventListener("click", saveSaving);
});

function saveSaving() {
    const name = document.getElementById("savingName").value;
    const goal = document.getElementById("savingGoal").value;
    const current = document.getElementById("savingCurrent").value;
    const currency = document.getElementById("savingCurrency").value;

    if (!name || !goal || !current || !currency) {
        Swal.fire("Error", "Todos los campos son obligatorios", "error");
        return;
    }

    let symbol = "";
    if (currency === "USD") symbol = "$";
    else if (currency === "CRC") symbol = "₡";

    const formattedGoal = parseFloat(goal).toLocaleString(undefined, {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    const percentage = (current / goal) * 100;

    const newRow = `<tr>
        <td>#</td>
        <td>${name}</td>
        <td>${symbol}${formattedGoal}</td>
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
    document.getElementById("savingModal").classList.remove("is-active");
    Swal.fire("Éxito", "Meta de ahorro creada correctamente", "success");
}
