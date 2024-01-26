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
            <div class="mb-4">
                <label for="search" class="text-gray-500">Cari:</label>
                <input type="text" id="search" class="border border-gray-300 rounded-md p-1">
            </div>
            <table id="tableContainer" class="w-full bg-white border border-gray-300 rounded-md shadow-md">
                <thead class="bg-blue-700 text-white">
                    <tr>
                        <th class="py-3 px-4 border-b">#</th>
                        <th class="py-3 px-4 border-b">Nama</th>
                        <th class="py-3 px-4 border-b">Jenis Kelamin</th>
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
                            <tr class="data-row hover:bg-blue-100 transition duration-300">
                                <td class="py-3 px-4 border-b"><?= $no ?>.</td>
                                <td class="py-3 px-4 border-b"><?= $row->nama ?></td>
                                <td class="py-3 px-4 border-b"><?= $row->jenis_kelamin ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif; ?>
                </tbody>
            </table>
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
