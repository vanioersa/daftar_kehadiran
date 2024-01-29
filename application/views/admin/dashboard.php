<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <title>Layanan Pengaduan Bencana</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
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
    <?php $this->load->view('sidebar_admin'); ?>
    <div class="w-screen-xl w-full mx-auto my-8 p-4">

        <div class="mb-8 text-center">
            <?php foreach ($user as $row) : ?>
                <h1 class="font-bold text-4xl text-blue-700">Selamat datang, <?= $row->nama; ?></h1>
                <p class="text-gray-600">Role: <?= $row->role; ?></p>
            <?php endforeach; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <div class="bg-white p-6 rounded-md shadow-md">
                <h2 class="text-2xl font-semibold mb-4 text-blue-700">Daftar Pengguna</h2>
                <div class="w-full overflow-x-auto">
                    <?php if (!empty($pengguna)) : ?>
                        <table class="w-full min-w-full bg-white text-center border border-gray-300">
                            <thead class="bg-blue-700 text-white">
                                <tr>
                                    <th class="py-2 px-4 border-b">No</th>
                                    <th class="py-2 px-4 border-b">Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
                                foreach ($pengguna as $row) :
                                    $no++;
                                    if ($no > 5) break; ?>
                                    <tr class="hover:bg-blue-100" <?php if ($no <= 5 && count($pengguna) <= 5) echo 'onclick="window.location=' . "'" . base_url('admin/detail_pengguna/' . $row->id) . "'" . '"' ?>>
                                        <td class="py-2 px-4 border-b"><?= $no ?></td>
                                        <td class="py-2 px-4 border-b text-blue-700"><?= $row->nama ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        <?php if (count($pengguna) > 5) : ?>
                            <div class="w-full mt-4 flex justify-center mb-5">
                                <a href="<?php echo base_url('admin/table_pengguna') ?>" class="text-blue-500 hover:underline">Lihat Lebih Banyak &rarr;</a>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <p class="text-center text-gray-500">Maaf, tidak ada pengguna.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white p-6 rounded-md shadow-md">
                <h2 class="text-2xl font-semibold mb-4 text-blue-700">Informasi Rating</h2>
                <div class="grid grid-cols-1 gap-4">
                    <?php
                    $count = 0;

                    if (empty($reting)) {
                        echo '<div class="text-center md:py-20"><p class="text-gray-600">Maaf, tidak ada data yang tersedia.</p></div>';
                    } else {
                        foreach ($reting as $row) :
                            if ($count < 1) : ?>
                                <div class="bg-blue-700 p-6 text-white rounded-md shadow-md">
                                    <p class="font-semibold text-lg"><?= tampil_nama_byid($row->id_user) ?></p>
                                    <p class="mt-2"><span style="color: #fbbf24;"><?php echo str_repeat('&#9733;', $row->rating); ?></span></p>
                                    <p class="mt-2">Komentar: <?= $row->comment ?></p>
                                </div>
                            <?php else : ?>
                                <?php if ($count === 1) : ?>
                                    <div class="text-blue-700 p-4 text-center">
                                        <a href="<?php echo base_url('admin/ratting') ?>" class="cta-link">Lihat Lebih Lanjut &rarr;</a>
                                    </div>
                                <?php endif; ?>
                    <?php endif;
                            $count++;
                        endforeach;
                    } ?>
                </div>
            </div>

            <div class="bg-white p-6 rounded-md shadow-md">
                <h2 class="text-2xl font-semibold mb-4 text-blue-700">Riwayat Pesan</h2>
                <div style="max-height: 290px;" class="overflow-y-auto px-2 py-3">
                    <?php
                    if (empty($pesan)) :
                    ?>
                        <p class="text-gray-500 mx-auto text-center md:my-20">Tidak ada pesan yang ditampilkan.</p>
                        <?php
                    else :
                        $prevDate = null;
                        $uniqueMessages = [];
                        $today = date('j/n/Y');
                        $yesterday = date('j/n/Y', strtotime('-1 day'));
                        usort($pesan, function ($a, $b) {
                            return strtotime($b->tanggal . ' ' . $b->jam) - strtotime($a->tanggal . ' ' . $a->jam);
                        });
                        foreach ($pesan as $row) :
                            $englishDate = date('j F Y', strtotime($row->tanggal));
                            $translatedDate = date('j/n/Y', strtotime($englishDate));
                            $displayDate = getDisplayDate($row->tanggal);

                            $messageKey = $translatedDate . '_' . $row->jam . '_' . $row->pesan;
                            if (!in_array($messageKey, $uniqueMessages)) :
                        ?>
                                <?php if ($translatedDate != $prevDate) : ?>
                                    <p class="my-5 text-gray-500 mx-auto text-center bg-blue-100 shadow w-full">
                                        <?= $displayDate ?>
                                    </p>
                                <?php endif; ?>

                                <div class="mb-2">
                                    <?php if (!empty($row->id_pengirim)) : ?>
                                        <img src="<?= base_url('./image/' . tampil_image_byid($row->id_pengirim)) ?>" class="w-10 h-10 rounded-full <?= ($row->id_pengirim == $id_user) ? 'float-right ml-2' : 'float-left mr-2' ?>" alt="Profile Picture" loading="lazy">
                                    <?php else : ?>
                                        <img src="https://cdn-icons-png.flaticon.com/512/3177/3177440.png" class="w-8 h-8 rounded-full mr-2" alt="Default Profile Picture" loading="lazy">
                                    <?php endif; ?>

                                    <div class="flex items-start <?= ($row->id_pengirim == $id_user) ? 'justify-end text-right' : 'justify-start text-left' ?>">
                                        <div class="<?= ($row->id_pengirim == $id_user) ? 'bg-blue-700 text-white' : 'bg-gray-300 text-black' ?> rounded-md p-3 max-w-2xl inline-block">
                                            <p class="font-bold"><?= tampil_nama_byid($row->id_pengirim) ?></p>
                                            <p><?= $row->pesan ?></p>
                                            <p class="text-xs <?= ($row->id_pengirim == $id_user) ? 'text-left' : 'text-right' ?>"><?= date('H:i', strtotime($row->jam)) ?></p>
                                        </div>
                                    </div>
                                </div>
                    <?php
                                $uniqueMessages[] = $messageKey;
                                $prevDate = $translatedDate;
                            endif;
                        endforeach;
                    endif;
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