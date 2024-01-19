<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Public Deskripsi</title>
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
    <div class="babu container bg-blue-200">
        <h1 class="buba text-center">Tambah Public Deskripsi</h1>

        <form action="<?php echo base_url('admin/aksi_tambah_card') ?>" method="post" id="survey-form" class="survey-form ">
            <div class="form-group">
                <label class="group-form" for="deskripsi">Deskripsi</label>
                <input type="text" id="deskripsi" name="deskripsi" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="group-form" for="tempat">Lokasi</label>
                <input type="text" id="tempat" name="tempat" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="group-form" for="foto">Foto</label>
                <input type="file" id="foto" name="foto" class="form-control" required>
            </div>

            <button type="submit" id="submit" class="bg-blue-500 hover:bg-blue-700 px-5 py-2 text-white rounded">submit</button>
        </form>
    </div>

    <a class="btn btn-secondary back-btn" onclick="confirmGoBack()">Kembali</a>

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