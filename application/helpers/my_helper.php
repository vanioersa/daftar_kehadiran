<?php
function tampil_nama_byid($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id', $id)->get('user');
    foreach ($result->result() as $c) {
        $stmt = $c->nama;
        return $stmt;
    }
}
function tampil_image_byid($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id', $id)->get('user');
    foreach ($result->result() as $c) {
        $stmt = $c->image;
        return $stmt;
    }
}
function tampil_nomor_byid($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id', $id)->get('user');
    foreach ($result->result() as $c) {
        $stmt = $c->nomor;
        return $stmt;
    }
}
function tampil_email_byid($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id', $id)->get('user');
    foreach ($result->result() as $c) {
        $stmt = $c->email;
        return $stmt;
    }
}
function get_star_icons($rating)
{
    $output = '';

    // Assuming you want to display full stars
    for ($i = 1; $i <= 5; $i++) {
        $output .= ($i <= $rating) ? '&#9733;' : '&#9734;'; // Unicode for star and empty star
    }

    return $output;
}
?>