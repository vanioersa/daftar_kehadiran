<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php $this->load->view('sidebar_user'); ?>

    <div class="container mx-auto my-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php foreach ($public as $row) : ?>
                <div class="bg-blue-500 text-white p-5 rounded-md shadow-md mb-4">
                    <img src="<?= base_url('./image/' . $row->image) ?>" class="object-cover w-full h-56 mb-4 rounded-md" alt="Foto Profil" loading="lazy">
                    <p class="font-bold text-center text-2xl mb-2"><?= $row->tempat ?></p>
                    <p class="text-gray-200"><?= $row->deskripsi ?></p>

                    <?php $formattedDate = date('l, d F Y', strtotime($row->waktu_kejadian));
                    $formattedTime = date('H.i', strtotime($row->waktu_kejadian));
                    $formattedDate = str_replace(array_keys($dayNames), array_values($dayNames), $formattedDate);
                    $formattedDate = str_replace(array_keys($monthNames), array_values($monthNames), $formattedDate); ?>

                    <div class="flex items-center justify-between mt-4">
                        <p class="text-gray-300 formatted-date"><?= $formattedDate ?></p>
                        <p class="text-gray-300 formatted-time"><?= $formattedTime ?> WIB</p>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>