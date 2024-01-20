<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <link rel="stylesheet" href="path/to/tailwind.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php $this->load->view('sidebar_admin'); ?>

    <?php foreach ($user as $row) : ?>

        <div class="container mx-auto my-10 bg-blue-100 rounded-sm sm:w-3/4 md:w-1/2 lg:w-1/3 xl:w-full p-6 shadow-md">
            <div class="text-center">
                <?php if (!empty($row->image)) : ?>
                    <img src="<?= base_url('./image/' . $row->image) ?>" class="mx-auto mt-4 mb-2 h-48 w-auto rounded-full" alt="Profile Image">
                <?php else : ?>
                    <img src="https://slabsoft.com/wp-content/uploads/2022/05/pp-wa-kosong-default.jpg" class="mx-auto mt-4 mb-2 h-48 w-auto rounded-full" alt="Default Profile Image" />
                <?php endif; ?>
            </div>

            <h5 class="font-bold text-xl mb-4 text-center"><?= $row->nama ?></h5>

            <div class="mb-4 text-center text-green-500">
                <?= $this->session->flashdata('sukses'); ?>
            </div>
            <div class="mb-4 text-center text-red-500">
                <?= $this->session->flashdata('message'); ?>
            </div>

            <form method="post" action="<?= base_url('admin/aksi_ubah_profile'); ?>" enctype="multipart/form-data">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-600">Nama</label>
                        <input type="text" id="nama" name="nama" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" value="<?= $row->nama; ?>">
                    </div>

                    <div>
                        <label for="nomor" class="block text-sm font-medium text-gray-600">Nomor</label>
                        <input type="number" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" id="nomor" name="nomor" value="<?= $row->nomor; ?>">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div class="mb-4">
                        <label for="foto" class="block text-sm font-medium text-gray-600">Foto</label>
                        <input type="file" id="foto" name="foto" class="mt-1 p-1 w-full bg-white border rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-600">Jenis Kelamin</label>
                        <select name="jenis_kelamin" value="<?php $row->jenis_kelamin ?>" id="jenis_kelamin" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
                            <option value="<?= $row->jenis_kelamin ?>">pilih Gender</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="flex justify-between items-center">
                        <button type="button" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded-full mr-2 focus:outline-none focus:shadow-outline-blue" onclick="ubahProfile()">Ubah</button>
                        <button type="button" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline-red" onclick="hapusFoto()">Hapus Foto</button>
                    </div>
                </div>
            </form>

            <!-- Password Form Section -->
            <form method="post" action="<?= base_url('admin/aksi_ubah_password'); ?>" class="mt-6" id="ubahPasswordForm">

                <div class="mb-4 relative">
                    <label for="password_lama" class="block text-sm font-medium text-gray-600">Password Lama</label>
                    <div class="relative">
                        <input type="password" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" id="password_lama" name="password_lama">
                        <button class="btn btn-outline-secondary absolute top-7 transform -translate-y-1/2 right-2" type="button" id="togglePasswordLama" onclick="togglePassword('password_lama', 'togglePasswordLama')">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4 relative">
                    <label for="password_baru" class="block text-sm font-medium text-gray-600">Password Baru</label>
                    <div class="relative">
                        <input type="password" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" id="password_baru" name="password_baru">
                        <button class="btn btn-outline-secondary absolute top-7 transform -translate-y-1/2 right-2" type="button" id="togglePasswordBaru" onclick="togglePassword('password_baru', 'togglePasswordBaru')">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4 relative">
                    <label for="konfirmasi_password" class="block text-sm font-medium text-gray-600">Konfirmasi Password</label>
                    <div class="relative">
                        <input type="password" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" id="konfirmasi_password" name="konfirmasi_password">
                        <button class="btn btn-outline-secondary absolute top-7 transform -translate-y-1/2 right-2" type="button" id="toggleKonfirmasiPassword" onclick="togglePassword('konfirmasi_password', 'toggleKonfirmasiPassword')">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <button type="button" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded-full mr-2 focus:outline-none focus:shadow-outline-blue" onclick="confirmPasswordChange()">Ubah Password</button>
                </div>

            </form>

        </div>
    <?php endforeach; ?>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function confirmPasswordChange() {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin mengubah password?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Ubah",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('ubahPasswordForm').submit();
                }
            });
        }

        function navigateTo(url) {
            window.location.href = url;
        }

        function togglePassword(inputId, toggleId) {
            var passwordInput = document.getElementById(inputId);
            var toggleButton = document.getElementById(toggleId);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
            } else {
                passwordInput.type = "password";
                toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
            }
        }

        function ubahProfile() {
            Swal.fire({
                title: "Ubah Profile",
                text: "Anda yakin ingin mengubah profile?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Ubah",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Berhasil",
                        text: "Profil berhasil diubah",
                        icon: "success",
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        document.querySelector("form").submit();
                    }, 2000);
                }
            });
        }

        function hapusFoto() {
            Swal.fire({
                title: "Hapus Foto",
                text: "Anda yakin ingin menghapus foto profil?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Berhasil",
                        text: "Foto profil berhasil dihapus",
                        icon: "success",
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        navigateTo('<?php echo base_url('admin/hapus_imagee'); ?>');
                    }, 2000);
                }
            });
        }
    </script>
</body>

</html>