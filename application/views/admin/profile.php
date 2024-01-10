<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Profile</title>
</head>

<style>
    /* Your existing styles for body, root, scroll bar, etc. */

    /* Wrapper for Profile Information */
    .profile-container {
        max-width: 80%;
        margin: auto;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 50px;
        /* Adjust as needed */
    }

    .profile-container img {
        display: block;
        margin: auto;
        margin-bottom: 20px;
        border-radius: 50%;
        max-width: 100%;
        /* Make sure the image is responsive */
    }

    .profile-container form {
        margin-top: 20px;
    }

    /* Add more styles as needed */

    @media (max-width: 768px) {
        .profile-container {
            max-width: 90%;
        }
    }

    @media (max-width: 576px) {
        .profile-container {
            max-width: 95%;
        }
    }
</style>

<body>
    <?php $this->load->view('sidebar_admin'); ?>
    <?php $no = 0;
    foreach ($user as $row) : $no++; ?>
        <div class="profile-container">
            <div>
                <?php echo $this->session->flashdata('message'); ?>
            </div>

            <div>
                <?php echo $this->session->flashdata('sukses'); ?>
            </div>

            <div class="row text-center">
                <input name="id" type="hidden" value="<?php echo $row->id ?>">
                <div class="text">
                    <b>Akun <?php echo $this->session->userdata('username'); ?></b>
                </div>

                <span class="border border-0 btn btn-link d-block mx-auto">
                    <?php if (!empty($row->image)) : ?>
                        <img src="<?php echo base_url('./image/' . $row->image) ?>" height="250" width="250">
                    <?php else : ?>
                        <img class="rounded-circle " height="150" width="150" src="https://slabsoft.com/wp-content/uploads/2022/05/pp-wa-kosong-default.jpg" />
                    <?php endif; ?>
                </span>

                <br> <br>

                <input name="id" type="hidden" value="<?php echo $row->id; ?>">
                <form method="post" action="<?php echo base_url('admin/aksi_ubah_profilee'); ?>" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-md-6">
                            <label for="" class="form-label fs-5"><b>Nama</b></label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row->nama; ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="" class="form-label fs-5"><b>Email</b></label>
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $row->email; ?>">
                        </div>
                        <br>
                        <div class="col-md-6">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>

                        <div class="col-md-6">
                            <label for="" class="form-label fs-5"><b>Jenis Kelamin</b></label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                                <option value="<?php echo $row->jenis_kelamin; ?>"><?php echo $row->jenis_kelamin; ?></option>
                                <option value="laki-laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="password_lama" class="form-label"><b>Password Lama</b></label>
                            <div class="input-group mb-3"><input type="password" class="form-control" id="password_lama" name="password_lama">
                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordlama" onclick="togglePassword('password_lama', 'togglePasswordLama')"><i class="fas fa-eye-slash"></i></button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="password_baru" class="form-label"><b>Password Baru</b></label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="password_baru" name="password_baru">
                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordBaru" onclick="togglePassword('password_baru', 'togglePasswordBaru')"><i class="fas fa-eye-slash"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="konfirmasi_password" class="form-label"><b>Konfirmasi Password</b></label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password">
                                <button class="btn btn-outline-secondary" type="button" id="toggleKonfirmasiPassword" onclick="togglePassword('konfirmasi_password', 'toggleKonfirmasiPassword')"><i class="fas fa-eye-slash"></i></button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success" name="submit">Ubah</button>
                        </div>
                    </div>
                </form>

                <form method="post" action="<?php echo base_url('admin/hapus_imagee'); ?>" enctype="multipart/form-data">
                    <button type="submit" class="btn btn-danger" onclick="navigateTo('<?php echo base_url('admin/hapus_image'); ?>')">Hapus Foto</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="your-script.js"></script>
    <script>
        function navigateTo(url) {
            window.location.href = url;
        }

        function togglePassword(inputId, buttonId) {
            const inputElement = document.getElementById(inputId);
            const buttonElement = document.getElementById(buttonId);

            if (inputElement.type === "password") {
                inputElement.type = "text";
                buttonElement.innerHTML = '<i class="fas fa-eye"></i>';
            } else {
                inputElement.type = "password";
                buttonElement.innerHTML = '<i class="fas fa-eye-slash"></i>';
            }
        }

        // Attach the SweetAlert confirmation to the "Logout" button
        document.getElementById('logout-button').addEventListener('click', function(e) {
            e.preventDefault();
            showLogoutConfirmation();
        });
    </script>
</body>

</html>