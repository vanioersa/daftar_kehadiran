<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Pendaftaran Peduli Lindungi alam</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: url('https://png.pngtree.com/thumb_back/fw800/background/20230504/pngtree-painting-rainforest-scene-along-a-riverbank-ai-generated-image_2590576.jpg') no-repeat;
        background-size: cover;
        background-position: center;
    }

    .wrapper {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        justify-content: center;
        align-items: center;
        width: 400px;
        height: 500px;
        box-shadow: 0 0 60px #000;
        border-radius: 10px;
    }

    h2 {
        font-size: 2em;
        color: #fff;
        text-align: center;
    }

    .input-group {
        position: relative;
        width: 320px;
        margin: 30px 0;
    }

    .input-group input,
    .input-group textarea {
        width: 100%;
        height: 40px;
        font-size: 1em;
        color: #fff;
        padding: 0 10px 0 35px;
        background: transparent;
        border: 1px solid #fff;
        outline: none;
        border-radius: 5px;
    }

    .input-group select {
        width: 100%;
        height: 40px;
        font-size: 1em;
        color: green;
        padding: 0 10px 0 35px;
        background: transparent;
        border: 1px solid #fff;
        outline: none;
        border-radius: 5px;
    }

    .input-group input::placeholder {
        color: rgba(255, 255, 255, .3);
    }

    .input-group .icon {
        position: absolute;
        display: block;
        left: 10px;
        color: #fff;
        font-size: 1.2em;
        line-height: 45px;
    }

    .input-group .eye-icon-container {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        color: white;
    }

    .input-group .eye-icon-container input {
        width: 16px;
        height: 16px;
        margin-right: 5px;
    }

    .forgot-pass {
        margin: -15px 0 15px;
    }

    .forgot-pass a {
        color: #fff;
        font-size: .9em;
        text-decoration: none;
    }

    .forgot-pass a:hover {
        text-decoration: underline;
    }

    .btn {
        width: 100%;
        position: relative;
        width: 100%;
        height: 40px;
        background: green;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .4);
        font-size: 1em;
        color: #fff;
        font-weight: 500;
        cursor: pointer;
        border-radius: 5px;
        border: none;
        outline: none;
        transition: .5s;
    }

    .btn:hover {
        background: #fff;
        color: green;
    }

    .sign-link {
        font-size: .9em;
        text-align: center;
        margin: 25px 0;
    }

    .sign-link p {
        color: #fff;
    }

    .sign-link p a {
        color: #fff;
        text-decoration: none;
        font-weight: 600;
    }

    .sign-link p a:hover {
        text-decoration: underline;
    }
</style>

<body>
    <div class="wrapper">
        <form method="post" action="<?php echo base_url('auth/submit') ?>">
            <h2>Pendaftaran User</h2>
            <div class="input-group">
                <span class="icon">
                    <i class="fas fa-user"></i>
                </span>
                <input type="text" id="nama" placeholder="Nama" name="nama" class="form-control" required>
            </div>

            <div class="input-group">
                <span class="icon">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <input type="number" id="nomor" placeholder="nomor" name="nomor" class="form-control" required>
            </div>

            <div class="input-group">
                <span class="icon">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" id="email" placeholder="Email" name="email" class="form-control" required>
            </div>

            <div class="input-group">
                <span class="icon">
                    <i class="fas fa-restroom"></i>
                </span>
                <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                    <option value="#">Pilih Jenis Kelamin</option>
                    <option value="laki-laki">Laki-laki</option>
                    <option value="perempuan">Perempuan</option>
                </select>
            </div>

            <div class="input-group">
                <span class="icon">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="password" placeholder="Password" id="password" name="password" class="form-control" required>
                <div class="eye-icon-container">
                    <i id="eye-icon" onclick="togglePassword()" class="fas fa-eye-slash"></i>
                </div>
                <br>
                <p style="color: red;">*Password minimal 8  karakter</p>
            </div>

            <div class="forgot-pass">

            </div>

            <button type="submit" class="btn">Daftar</button>
            <div class="sign-link">
            </div>
        </form>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
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