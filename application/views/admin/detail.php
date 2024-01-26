<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Layanan Pengaduan Bencana</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            overflow: hidden;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            max-width: 400px;
            width: 100%;
            position: relative;
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 255, 0.5);
            z-index: 1;
        }

        .card-content {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            z-index: 2;
        }
    </style>
</head>

<body>

    <?php $this->load->view('sidebar_admin'); ?>

    <?php foreach ($user as $row) : ?>
        <div class="card mx-4 rounded-md overflow-hidden shadow-lg">
            <img src="<?php echo base_url('./image/' . $row->image) ?>" alt="Profile Picture" class="w-full h-full object-cover rounded-md">
            <div class="card-content">
                <h2 class="text-3xl font-semibold"><?php echo $row->nama; ?></h2>
                <p class="text-lg mb-4"><?php echo $row->jenis_kelamin; ?></p>
                <p class="text-lg mb-4"><?php echo $row->nomor; ?></p>
            </div>
        </div>
    <?php endforeach; ?>

</body>

</html>
