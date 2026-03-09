<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    private function baseQuery($start = null, $end = null, $kasir = null)
    {
        $builder = $this->db->table('transactions t')
            ->select('t.id, t.nomor_unik, t.nama_pelanggan, t.total_harga, t.uang_bayar, t.uang_kembali, t.created_at, u.nama as nama_kasir')
            ->join('users u', 'u.id = t.id_user');

        if ($start && $end) {
            $builder->where('DATE(t.created_at) >=', $start)
                    ->where('DATE(t.created_at) <=', $end);
        }

        if ($kasir) {
            $builder->where('t.id_user', $kasir);
        }

        return $builder->orderBy('t.created_at', 'DESC');
    }

    public function index()
    {
        $start = $this->request->getGet('start');
        $end   = $this->request->getGet('end');
        $kasir = $this->request->getGet('kasir');

        $data['laporan'] = $this->baseQuery($start, $end, $kasir)->get()->getResultArray();
        $data['kasirList'] = $this->db->table('users')->where('role', 'kasir')->get()->getResultArray();

        $data['start'] = $start;
        $data['end']   = $end;
        $data['kasir'] = $kasir;

        return view('owner/laporan/index', $data);
    }

    public function exportPdf()
    {
        $start = $this->request->getGet('start');
        $end   = $this->request->getGet('end');
        $kasir = $this->request->getGet('kasir');

        $data['laporan'] = $this->baseQuery($start, $end, $kasir)->get()->getResultArray();

        $html = view('owner/laporan/pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream('laporan-transaksi-owner.pdf', ['Attachment' => true]);
    }

    public function exportExcel()
    {
        $start = $this->request->getGet('start');
        $end   = $this->request->getGet('end');
        $kasir = $this->request->getGet('kasir');

        $rows = $this->baseQuery($start, $end, $kasir)->get()->getResultArray();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->fromArray([
            ['No', 'No Transaksi', 'Tanggal', 'Kasir', 'Pelanggan', 'Total', 'Bayar', 'Kembali']
        ], null, 'A1');

        $i = 2; $no = 1;
        foreach ($rows as $r) {
            $sheet->fromArray([[
                $no++,
                $r['nomor_unik'],
                date('d/m/Y H:i', strtotime($r['created_at'])),
                $r['nama_kasir'],
                $r['nama_pelanggan'],
                $r['total_harga'],
                $r['uang_bayar'],
                $r['uang_kembali'],
            ]], null, 'A' . $i++);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-transaksi-owner.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $writer->save('php://output');
        exit;
    }
}