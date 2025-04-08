<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen Pago</title>
    <link href='https://fonts.googleapis.com/css?family=Black Han Sans' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="./css/Pago.css" rel="stylesheet">
</head>
<body>
    <div class="titulo text-center mt-4">
        <h4>RESUMEN DE PAGO</h4>
    </div>

    <div class="container mt-4">
        <table class="table table-group-divider">
            <thead>
                <tr>
                    <th scope="col">N°</th>
                    <th scope="col">Nombre cupón</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody class="table-group-divider" id="tablaCarrito">
                <!-- Aquí se mostrará la información del carrito -->
            </tbody>
        </table>
    </div>
</body>
</html>