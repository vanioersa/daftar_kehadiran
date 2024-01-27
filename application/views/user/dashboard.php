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
        overflow-x: hidden;
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
        margin-top: 5px;
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

    <div class="w-screen-xl w-full text-center mx-auto md:my-5 my-8 px-8">

        <div class="mb-8 text-center">
            <?php foreach ($user as $row) : ?>
                <h1 class="font-bold text-4xl text-blue-700">Selamat datang, <?= $row->nama; ?></h1>
            <?php endforeach; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

            <div class="bg-white p-6 rounded-md shadow-md">
                <h2 class="text-3xl font-semibold mb-4 text-blue-700">Informasi </h2>
                <div class="bg-blue-500 text-white px-3 py-6 rounded-md shadow-md card">
                    <div class="flex justify-between">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
                            <i class="fas fa-users w-10 md:text-xl text-blue-800 dark:text-white"></i>
                        </div>
                        <div class="text-center md:text-left mt-2">
                            <p class="md:text-base text-xs text-gray-300">Total Pengguna aplikasi</p>
                            <p class="md:text-xl text-lg text-right font-bold md:text-right"><?= $users; ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-500 text-white px-3 py-6 rounded-md shadow-md card mt-4">
                    <?php if ($comment_count > 0) : ?>
                        <a href="<?= base_url('user/rating_pengguna') ?>" class="flex justify-between">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
                                <i class="fas fa-chart-bar w-10 md:text-xl text-blue-800 dark:text-white"></i>
                            </div>
                            <div class="text-center md:text-right mt-2">
                                <p class="md:text-base text-xs text-gray-300">Hasil rating seluruh pengguna</p>
                                <p class="md:text-xl text-lg text-right font-bold md:text-right"><?= $comment_count ?></p>
                            </div>
                        </a>
                    <?php else : ?>
                        <p class="text-white text-center">Tidak ada data ratingdari pengguna.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white p-6 rounded-md shadow-md">
                <h2 class="text-3xl font-semibold mb-4 text-blue-700">Informasi Public</h2>
                <div class="grid grid-cols-1 gap-4">
                    <?php if (!empty($public)) : ?>
                        <?php $count = 0;
                        foreach ($public as $row) : ?>
                            <?php if ($count < 1) : ?>
                                <div class="info-card mb-4">
                                    <p class="font-bold text-xl mb-3"><?= $row->tempat ?></p>
                                    <?php
                                    $words = explode(' ', $row->deskripsi);
                                    $shortDescription = implode(' ', array_slice($words, 0, 50));
                                    ?>
                                    <p class="text-gray-300 leading-6"><?= $shortDescription ?></p>
                                </div>
                            <?php endif; ?>
                            <?php $count++; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-gray-600">Maaf, tidak ada data yang tersedia.</p>
                    <?php endif; ?>
                </div>

                <?php if (count($public) > 0) : ?>
                    <a href="<?= base_url('user/public') ?>" class="cta-link">Lihat lebih lanjut &rarr;</a>
                <?php endif; ?>
            </div>

            <div class="bg-white p-6 rounded-md shadow-md">
                <h2 class="text-2xl font-semibold mb-4 text-blue-700">Riwayat Pesan</h2>

                <div style="max-height: 370px;" class="overflow-y-auto px-2 py-3">
                    <?php
                    $prevDate = null;
                    $uniqueMessages = [];
                    $today = date('j/n/Y');
                    $yesterday = date('j/n/Y', strtotime('-1 day'));

                    $searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

                    foreach ($pesan as $row) :
                        $englishDate = date('j F Y', strtotime($row->tanggal));
                        $translatedDate = date('j/n/Y', strtotime($englishDate));
                        $displayDate = getDisplayDate($row->tanggal);

                        $messageKey = $translatedDate . '_' . $row->jam . '_' . $row->pesan;
                        $messageText = tampil_nama_byid($row->id_pengirim) . ' ' . $row->pesan;

                        // Check if the search term is empty or if it matches the message text
                        if (empty($searchTerm) || stripos($messageText, $searchTerm) !== false) :
                    ?>
                            <?php if ($displayDate != $prevDate) : ?>
                                <p class="my-4 text-gray-500 mx-auto text-center bg-blue-100 px-2 py-1 rounded-md">
                                    <?= $displayDate ?>
                                </p>
                            <?php endif; ?>

                            <div class="mb-4 flex items-start <?= ($row->id_pengirim == $id_user) ? 'justify-end text-right' : 'justify-start text-left' ?>">
                                <div class="<?= ($row->id_pengirim == $id_user) ? 'bg-blue-700 text-white' : 'bg-gray-300 text-black' ?> rounded-md p-3 max-w-full inline-block">
                                    <p class="font-bold"><?= tampil_nama_byid($row->id_pengirim) ?></p>
                                    <p><?= $row->pesan ?></p>
                                    <p class="text-xs <?= ($row->id_pengirim == $id_user) ? 'md:text-left text-right' : 'text-right' ?>"><?= date('H:i', strtotime($row->jam)) ?></p>
                                </div>

                                <?php if (!empty($row->id_pengirim)) : ?>
                                    <img src="<?= base_url('./image/' . tampil_image_byid($row->id_pengirim)) ?>" class="w-10 h-10 rounded-full <?= ($row->id_pengirim == $id_user) ? 'ml-2' : 'mr-2' ?>" alt="Foto Profil" loading="lazy">
                                <?php else : ?>
                                    <img src="https://cdn-icons-png.flaticon.com/512/3177/3177440.png" class="w-8 h-8 rounded-full mr-2" alt="Foto Profil Default" loading="lazy">
                                <?php endif; ?>
                            </div>
                    <?php
                            $uniqueMessages[] = $messageKey;
                            $prevDate = $displayDate;
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>

            <?php
            function getDisplayDate($messageDate)
            {
                $dateDiff = strtotime('today') - strtotime($messageDate);
                $daysAgo = floor($dateDiff / (60 * 60 * 24));
                if ($daysAgo == 0) {
                    return 'Hari Ini';
                } elseif ($daysAgo == 1) {
                    return 'Kemarin';
                } elseif ($daysAgo >= 2 && $daysAgo <= 6) {
                    return terbilang($daysAgo) . ' Hari Lalu';
                } elseif ($daysAgo >= 7 && $daysAgo <= 13) {
                    $weeksAgo = floor($daysAgo / 7);
                    return 'Satu Minggu Lalu';
                } elseif ($daysAgo >= 14 && $daysAgo <= 29) {
                    return 'Dua Minggu Lalu';
                } elseif ($daysAgo >= 30 && $daysAgo <= 59) {
                    return 'Satu Bulan Lalu';
                } elseif ($daysAgo >= 60 && $daysAgo <= 365) {
                    $monthsAgo = floor($daysAgo / 30);
                    return terbilang($monthsAgo) . ' Bulan Lalu';
                } elseif ($daysAgo > 365) {
                    $yearsAgo = floor($daysAgo / 365);
                    return terbilang($yearsAgo) . ' Tahun Lalu';
                }
            }

            function terbilang($number)
            {
                $words = array(1 => 'Satu', 2 => 'Dua', 3 => 'Tiga', 4 => 'Empat', 5 => 'Lima', 6 => 'Enam', 7 => 'Tujuh', 8 => 'Delapan', 9 => 'Sembilan', 10 => 'Sepuluh', 11 => 'Sebelas');

                if ($number < 12) {
                    return $words[$number];
                } elseif ($number < 20) {
                    return terbilang($number - 10) . ' Belas';
                } elseif ($number < 100) {
                    return terbilang($number / 10) . ' Puluh ' . terbilang($number % 10);
                } elseif ($number < 200) {
                    return 'Seratus ' . terbilang($number - 100);
                } elseif ($number < 1000) {
                    return terbilang($number / 100) . ' Ratus ' . terbilang($number % 100);
                } elseif ($number < 2000) {
                    return 'Seribu ' . terbilang($number - 1000);
                } elseif ($number < 1000000) {
                    return terbilang($number / 1000) . ' Ribu ' . terbilang($number % 1000);
                } elseif ($number < 1000000000) {
                    return terbilang($number / 1000000) . ' Juta ' . terbilang($number % 1000000);
                }
                return 'Angka terlalu besar untuk diurai.';
            }
            ?>

        </div>
    </div>
</body>

</html>