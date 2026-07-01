<?php

namespace App\Exports;

use App\Models\Penyaluran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanBansosExport implements FromCollection, WithHeadings
{

    protected $bulan;
    protected $tahun;


    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }



    public function collection()
    {

        return Penyaluran::with([
            'penerima.warga',
            'penerima.jenisBansos'
        ])
        ->where('periode_bulan',$this->bulan)
        ->where('periode_tahun',$this->tahun)
        ->get()
        ->map(function($item){


            return [

                'NIK' =>
                $item->penerima->warga->nik ?? '-',

                'Nama Warga' =>
                $item->penerima->warga->nama_lengkap ?? '-',

                'Jenis Bansos' =>
                $item->penerima->jenisBansos->nama_bansos ?? '-',


                'Nominal' =>
                $item->nominal,


                'Tanggal Salur' =>
                $item->tanggal_salur,


                'Metode' =>
                $item->metode,


                'Status' =>
                ucfirst($item->status)

            ];


        });

    }



    public function headings(): array
    {
        return [

            'NIK',
            'Nama Warga',
            'Jenis Bansos',
            'Nominal',
            'Tanggal Salur',
            'Metode',
            'Status'

        ];
    }

}