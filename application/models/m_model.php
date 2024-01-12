<?php
class M_model extends CI_Model
{
    public function get_data($table)
    {
        return $this->db->get($table);
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

    public function simpan_pesan($pesan, $pengirim, $penerima_array)
    {
        foreach ($penerima_array as $penerima) {
            $data = array(
                'pesan'    => $pesan,
                'id_pengirim' => $pengirim,
                'id_penerima' => $penerima,
                'tanggal'  => date('d-m-Y'),
                'jam'  => date('H.i')
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

    public function edit_deskripsi($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('deskripsi_public', $data);
    }
}
