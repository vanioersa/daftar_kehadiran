<?php
class M_model extends CI_Model
{
    public function get_data($table)
    {
        return $this->db->get($table);
    }

    public function get_user_data_by_role($role, $limit, $offset)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('user', array('role' => $role))->result();
    }

    public function get_all_messages($table)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('tanggal', 'DESC');
        $this->db->order_by('jam', 'DESC');

        return $this->db->get();
    }

    public function get_data_by_id($table, $id)
    {
        $this->db->where('id', $id);
        return $this->db->get('user');
    }

    public function get_user_data_by_rolle($role)
    {
        $this->db->where('role', $role);
        $query = $this->db->get('user');
        return $query->result();
    }

    public function count_user_data_by_role($role)
    {
        return $this->db->get_where('user', array('role' => $role))->num_rows();
    }

    public function get_dataa($table, $limit, $offset)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get($table);
    }

    public function count_rows($table)
    {
        return $this->db->count_all($table);
    }

    public function get_data_except_current_user($table, $user_id)
    {
        $this->db->where('id !=', $user_id);
        return $this->db->get($table);
    }

    public function get_data_except_current_users($table, $user_id)
    {
        $this->db->where('id !=', $user_id);
        $this->db->where('role', 'user');
        return $this->db->get($table);
    }


    public function get_all_admin_ids_except_current($current_user_id)
    {
        $this->db->where('id !=', $current_user_id);
        $this->db->where('role', 'admin');
        $query = $this->db->get('user');

        $admin_ids = array();
        foreach ($query->result() as $row) {
            $admin_ids[] = $row->id;
        }

        return $admin_ids;
    }

    public function get_rating_results($user_id)
    {
        // Assuming you have a table named 'ratting'
        $this->db->where('id_user', $user_id);
        $query = $this->db->get('ratting');

        // Return the result as an array of objects
        return $query->result();
    }

    public function get_messages_by_sender($table, $user_id)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id_pengirim', $user_id);
        $this->db->or_where('id_penerima', $user_id);
        $this->db->order_by('tanggal', 'asc');
        $this->db->order_by('jam', 'asc');

        return $this->db->get();
    }

    public function getwhere($table, $data)
    {
        return $this->db->get_where($table, $data);
    }

    public function delete($table, $field, $id)
    {
        $data = $this->db->delete($table, array($field => $id));
        return $data;
    }

    public function tambah_data($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id($table);
    }

    public function get_by_id($tabel, $id_column, $id)
    {
        $data = $this->db->where($id_column, $id)->get($tabel);
        return $data;
    }

    public function ubah_data($tabel, $data, $where)
    {
        $data = $this->db->update($tabel, $data, $where);
        return $this->db->affected_rows();
    }

    public function check_email_exists($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('user');

        return $query->num_rows() > 0;
    }

    public function get_user_messagess($user_id)
    {
        $this->db->where('(id_pengirim = ' . $user_id . ' OR id_penerima = ' . $user_id . ')');
        $this->db->order_by('tanggal', 'DESC');
        $this->db->order_by('jam', 'DESC');
        return $this->db->get('pesan');
    }

    public function search_data($table, $order_by, $order_type, $search_query)
    {
        $this->db->group_start();
        $this->db->like('deskripsi', $search_query);
        $this->db->or_like('tempat', $search_query);
        $this->db->or_like('waktu_kejadian', $search_query);
        $this->db->group_end();
        $this->db->order_by($order_by, $order_type);
        return $this->db->get($table);
    }

    public function get_data_sorted($table, $field, $order = 'ASC')
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($field, $order);
        return $this->db->get();
    }

    public function search_public_data($search_query)
    {
        if ($search_query !== null) {
            $escaped_search_query = $this->db->escape_str($search_query);
            $this->db->like('tempat', $escaped_search_query);
            $this->db->or_like('deskripsi', $escaped_search_query);
        }

        $query = $this->db->get('deskripsi_public');
        return $query->result();
    }

    public function get_user_password($user_id)
    {
        $query = $this->db->select('password')->where('id', $user_id)->get('users');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->password;
        } else {
            return false;
        }
    }

    public function check_password_match($password)
    {
        $query = $this->db->where('password', $password)->get('users');

        return $query->num_rows() > 0;
    }

    public function check_nomor_exists($nomor)
    {
        $this->db->where('nomor', $nomor);
        $query = $this->db->get('user');

        return $query->num_rows() > 0;
    }

    public function insert_user($data)
    {
        $this->db->insert('user', $data);
        return $this->db->insert_id();
    }

    public function check_login($email, $password)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('user');

        if ($query->num_rows() > 0) {
            $user = $query->row();
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }

        return false;
    }

    public function get_user_by_role($role)
    {
        $this->db->where('role', $role);
        return $this->db->count_all_results('user');
    }

    public function get_comment_count()
    {
        return $this->db->count_all_results('ratting');
    }

    public function simpan_pesan_user($pesan, $pengirim, $penerima_array)
    {
        // Set timezone ke Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');

        // Loop melalui array penerima untuk menyimpan pesan kepada setiap penerima
        foreach ($penerima_array as $penerima) {
            $data = array(
                'pesan'       => $pesan,
                'id_pengirim' => $pengirim,
                'id_penerima' => $penerima,
                'tanggal'     => date('Y-m-d'), // Ubah format tanggal menjadi Y-m-d
                'jam'         => date('H:i:s') // Ubah format jam menjadi H:i:s
            );

            // Jika penerima adalah array, ubah menjadi string dengan koma
            if (is_array($penerima)) {
                $penerima = implode(', ', $penerima);
            }

            // Simpan data pesan ke dalam tabel pesan
            $this->db->insert('pesan', $data);
        }

        return true; // Mengembalikan nilai true jika penyimpanan berhasil
    }

    public function simpan_pesan($pesan, $pengirim, $penerima_array)
    {
        date_default_timezone_set('Asia/Jakarta');

        foreach ($penerima_array as $penerima) {
            $data = array(
                'pesan'       => $pesan,
                'id_pengirim' => $pengirim,
                'id_penerima' => $penerima,
                'tanggal'     => date('d-m-Y'),
                'jam'         => date('H.i.s')
            );

            if (is_array($penerima)) {
                $penerima = implode(', ', $penerima);
            }

            $this->db->insert('pesan', $data);
        }

        return true;
    }

    public function get_deskripsi_by_id($id)
    {
        $query = $this->db->get_where('deskripsi_public', array('id' => $id));
        return $query->row();
    }

    public function get_user_by_id($user_id)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->get('user');

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_image_by_id($table, $id)
    {
        $query = $this->db->get_where($table, array('id' => $id));

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->image;
        }

        return null;
    }

    public function get_foto_by_id($id)
    {
        $this->db->select('image');
        $this->db->from('user');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->image;
        } else {
            return false;
        }
    }

    public function get_dataa_by_user_id($table, $limit, $offset, $user_id)
    {
        $this->db->where('id_penerima', $user_id);
        $this->db->or_where('id_pengirim', $user_id);
        $this->db->limit($limit, $offset);
        $this->db->order_by('tanggal', 'desc');
        return $this->db->get($table)->result();
    }

    public function get_user_messages($user_id, $limit, $offset)
    {
        $this->db->where('id_pengirim', $user_id);
        $this->db->or_where('id_penerima', $user_id);
        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'desc');
        return $this->db->get('pesan');
    }

    public function count_user_messages($user_id)
    {
        $this->db->where('id_pengirim', $user_id);
        $this->db->or_where('id_penerima', $user_id);
        return $this->db->count_all_results('pesan');
    }

    public function get_admin_ids()
    {
        $this->db->select('id');
        $this->db->where('role', 'admin');
        $result = $this->db->get('user')->result();

        $admin_ids = [];
        foreach ($result as $admin) {
            $admin_ids[] = $admin->id;
        }

        return $admin_ids;
    }

    public function edit_deskripsi($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('deskripsi_public', $data);
    }
}
