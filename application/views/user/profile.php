<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
</head>

<body>

    <?php $this->load->view('sidebar_user'); ?>

    <?php foreach ($user as $row) : ?>

        <div class="container mx-auto p-5 my-10 bg-blue-100 rounded-sm sm:w-3/4 md:w-1/2 lg:w-1/3 xl:w-full">
            <input name="id" type="hidden" value="<?php echo $row->id ?>">

            <p class="font-bold text-xl mb-4 text-center">Akun <?php echo $this->session->userdata('username'); ?></p>

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
                        <input type="text" id="nama" name="nama" class="mt-1 p-2 w-full border rounded-md" value="<?php echo $row->nama; ?>">
                    </div>

                    <div>
                        <label for="nomor" class="block text-sm font-medium text-gray-600">Nomor</label>
                        <input type="number" class="mt-1 p-2 w-full border rounded-md" id="nomor" name="nomor" value="<?php echo $row->nomor; ?>">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                        <input type="text" id="email" name="email" class="mt-1 p-2 w-full border rounded-md" value="<?php echo $row->email; ?>">
                    </div>

                    <div class="mb-4">
                        <label for="foto" class="block text-sm font-medium text-gray-600">Foto</label>
                        <input type="file" id="foto" name="foto" class="mt-1 p-2 w-full bg-white border rounded-md">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-600">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 p-2 w-full border rounded-md" required>
                            <option value="<?php echo $row->jenis_kelamin; ?>"><?php echo $row->jenis_kelamin; ?></option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-4 relative">
                        <label for="password_lama" class="block text-sm font-medium text-gray-600">Password Lama</label>
                        <div class="relative">
                            <input type="password" class="mt-1 p-2 w-full border rounded-md" id="password_lama" name="password_lama">
                            <button class="btn btn-outline-secondary absolute top-7 transform -translate-y-1/2 right-2" type="button" id="togglePasswordLama" onclick="togglePassword('password_lama', 'togglePasswordLama')">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div class="mb-4 relative">
                        <label for="password_baru" class="block text-sm font-medium text-gray-600">Password Baru</label>
                        <div class="relative">
                            <input type="password" class="mt-1 p-2 w-full border rounded-md" id="password_baru" name="password_baru">
                            <button class="btn btn-outline-secondary absolute top-7 transform -translate-y-1/2 right-2" type="button" id="togglePasswordBaru" onclick="togglePassword('password_baru', 'togglePasswordBaru')">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4 relative">
                        <label for="konfirmasi_password" class="block text-sm font-medium text-gray-600">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" class="mt-1 p-2 w-full border rounded-md" id="konfirmasi_password" name="konfirmasi_password">
                            <button class="btn btn-outline-secondary absolute top-7 transform -translate-y-1/2 right-2" type="button" id="toggleKonfirmasiPassword" onclick="togglePassword('konfirmasi_password', 'toggleKonfirmasiPassword')">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <button type="button" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded-full mr-2" onclick="ubahProfile()">Ubah</button>
                    <button type="button" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 rounded-full" onclick="hapusFoto()">Hapus Foto</button>
                </div>
            </form>
        </div>
    <?php endforeach; ?>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
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
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#dc3545",
                confirmButtonText: "Ubah",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Berhasil",
                        text: "Profil berhasil diubah",
                        icon: "success",
                        timer: 2000, // Timer dalam milidetik (2000ms = 2 detik)
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
                        timer: 2000, // Timer dalam milidetik (2000ms = 2 detik)
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        navigateTo('<?php echo base_url('user/hapus_imagee'); ?>');
                    }, 2000);
                }
            });
        }
    </script>
</body>

</html>