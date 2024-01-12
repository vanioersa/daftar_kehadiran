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

    tr:hover {
        background-color: #f0f5f9;
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
        background-color: #4CAF50;
    }
</style>

<body>
    <?php $this->load->view('sidebar_admin'); ?>

    <div class="flex flex-col md:col-span-2 md:row-span-2 shadow rounded-lg ml-10 mr-10 mt-10 bg-gradient-to-r from-green-400 to-blue-500">
        <form method="post" action="<?= base_url('admin/simpan_pesan'); ?>" id="pesanForm">
            <div class="px-6 py-5 font-semibold text-white border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="<?= base_url('./image/' . tampil_image_byid($user_id)) ?>" class="object-cover w-10 h-10 rounded-full mr-2" alt="Profile Picture" loading="lazy">
                    <p class="text-lg font-semibold">
                        <?php $user_id = $this->session->userdata('id');
                        echo tampil_nama_byid($user_id); ?>
                    </p>
                </div>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full">Kirim Pesan</button>
            </div>
            <div class="p-4 flex-grow flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                <div class="bg-white rounded-md p-6 flex-grow">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-300">Pesan:</h2>
                    <textarea class="border rounded-md px-3 py-2 w-full mb-4" name="pesan" placeholder="Ketik pesan untuk ..."></textarea>
                    <div class="flex items-center space-x-4">
                        <p class="text-gray-500">Pesan dikirim kepada:</p>
                        <select id="penerima" name="penerima[]" class="border rounded-md px-3 py-2 w-1/2" <?php echo count($user_names) > 5 ? 'multiple size="5"' : ''; ?>>
                            <?php foreach ($user_names as $user) : ?>
                                <option value="<?= $user->id; ?>"><?= $user->nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-4 mx-4">
        <div class="w-full rounded-lg overflow-hidden shadow-md bg-white dark:bg-gray-800">
            <div class="w-full overflow-x-auto">
                <table class="w-full border border-collapse hover:border-blue-500">
                    <tbody class="bg-white dark:divide-gray-700 divide-y divide-gray-200">
                        <?php foreach ($pesan as $row) : ?>
                            <tr class="hover:bg-blue-300 text-gray-700 dark:text-gray-400">
                                <td class="px-2 py-4 w-1/6">
                                    <div class="flex items-center">
                                        <?php if (!empty($row->id_pengirim)) : ?>
                                            <img src="<?php echo base_url('./image/' . tampil_image_byid($row->id_pengirim)) ?>" class="object-cover w-8 h-8 rounded-full mr-2" alt="Profile Picture" loading="lazy">
                                        <?php else : ?>
                                            <img src="https://cdn-icons-png.flaticon.com/512/3177/3177440.png" class="object-cover w-8 h-8 rounded-full mr-2" alt="Default Profile Picture" loading="lazy" />
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-2 py-4 w-2/6">
                                    <div class="flex flex-col ml-2">
                                        <div class="flex items-center">
                                            <p class="font-semibold text-gray-800 dark:text-gray-300"><?php echo tampil_nama_byid($row->id_pengirim) ?></p>
                                            <p class="text-gray-500 text-sm ml-2">(Untuk: <?php echo tampil_nama_byid($row->id_penerima) ?>)</p>
                                            <p class="text-gray-500 text-sm ml-2"><?php echo $row->jam; ?></p>
                                        </div>
                                        <div class="bg-gray-100 p-2 mt-2 rounded">
                                            <p class="text-gray-800 dark:text-gray-300"><?php echo $row->pesan; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 py-4 w-1/6 text-right">
                                    <p class="text-gray-500 text-sm">Penerima: <?php echo tampil_nomor_byid($row->id_penerima) ?></p>
                                    <?php if (!empty($row->id_penerima)) : ?>
                                        <img src="<?php echo base_url('./image/' . tampil_image_byid($row->id_penerima)) ?>" class="object-cover w-8 h-8 rounded-full ml-2" alt="Profile Picture" loading="lazy">
                                    <?php else : ?>
                                        <img src="https://cdn-icons-png.flaticon.com/512/3177/3177440.png" class="object-cover w-8 h-8 rounded-full ml-2" alt="Default Profile Picture" loading="lazy" />
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="flex items-center justify-center mb-4">
                    <ul class="pagination">
                        <?php if ($current_page > 1) : ?>
                            <li><a href="<?= base_url('admin/pesan/' . ($current_page - 1)); ?>" class="page-link">&laquo; Previous</a></li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                            <li class="<?= ($current_page == $i) ? 'active' : ''; ?>">
                                <a href="<?= base_url('admin/pesan/' . $i); ?>" class="page-link"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($current_page < $total_pages) : ?>
                            <li><a href="<?= base_url('admin/pesan/' . ($current_page + 1)); ?>" class="page-link">Next &raquo;</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</body>

</html>