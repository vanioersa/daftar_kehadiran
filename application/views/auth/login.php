<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Login Aktivitas Lingkungan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            overflow: hidden;
            /* Menyembunyikan scroll pada body */
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            /* Menampilkan scroll pada container jika content melebihi container */
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form h1 {
            text-align: center;
            font-weight: bold;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            margin-bottom: 16px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            color: red;
            margin-bottom: 16px;
        }

        .password-container {
            position: relative;
            margin-bottom: 16px;
        }

        #password {
            padding-right: 40px;
            /* Menyisakan ruang untuk ikon mata */
        }

        .password-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="post" action="<?php echo base_url('auth/submit_login') ?>">
            <h1>Login</h1>
            <br>
            <?php echo $this->session->flashdata('error'); ?>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <div class="password-container">
                <label for="password">Password:</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" required>
                    <span class="password-icon" onclick="togglePassword()">
                        <i id="eye-icon" class="far fa-eye-slash"></i>
                    </span>
                </div>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            }
        }
    </script>

</body>

</html>