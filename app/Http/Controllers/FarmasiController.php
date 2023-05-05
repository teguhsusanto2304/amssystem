<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KunjunganPasien;
use App\Models\TransaksiBarang;
use App\Models\Transaksi;
use App\Http\Controllers\TransaksiController;
use App\Models\Barang;
use App\Models\BarangSatuan;
use DataTables;
use DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class FarmasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$kunjungan)
    {
        if ($request->ajax()) {
            $data = TransaksiBarang::select('transaksi_barangs.qty','transaksi_barangs.tarif','transaksi_barangs.sub_total','barang_satuans.satuan','barangs.nama_barang','barangs.kode_barang','transaksi_barangs.data_status','transaksi_barangs.id','transaksi_barangs.kunjungan_pasien_id')
            ->join('barangs','transaksi_barangs.barang_id','=','barangs.id')
            ->join('barang_satuans','transaksi_barangs.satuan_barang_id','=','barang_satuans.id')
            ->where('transaksi_barangs.kunjungan_pasien_id',$kunjungan)
            ->orderBy('barangs.nama_barang','ASC');
            return DataTables::of($data)
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
        return view('farmasi.transaksi',compact('kunjungan'));
    }
    public function add_medicine($kunjungan){
        $obat = Barang::pluck('nama_barang','id');
        $satuan = BarangSatuan::pluck('satuan','id');
        return view('farmasi.add_medicine',compact('kunjungan','obat','satuan'));
    }
    function getAntrianFarmasi(){
        $last = Transaksi::where('service_unit_id',6)->where(DB::raw("DATE_FORMAT(transaksi_at,'%Y%m%d')"),date('Ymd'))
        ->get();
        return $last->count()+1;
    }
    public function getTarifBarang($id,$qty)
    {
        return Barang::select('harga_dasar',DB::RAW("harga_dasar * $qty as sub_total"))->where('id',$id)->first();
    }
    public function save_medicine(Request $request,$kunjungan){
        $head = Transaksi::select(DB::raw('id as no_trx'),'no_antrian')->where(['kunjungan_pasien_id'=>$kunjungan,'service_unit_id'=>6])->get()->first();
        $reg = KunjunganPasien::where('id',$kunjungan)->get()->first();
        if(empty($head->no_trx)==true){
            //transaksi pendaftaran pasien
            $no_antrian = $this->getAntrianFarmasi();
            $no_transaksi = (string) Str::uuid();
            $dt_transaksi = [];
            $dt_transaksi['id'] =  $no_transaksi;
            $dt_transaksi['kunjungan_pasien_id'] =  $kunjungan;
            $dt_transaksi['transaksi_at'] = date('Y-m-d H:n:s');
            $dt_transaksi['service_unit_id'] = 6;
            $dt_transaksi['no_antrian'] = $no_antrian;
            $dt_transaksi['no_transaksi'] = (new TransaksiController)->getTransactionNumber();
            Transaksi::create($dt_transaksi);
        } else {
            $no_transaksi = $head->no_trx;
            $no_antrian = $head['no_antrian'];
        }
        
            $no_transaksi_item = (string) Str::uuid();
            $dt_transaksi_item = [];
            $tarif = $this->getTarifbarang($request['obat'],$request['qty']);
            $dt_transaksi_item['id'] =  $no_transaksi_item;
            $dt_transaksi_item['transaksi_id'] =  $no_transaksi;
            $dt_transaksi_item['kunjungan_pasien_id'] =  $kunjungan;
            $dt_transaksi_item['transaksi_at'] = date('Y-m-d H:n:s');
            $dt_transaksi_item['service_unit_id'] = 6;
            $dt_transaksi_item['dokter_id'] = $reg['dokter_id'];
            $dt_transaksi_item['barang_id'] = $request['obat'];
            $dt_transaksi_item['satuan_barang_id'] = $request['satuan'];
            $dt_transaksi_item['tarif'] = $tarif['harga_dasar'];
            $dt_transaksi_item['qty'] = $request['qty'];
            $dt_transaksi_item['sub_total'] = $tarif['sub_total'];
            $dt_transaksi_item['no_antrian'] = $no_antrian;
            $dt_transaksi_item['no_transaksi'] = (new TransaksiItemController)->getTransaksiLayananNumber();
            TransaksiBarang::create($dt_transaksi_item);
            $trx = Transaksi::findOrFail($no_transaksi);
            $trx->update([
                'total' => $tarif['sub_total']
            ]);
       
        return redirect()->route('farmasi.transaksi',$kunjungan);
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
                           
                           $btn = '<a class="btn btn-primary" href="'.route('farmasi.transaksi',$row->reg_id).'">Transaksi Resep Obat</a>';
                           
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
        return view('farmasi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
