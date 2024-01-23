<!DOCTYPE html>
<html lang="id">

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

    <?php $this->load->view('sidebar_admin'); ?>

    <div class="max-w-screen-xl w-full mx-auto mt-8 p-4">

        <div class="mb-8 text-center">
            <?php foreach ($user as $row) : ?>
                <h1 class="font-bold text-4xl text-blue-700">Selamat datang, <?= $row->nama; ?></h1>
                <p class="text-gray-600">Role: <?= $row->role; ?></p>
            <?php endforeach; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Bagian Daftar Pengguna -->
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
                                    if ($no > 10) break; ?>
                                    <tr class="hover:bg-blue-100" onclick="window.location='<?= base_url('admin/detail_pengguna/' . $row->id) ?>'">
                                        <td class="py-2 px-4 border-b"><?= $no ?></td>
                                        <td class="py-2 px-4 border-b text-blue-700"><?= $row->nama ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        <?php if (count($pengguna) > 10) : ?>
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
                    <?php usort($reting, function ($a, $b) {
                        return $b->rating - $a->rating;
                    });
                    $count = 0;
                    foreach ($reting as $row) :
                        if ($count < 3) : ?>
                            <div class="bg-blue-700 p-6 text-white rounded-md shadow-md">
                                <p class="font-semibold text-lg"><?= tampil_nama_byid($row->id_user) ?></p>
                                <p class="mt-2"><span class="text-yellow-500"><?php echo str_repeat('&#9733;', $row->rating); ?></span></p>
                                <p class="mt-2">Komentar: <?= $row->comment ?></p>
                            </div>
                        <?php else : ?>
                            <?php if ($count === 3) : ?>
                                <div class="text-blue-700 p-4 text-center">
                                    <p class="text-lg font-semibold">Lihat Lebih Banyak...</p>
                                    <a href="<?php echo base_url('admin/ratting') ?>" class="hover:underline">Lihat Semua &rarr;</a>
                                </div>
                            <?php endif; ?>
                    <?php endif;
                        $count++;
                    endforeach; ?>
                </div>
            </div>

            <div class="bg-white p-6 rounded-md shadow-md">
                <h2 class="text-2xl font-semibold mb-4 text-blue-700">Riwayat Pesan</h2>
                <div class="max-h-screen overflow-y-auto text-blue-700">
                    <?php $prevMessage = null;
                    foreach ($pesan as $row) : if (!$prevMessage || ($prevMessage->id_pengirim != $row->id_pengirim) || ($prevMessage->pesan != $row->pesan)) :
                            $englishDate = date('j F Y', strtotime($row->tanggal));
                            $translatedDate = date('j/n/Y', strtotime($englishDate)); ?>
                            <div class="<?= ($row->id_pengirim == $current_user_id) ? 'text-right' : 'text-left' ?> mb-4">
                                <div class="<?= ($row->id_pengirim == $current_user_id) ? 'bg-blue-200' : 'bg-gray-300' ?> rounded-md p-3 max-w-2xl inline-block mx-auto">
                                    <p class="font-bold"><?= tampil_nama_byid($row->id_pengirim) ?></p>
                                    <p class="mt-2"><?= $row->pesan ?></p>
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
    </div>
</body>

</html>
