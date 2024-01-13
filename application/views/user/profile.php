<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f7fafc;
        }

        .bubaba {
            margin-left: 43%;
        }

        .buru {
            margin-left: 30px;
        }

        @media only screen and (max-width: 767px) {
            .bubaba {
                margin-left: 30%;
            }

            .buru {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <?php $this->load->view('sidebar_user'); ?>

    <?php foreach ($user as $row) : ?>

        <div style="border-radius: 20px;" class="container mx-auto p-5 my-10 bg-green-500 rounded-sm sm:w-3/4 md:w-1/2 lg:w-1/3 xl:w-full">
            <input name="id" type="hidden" value="<?php echo $row->id ?>">

            <p style="font-size: xx-large;" class="font-bold text-xl mb-4 text-center">Akun <?php echo $this->session->userdata('username'); ?></p>

            <?php if (!empty($row->image)) : ?>
                <img src="<?php echo base_url('./image/' . $row->image) ?>" class="mx-auto" height="150" width="250" alt="Profile Image">
            <?php else : ?>
                <img src="https://slabsoft.com/wp-content/uploads/2022/05/pp-wa-kosong-default.jpg" class="mx-auto" height="150" width="150" alt="Default Profile Image" />
            <?php endif; ?>

            <br>
            <h1><?php echo $this->session->flashdata('message'); ?></h1>
            <h1><?php echo $this->session->flashdata('sukses'); ?></h1>
            <br>

            <form method="post" action="<?php echo base_url('user/aksi_ubah_profile'); ?>" enctype="multipart/form-data">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-600">Nama</label>
                        <input type="text" id="nama" name="nama" class="mt-1 p-2 w-full bg-green-100 border rounded-md" value="<?php echo $row->nama; ?>">
                    </div>

                    <div>
                        <label for="nomor" class="block text-sm font-medium text-gray-600">Nomor</label>
                        <input type="number" class="mt-1 p-2 w-full bg-green-100 border rounded-md" id="nomor" name="nomor" value="<?php echo $row->nomor; ?>">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                        <input type="text" id="email" name="email" class="mt-1 p-2 w-full bg-green-100 border rounded-md" value="<?php echo $row->email; ?>">
                    </div>

                    <div class="mb-4">
                        <label for="foto" class="block text-sm font-medium text-gray-600">Foto</label>
                        <input type="file" id="foto" name="foto" class="mt-1 p-2 w-full bg-green-100 border rounded-md">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-600">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 p-2 w-full bg-green-100 border rounded-md" required>
                            <option value="<?php echo $row->jenis_kelamin; ?>"><?php echo $row->jenis_kelamin; ?></option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-4 relative">
                        <label for="password_lama" class="block text-sm font-medium text-gray-600">Password Lama</label>
                        <div class="relative">
                            <input type="password" class="mt-1 p-2 w-full bg-green-100 border rounded-md" id="password_lama" name="password_lama">
                            <button class="btn btn-outline-secondary absolute top-1/2 transform -translate-y-1/2 right-2" type="button" id="togglePasswordLama" onclick="togglePassword('password_lama', 'togglePasswordLama')">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div class="mb-4 relative">
                        <label for="password_baru" class="block text-sm font-medium text-gray-600">Password Baru</label>
                        <div class="relative">
                            <input type="password" class="mt-1 p-2 w-full bg-green-100 border rounded-md" id="password_baru" name="password_baru">
                            <button class="btn btn-outline-secondary absolute top-1/2 transform -translate-y-1/2 right-2" type="button" id="togglePasswordBaru" onclick="togglePassword('password_baru', 'togglePasswordBaru')">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4 relative">
                        <label for="konfirmasi_password" class="block text-sm font-medium text-gray-600">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" class="mt-1 p-2 w-full bg-green-100 border rounded-md" id="konfirmasi_password" name="konfirmasi_password">
                            <button class="btn btn-outline-secondary absolute top-1/2 transform -translate-y-1/2 right-2" type="button" id="toggleKonfirmasiPassword" onclick="togglePassword('konfirmasi_password', 'toggleKonfirmasiPassword')">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bubaba">
                    <button type="submit" class="bg-green-800 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full mr-2" name="submit">Ubah</button>
                    <button type="button" class="buru bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full" onclick="navigateTo('<?php echo base_url('user/hapus_imagee'); ?>')">Hapus Foto</button>
                </div>
            </form>
        </div>
    <?php endforeach; ?>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="your-script.js"></script>
    <script>
        function navigateTo(url) {
            window.location.href = url;
        }

        function togglePassword(inputId, toggleId) {
            var passwordInput = document.getElementById(inputId);
            var toggleButton = document.getElementById(toggleId);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleButton.innerHTML = '<i class="fas fa-eye"></i>'; // Change to eye icon
            } else {
                passwordInput.type = "password";
                toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Change to eye-slash icon
            }
        }
    </script>

</body>

</html>