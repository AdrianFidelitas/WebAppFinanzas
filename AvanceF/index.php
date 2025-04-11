<?php include 'data.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sist Finanzas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>

        <main class="content">
            <h1>Dashboard</h1>
            <div class="cards">
                <div class="card"><i class="fas fa-arrow-up"></i> Entrada y salida: <strong>0,00 ₡</strong></div>
                <div class="card"><i class="fas fa-rotate-left"></i> Subscripcciones: <strong>-350.663,05 ₡</strong></div>
                <div class="card"><i class="fas fa-wallet"></i> Disponible: <strong>0,00 ₡</strong></div>
                <div class="card"><i class="fas fa-scale-balanced"></i> Valor neto: <strong>223.278,61 ₡</strong></div>
            </div>

            <div class="chart">
                <h2>Tus cuentas</h2>
                <table>
                    <?php foreach ($cuentas as $cuenta) { ?>
                        <tr>
                            <td><?php echo $cuenta['nombre']; ?></td>
                            <td style="text-align:right; color: #00ffcc;"><strong><?php echo $cuenta['saldo']; ?></strong></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <div class="budget-section">
                <div class="card">Presupuestos y gastos: <strong>No hay suficiente información.</strong></div>
                <div class="card">Categorías: <strong>No hay suficiente información.</strong></div>
            </div>
        </main>
    </div>
</body>
</html>
