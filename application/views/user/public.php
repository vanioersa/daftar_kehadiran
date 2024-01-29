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
    <?php
    date_default_timezone_set('Asia/Jakarta');
    $this->load->view('sidebar_user');
    ?>

    <div class="container mx-auto my-10">
        <div class="mb-8 flex justify-end">
            <form action="<?= base_url('user/public') ?>" method="get" class="flex items-center space-x-1">
                <button type="submit" class="p-2 bg-blue-500 text-white rounded">Cari</button>
                <input type="text" name="search_query" placeholder="Cari..." value="<?= $this->input->get('search_query') ?>" class="p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
            </form>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php foreach ($public as $row) : ?>
                <div class="bg-blue-500 text-white p-5 rounded-md shadow-md mb-4">
                    <img src="<?= base_url('./image/' . $row->image) ?>" class="object-cover w-full h-56 mb-4 rounded-md" alt="Foto Profil" loading="lazy">
                    <p class="font-bold text-center text-2xl mb-2"><?= $row->tempat ?></p>
                    <p class="text-gray-200"><?= $row->deskripsi ?></p>

                    <div class="flex items-center justify-between mt-4">
                        <?php
                        // Memisahkan tanggal dan waktu dari kolom waktu_kejadian
                        list($hari, $waktu) = explode(' ',  $row->waktu_kejadian);
                        ?>
                        <p class="text-gray-300">Tanggal: <?= $hari ?></p>
                        <p class="text-gray-300">Jam: <?= $waktu ?></p>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
        <?php if (empty($public)) : ?>
            <p class="text-center text-gray-500 justify-center items-center my-40">Tidak ada data yang tersedia.</p>
        <?php endif; ?>
    </div>

</body>

</html>