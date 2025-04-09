<?php
session_start();
include "db.php";

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $username;
            header("Location: home.php");
            exit();
        } else {
            $error = "⚠ Contraseña incorrecta.";
        }
    } else {
        $error = "⚠ Usuario no encontrado.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('fondo.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            width: 350px;
            margin: 100px auto;
            background: rgba(0, 0, 50, 0.6);
            padding: 30px;
            border-radius: 10px;
            color: #fff;
            backdrop-filter: blur(6px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: none;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 25px;
            background: #007BFF;
            color: white;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #0056b3;
        }

        .link {
            text-align: center;
            margin-top: 10px;
        }

        .link a {
            color: #ccc;
            text-decoration: none;
        }

        .error {
            color: #ff8080;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>INICIO DE SESION</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Iniciar Sesion</button>
        </form>
        <div class="link">
            <p>¿No tienes cuenta? <a href="register.php">REGISTRARSE</a></p>
        </div>
    </div>
</body>
</html>
