<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Untuk User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .message-container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 0px 20px;
            background-color: #f9f9f9;
            border-radius: 30px;
            overflow-y: scroll;
            overflow-x: hidden;
            height: 460px;
            max-height: 460px;
            position: relative;
        }


        .message-date {
            text-align: center;
            background-color: #f9f9f9;
            padding: 10px;
            z-index: 1;
            position: sticky;
            top: 0;
        }

        .message-date.fixed {
            position: fixed;
            width: 100%;
            left: 0;
        }

        .message-container.scroll-padding {
            padding-top: 30px;
        }

        .message-container::-webkit-scrollbar {
            display: none;
        }

        .message {
            display: flex;
            align-items: flex-start;
            margin: 20px auto;

            border-radius: 100px;
        }

        .message .avatar {
            margin-top: 10px;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            margin-right: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .message .content {
            padding: 15px;
            border-radius: 10px;
            max-width: 70%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .message.self {
            justify-content: flex-end;
        }

        .message.self .avatar {
            margin-left: 10px;
            margin-right: 0;
        }

        .message.self .content p.sender {
            text-align: right;
        }

        .message.self .content p.timestamp {
            text-align: right;
        }

        .message .content p {
            margin: 0;
            word-wrap: break-word;
        }

        .message .content .timestamp {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
        }

        .message .content .sender {
            font-weight: bold;
        }

        .reply-form {
            display: flex;
            align-items: center;
        }

        .reply-form textarea {
            width: calc(100% - 100px);
            padding-top: 10px;
            padding-left: 10px;
            margin-left: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: none;
        }

        #sendMessage {
            padding: 10px;
            background-color: #3B62F6;
            color: white;
            border: none;
            margin-left: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        #sendMessage:hover {
            background-color: #3B82F6;
        }

        @media only screen and (max-width: 767px) {
            .message-date {
                text-align: center;
                background-color: rgba(255, 255, 255, 1);
                padding: 10px;
                z-index: 1;
                position: sticky;
            }
        }
    </style>

</head>

<body>
    <?php $this->load->view('sidebar_user'); ?>
    <div class="message-container">
        <?php $last_date = null;
        foreach ($pesan as $row) :
            $message_date = date('Y-m-d', strtotime($row->tanggal));
            $today_date = date('Y-m-d');

            if ($message_date == date('Y-m-d', strtotime('-1 day', strtotime($today_date)))) {
                $formatted_date = 'Kemarin';
            } elseif ($message_date == $today_date) {
                $formatted_date = 'Hari Ini';
            } else {
                $formatted_date = date('d M Y', strtotime($row->tanggal));
            }

            if ($formatted_date != $last_date) { ?>

                <p id="<?= str_replace(' ', '_', $formatted_date) ?>" class="message-date"><?= $formatted_date ?></p>

            <?php $last_date = $formatted_date;
            } ?>

            <div class="message <?= $row->id_pengirim == $user_id ? 'self' : '' ?>">
                <?php if ($row->id_pengirim != $user_id) : ?>
                    <img src="<?= base_url('./image/' . tampil_image_byid($row->id_pengirim)) ?>" class="avatar" alt="Avatar">
                <?php endif; ?>
                <div class="content <?= $row->id_pengirim == $user_id ? 'bg-blue-500 text-white' : 'bg-gray-300' ?>">
                    <p class="sender"><?= $row->id_pengirim == $user_id ? 'Anda' : tampil_nama_byid($row->id_pengirim) ?></p>
                    <p class="<?= $row->id_pengirim == $user_id ? 'text-right' : 'text-left' ?>"><?= $row->pesan ?></p>
                    <p class="<?= $row->id_pengirim == $user_id ? 'text-left pr-10 text-xs' : 'text-right pl-10 text-xs' ?>"> <?= date('H.i', strtotime($row->jam)) ?></p>
                </div>
                <?php if ($row->id_pengirim == $user_id) : ?>
                    <img src="<?= base_url('./image/' . tampil_image_byid($row->id_pengirim)) ?>" class="avatar" alt="Avatar">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div>
        <form method="post" action="<?= base_url('user/simpan_pesan'); ?>" id="pesanForm" class="reply-form">
            <textarea name="pesan" id="messageInput" placeholder="Tulis pesan untuk ..." required></textarea>
            <button type="submit" id="sendMessage"><i class="fas fa-paper-plane"></i> Kirim</button>
        </form>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', function() {
            const messageDates = document.querySelectorAll('.message-date');
            const messageContainer = document.querySelector('.message-container');

            window.addEventListener('scroll', function() {
                const scrollPosition = window.scrollY;

                messageDates.forEach(messageDate => {
                    const messageDatePosition = messageDate.offsetTop;

                    if (scrollPosition >= messageDatePosition) {
                        messageDate.classList.add('fixed');
                        messageContainer.classList.add('scroll-padding');
                    } else {
                        messageDate.classList.remove('fixed');
                        messageContainer.classList.remove('scroll-padding');
                    }
                });
            });
        });
    </script>
</body>

</html>