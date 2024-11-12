<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oasis Urbano - Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: url('https://www.pexels.com/es-es/foto/cuerpo-de-agua-entre-arboles-de-hojas-verdes-709552/') no-repeat center center fixed;
            background-size: cover;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            clip-path: polygon(0 0, 100% 0, 100% 75%, 0 100%);
        }
        .login-container {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        .login-form {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 3rem;
            width: 400px;
            margin-right: 8%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            z-index: 3;
        }
        h1, h2 {
            color: #2c3e50;
            text-align: center;
        }
        input {
            width: 100%;
            padding: 0.8rem;
            margin: 0.8rem 0;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        button {
            width: 100%;
            padding: 0.8rem;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background-color: #c0392b;
        }
        .diagonal-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 65%;
            height: 100%;
            clip-path: polygon(0 0, 100% 0, 85% 100%, 0 100%);
        }
        .diagonal-image img {
            width: 100%;
            height: auto;
        }
        .error-message {
            color: red;
            text-align: center; 
        }
    </style>
</head>
<body>
<?php
// Incluir archivo de conexión
include('conexion.php');

// Iniciar la sesión al principio del archivo login.php
session_start();

// Verificar si el formulario de login ha sido enviado
if (isset($_POST['login'])) {
    // Obtener los valores del formulario
    $email = $_POST['email'];
    $contrasena = $_POST['password'];

    // Preparar la consulta
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE CorreoElectronico = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Si existe el usuario
    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        
        // Verificar la contraseña
        if (password_verify($contrasena, $usuario['Contrasena'])) {
            // Almacenar datos del usuario en la sesión
            $_SESSION['nombre'] = $usuario['Nombre'];
            $_SESSION['rolID'] = $usuario['RolID'];

            // Redirigir al cliente o al administrador según el rol
            if ($usuario['RolID'] == 2) {
                header("Location: ABM/inicio.php");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }
        } else {
            // Contraseña incorrecta
            echo "<script>$(document).ready(function() { 
                $('#login-error').text('Contraseña incorrecta').show(); 
            });</script>";
        }
    } else {
        // Correo no encontrado
        echo "<script>$(document).ready(function() { 
            $('#login-error').text('El correo electrónico no existe').show(); 
        });</script>";
    }

    $stmt->close();
}


// Registro de nuevo usuario
if (isset($_POST['register'])) {
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $emailNuevo = $_POST['CorreoElectronico'];
    $contrasenaNueva = password_hash($_POST['Contrasena'], PASSWORD_DEFAULT);
    $telefono = $_POST['Telefono'];

    // Verificar si el correo ya existe
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE CorreoElectronico = ?");
    $stmt->bind_param("s", $emailNuevo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        echo "<script>$('#register-error').text('El correo ya está registrado.').show();</script>";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO usuarios (Nombre, Apellido, CorreoElectronico, Contrasena, Telefono, RolID) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("sssss", $nombre, $apellido, $emailNuevo, $contrasenaNueva, $telefono);
        
        if ($stmt->execute()) {
            echo "<script>alert('Usuario creado exitosamente');</script>";
        } else {
            echo "<script>$('#register-error').text('Error al crear usuario.').show();</script>";
        }
    }
}
?>

    <div class="overlay"></div>
    <div class="login-container">
        <div class="diagonal-image">
            <img src="img/relax.jpeg" alt="Oasis Urbano">
        </div>
        
        <div class="login-form">
            <h1>Oasis Urbano</h1>
            <h2>Iniciar Sesión</h2>
            
            <form id="loginForm" method="post">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <div>
                    <input type="password" name="password" id="password" placeholder="Contraseña" required>
                    <span class="toggle-password" id="toggle-password">Mostrar</span>
                </div>
                <button type="submit" name="login">Ingresar</button>
                <div class="error-message" id="login-error" style="display:none;"></div>
                <div class="signup-link">
                    <a href="#">Olvidaste la contraseña?</a> | 
                    <a id="crearUsuario">Crear Usuario</a>
                </div>
            </form>

            <!-- Superposición para crear un usuario -->
            <div class="superposicion" id="superposicionUsuario" style="display:none;">
                <h2>Crear Usuario</h2>
                <form id="createUserForm" method="POST">
                    <input type="text" name="Nombre" id="Nombre" placeholder="Nombre" required>
                    <input type="text" name="Apellido" id="Apellido" placeholder="Apellido" required>
                    <input type="email" name="CorreoElectronico" id="CorreoElectronicoNuevo" placeholder="Correo Electrónico" required>
                    <div class="error-message" id="register-error" style="display:none;"></div>
                    <input type="password" name="Contrasena" id="ContrasenaNueva" placeholder="Contraseña" required>
                    <input type="text" name="Telefono" id="Telefono" placeholder="Teléfono" required>

                    <button type="submit" name="register">Registrar Usuario</button>
                </form>
                <button id="cerrarSuperposicion">Cerrar</button>
            </div>

        </div>
    </div>

    <!-- JavaScript para mostrar/ocultar la contraseña -->
    <script>
    $(document).ready(function () {
        $("#toggle-password").on('click', function () {
            let passwordField = $("#password");
            let type = passwordField.attr('type') === 'password' ? 'text' : 'password';
            passwordField.attr('type', type);
            $(this).text($(this).text() === 'Mostrar' ? 'Ocultar' : 'Mostrar');
        });

        $("#crearUsuario").on('click', function () {
            $("#superposicionUsuario").show();
        });

        $("#cerrarSuperposicion").on('click', function () {
            $("#superposicionUsuario").hide();
        });
    });
    </script>
</body>
</html>