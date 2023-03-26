<?php

namespace App\Controllers;
use App\Models\Catatan;

class user extends BaseController
{
    public function index()
    {
        if (session('nik') == NULL)  {
            return redirect()->to(base_url('login'));
        } else {
            return view('user/index');
        }
    }

    public function catatan()
    {
        if (session('nik') == NULL) {
        return redirect()->to(base_url('login'));
        } else {
        return view('user/catatan');
        }
    }

    public function simpan_catatan()
    {
        $catatan = new Catatan();
        $tanggal = $this->request->getVar('tanggal');
        $jam = $this->request->getVar('jam');
        $lokasi = $this->request->getVar('lokasi');
        $suhu = $this->request->getVar('suhu');
        $nama = session('nama');
        $nik = session('nik');
        $data = [
          'Tanggal' => $tanggal,
          'Jam' => $jam,
          'LokasiBerkunjung' => $lokasi ,
          'SuhuTubuh' => $suhu, 
        ];

        $catatan->save($data);
        
        // $format = "\n$nik|$nama|$tanggal|$jam|$lokasi|$suhu °";
        // $file = fopen('catatan.txt', 'a');
        // fwrite($file, $format);
        // fclose($file);

        session()->set('simpan_catatan', 'Catatan Berhasil Disimpan');

        $session = session();
        $session->markAsFlashdata('simpan_catatan');
        return redirect()->to(base_url('riwayat'));
    }

    public function riwayat()
    {
        if (session('nik') == NULL) {
        return redirect()->to(base_url('login'));
        } else {
        // $data = [
        // 'data' => file('catatan.txt', FILE_IGNORE_NEW_LINES)
        // ];
        $perjalanan = new Catatan();
        $perjalanan = $perjalanan->findAll();

        $data = [
            'perjalanan' => $perjalanan
        ];
        return view('user/riwayat', $data);
        }
    }
}