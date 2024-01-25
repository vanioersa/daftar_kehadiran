<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Tambah Public Deskripsi</title>
    <script src="https://cdn.jsdelivr.net/momentjs/2.29.1/moment.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .content {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            background-color: #fff;
        }

        .title {
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
        input[type="file"],
        input[type="datetime-local"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: white;
        }

        button,
        .back-btn {
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .back-btn {
            background-color: #6c757d;
            color: #fff;
            border: none;
            position: absolute;
            bottom: 10px;
            right: 20px;
        }

        @media only screen and (max-width: 767px) {
            .back-btn {
                margin-right: 1%;
                width: 80px;
            }
        }
    </style>
</head>

<body>
    <?php $this->load->view('sidebar_admin'); ?>
    <div class="content bg-blue-200">
        <h1 class="title">Tambah Public Deskripsi</h1>

        <form action="<?php echo base_url('admin/aksi_tambah_card') ?>" method="post" id="survey-form" class="survey-form">
            <div class="form-group">
                <label class="group-form" for="tempat">Lokasi</label>
                <input type="text" id="tempat" name="tempat" class="form-control" placeholder="Lokasi atau tempat" required>
            </div>

            <div class="form-group">
                <label class="group-form" for="waktu_kejadian">Waktu Kejadian</label>
                <input type="datetime-local" id="waktu_kejadian" name="waktu_kejadian" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="group-form" for="deskripsi">Deskripsi</label>
                <input type="text" id="deskripsi" name="deskripsi" class="form-control" placeholder="Keterangan " required>
            </div>

            <div class="form-group">
                <label class="group-form" for="foto">Foto</label>
                <input type="file" id="foto" name="foto" class="form-control" required>
            </div>

            <input type="hidden" id="tanggal" name="tanggal" class="form-control" required>
            <input type="hidden" id="jam" name="jam" class="form-control" required>

            <button type="submit" id="submit" class="bg-blue-500 hover:bg-blue-700 px-5 py-2 text-white rounded">Tambah</button>
        </form>
        <a class="btn btn-secondary back-btn" onclick="confirmGoBack()">Kembali</a>
    </div>

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

        $(document).ready(function() {
            const form = document.getElementById("survey-form");

            form.addEventListener("submit", function(e) {
                e.preventDefault();

                if (e.submitter.id === "submit") {
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin menambah data?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal'
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            document.getElementById("submit").disabled = true;

                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url('admin/aksi_tambah_card') ?>",
                                data: new FormData(form),
                                contentType: false,
                                processData: false,
                                dataType: "json",
                                success: function(response) {
                                    if (response.status === 'success') {
                                        Swal.fire({
                                            title: 'Berhasil',
                                            text: response.message,
                                            icon: 'success',
                                            showConfirmButton: false,
                                            timer: 2000
                                        }).then(function() {
                                            window.location.href = response.redirect;
                                        });
                                    } else {
                                        if (response.errors) {
                                            response.errors.forEach(function(error) {
                                                Swal.fire({
                                                    title: 'Gagal',
                                                    text: error,
                                                    icon: 'error',
                                                    showConfirmButton: false,
                                                    timer: 2000
                                                });
                                            });
                                        } else {
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
                                }
                            });
                        }
                    });
                } else if (e.submitter.id === "cancel") {
                    Swal.fire({
                        title: 'Aksi dibatalkan',
                        text: 'Anda membatalkan aksi penyimpanan data.',
                        icon: 'info',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        });
    </script>
</body>

</html>