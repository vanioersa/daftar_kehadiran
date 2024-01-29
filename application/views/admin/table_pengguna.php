<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Layanan Pengaduan Bencana</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>

    <?php $this->load->view('sidebar_admin'); ?>
    <div class="p-4 lg:p-10">
        <div class="w-full overflow-x-auto">

            <div class="mb-4 relative">
                <input type="text" id="search" placeholder="Cari......" class="border border-gray-300 rounded-md pl-10 pr-4 py-2 w-full focus:outline-none focus:border-blue-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                    <svg class="w-5 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m4.286-1.429a9 9 0 11-12.727-12.728 9 9 0 0112.727 12.728z"></path>
                    </svg>
                </div>
            </div>

            <div class="shadow-md rounded-lg overflow-hidden">
                <table id="tableContainer" class="w-full bg-white">
                    <thead class="bg-blue-700 text-white">
                        <tr>
                            <th class="py-3 px-4">NO</th>
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($public)) : ?>
                            <tr>
                                <td colspan="3" class="py-6 text-center text-gray-500">Tidak ada data yang ditemukan.</td>
                            </tr>
                        <?php else : ?>
                            <?php $no = 0;
                            foreach ($public as $row) : $no++ ?>
                                <tr onclick="window.location='<?php echo base_url('admin/detail_pengguna/' . $row->id); ?>'" class="data-row hover:bg-blue-100 transition duration-300">
                                    <td class="py-3 px-4"><?= $no ?>.</td>
                                    <td class="py-3 px-4"><?= $row->nama ?></td>
                                    <td class="py-3 px-4"><?= $row->jenis_kelamin ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("tableContainer");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        document.getElementById("search").addEventListener("input", searchTable);
    </script>

</body>

</html>