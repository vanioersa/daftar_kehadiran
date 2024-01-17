<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    .message-container {
        display: flex;
        justify-content: flex-start;
        margin-bottom: 10px;
    }

    .justify-end {
        justify-content: flex-end;
    }

    .message-bubble-outgoing {
        background-color: #DCF8C6;
        border-radius: 10px;
        padding: 10px;
        max-width: 70%;
    }

    .message-bubble-incoming {
        background-color: #E5DDD5;
        border-radius: 10px;
        padding: 10px;
        max-width: 70%;
    }

    .message-sender {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .message-metadata {
        display: flex;
        justify-content: space-between;
        margin-top: 5px;
        color: #888;
        font-size: 12px;
    }
</style>

<body>
    <?php $this->load->view('sidebar_admin'); ?>

    <?php foreach ($user as $row) : ?>
        <h1 style="text-align: center; font-weight: bold; font-size: xx-large; margin-top: 20px;">Selamat datang <?php echo $row->nama; ?></h1>
    <?php endforeach; ?>

    <div class="p-4 lg:p-10">
        <div class="w-full overflow-x-auto">
            <?php if (!empty($pengguna)) : ?>
                <table class="w-full min-w-full bg-white text-center border border-gray-300">
                    <thead style="background-color: #68D391">
                        <tr>
                            <th class="py-2 px-4 border-b">NO</th>
                            <th class="py-2 px-4 border-b">Nama</th>
                            <th class="py-2 px-4 border-b">email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($pengguna as $row) :
                            if ($no >= 5) break;
                            $no++;
                        ?>
                            <tr class="hover:bg-blue-300">
                                <td class="py-2 px-4 border-b"><?= $no ?>.</td>
                                <td class="py-2 px-4 border-b"><?= $row->nama ?></td>
                                <td class="py-2 px-4 border-b"><?= $row->email ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <div class="w-full mt-4 flex justify-center mb-5">
                    <a href="<?php echo base_url('admin/table_pengguna') ?>">Lihat Selengkapnya-></a>
                </div>
            <?php else : ?>
                <p class="text-center text-gray-500">Maaf, tidak ada pengguna.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="mx-10 mx-10 my-10">
        <div class="w-full rounded-3xl overflow-hidden shadow-md bg-gray-100 dark:bg-gray-800">
            <div class="w-full overflow-x-auto">
                <?php
                $prevMessage = null;
                foreach ($pesan as $row) :
                    if (!$prevMessage || ($prevMessage->id_pengirim != $row->id_pengirim) || ($prevMessage->pesan != $row->pesan)) :
                ?>
                        <div class="message-container px-5 <?= ($row->id_pengirim == $current_user_id) ? 'justify-end' : 'justify-start' ?>">
                            <div class="mt-3 <?= ($row->id_pengirim == $current_user_id) ? 'message-bubble-outgoing' : 'message-bubble-incoming' ?>">
                                <p class="message-sender"><?= tampil_nama_byid($row->id_pengirim) ?></p>
                                <p class="message-content"><?= $row->pesan ?></p>
                                <?php
                                $englishDate = date('j F Y', strtotime($row->tanggal));
                                $translatedDate = date('j', strtotime($englishDate)) . '/' . date('n', strtotime($englishDate)) . '/' . date('Y', strtotime($englishDate));
                                ?>
                                <div class="message-metadata">
                                    <p class="message-date pr-10"><?= $translatedDate ?></p>
                                    <p class="message-time"><?= $row->jam ?></p>
                                </div>
                            </div>
                        </div>
                <?php
                    endif;
                    $prevMessage = $row;
                endforeach;
                ?>
            </div>
        </div>
    </div>

</body>

</html>