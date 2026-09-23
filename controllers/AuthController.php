<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'models/Usuario.php';

class AuthController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    public function login() {
        if (isset($_SESSION['user_id'])) {
            header('Location: /spare-parts-jb/home');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            if (empty($email) || empty($password)) {
                $error = "Por favor completa todos los campos.";
                require_once 'views/auth/login.php';
                return;
            }

            $user = $this->usuarioModel->obtenerPorEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id_usuario'];
                $_SESSION['user_nombre'] = $user['nombre'];
                $_SESSION['user_email'] = $user['email'];
                
                // Asignación robusta del rol para que reconozca el ID 1 como administrador
                if (isset($user['id_rol']) && $user['id_rol'] == 1) {
                    $_SESSION['rol'] = 'admin';
                    $_SESSION['user_rol'] = 'admin';
                } else {
                    $_SESSION['rol'] = $user['rol'] ?? 'cliente';
                    $_SESSION['user_rol'] = $user['rol'] ?? 'cliente';
                }

                header('Location: /spare-parts-jb/home');
                exit;
            } else {
                $error = "Correo o contraseña incorrectos.";
                require_once 'views/auth/login.php';
            }
        } else {
            require_once 'views/auth/login.php';
        }
    }

    public function registro() {
        if (isset($_SESSION['user_id'])) {
            header('Location: /spare-parts-jb/home');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $telefono = trim($_POST['telefono'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');

            if (empty($nombre) || empty($email) || empty($password)) {
                $error = "Nombre, correo y contraseña son obligatorios.";
                require_once 'views/auth/registro.php';
                return;
            }

            if ($this->usuarioModel->emailExiste($email)) {
                $error = "El correo ya está registrado.";
                require_once 'views/auth/registro.php';
                return;
            }

            if ($this->usuarioModel->registrar($nombre, $email, $password, $telefono, $direccion)) {
                header('Location: /spare-parts-jb/auth/login?registrado=1');
                exit;
            } else {
                $error = "Error al crear la cuenta.";
                require_once 'views/auth/registro.php';
            }
        } else {
            require_once 'views/auth/registro.php';
        }
    }

    public function register() {
        $this->registro();
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /spare-parts-jb/auth/login');
        exit;
    }
}