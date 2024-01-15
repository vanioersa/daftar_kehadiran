<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Public Deskripsi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .babu {
            max-width: 600px;
            margin: 80px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            background-color: #fff;
        }

        .buba {
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .group-form {
            font-size: 1.2rem;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: white;
        }

        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        .back-btn {
            position: absolute;
            bottom: 10px;
            right: 50px;
            padding: 10px 15px;
            background-color: #6c757d;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        @media only screen and (max-width: 767px) {
            .buru {
                margin-left: 49%;
            }

            .back-btn {
                margin-bottom: 5px;
                margin-right: 60%;
                width: 80px;
            }
        }
    </style>
</head>

<body>
    <?php $this->load->view('sidebar_admin'); ?>
    <div class="babu container bg-green-500">
        <h1 class="buba text-center">Ubah Public Deskripsi</h1>

        <form action="<?php echo base_url('admin/aksi_edit_card/' . $public->id) ?>" method="post" id="edit-form" class="survey-form" enctype="multipart/form-data">
            <div class="form-group">
                <label class="group-form" for="deskripsi">Deskripsi</label>
                <input type="text" id="deskripsi" name="deskripsi" class="form-control" value="<?php echo $public->deskripsi; ?>">
            </div>

            <div class="form-group">
                <label class="group-form" for="tempat">Lokasi</label>
                <input type="text" id="tempat" name="tempat" class="form-control" value="<?php echo $public->tempat; ?>">
            </div>

            <div class="form-group">
                <label class="group-form" for="foto">Foto</label>
                <input type="file" id="foto" name="foto" value="<?php echo $public->image; ?>" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary text-bg-black" id="submit">Submit</button>

            <form action="<?php echo base_url('admin/hapus_image/' . $public->id) ?>" method="post" id="edit-form" enctype="multipart/form-data">
                <input type="button" id="submitt" class="bg-red-500 text-white px-4 py-2 rounded buru" value="Hapus Foto" onclick="deleteImage('<?= $public->id ?>')">
            </form>
        </form>
    </div>
    <a class="btn btn-secondary back-btn" onclick="confirmGoBack()">Kembali</a>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function confirmGoBack() {
            Swal.fire({
                text: 'Apakah Anda yakin ingin kembali?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo base_url('admin/public') ?>";
                }
            });
        }

        function deleteImage(imageId) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus foto ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('admin/hapus_image/') ?>" + imageId,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Berhasil Menghapus',
                                    text: response.message,
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function() {
                                    // Redirect ke URL tujuan setelah berhasil
                                    window.location.href = response.redirect;
                                });
                            } else if (response.status === 'error') {
                                Swal.fire({
                                    title: 'Gagal',
                                    text: response.message,
                                    icon: 'error',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error',
                                text: 'Terjadi kesalahan saat melakukan permintaan.',
                                icon: 'error',
                            });
                        }
                    });
                }
            });
        }

        $(document).ready(function() {
            const form = document.getElementById("edit-form");

            form.addEventListener("submit", function(e) {
                e.preventDefault();

                if (e.submitter.id === "submit") {
                    // Use SweetAlert to confirm export
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin menyimpan perubahan?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#4F709C',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById("submit").disabled = true;

                            const id = $("#room_id").val();
                            const formData = new FormData(this);

                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url('admin/aksi_edit_card/' . $public->id) ?>",
                                data: formData,
                                contentType: false,
                                processData: false,
                                dataType: "json",
                                success: function(response) {
                                    if (response.status === 'success') {
                                        Swal.fire({
                                            title: 'Berhasil Mengubah Deskripsi Public',
                                            text: response.message,
                                            icon: 'success',
                                            showConfirmButton: false,
                                            timer: 2000
                                        }).then(function() {
                                            // Redirect ke URL tujuan setelah berhasil
                                            window.location.href = response.redirect;
                                        });
                                    } else if (response.status === 'error') {
                                        Swal.fire({
                                            title: 'Gagal',
                                            text: response.message,
                                            icon: 'error',
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                    }

                                    document.getElementById("submit").disabled = false;
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>