<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Public Deskripsi</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }

        .babu {
            max-width: 600px;
            margin: 80px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .back-btn {
            position: absolute;
            bottom: 10px;
            right: 50px;
        }

        .buba {
            margin-bottom: 10px;
            font-weight: bold;
            font-size: x-large;
        }

        .form-group {
            margin-bottom: 20px;
            width: 100%;
        }

        .group-form {
            font-size: larger;
            font-weight: bolder;
        }

        .back-btn {
            position: absolute;
            bottom: 10px;
            right: 50px;
        }

        .buba {
            margin-bottom: 10px;
            font-weight: bold;
            font-size: xx-large;
        }

        @media only screen and (max-width: 767px) {
            .buru {
                margin-left: 49%;
            }

            .back-btn {
                margin-bottom: 5px;
                margin-right: 60%;
                width: 100px;
            }
        }
    </style>
</head>

<body>
    <?php $this->load->view('sidebar_admin'); ?>
    <div class="babu container bg-green-500">
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

            <button type="submit" id="submit" class="btn btn-outline-dark">submit</button>
        </form>
    </div>

    <a class="btn btn-secondary back-btn" onclick="confirmGoBack()">Kembali</a>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include jQuery before SweetAlert2 and your other scripts -->
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
                    // Display SweetAlert confirmation before submitting
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin menambah data?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal'
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            // If user clicks "Ya", proceed with AJAX submission
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
                                        // Show success SweetAlert and then redirect
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
                                        // Display error messages
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

                                        // Re-enable the submit button immediately upon encountering an error
                                        document.getElementById("submit").disabled = false;
                                    }
                                }
                            });
                        }
                    });
                } else if (e.submitter.id === "cancel") {
                    // Handle the "Batal" button click event here
                    Swal.fire({
                        title: 'Aksi dibatalkan',
                        text: 'Anda membatalkan aksi penyimpanan data.',
                        icon: 'info',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    // Optionally, you can redirect or perform other actions when canceling
                }
            });
        });
    </script>
</body>

</html>