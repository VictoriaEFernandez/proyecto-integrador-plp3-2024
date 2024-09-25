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
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Animi eos natus sed, esse aperiam recusandae minima doloremque reiciendis in neque, corporis culpa enim sit placeat sapiente sunt unde id excepturi?</p>
                    </div>
                </div>
            </div>
            <!-- Propietario 2 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <img src="imgPropietarios/hombre.png" class="card-img-top" alt="Avatar 2">
                    <div class="card-body">
                        <h5 class="card-title">Carlos Rodríguez</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos nostrum corrupti fuga, eaque molestias impedit maxime dolore fugit expedita dicta ex? Ab fugit provident omnis ut aperiam architecto illo neque.</p>
                    </div>
                </div>
            </div>
            <!-- Propietario 3 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <img src="imgPropietarios/mujer.png" class="card-img-top" alt="Avatar 3">
                    <div class="card-body">
                        <h5 class="card-title">Elena Torres</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi facere facilis doloribus, rem, mollitia quas magnam beatae libero repellendus adipisci enim voluptatum eum dicta maxime, aspernatur neque sunt voluptate cumque.</p>
                    </div>
                </div>
            </div>
            <!-- Propietario 4 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <img src="imgPropietarios/hombre.png" class="card-img-top" alt="Avatar 4">
                    <div class="card-body">
                        <h5 class="card-title">Luis Sánchez</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque, debitis facere iusto exercitationem officiis iste reprehenderit numquam magni velit delectus sapiente ea voluptatum accusamus officia corporis, alias inventore veritatis voluptates.</p>
                    </div>
                </div>
            </div>
            <!-- Propietario 5 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <img src="imgPropietarios/mujer.png" class="card-img-top" alt="Avatar 5">
                    <div class="card-body">
                        <h5 class="card-title">María González</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque vero modi officia at! Dolor recusandae sequi eum quaerat distinctio animi exercitationem quidem quis cum voluptatem dignissimos, accusamus vitae! Accusamus, consequuntur?</p>
                    </div>
                </div>
            </div>
            <!-- Propietario 6 -->
            <div class="col">
                <div class="card h-100 text-center">
                    <img src="imgPropietarios/hombre.png" class="card-img-top" alt="Avatar 6">
                    <div class="card-body">
                        <h5 class="card-title">Roberto Díaz</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos ipsum eos incidunt enim fugit iure voluptatem, corrupti perferendis provident dignissimos modi labore eveniet laboriosam sed perspiciatis maxime sint ipsam repudiandae.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="javascript/propietarios.js"></script>
</body>

</html>