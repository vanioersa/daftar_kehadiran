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
<style>
    .babubu {
        height: 420px;
    }
</style>
<body>
    <?php $this->load->view('sidebar_user'); ?>

    <div class="max-w-screen-xl w-full h-full md:py-10 md:px-10 pt-10 pb-10 pl-5 pr-5 text-center overflow-hidden">
        <?php foreach ($user as $row) : ?>
            <h1 class="font-bold text-4xl mb-4">Selamat datang <?php echo $row->nama; ?></h1>
        <?php endforeach; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 justify-center items-center mt-7">
            <div class="flex flex-col md:flex-row justify-between items-center bg-blue-500 text-white px-5 py-10 rounded-md shadow-md">
                <div class="md:w-20 md:h-20 w-14 h-14 bg-white rounded-full flex items-center justify-center">
                    <i class="fas fa-users w-14 md:text-3xl text-blue-800 dark:text-white"></i>
                </div>
                <div class="text-center md:text-left">
                    <p class="md:text-lg text-smtext-gray-300">Total Pengguna aplikasi</p>
                    <p class="md:text-3xl text-sxl font-bold md:text-right"><?php echo $user_count; ?></p>
                </div>
            </div>

            <div class="max-h-screen overflow-y-auto p-5 bg-white rounded-md shadow-md w-full md:w-auto babubu">
                <?php $prevMessage = null;
                foreach ($pesan as $row) : if (!$prevMessage || ($prevMessage->id_pengirim != $row->id_pengirim) || ($prevMessage->pesan != $row->pesan)) : ?>
                        <div class="flex <?= ($row->id_pengirim == $current_user_id) ? 'justify-end' : 'justify-start' ?> mb-2">
                            <div class="<?= ($row->id_pengirim == $current_user_id) ? 'bg-green-300' : 'bg-gray-300' ?> rounded-md p-3 max-w-2xl">
                                <p class="font-bold"><?= tampil_nama_byid($row->id_pengirim) ?></p>
                                <p><?= $row->pesan ?></p>
                                <?php
                                $englishDate = date('j F Y', strtotime($row->tanggal));
                                $translatedDate = date('j', strtotime($englishDate)) . '/' . date('n', strtotime($englishDate)) . '/' . date('Y', strtotime($englishDate));
                                ?>
                                <div class="flex justify-between mt-2 text-sm text-gray-600">
                                    <p><?= $translatedDate ?></p>
                                    <p><?= $row->jam ?></p>
                                </div>
                            </div>
                        </div>
                <?php endif;
                    $prevMessage = $row;
                endforeach;
                ?>
            </div>
        </div>
    </div>
</body>

</html>