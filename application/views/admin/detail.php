<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            overflow: hidden;
        }
    </style>
    <title>Detail Pengguna</title>
</head>

<body>

    <?php $this->load->view('sidebar_admin'); ?>

    <div class="flex justify-center items-center h-screen">
        <?php foreach ($user as $row) : ?>
            <div class="max-w-md w-full mx-4 bg-white rounded-md overflow-hidden shadow-lg">
                <div class="relative">
                    <img src="<?php echo base_url('./image/' . $row->image) ?>" alt="Profile Picture" class="w-full h-64 object-cover">
                    <div class="absolute inset-0 bg-black opacity-30"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <h2 class="text-3xl font-semibold text-white"><?php echo $row->nama; ?></h2>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 text-lg mb-4"><?php echo $row->jenis_kelamin; ?></p>
                    <p class="text-gray-600 text-lg mb-4"><?php echo $row->nomor; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>

</html>
