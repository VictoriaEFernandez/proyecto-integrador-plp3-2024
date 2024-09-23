<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarjetas de Propietarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos-propietarios.css">
    <?php include 'cabecera.php'; ?>
</head>
<body>
    <div class="container mt-5">
    <input type="text" id="filtro" placeholder="Buscar propietario por nombre..." class="form-control mb-4">
    <div class="row row-cols-1 row-cols-md-3 g-4" id="propietarios">
            <!-- Propietario 1 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <img src="imgPropietarios/mujer.png" class="card-img-top" alt="Avatar 1">
                    <div class="card-body">
                        <h5 class="card-title">Ana Martínez</h5>
                        <p class="card-text">Arquitecta especializada en diseño sostenible</p>
                    </div>
                </div>
            </div>
            <!-- Propietario 2 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <img src="imgPropietarios/hombre.png" class="card-img-top" alt="Avatar 2">
                    <div class="card-body">
                        <h5 class="card-title">Carlos Rodríguez</h5>
                        <p class="card-text">Ingeniero civil con enfoque en estructuras</p>
                    </div>
                </div>
            </div>
            <!-- Propietario 3 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <img src="imgPropietarios/mujer.png" class="card-img-top" alt="Avatar 3">
                    <div class="card-body">
                        <h5 class="card-title">Elena Torres</h5>
                        <p class="card-text">Diseñadora de interiores especialista en espacios comerciales</p>
                    </div>
                </div>
            </div>
            <!-- Propietario 4 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <img src="imgPropietarios/hombre.png" class="card-img-top" alt="Avatar 4">
                    <div class="card-body">
                        <h5 class="card-title">Luis Sánchez</h5>
                        <p class="card-text">Ingeniero eléctrico experto en domótica</p>
                    </div>
                </div>
            </div>
            <!-- Propietario 5 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <img src="imgPropietarios/mujer.png" class="card-img-top" alt="Avatar 5">
                    <div class="card-body">
                        <h5 class="card-title">María González</h5>
                        <p class="card-text">Paisajista especializada en jardines urbanos</p>
                    </div>
                </div>
            </div>
            <!-- Propietario 6 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <img src="imgPropietarios/hombre.png" class="card-img-top" alt="Avatar 6">
                    <div class="card-body">
                        <h5 class="card-title">Roberto Díaz</h5>
                        <p class="card-text">Arquitecto restaurador de edificios históricos</p>
                    </div>
                </div>
            </div>
            <!-- Propietario 7 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <img src="imgPropietarios/mujer.png" class="card-img-top" alt="Avatar 7">
                    <div class="card-body">
                        <h5 class="card-title">Patricia López</h5>
                        <p class="card-text">Ingeniera ambiental especialista en construcciones ecológicas</p>
                    </div>
                </div>
            </div>
            <!-- Propietario 8 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <img src="imgPropietarios/hombre.png" class="card-img-top" alt="Avatar 8">
                    <div class="card-body">
                        <h5 class="card-title">Miguel Fernández</h5>
                        <p class="card-text">Diseñador de iluminación para proyectos residenciales y comerciales</p>
                    </div>
                </div>
            </div>
            <!-- Propietario 9 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <img src="imgPropietarios/mujer.png" class="card-img-top" alt="Avatar 9">
                    <div class="card-body">
                        <h5 class="card-title">Sofia Vega</h5>
                        <p class="card-text">Ingeniera acústica especializada en aislamiento sonoro</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="javascript/propietarios.js"></script>
</body>

</html>