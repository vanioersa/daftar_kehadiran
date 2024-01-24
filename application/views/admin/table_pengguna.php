<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>

    <?php $this->load->view('sidebar_admin'); ?>
    <div class="p-4 lg:p-10">
        <div class="w-full overflow-x-auto">
        <table class="w-full min-w-full bg-white text-center border border-gray-300">
                <thead class="bg-green-500">
                    <tr>
                        <th class="py-2 px-4 border-b">NO</th>
                        <th class="py-2 px-4 border-b">Nama</th>
                        <th class="py-2 px-4 border-b">Jenis Kelamin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0;
                    foreach ($public as $row) : $no++ ?>
                        <tr class="hover:bg-green-100" onclick="window.location='<?php echo base_url('admin/detail_pengguna/'.$row->id); ?>';">
                            <td class="py-2 px-4 border-b"><?= $no ?>.</td>
                            <td class="py-2 px-4 border-b"><?= $row->nama ?></td>
                            <td class="py-2 px-4 border-b"><?= $row->jenis_kelamin ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div class="w-full mt-4 flex justify-center">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>

</body>

</html>