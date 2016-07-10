<?php

class User extends Controller {
    public function profile() {
        if($this->isLogged) {
            $this->template = __DIR__."/templates/profile.php";
            include(__DIR__."/templates/layout.php");
        } else {
            header("Location: index.php");
        }
    }

    public function signup() {
        if($this->isLogged) {
            header("Location: index.php");
        } else {
            $this->template = __DIR__."/templates/register_form.php";
            include(__DIR__."/templates/layout.php");
        }
    }

    // Functions that DO NOT produce html directly but redirect
    public function login() {
        if($this->isLogged) {
            header("Location: index.php");
        } else {
            session_start();
            $conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE); 

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 

            // username and password sent from form 
            $user_param = $_POST['username']; 
            $pwd_param = $_POST['password']; 

            $sql = "SELECT * FROM Users WHERE username='".$user_param."' AND password='".$pwd_param."'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo $row['id'];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                header("Location: index.php");
            } else {
                header("Location: index.php?error=Invalid credentials");
                echo "error";
            }
            $conn->close();
        }
    }

    public function logout() {
        if($this->isLogged) {
            session_start();
            unset($_SESSION['user_id']);
            unset($_SESSION["username"]);
            if(session_destroy()) {
                header("Location: index.php");
            }
        } else {
            header("Location: index.php");
        }
    }
    public function register() {
        session_start();
        $conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE); 
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        if (!empty($_POST['username'])) {
            $user_param = $_POST['username']; 
        } else {
            header("Location: signup.php?error=Missing parameter");
        }
        if (!empty($_POST['password'])) {
            $pwd_param = $_POST['password'];
        } else {
            header("Location: signup.php?error=Missing parameter");
        }
          
        if (!empty($_POST['password-confirm'])) {
            $pwd_confirm = $_POST['password-confirm'];
        } else {
            header("Location: signup.php?error=Missing parameter");
        }
        if (!empty($_POST['email'])) {
            $email_param = $_POST['email']; 
        } else {
            header("Location: signup.php?error=Missing parameter");
        }
        if (!empty($_POST['entity'])) {
            $entity_param = $_POST['entity'];
        } else {
            $entity_param = "";
        }
        if (!empty($_POST['role'])) {
            $role=0;
        } else {
            $role=1;
        }

        $sql1 = "SELECT * FROM Users WHERE username = '$user_param'";
        $sql2 = "SELECT * FROM Users WHERE email = '$email_param'";

        if ($pwd_param!=$pwd_confirm) {
            header("Location: signup.php?error=Password mismatch");
        }
        if (!filter_var($email_param,  FILTER_VALIDATE_EMAIL)) {
            header("Location: signup.php?error=Password mismatch");
        }

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {
            header("Location: signup.php?error=Username already in use");
        }
        $result = $conn->query($sql2);
        if ($result->num_rows > 0) {
            header("Location: signup.php?error=Email already in use");
        } else {
            $sql = "INSERT INTO Users(username, password, email, entity, role) VALUES ('$user_param', '$pwd_param','$email_param','$entity_param',$role)";
            $result = $conn->query($sql);
            header("Location: index.php?status=Cuenta creada con exito");
        }
        $conn->close();
    }
}