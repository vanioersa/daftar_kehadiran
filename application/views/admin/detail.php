<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Detail Pengguna</title>
</head>

<body>

    <?php $this->load->view('sidebar_admin'); ?>
    <div class="p-4 lg:p-10">
    <div class="w-full max-w-md mx-auto bg-white rounded-md overflow-hidden shadow-md">
        <?php foreach ($user as $row) : ?>
            <div class="relative">
                <img src="<?php echo base_url('./image/' . $row->image) ?>" alt="Profile Picture" class="w-full h-40 object-cover">
                <div class="absolute bottom-0 left-0 p-4">
                </div>
            </div>
            <div class="p-6">
                <h2 class="font-bold text-xl mb-2 text-center"><?php echo $row->nama; ?></h2>
                <p class="text-gray-700 text-base mb-4 text-center"><?php echo $row->email; ?> | <?php echo $row->jenis_kelamin; ?></p>
                <p class="text-gray-700 text-base text-center"><?php echo $row->nomor; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>


</body>

</html>