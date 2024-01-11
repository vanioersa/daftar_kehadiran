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

<body>
    <?php $this->load->view('sidebar_admin'); ?>

    <?php foreach ($user as $row) : ?>
        <h1 style="text-align: center; font-weight: bold; font-size: xx-large; margin-top: 20px;">selamat datang <?php echo $row->nama; ?></h1>
    <?php endforeach; ?>

    <div class="flex flex-col md:col-span-2 md:row-span-2 shadow rounded-lg ml-10 mr-10 mt-10 bg-green-500">
        <div class="px-6 py-5 font-semibold border-b border-gray-100">Rating</div>
        <div class="p-4 flex-grow">
            <div class="flex items-center justify-center h-full px-4 py-16 text-gray-400 text-3xl font-semibold bg-gray-100 border-2 border-gray-200 border-dashed rounded-md">

            </div>
        </div>
    </div>

</body>

</html>