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
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: scale(1.03);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .info-card,
    .public-card,
    .message-card {
        border-radius: 0.75rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .info-card {
        background-color: #4a90e2;
        color: #fff;
        padding: 1.5rem;
    }

    .public-card {
        background-color: #4a90e2;
        color: #fff;
        padding: 1.5rem;
    }

    .message-card {
        padding: 1.5rem;
    }

    .profile-picture {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        object-fit: cover;
    }

    .public-card p {
        line-height: 1.5;
    }

    .cta-link {
        display: inline-block;
        margin-bottom: 1rem;
        padding: 0.75rem 1.5rem;
        background-color: #3490dc;
        color: #fff;
        text-decoration: none;
        border-radius: 0.375rem;
        transition: background-color 0.3s ease;
    }

    .cta-link:hover {
        background-color: #2779bd;
    }
</style>

<body>
    <?php $this->load->view('sidebar_user'); ?>

    <div class="min-w-screen-xl h-full md:py-10 md:px-16 py-12 px-5 text-center overflow-hidden">
        <?php foreach ($user as $row) : ?>
            <h1 class="font-bold text-4xl mb-4">Selamat datang <?php echo $row->nama; ?></h1>
        <?php endforeach; ?>

        <div class="md:flex gap-3 mb-5">
            <div class="flex items-start justify-between mb-4 flex-1 bg-blue-500 text-white px-3 py-6 rounded-md shadow-md mr-2 card">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
                    <i class="fas fa-users w-10 md:text-xl text-blue-800 dark:text-white"></i>
                </div>
                <div class="text-center md:text-left mt-2">
                    <p class="md:text-base text-xs text-gray-300">Total Pengguna aplikasi</p>
                    <p class="md:text-xl text-lg text-right font-bold md:text-right"><?= $users; ?></p>
                </div>
            </div>
            <a href="<?= base_url('user/rating_pengguna') ?>" style="cursor: default;" class="flex items-start justify-between mb-4 flex-1 bg-blue-500 text-white px-3 py-6 rounded-md shadow-md ml-2 card">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-bar w-10 md:text-xl text-blue-800 dark:text-white"></i>
                </div>
                <div class="text-center md:text-left mt-2">
                    <p class="md:text-base text-xs text-gray-300">Hasil rating seluruh pengguna</p>
                    <p class="md:text-xl text-lg text-right font-bold md:text-right"><?= $comment_count ?></p>
                </div>
            </a>
        </div>

        <p class="mb-5 text-3xl font-bold section-title">Informasi</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php $count = 0;
            foreach ($public as $row) : ?>
                <?php if ($count < 3) : ?>
                    <div class="info-card mb-4">
                        <p class="font-bold text-xl mb-3"><?= $row->tempat ?></p>
                        <p class="text-gray-300 leading-6"><?= $row->deskripsi ?></p>
                    </div>
                <?php endif; ?>
                <?php $count++; ?>
            <?php endforeach; ?>
        </div>

        <?php if (count($public) > 3) : ?>
            <a href="<?= base_url('user/public') ?>" class="cta-link">Lihat Selengkapnya &rarr;</a>
        <?php endif; ?>

        <p class="mb-5 text-3xl font-bold section-title">Pesan</p>
        <div class="max-h-screen overflow-y-auto bg-white rounded-md shadow-md w-full md:w-auto p-5">
            <?php if (empty($pesan)) {
                echo '<p class="text-gray-500">Tidak ada pesan</p>';
            } else {
                $prevMessage = null;
                foreach ($pesan as $row) :
                    if (!$prevMessage || ($prevMessage->id_pengirim != $row->id_pengirim) || ($prevMessage->pesan != $row->pesan)) : ?>
                        <div class="mb-6 flex <?= ($row->id_pengirim == $current_user_id) ? 'justify-end items-end' : 'justify-start items-end' ?>">
                            <div class="message-card <?= ($row->id_pengirim == $current_user_id) ? 'bg-green-300 text-right' : 'bg-gray-300 text-left' ?> rounded-md p-3 max-w-2xl overflow-auto">
                                <div class="flex items-center <?= ($row->id_pengirim == $current_user_id) ? 'flex-row-reverse' : '' ?>">
                                    <img src="<?= base_url('./image/' . tampil_image_byid($row->id_pengirim)) ?>" class="profile-picture w-10 h-10 rounded-full <?= ($row->id_pengirim == $current_user_id) ? 'ml-4' : 'mr-1' ?>" alt="Profile Picture" loading="lazy">
                                    <div class="ml-3">
                                        <p class="font-bold"><?= tampil_nama_byid($row->id_pengirim) ?></p>
                                        <p><?= $row->pesan ?></p>
                                    </div>
                                </div>
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
            } ?>
        </div>

    </div>
</body>

</html>