<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="path/to/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9' crossorigin='anonymous'>
    <title>Pendaftaran Aktivitas Lingkungan</title>
    <script src="path/to/sweetalert2.all.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            overflow: hidden;
            background-image: url('https://png.pngtree.com/thumb_back/fw800/background/20230425/pngtree-forest-image_2479472.jpg');
            background-size: 1370px;
            background-repeat: no-repeat;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
        }

        .card label {
            margin-bottom: 5px;
        }

        .card input,
        .card textarea,
        .card select {
            margin-bottom: 10px;
        }

        .password-container {
            position: relative;
        }

        .eye-icon-container {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body class='min-vh-100 d-flex align-items-center'>
    <div class='card w-50 m-auto p-3'>
        <h2 style="text-align: center; font-weight: bold;">Pendaftaran</h2>

        <form method="post" action="<?php echo base_url('auth/submit') ?>">

            <div class="row">
                <div class="col-12 col-md-6">
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" name="nama" class="form-control" required>
                </div>

                <div class="col-12 col-md-6">
                    <label for="jenis_kelamin">Jenis Kelamin:</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                        <option value="#">Pilih Jenis Kelamin</option>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="col-12 col-md-6">
                    <label for="alamat">Alamat:</label>
                    <textarea id="alamat" name="alamat" class="form-control" required></textarea>
                </div>

                <div class="col-12 col-md-6">
                    <label for="password">Password:</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" class="form-control" required>
                        <div class="eye-icon-container">
                            <span class="password-icon" onclick="togglePassword()">
                                <i id="eye-icon" class="far fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>
                    <p style="color: red;">* Password Minimal menggunakan 8 Karakter</p>
                </div>

                <div class="col-12 col-md-6">
                    <label for="aktivitas">Aktivitas:</label>
                    <textarea id="aktivitas" name="aktivitas" class="form-control" required></textarea>
                </div>

                <div class="col-12">
                    <button class="btn btn-success" type="submit">Daftar</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById('password');
            var eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>

</html>