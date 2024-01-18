<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Untuk User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<style>
    .table-container {
        max-width: 600px;
        margin: 0 auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid #e4e4e4;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        list-style: none;
        padding: 0;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination a {
        text-decoration: none;
        padding: 10px 15px;
        border-radius: 5px;
        background-color: #007bff;
        color: #fff;
    }

    .pagination a:hover {
        background-color: #0056b3;
    }

    .pagination .active a {
        background-color: #3559E0;
    }
</style>

<body>
    <?php $this->load->view('sidebar_admin'); ?>

    <div class="flex flex-col md:col-span-2 md:row-span-2 shadow rounded-lg ml-10 mr-10 mt-10 bg-gradient-to-r from-green-400 to-blue-500">
        <form method="post" action="<?= base_url('admin/simpan_pesan'); ?>" id="pesanForm">
            <div class="px-6 py-5 font-semibold text-white border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="<?= base_url('./image/' . tampil_image_byid($user_id)) ?>" class="object-cover w-10 h-10 rounded-full mr-2" alt="Foto Profil" loading="lazy">
                    <p class="text-lg font-semibold">
                        <?php $user_id = $this->session->userdata('id');
                        echo tampil_nama_byid($user_id); ?>
                    </p>
                </div>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <div class="p-4 flex-grow flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                <div class="bg-white rounded-md p-6 flex-grow">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-300">Pesan:</h2>
                    <textarea class="border rounded-md px-3 py-2 w-full mb-4" name="pesan" placeholder="Tulis pesan untuk ..."></textarea>
                    <div class="flex items-center space-x-4">
                        <p class="text-gray-500">Pesan dikirim kepada:</p>
                        <?php if (!empty($user_names)) : ?>
                            <select id="penerima" name="penerima[]" class="border rounded-md px-3 py-2 w-1/2" <?php echo count($user_names) > 5 ? 'multiple size="5"' : ''; ?>>
                                <?php foreach ($user_names as $user) : ?>
                                    <option value="<?= $user->id; ?>"><?= $user->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php else : ?>
                            <p>Tidak ada pengguna yang tersedia.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php
    function translateDay($englishDay)
    {
        $daysTranslation = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu',];

        return $daysTranslation[$englishDay];
    }

    function translateMonth($englishMonth)
    {
        $monthsTranslation = [
            'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober', 'December' => 'Desember'
        ];

        return $monthsTranslation[$englishMonth];
    }
    ?>
    <div class="mt-10 mx-10 mb-10">
        <div class="w-full rounded-lg overflow-hidden shadow-md bg-white dark:bg-gray-800">
            <div class="w-full overflow-x-auto">
                <div class="flex flex-col h-screen">
                    <div class="flex-1 overflow-x-hidden overflow-y-scroll">
                        <table class="min-w-full bg-white">
                            <tbody>
                                <?php
                                $prevMessage = null;
                                $displayTable = false;

                                foreach ($pesan as $row) :
                                    $rowClass = 'border-b';
                                    $englishDate = date('l, j F Y', strtotime($row->tanggal));
                                    $translatedDate = translateDay(date('l', strtotime($englishDate))) . ', ' . date('j', strtotime($englishDate)) . ' ' . translateMonth(date('F', strtotime($englishDate))) . ' ' . date('Y', strtotime($englishDate));

                                    if ($prevMessage && $prevMessage->pesan == $row->pesan && $prevMessage->jam == $row->jam) {
                                        continue;
                                    }
                                    $displayTable = true;
                                ?>
                                    <tr class="<?= $rowClass ?>">
                                        <td class="w-1/5 p-4">
                                            <?php if ($prevMessage && $prevMessage->pesan == $row->pesan && $prevMessage->jam == $row->jam) : ?>
                                                <div class="flex flex-col items-left">
                                                    <p class="font-semibold dark:text-gray-300"></p>
                                                    <p class="text-sm"></p>
                                                </div>
                                            <?php else : ?>
                                                <div class="flex flex-col items-left">
                                                    <p class="font-semibold dark:text-gray-300"><?= tampil_nama_byid($row->id_pengirim) ?></p>
                                                    <?php if (!empty($row->id_pengirim)) : ?>
                                                        <img src="<?= base_url('./image/' . tampil_image_byid($row->id_pengirim)) ?>" class="object-cover w-12 h-12 rounded-full mt-2" alt="Profile Picture" loading="lazy">
                                                    <?php else : ?>
                                                        <img src="https://cdn-icons-png.flaticon.com/512/3177/3177440.png" class="object-cover w-12 h-12 rounded-full mt-2" alt="Default Profile Picture" loading="lazy" />
                                                    <?php endif; ?>
                                                    <p class="text-sm"><?= tampil_nomor_byid($row->id_pengirim) ?></p>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="w-2/3 p-4">
                                            <?php if ($prevMessage && $prevMessage->pesan == $row->pesan && $prevMessage->jam == $row->jam) : ?>
                                                <div class="flex flex-col bg-gray-300 p-3 rounded">
                                                    <p class="text-gray-800 dark:text-gray-300"></p>
                                                    <p class="text-sm text-gray-800 text-right"></p>
                                                </div>
                                            <?php else : ?>
                                                <div class="flex flex-col bg-gray-300 p-3 rounded">
                                                    <p class="text-gray-800 dark:text-gray-300"><?= $row->pesan ?></p>
                                                    <p class="text-sm text-gray-800 text-right"><?= $translatedDate ?> <?= $row->jam ?></p>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="w-1/5 p-4 text-right">
                                            <?php if ($prevMessage && $prevMessage->pesan == $row->pesan && $prevMessage->jam == $row->jam) : ?>
                                                <div class="flex flex-col items-end">
                                                    <p class="font-semibold dark:text-gray-300"></p>
                                                    <p class="text-sm"></p>
                                                </div>
                                            <?php else : ?>
                                                <div class="flex flex-col items-end">
                                                    <p class="font-semibold dark:text-gray-300"><?= tampil_nama_byid($row->id_penerima) ?></p>
                                                    <?php if (!empty($row->id_penerima)) : ?>
                                                        <img src="<?= base_url('./image/' . tampil_image_byid($row->id_penerima)) ?>" class="object-cover w-12 h-12 rounded-full mt-2" alt="Profile Picture" loading="lazy">
                                                    <?php else : ?>
                                                        <img src="https://cdn-icons-png.flaticon.com/512/3177/3177440.png" class="object-cover w-12 h-12 rounded-full mt-2" alt="Default Profile Picture" loading="lazy" />
                                                    <?php endif; ?>
                                                    <p class="text-sm"><?= tampil_nomor_byid($row->id_penerima) ?></p>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php $prevMessage = $row; ?>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>