<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KunjunganPasien;
use App\Models\TransaksiBarang;
use App\Models\TransaksiItem;
use App\Models\Transaksi;
use App\Http\Controllers\TransaksiController;
use App\Models\Barang;
use App\Models\BarangSatuan;
use App\Models\RekamMedis;
use DataTables;
use DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$kunjungan)
    {
        if ($request->ajax()) {
            $obat = TransaksiBarang::select(DB::RAW('CONCAT(doctors.front_title,\' \',doctors.fullname) as dokter'),DB::raw("'Obat/Alkes' as group_item"),'transaksi_barangs.qty','transaksi_barangs.tarif','transaksi_barangs.sub_total','barang_satuans.satuan','barangs.nama_barang','barangs.kode_barang','transaksi_barangs.data_status','transaksi_barangs.id','transaksi_barangs.kunjungan_pasien_id')
            ->join('barangs','transaksi_barangs.barang_id','=','barangs.id')
            ->join('doctors','transaksi_barangs.dokter_id','=','doctors.id')
            ->join('barang_satuans','transaksi_barangs.satuan_barang_id','=','barang_satuans.id')
            ->where('transaksi_barangs.kunjungan_pasien_id',$kunjungan)
            ->orderBy('barangs.nama_barang','ASC');
            $layanan = TransaksiItem::select(DB::RAW('CONCAT(doctors.front_title,\' \',doctors.fullname) as dokter'),DB::raw("'Layanan/Tindakan' as group_item"),'transaksi_items.qty','transaksi_items.tarif','transaksi_items.sub_total',DB::raw("'jasa' as satuan"),DB::raw('layanans.nama_layanan as nama_barang'),DB::raw('layanans.kode_layanan as kode_barang'),'transaksi_items.data_status','transaksi_items.id','transaksi_items.kunjungan_pasien_id')
            ->join('layanans','transaksi_items.layanan_id','=','layanans.id')
            ->join('doctors','transaksi_items.dokter_id','=','doctors.id')
            ->where('transaksi_items.kunjungan_pasien_id',$kunjungan)
            ->orderBy('layanans.nama_layanan','ASC')
            ->union($obat)
            ->get();
            return DataTables::of($layanan)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<div class="row"><a href="javascript:void(0)" id="'.$row->id.'" class="btn btn-primary btn-sm ml-2 btn-edit">Edit</a>';
                           $btn .= '<a href="javascript:void(0)" id="'.$row->id.'" class="btn btn-danger btn-sm ml-2 btn-delete">Delete</a></div>';
                           $btn = '<div class="btn-group" role="group">
                           <button id="btnGroupVerticalDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               Menu <i class="mdi mdi-chevron-down"></i>
                           </button>';
                           $btn .= '<div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">';
                           $btn .= '<a class="dropdown-item" href="'.route('farmasi.transaksi.delete',$row->id).'">Hapus</a>';
                           
                           $btn .= '</div></div>';
                            return $btn;
                    })
                    ->addColumn('data_status', function($row){
                        if($row->data_status==1){
                            $btn = '<span class="badge bg-primary">Aktif</span>';
                        } else if ($row->data_status==0){
                            $btn = '<span class="badge badge-danger">Tidak Aktif</span>';
                        }
                        

                         return $btn;
                 })
                    ->rawColumns(['action','data_status'])
                    ->make(true);
        }
        return view('keuangan.transaksi',compact('kunjungan'));
    }

    public function kunjungan(request $request)
    {
        if ($request->ajax()) {
            if(!empty($request->get('tanggal'))){
            $data = KunjunganPasien::join('rekam_medis','kunjungan_pasiens.rekam_medis_id','=','rekam_medis.id')
            ->join('doctors','kunjungan_pasiens.dokter_id','=','doctors.id')
            ->join('service_units','kunjungan_pasiens.service_unit_id','=','service_units.id')
            ->select('kunjungan_pasiens.data_status',
            'kunjungan_pasiens.no_antrian',
            'kunjungan_pasiens.no_registrasi',
            'service_units.service_unit',
            DB::raw('kunjungan_pasiens.id as reg_id'),
            'rekam_medis.fullname',
            'rekam_medis.medical_record_no',
            DB::RAW('CONCAT(doctors.front_title,\' \',doctors.fullname) as dokter'),
            'doctors.front_title',
            DB::RAW("DATE_FORMAT(kunjungan_pasiens.kunjungan_at,'%d %M %Y %H:%i:%s') as kunjungan_at"))
            ->where( DB::RAW("DATE_FORMAT(kunjungan_pasiens.kunjungan_at,'%Y-%m-%d')"),$request->get('tanggal'))
            ->orderBy('kunjungan_pasiens.service_unit_id','ASC');
        } else {
            $data = KunjunganPasien::join('rekam_medis','kunjungan_pasiens.rekam_medis_id','=','rekam_medis.id')
            ->join('doctors','kunjungan_pasiens.dokter_id','=','doctors.id')
            ->join('service_units','kunjungan_pasiens.service_unit_id','=','service_units.id')
            ->select('kunjungan_pasiens.data_status',
            'kunjungan_pasiens.no_antrian',
            'kunjungan_pasiens.no_registrasi',
            'service_units.service_unit',
            'kunjungan_pasiens.id',
            'rekam_medis.fullname',
            'rekam_medis.medical_record_no',
            DB::RAW('CONCAT(doctors.front_title,\' \',doctors.fullname) as dokter'),
            'doctors.front_title',
            DB::RAW("DATE_FORMAT(kunjungan_pasiens.kunjungan_at,'%d %M %Y %H:%i:%s') as kunjungan_at"))
            ->where( DB::RAW("DATE_FORMAT(kunjungan_pasiens.kunjungan_at,'%Y%m%d')"),date('Ymd'))
            ->orderBy('kunjungan_pasiens.service_unit_id','ASC');
        }
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           
                           $btn = '<a class="btn btn-primary" href="'.route('keuangan.transaksi',$row->reg_id).'">Detail Transaksi</a>';
                           
                            return $btn;
                    })
                    ->addColumn('data_status', function($row){
                        if($row->data_status==1){
                            $btn = '<span class="badge bg-primary">Aktif</span>';
                        } else if ($row->data_status==0){
                            $btn = '<span class="badge bg-danger">Tidak Aktif</span>';
                        }
                        

                         return $btn;
                 })
                    ->rawColumns(['action','data_status'])
                    ->make(true);
        }
        return view('keuangan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($kunjungan)
    {
        $metode = ['Tunai','Transfer Bank','Virtual Account','Kartu Kredit'];
        $dtkunjungan = kunjunganPasien::select(DB::raw('id as reg_id'),'rekam_medis_id')->where('id',$kunjungan)->get()->first();
        $dtpasien = RekamMedis::where('id',$dtkunjungan->rekam_medis_id)->get()->first();
        $bank = ['','Mandiri','BCA','BNI','BRI'];
        $total = Transaksi::select(DB::raw('SUM(total) as sub_total'))->where('kunjungan_pasien_id',$kunjungan)->get()->first();
        return view('keuangan.pembayaran',compact('dtkunjungan','metode','dtpasien','bank','total'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$kunjungan)
    {
        $dtkunjungan = kunjunganPasien::select(DB::RAW('CONCAT(doctors.front_title,\' \',doctors.fullname) as dokter'),'service_units.service_unit',DB::raw('kunjungan_pasiens.id as reg_id'),'rekam_medis_id','no_registrasi')
        ->join('service_units','kunjungan_pasiens.service_unit_id','=','service_units.id')
        ->join('doctors','kunjungan_pasiens.dokter_id','=','doctors.id')
        ->where('kunjungan_pasiens.id',$kunjungan)->get()->first();
        $dtpasien = RekamMedis::where('id',$dtkunjungan->rekam_medis_id)->get()->first();
        $transaksi = Transaksi::select('service_units.service_unit','transaksis.no_transaksi','transaksis.total')->join('service_units','transaksis.service_unit_id','=','service_units.id')->where('kunjungan_pasien_id',$kunjungan)->get();
        
        return view('keuangan.invoice',compact('request','dtkunjungan','dtpasien','transaksi'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
