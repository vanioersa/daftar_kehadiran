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
                <thead style="background-color: #667eea;">
                    <tr>
                        <th class="py-2 px-4 border-b">NO</th>
                        <th class="py-2 px-4 border-b">Foto profile</th>
                        <th class="py-2 px-4 border-b">Nama</th>
                        <th class="py-2 px-4 border-b">Nomor</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Jenis Kelamin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0;
                    foreach ($public as $row) : $no++ ?>
                        <tr class="hover:bg-blue-300">
                            <td class="py-2 px-4 border-b"><?= $no ?>.</td>
                            <td class="py-2 px-4 border-b">
                                <?php if (!empty($row->image)) : ?>
                                    <img src="<?php echo base_url('./image/' . $row->image) ?>" class="object-cover w-10 h-10 mx-auto rounded-full" alt="Profile Picture" loading="lazy">
                                <?php else : ?>
                                    <img src="https://cdn-icons-png.flaticon.com/512/3177/3177440.png" class="object-cover w-8 h-8 mx-auto rounded-full" alt="Default Profile Picture" loading="lazy" />
                                <?php endif; ?>
                            </td>
                            <td class="py-2 px-4 border-b"><?= $row->nama ?></td>
                            <td class="py-2 px-4 border-b"><?= $row->nomor ?></td>
                            <td class="py-2 px-4 border-b"><?= $row->email ?></td>
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