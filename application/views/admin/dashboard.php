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
        height: 430px;
        width: 700px;
    }
    .baru{
        width: 700px;
    }

    @media only screen and (max-width: 767px) {
        .babubu{
            width: 100%;
        }
        .baru{
        width: 100%;
    }
    }
</style>

<body>

    <?php $this->load->view('sidebar_admin'); ?>

    <div class="flex flex-col items-center max-w-screen-xl w-full h-full py-10 text-center overflow-hidden">

        <?php foreach ($user as $row) : ?>
            <div class="mb-4">
                <h1 class="font-bold text-4xl">Selamat datang <?php echo $row->nama; ?></h1>
            </div>
        <?php endforeach; ?>

        <div class="flex md:flex-row flex-col md:space-y-0 space-y-4 w-full">
            <div class="baru">
                <div class="p-4 lg:p-10">
                    <div class="w-full overflow-x-auto">
                        <?php if (!empty($pengguna)) : ?>
                            <table class="w-full min-w-full bg-white text-center border border-gray-300">
                                <thead class="bg-blue-500 text-white">
                                    <tr>
                                        <th class="py-2 px-4 border-b">NO</th>
                                        <th class="py-2 px-4 border-b">Nama</th>
                                        <th class="py-2 px-4 border-b">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($pengguna as $row) :
                                        $no++;
                                    ?>
                                        <tr class="hover:bg-blue-100">
                                            <td class="py-2 px-4 border-b"><?= $no ?>.</td>
                                            <td class="py-2 px-4 border-b"><?= $row->nama ?></td>
                                            <td class="py-2 px-4 border-b"><?= $row->email ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                            <?php if (count($pengguna) > 0) : ?>
                                <div class="w-full mt-4 flex justify-center mb-5">
                                    <a href="<?php echo base_url('admin/table_pengguna') ?>" class="text-blue-500 hover:underline">Lihat Selengkapnya &rarr;</a>
                                </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <p class="text-center text-gray-500">Maaf, tidak ada pengguna.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="max-h-screen overflow-y-auto p-5 bg-blue-100 rounded-md shadow-md babubu">
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