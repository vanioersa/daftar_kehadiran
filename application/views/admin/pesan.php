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
                            <option value="<?= $user->nama; ?>"><?= $user->nama; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" onclick="kirimPesan()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Kirim Pesan</button>
                </div>
            </div>
        </form>
    </div>
    <br><br>
    <div class="mt-4 mx-4 m-20">
        <div class="w-full rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Pengirim</th>
                            <th class="px-4 py-3">Di Terima</th>
                            <th class="px-4 py-3">Pesan</th>
                            <th class="px-4 py-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <?php foreach ($pesan as $row) : ?>
                            <tr class="bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-900 text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                            <?php if (!empty($row->image)) : ?>
                                                <img src="<?php echo base_url('./image/' . $row->image) ?>" class="object-cover w-full h-full rounded-full" alt="" loading="lazy">
                                            <?php else : ?>
                                                <img src="https://slabsoft.com/wp-content/uploads/2022/05/pp-wa-kosong-default.jpg" class="object-cover w-full h-full rounded-full" loading="lazy" />
                                            <?php endif; ?>
                                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                        </div>
                                        <div>
                                            <p class="font-semibold"><?php echo $row->pengirim; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3"><?php echo $row->penerima; ?></td>
                                <td class="px-4 py-3"><?php echo $row->pesan; ?></td>
                                <td class="px-4 py-3"><?php echo $row->tanggal; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

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