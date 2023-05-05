<?php

namespace App\Http\Controllers;

use App\Models\KunjunganPasien;
use App\Models\RekamMedis;
use App\Models\Doctor;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\JadwalDokter;
use App\Models\JenisKunjungan;
use App\Models\JenisPerawatan;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\TransaksiItemController;

class KunjunganPasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
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
                'kunjungan_pasiens.id',
                'rekam_medis.fullname',
                'rekam_medis.gender',
                'rekam_medis.medical_record_no',
                DB::RAW('CONCAT(doctors.front_title,\' \',doctors.fullname) as dokter'),
                'doctors.front_title',
                DB::RAW("DATE_FORMAT(kunjungan_pasiens.kunjungan_at,'%d %M %Y %H:%i:%s') as kunjungan_at"),
                DB::RAW(" timestampdiff(year, rekam_medis.date_of_birth, curdate()) as age"))
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
            'rekam_medis.gender',
            'rekam_medis.medical_record_no',
            DB::RAW('CONCAT(doctors.front_title,\' \',doctors.fullname) as dokter'),
            'doctors.front_title',
            DB::RAW("DATE_FORMAT(kunjungan_pasiens.kunjungan_at,'%d %M %Y %H:%i:%s') as kunjungan_at"),
            DB::RAW(" timestampdiff(year, rekam_medis.date_of_birth, curdate()) as age"))
            ->where( DB::RAW("DATE_FORMAT(kunjungan_pasiens.kunjungan_at,'%Y%m%d')"),date('Ymd'))
            ->orderBy('kunjungan_pasiens.service_unit_id','ASC');
        }
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
                           $btn .= '<a class="dropdown-item" href="'.route('users.show',$row->id).'">Batal Kunjungan</a>';
                           $btn .= '<a class="dropdown-item" href="'.route('users.show',$row->id).'">Ganti Poli</a>';
                           if ( Gate::allows('user1-edit',$row)) {
                           $btn .= '<a class="dropdown-item" href="'.route('users.edit',$row->id).'">Edit</a>';
                           }
                           if ( Gate::allows('user1-edit',$row)) {
                            $btn .= '<a class="dropdown-item" href="'.route('users.edit',$row->id).'">Non Aktif</a>';
                            }
                           $btn .= '</div></div>';
                            return $btn;
                    })
                    ->addColumn('data_status', function($row){
                        if($row->data_status==1){
                            $btn = '<span class="badge bg-primary">Aktif</span>';
                        } else if ($row->data_status==0){
                            $btn = '<span class="badge badge-danger">Tidak Aktif</span>';
                        }     
                        if($row->data_status==1){
                            $btn = '<span class="badge bg-warning">Proses</span>';
                        } else if ($row->data_status==2){
                            $btn = '<span class="badge bg-success">Konsultasi</span>';
                        } else {
                            $btn = '<span class="badge bg-danger">Batal</span>';
                        }                         

                         return $btn;
                 })
                 ->addColumn('warna', function($row){
                    if($row->data_status==1){
                        $btn = '#90EE90';
                    } else if ($row->data_status==2){
                        $btn = '#00BFFF';
                    } else {
                        $btn = '#e9a296'; 
                    }                      

                     return $btn;
             })
                    ->rawColumns(['action','data_status','warna'])
                    ->make(true);
        }
        return view('registrations.index');
    }
    public function create_konsultasi_online($data=null)
    {
        $jadwal = JadwalDokter::join('doctors','jadwal_dokters.doctor_id','=','doctors.id')
        ->join('specialities','doctors.speciality_id','=','specialities.id')
        ->join('service_units','doctors.service_unit_id','=','service_units.id')
        ->select('doctors.id','doctors.service_unit_id',
        'hari',
        'jam_mulai',
        'jam_akhir',
        'service_unit',
        'speciality',
        DB::raw("CONCAT(front_title,' ',fullname,' ',IFNULL(back_title,'')) as name"))
        //->where('jadwal_dokters.index_hari',date('w'))
        ->orderBy('fullname','ASC')
        ->orderBy('index_hari','ASC')
        ->get();
        $config = [
            'title'=>'Registrasi Konsultasi Online',
            'subtitle'=>'Halaman Tambah Registrasi Konsultasi Online',
            'post_url'=>'registrations.store.online',
            'list_url'=>'registrations.online',
            'update_url'=>'registrations.update.online',
            'column'=>config('title.appointment_column'),
            'jadwal' => $jadwal
        ];
        return view('registrations.form',compact('data','config'));
    }
    public function konsultasi_online(request $request)
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
                'kunjungan_pasiens.id',
                'rekam_medis.fullname',
                'rekam_medis.gender',
                'rekam_medis.medical_record_no',
                DB::RAW('CONCAT(doctors.front_title,\' \',doctors.fullname) as dokter'),
                'doctors.front_title',
                DB::RAW("DATE_FORMAT(kunjungan_pasiens.kunjungan_at,'%d %M %Y %H:%i:%s') as kunjungan_at"),
                DB::RAW(" timestampdiff(year, rekam_medis.date_of_birth, curdate()) as age"))
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
            'rekam_medis.gender',
            'rekam_medis.medical_record_no',
            DB::RAW('CONCAT(doctors.front_title,\' \',doctors.fullname) as dokter'),
            'doctors.front_title',
            DB::RAW("DATE_FORMAT(kunjungan_pasiens.kunjungan_at,'%d %M %Y %H:%i:%s') as kunjungan_at"),
            DB::RAW(" timestampdiff(year, rekam_medis.date_of_birth, curdate()) as age"))
            ->where( DB::RAW("DATE_FORMAT(kunjungan_pasiens.kunjungan_at,'%Y%m%d')"),date('Ymd'))
            ->orderBy('kunjungan_pasiens.service_unit_id','ASC');
        }
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
                           $btn .= '<a class="dropdown-item" href="'.route('users.show',$row->id).'">Batal Kunjungan</a>';
                           $btn .= '<a class="dropdown-item" href="'.route('users.show',$row->id).'">Ganti Poli</a>';
                           if ( Gate::allows('user1-edit',$row)) {
                           $btn .= '<a class="dropdown-item" href="'.route('users.edit',$row->id).'">Edit</a>';
                           }
                           if ( Gate::allows('user1-edit',$row)) {
                            $btn .= '<a class="dropdown-item" href="'.route('users.edit',$row->id).'">Non Aktif</a>';
                            }
                           $btn .= '</div></div>';
                            return $btn;
                    })
                    ->addColumn('data_status', function($row){
                        if($row->data_status==1){
                            $btn = '<span class="badge bg-primary">Aktif</span>';
                        } else if ($row->data_status==0){
                            $btn = '<span class="badge badge-danger">Tidak Aktif</span>';
                        }     
                        if($row->data_status==1){
                            $btn = '<span class="badge bg-warning">Proses</span>';
                        } else if ($row->data_status==2){
                            $btn = '<span class="badge bg-success">Konsultasi</span>';
                        } else {
                            $btn = '<span class="badge bg-danger">Batal</span>';
                        }                         

                         return $btn;
                 })
                 ->addColumn('warna', function($row){
                    if($row->data_status==1){
                        $btn = '#90EE90';
                    } else if ($row->data_status==2){
                        $btn = '#00BFFF';
                    } else {
                        $btn = '#e9a296'; 
                    }                      

                     return $btn;
             })
                    ->rawColumns(['action','data_status','warna'])
                    ->make(true);
        }
        return view('registrations.index_online');
    }
    public function doctors_search(RekamMedis $rekammedis,Request $request){
        if ($request->ajax()) {           
                $data = JadwalDokter::join('doctors','jadwal_dokters.doctor_id','=','doctors.id')
                ->join('specialities','doctors.speciality_id','=','specialities.id')
                ->join('service_units','doctors.service_unit_id','=','service_units.id')
                ->select(
                DB::raw($rekammedis->id.' as nrm'),
                'hari',
                'jam_mulai',
                'jam_akhir',
                'service_unit',
                'speciality',
                'doctors.service_unit_id',
                'doctors.id',
                DB::raw("CONCAT(front_title,' ',fullname,' ',IFNULL(back_title,'')) as name"))
                ->where('jadwal_dokters.index_hari',date('w'))
                ->orderBy('fullname','ASC')
                ->orderBy('index_hari','ASC');                
            return DataTables::of($data,$rekammedis)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="#" class="btn btn-primary btn-sm ml-2 btn-edit">Pilih</a>';
                        $btn = '<a href="'.route('registrations.create',['rekammedis'=>$row->nrm,'jadwal'=>$row->id]).'" class="btn btn-primary btn-sm ml-2 btn-edit">Pilih</a>';
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
        return view('registrations.doctor_schedules',compact('rekammedis'));
    }
    public function patients_search(Request $request){
        if ($request->ajax()) {
            if($request->get('keyword')){
                $data = RekamMedis::where('fullname','like',"%".$request->get('keyword')."%")
                ->orWhere('medical_record_no','like',"%".$request->get('keyword')."%")
                ->select('id','medical_record_no',
                'title',
                'fullname',
                'date_of_birth',
                'gender',
                'address',
                'province_id',
                'city_id',
                'postal_code',
                'phone_number',
                'blood_type',
                'identity_type',
                'identity_number')->orderBy('id','ASC');
            } else {
                $data = RekamMedis::where(DB::raw('1=0'))
                ->select('id','medical_record_no',
                'fullname',
                'date_of_birth',
                'gender',
                'address',
                'province_id',
                'city_id',
                'postal_code',
                'phone_number',
                'blood_type',
                'identity_type',
                'identity_number')->orderBy('id','ASC');
            }  
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){                        
                        $btn = '<a href="'.route('registrations.doctors.search',$row->id).'" class="btn btn-primary btn-sm ml-2 btn-edit">Pilih</a>';
                        //$btn = '<button class="btn btn-primary" id="embuh" data="1234" type="button">Ambil</button>';
                        return $btn;
                    })
                    ->addColumn('data_status', function($row){
                        if($row->data_status==1){
                            $btn = '<span class="badge rounded-pill bg-primary float-end">Aktif</span>';
                        } else if ($row->data_status==0){
                            $btn = '<span class="badge bg-danger float-end">Tidak Aktif</span>';
                        }
                        

                         return $btn;
                    })
                    ->addColumn('profile', function($row){
                        $html ='<h4><strong>'.$row->fullname.'</strong></h4>
                        <div class="container text-left">
                            <div class="row">
                                <div class="col-md-5">
                                No Rekam Medis
                                </div>
                                <div class="col-md-1">
                                :
                                </div>
                                <div class="col">
                                '.$row->medical_record_no.'
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                Tgl Lahir
                                </div>
                                <div class="col-md-1">
                                :
                                </div>
                                <div class="col">
                                '.$row->date_of_birth.'
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                Gol Darah
                                </div>
                                <div class="col-md-1">
                                :
                                </div>
                                <div class="col">
                                '.$row->blood_type.'
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                Jenis Kelamin
                                </div>
                                <div class="col-md-1">
                                :
                                </div>
                                <div class="col">
                                '.$row->gender.'
                                </div>
                            </div>
                        </div>';
                        

                         return $html;
                    })
                    ->addColumn('address', function($row){
                        if($row->data_status==1){
                            $btn = '<span class="badge rounded-pill bg-primary float-end">Aktif</span><br>';
                        } else if ($row->data_status==0){
                            $btn = '<span class="badge bg-danger float-end">Tidak Aktif</span><br>';
                        }
                        $html = $row->address.'
                        <div class="container text-left">
                            <div class="row">
                                <div class="col-md-2">
                                No HP
                                </div>
                                <div class="col-md-1">
                                :
                                </div>
                                <div class="col">
                                '.$row->phone_number.'
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                No KTP
                                </div>
                                <div class="col-md-1">
                                :
                                </div>
                                <div class="col">
                                '.$row->identity_number.'
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                
                                </div>
                                <div class="col-md-1">
                                
                                </div>
                                <div class="col">
                                '.$btn.'
                                </div>
                            </div>
                        </div>';
                        

                         return $html;
                    })
                    ->rawColumns(['action','data_status','profile','address'])
                    ->make(true);
        }
        return view('registrations.patients_search');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($data=null)
    {
        $jenis_kunjungan = JenisKunjungan::pluck('jenis_kunjungan','id');
        $jenis_perawatan = JenisPerawatan::pluck('jenis_perawatan','id');
        $penanggung = [];
        $penanggung[0] = 'Sendiri';
        $penjamin = [];
        $penjamin[0] = 'Pilih';
        $config = [
            'title'=>'Registrasi',
            'subtitle'=>'Halaman Tambah Registrasi Baru',
            'post_url'=>'registrations.store',
            'list_url'=>'registrations.index',
            'update_url'=>'registrations.update',
            'column'=>config('title.appointment_column')
        ];
        return view('registrations.registration_form',compact('data','config','penanggung','penjamin','jenis_kunjungan','jenis_perawatan'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_registration(RekamMedis $rekammedis,Request $request)
    {
        $dokter = JadwalDokter::join('doctors','jadwal_dokters.doctor_id','=','doctors.id')
        ->join('service_units','doctors.service_unit_id','=','service_units.id')
        ->join('specialities','doctors.speciality_id','=','specialities.id')
        ->where('jadwal_dokters.id',$request->get('jadwal'))
        ->select(DB::raw("CONCAT(doctors.front_title,' ',doctors.fullname,' ',IFNULL(doctors.back_title,'')) as dokter_name"),
        'specialities.speciality',
        DB::raw("CONCAT(jadwal_dokters.hari,' ',jadwal_dokters.jam_mulai,' - ',jadwal_dokters.jam_mulai) as jadwal"),
        'service_units.service_unit',
        'doctors.id',
        'doctors.service_unit_id'
        )->first();
        $jenis_kunjungan = JenisKunjungan::pluck('jenis_kunjungan','id');
        $jenis_perawatan = JenisPerawatan::pluck('jenis_perawatan','id');
        $penanggung = [];
        $penanggung[0] = 'Sendiri';
        foreach($rekammedis->penanggung_jawab as $row){
            $penanggung[$row->id] = $row->fullname." - ".$row->tipe_penanggung_jawab;
        }
        $penjamin = [];
        if(count($rekammedis->penjamin)==0){
            $penjamin[0] = 'Tidak Ada';
        } else {
            $penjamin[0] = 'Pilih';
        }
        foreach($rekammedis->penjamin as $row){
            $penjamin[$row->id] = $row->penjamin." - ".$row->pemengang;
        }
        //$jenis_kunjungan->prepend('Pilih', '');
        return view('registrations.create',compact('penjamin','rekammedis','dokter','jenis_kunjungan','jenis_perawatan','penanggung'));
    }
    public function create_registration_online(RekamMedis $rekammedis,Request $request)
    {
        $dokter = JadwalDokter::join('doctors','jadwal_dokters.doctor_id','=','doctors.id')
        ->join('service_units','doctors.service_unit_id','=','service_units.id')
        ->join('specialities','doctors.speciality_id','=','specialities.id')
        ->where('jadwal_dokters.id',$request->get('jadwal'))
        ->select(DB::raw("CONCAT(doctors.front_title,' ',doctors.fullname,' ',IFNULL(doctors.back_title,'')) as dokter_name"),
        'specialities.speciality',
        DB::raw("CONCAT(jadwal_dokters.hari,' ',jadwal_dokters.jam_mulai,' - ',jadwal_dokters.jam_mulai) as jadwal"),
        'service_units.service_unit',
        'doctors.id',
        'doctors.service_unit_id'
        )->first();
        $jenis_kunjungan = JenisKunjungan::pluck('jenis_kunjungan','id');
        $jenis_perawatan = JenisPerawatan::pluck('jenis_perawatan','id');
        $penanggung = [];
        $penanggung[0] = 'Sendiri';
        foreach($rekammedis->penanggung_jawab as $row){
            $penanggung[$row->id] = $row->fullname." - ".$row->tipe_penanggung_jawab;
        }
        $penjamin = [];
        if(count($rekammedis->penjamin)==0){
            $penjamin[0] = 'Tidak Ada';
        } else {
            $penjamin[0] = 'Pilih';
        }
        foreach($rekammedis->penjamin as $row){
            $penjamin[$row->id] = $row->penjamin." - ".$row->pemengang;
        }
        //$jenis_kunjungan->prepend('Pilih', '');
        return view('registrations.create',compact('penjamin','rekammedis','dokter','jenis_kunjungan','jenis_perawatan','penanggung'));
    }
    function getRegistrationNumber()
    {
        $last = KunjunganPasien::where(DB::raw("DATE_FORMAT(kunjungan_at,'%Y%m%d')"),date('Ymd'))->get();
        $newNum=0;
        $maxDigit=4; //maximum digit of ur number
        $currentNumber=$last->count()+1;  //example this is your last number in database all we need to do is remove the zero before the number . i dont know how to remove it
        $count=strlen($currentNumber); //count the digit of number. example we already removed the zero before the number. the answer here is 2
        $numZero="";
        for($count;$count<=$maxDigit;$count++)
            $numZero=$numZero."0";
        $newNum="RG".date('Ymd')."$numZero$currentNumber";
        return $newNum;
    }
    function getAntrianDokter($id){
        $last = KunjunganPasien::where('dokter_id',$id)
        ->where(DB::raw("DATE_FORMAT(kunjungan_at,'%Y%m%d')"),date('Ymd'))
        ->get();
        return $last->count()+1;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'jenis_kunjungan_id' => 'required',
            'jenis_perawatan_id'=>'required',
            'service_unit_id'=>'required',
            'dokter_id'=>'required',
            'rekam_medis_id'=>'required'
        ],[
            'jenis_kunjungan_id.required'=>'Jenis Kunjungan harus dipilih',
            'jenis_perawatan_id.required'=>'Jenis Perawatan harus dipilih',
            'dokter_id.required'=>'Dokter harus dipilih',
            'rekam_medis_id.required'=>'Pasien harus dipilih',
            'service_unit_id.required'=>'Poliklinik harus isi',
        ]);
        $data = [];
        $no_registrasi = (string) Str::uuid();
        $no_antrian = $this->getAntrianDokter($request['dokter_id']);
        $data['id'] = $no_registrasi;
        $data['rekam_medis_id'] = $request['rekam_medis_id'];
        $data['dokter_id'] = $request['dokter_id'];
        $data['service_unit_id'] = $request['service_unit_id'];
        $data['kunjungan_at'] = date('Y-m-d H:n:s');
        $data['service_unit_id'] = $request['service_unit_id'];
        $data['jenis_kunjungan_id'] = $request['rekam_medis_id'];
        $data['jenis_perawatan_id'] = $request['jenis_perawatan_id'];
        $data['penanggungjawab_id'] = $request['penanggung'];
        $data['no_antrian'] = $no_antrian;
        $data['no_registrasi'] = $this->getRegistrationNumber();
        KunjunganPasien::create($data);
        //transaksi pendaftaran pasien
        $no_transaksi = (string) Str::uuid();
        $dt_transaksi = [];
        $dt_transaksi['id'] =  $no_transaksi;
        $dt_transaksi['kunjungan_pasien_id'] =  $no_registrasi;
        $dt_transaksi['transaksi_at'] = date('Y-m-d H:n:s');
        $dt_transaksi['service_unit_id'] = 4;
        $dt_transaksi['no_antrian'] = $no_antrian;
        $dt_transaksi['no_transaksi'] = (new TransaksiController)->getTransactionNumber();
        Transaksi::create($dt_transaksi);
        //transaksi item
        $no_transaksi_item = (string) Str::uuid();
        $dt_transaksi_item = [];
        $kode_layanan = 3;
        $qty = 1;
        $tarif = (new LayananController)->getTarifLayanan($kode_layanan,$qty);
        $dt_transaksi_item['id'] =  $no_transaksi_item;
        $dt_transaksi_item['transaksi_id'] =  $no_transaksi;
        $dt_transaksi_item['kunjungan_pasien_id'] =  $no_registrasi;
        $dt_transaksi_item['transaksi_at'] = date('Y-m-d H:n:s');
        $dt_transaksi_item['service_unit_id'] = 4;
        $dt_transaksi_item['dokter_id'] = $request['dokter_id'];
        $dt_transaksi_item['layanan_id'] = $kode_layanan;
        $dt_transaksi_item['tarif'] = $tarif['tarif'];
        $dt_transaksi_item['qty'] = $qty;
        $dt_transaksi_item['sub_total'] = $tarif['sub_total'];
        $dt_transaksi_item['no_antrian'] = $no_antrian;
        $dt_transaksi_item['no_transaksi'] = (new TransaksiItemController)->getTransaksiLayananNumber();
        TransaksiItem::create($dt_transaksi_item);
        $trx = Transaksi::findOrFail($no_transaksi);
        $trx->update([
            'total' => $tarif['sub_total']
        ]);
        
        //jasa medis
        //transaksi pendaftaran pasien
        $no_transaksi = (string) Str::uuid();
        $dt_transaksi = [];
        $dt_transaksi['id'] =  $no_transaksi;
        $dt_transaksi['kunjungan_pasien_id'] =  $no_registrasi;
        $dt_transaksi['transaksi_at'] = date('Y-m-d H:n:s');
        $dt_transaksi['service_unit_id'] = 4;
        $dt_transaksi['no_antrian'] = $no_antrian;
        $dt_transaksi['no_transaksi'] = (new TransaksiController)->getTransactionNumber();
        Transaksi::create($dt_transaksi);
        //transaksi item
        $no_transaksi_item = (string) Str::uuid();
        $dt_transaksi_item = [];
        $kode_layanan = 3;
        $qty = 1;
        $tarif = (new LayananController)->getTarifLayanan($kode_layanan,$qty);
        $dt_transaksi_item['id'] =  $no_transaksi_item;
        $dt_transaksi_item['transaksi_id'] =  $no_transaksi;
        $dt_transaksi_item['kunjungan_pasien_id'] =  $no_registrasi;
        $dt_transaksi_item['transaksi_at'] = date('Y-m-d H:n:s');
        $dt_transaksi_item['service_unit_id'] = 4;
        $dt_transaksi_item['dokter_id'] = $request['dokter_id'];
        $dt_transaksi_item['layanan_id'] = $kode_layanan;
        $dt_transaksi_item['tarif'] = $tarif['tarif'];
        $dt_transaksi_item['qty'] = $qty;
        $dt_transaksi_item['sub_total'] = $tarif['sub_total'];
        $dt_transaksi_item['no_antrian'] = $no_antrian;
        $dt_transaksi_item['no_transaksi'] = (new TransaksiItemController)->getTransaksiLayananNumber();
        TransaksiItem::create($dt_transaksi_item);
        $trx = Transaksi::findOrFail($no_transaksi);
        $trx->update([
            'total' => $tarif['sub_total']
        ]);
        return redirect()->route('registrations.index')
                        ->with('success','Registration created successfully.');
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
