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

    <div class="w-screen-xl w-full text-center mx-auto my-8 p-4">

        <div class="mb-8 text-center">
            <?php foreach ($user as $row) : ?>
                <h1 class="font-bold text-4xl text-blue-700">Selamat datang, <?= $row->nama; ?></h1>
            <?php endforeach; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <div class="bg-white p-6 rounded-md shadow-md">
                <div class="flex items-start justify-between flex-1">
                    <div class="bg-blue-500 text-white px-3 py-6 rounded-md shadow-md card">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
                            <i class="fas fa-users w-10 md:text-xl text-blue-800 dark:text-white"></i>
                        </div>
                        <div class="text-center md:text-left mt-2">
                            <p class="md:text-base text-xs text-gray-300">Total Pengguna aplikasi</p>
                            <p class="md:text-xl text-lg text-right font-bold md:text-right"><?= $users; ?></p>
                        </div>
                    </div>
                    <a href="<?= base_url('user/rating_pengguna') ?>" style="cursor: default;" class="bg-blue-500 text-white px-3 py-6 rounded-md shadow-md card">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-bar w-10 md:text-xl text-blue-800 dark:text-white"></i>
                        </div>
                        <div class="text-center md:text-left mt-2">
                            <p class="md:text-base text-xs text-gray-300">Hasil rating seluruh pengguna</p>
                            <p class="md:text-xl text-lg text-right font-bold md:text-right"><?= $comment_count ?></p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="bg-white p-6 rounded-md shadow-md">
                <h2 class="text-4xl font-semibold mb-4 text-blue-700">Informasi</h2>
                <div class="grid grid-cols-1 gap-4">
                    <?php if (!empty($public)) : ?>
                        <?php $count = 0;
                        foreach ($public as $row) : ?>
                            <?php if ($count < 2) : ?>
                                <div class="info-card mb-4">
                                    <p class="font-bold text-2xl mb-3"><?= $row->tempat ?></p>
                                    <p class="text-gray-300 leading-6"><?= $row->deskripsi ?></p>
                                </div>
                            <?php endif; ?>
                            <?php $count++; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-gray-600">Maaf, tidak ada data yang tersedia.</p>
                    <?php endif; ?>
                </div>

                <?php if (count($public) > 2) : ?>
                    <a href="<?= base_url('user/public') ?>" class="cta-link">Lihat Selengkapnya &rarr;</a>
                <?php endif; ?>
            </div>

            <div class="bg-white p-6 rounded-md shadow-md">
    <h2 class="text-2xl font-semibold mb-4 text-blue-700">Pesan</h2>
    <div style="max-height: 490px;" class="overflow-y-auto text-blue-700 px-2 py-3">
        <?php
        $prevMessage = null;
        foreach ($pesan as $row) :
            $isCurrentUserMessage = ($row->id_pengirim == $current_user_id || $row->id_penerima == $current_user_id);

            if ($isCurrentUserMessage && (!$prevMessage || ($prevMessage->id_pengirim != $row->id_pengirim) || ($prevMessage->pesan != $row->pesan))) :
                $englishDate = date('j F Y', strtotime($row->tanggal));
                $translatedDate = date('j/n/Y', strtotime($englishDate));
                $formattedTime = date('H.i', strtotime($row->jam));

                $profileImage = base_url('./image/' . tampil_image_byid($row->id_pengirim));
                $isMessageFromCurrentUser = ($row->id_pengirim == $current_user_id);
                $messageAlignmentClass = $isMessageFromCurrentUser ? 'bg-blue-200 text-left' : 'bg-gray-300 text-left';
                $textAlignmentClass = $isMessageFromCurrentUser ? 'text-right' : 'text-left';
                $imageAlignmentClass = $isMessageFromCurrentUser ? 'ml-4' : 'ml-4'; ?>

                <div class="<?= $textAlignmentClass ?> mb-4">
                    <div class="<?= $messageAlignmentClass ?> rounded-md p-3 max-w-2xl inline-block mx-auto">
                        <div class="flex items-center mb-2">
                            <p class="font-bold"><?= tampil_nama_byid($row->id_pengirim) ?></p>
                            <img src="<?= $profileImage ?>" class="w-10 h-10 rounded-full <?= $imageAlignmentClass ?>" alt="Profile Picture" loading="lazy">
                        </div>
                        <p class="mt-2"><?= $row->pesan ?></p>
                        <div class="flex justify-between mt-2 text-sm text-gray-600">
                            <p><?= $translatedDate ?></p>
                            <p><?= $formattedTime ?></p>
                        </div>
                    </div>
                </div>
        <?php endif;
            $prevMessage = $row;
        endforeach; ?>
    </div>
</div>

        </div>
    </div>
</body>

</html>