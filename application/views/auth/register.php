<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Pendaftaran Aktivitas Lingkungan</title>
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
        }

        .container {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form h2 {
            text-align: center;
        }

        label {
            margin-bottom: 8px;
        }

        input,
        textarea,
        select {
            width: 100%;
            margin-bottom: 16px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a024;
        }

        .password-container {
            position: relative;
        }

        #password {
            padding-right: 40px;
        }

        .password-icon {
            position: absolute;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        /* Menambahkan media query untuk responsif */
        @media only screen and (max-width: 600px) {
            .container {
                max-width: 100%;
                margin: 20px auto;
            }
        }

        .eye-icon-container {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 3;
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="post" action="<?php echo base_url('auth/submit') ?>">
            <h2>Pendaftaran</h2>
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>


            <div class="password-container">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <div class="eye-icon-container">
                    <span class="password-icon" onclick="togglePassword()">
                        <i id="eye-icon" class="far fa-eye-slash"></i>
                    </span>
                </div>
            </div>

            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" required></textarea>

            <label for="jenis_kelamin">Jenis Kelamin:</label>
            <select id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="laki-laki">Laki-laki</option>
                <option value="perempuan">Perempuan</option>
            </select>

            <label for="aktivitas">Aktivitas:</label>
            <textarea id="aktivitas" name="aktivitas" required></textarea>

            <button type="submit">Daftar</button>
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