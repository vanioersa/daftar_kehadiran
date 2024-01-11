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
    .table-row:nth-child(even) {
        background-color: #d8f4cd;
    }

    .table-row:hover {
        background-color: #c1eac1;
    }
</style>

<body>
    <?php $this->load->view('sidebar_admin'); ?>

    <div class="flex flex-col md:col-span-2 md:row-span-2 shadow rounded-lg ml-10 mr-10 mt-10 bg-green-500">
        <div class="px-6 py-5 font-semibold border-b border-gray-100">Pesan</div>
        <form class="p-4 flex-grow flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4" method="post" action="<?= base_url('admin/simpan_pesan'); ?>" id="pesanForm">
            <div class="bg-white rounded-md p-6 flex-grow">
                <h2 class="text-xl font-semibold mb-4">Pesan:</h2>
                <textarea class="border rounded-md px-3 py-2 w-full mb-4" name="pesan" placeholder="Ketik pesan untuk ......"></textarea>
                <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                    <select id="penerima" name="penerima[]" class="border rounded-md px-3 py-2 mb-4 md:mb-0" <?php echo count($user_names) > 5 ? 'multiple size="5"' : ''; ?>>
                        <?php foreach ($user_names as $user) : ?>
                            <option value="<?= $user->id; ?>"><?= $user->nama; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" onclick="kirimPesan()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Kirim Pesan</button>
                </div>
            </div>
        </form>
    </div>
    <br><br>
    <div class="mt-4 mx-4">
        <div class="w-full rounded-lg overflow-hidden shadow-md bg-white dark:bg-gray-800">
            <div class="w-full overflow-x-auto">
                <table class="w-full text-left border border-collapse hover:text-white border-blue-500">
                    <thead>
                        <tr class="text-xs text-center font-semibold tracking-wide text-white bg-blue-500 dark:bg-gray-700">
                            <th class="px-6 py-3">Pengirim</th>
                            <th class="px-6 py-3">Nomor Pengirim</th>
                            <th class="px-6 py-3">Di Terima</th>
                            <th class="px-6 py-3">Nomor Penerima</th>
                            <th class="px-6 py-3">Pesan</th>
                            <th class="px-6 py-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white hover:text-white dark:divide-gray-700 divide-y divide-gray-200">
                        <?php foreach ($pesan as $row) : ?>
                            <tr class="hover:bg-green-500 hover:text-white text-gray-700 dark:text-gray-400">
                                <td class="px-2 py-4">
                                    <div class="flex items-center">
                                        <?php if (!empty($row->id_pengirim)) : ?>
                                            <img src="<?php echo base_url('./image/' . tampil_image_byid($row->id_pengirim)) ?>" class="object-cover w-8 h-8 rounded-full mr-2" alt="Profile Picture" loading="lazy">
                                        <?php else : ?>
                                            <img src="https://slabsoft.com/wp-content/uploads/2022/05/pp-wa-kosong-default.jpg" class="object-cover w-8 h-8 rounded-full mr-2" alt="Default Profile Picture" loading="lazy" />
                                        <?php endif; ?>
                                        <p class="font-semibold text-gray-800 dark:text-gray-300"><?php echo tampil_nama_byid($row->id_pengirim) ?></p>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center text-gray-800 dark:text-gray-300"><?php echo tampil_nomor_byid($row->id_pengirim); ?></td>
                                <td class="px-4 py-4 text-center text-gray-800 dark:text-gray-300">
                                    <div class="flex items-center">
                                        <?php if (!empty($row->id_penerima)) : ?>
                                            <img src="<?php echo base_url('./image/' . tampil_image_byid($row->id_penerima)) ?>" class="object-cover w-8 h-8 rounded-full mr-2" alt="Profile Picture" loading="lazy">
                                        <?php else : ?>
                                            <img src="https://slabsoft.com/wp-content/uploads/2022/05/pp-wa-kosong-default.jpg" class="object-cover w-8 h-8 rounded-full mr-2" alt="Default Profile Picture" loading="lazy" />
                                        <?php endif; ?>
                                        <p class="font-semibold text-gray-800 dark:text-gray-300"><?php echo tampil_nama_byid($row->id_penerima) ?></p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-800 dark:text-gray-300"><?php echo tampil_nomor_byid($row->id_penerima); ?></td>
                                <td class="px-6 py-4 text-center text-gray-800 dark:text-gray-300"><?php echo $row->pesan; ?></td>
                                <td class="px-6 py-4 text-center text-gray-800 dark:text-gray-300"><?php echo $row->tanggal; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="flex items-center justify-center mt-4">
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function kirimPesan() {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin mengirim pesan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    document.getElementById('pesanForm').submit();
                }
            });
        }
    </script>
</body>

</html>