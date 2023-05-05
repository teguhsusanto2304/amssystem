<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\JadwalDokter;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Illuminate\Support\Facades\Gate;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Appointment::join('doctors','appointments.dokter_id','=','doctors.id')
            ->join('service_units','appointments.service_unit_id','=','service_units.id')
            ->select(
                'appointments.id',
                'appointments.rekam_medis_id',
                'appointments.title',
                DB::RAW('CONCAT(appointments.fullname,\', \',appointments.title) as fullname'),
                'appointments.date_of_birth',
                'appointments.gender',
                'appointments.phone_number',
                DB::RAW('CONCAT(doctors.front_title,\' \',doctors.fullname) as dokter'),
                DB::RAW("DATE_FORMAT(appointments.appointment_at,'%d %M %Y %H:%i:%s') as appointment_at"),
                DB::RAW(" timestampdiff(year, appointments.date_of_birth, curdate()) as age"),
                'service_units.service_unit',
                'appointments.no_antrian',
                'appointments.data_status',
                'kunjungan_pasien_id',
                'keterangan'
            )
            ->where( DB::RAW("DATE_FORMAT(appointments.appointment_at,'%Y-%m-%d')"),$request->get('tanggal'))
            ->orderBy('appointment_at','ASC');
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
                           if (! Gate::allows(config('global.appointment')['permission'].'-edit',$row)) {
                            $btn .= '<a class="dropdown-item" href="'.route(config('global.appointment')['url'].'.edit',$row->id).'">Buat Kunjungan Pasien</a>';
                           $btn .= '<a class="dropdown-item" href="'.route(config('global.appointment')['url'].'.edit',$row->id).'">Reschedule</a>';
                           $btn .= '<a class="dropdown-item" href="'.route(config('global.appointment')['url'].'.edit',$row->id).'">Batal</a>';
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
                 ->addColumn('warnaku', function($row){
                    if($row->data_status==1){
                        $btn = '#90EE90';
                    } else if ($row->data_status==2){
                        $btn = '#00BFFF';
                    } else {
                        $btn = '#e9a296'; 
                    }                      

                     return $btn;
             })
                    ->rawColumns(['action','data_status','warnaku'])
                    ->make(true);
        }
        $config = [
            'title'=>config('title.appointment_title')['module'],
            'subtitle'=>'Halaman '.config('title.appointment_title')['module'],
            'create_url'=>config('global.appointment')['url'].'.create',
            'list_url'=>config('global.appointment')['url'].'.index',
            'create_label'=>'Tambah '.config('title.appointment_title')['module'],
            'column'=>config('title.appointment_column'),
            'field'=>config('title.appointment_column_field')
        ];
        return view(config('global.appointment')['dir'].".index",compact('config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($data=null)
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
            'title'=>config('title.appointment_title')['module'],
            'subtitle'=>'Halaman Tambah '.config('title.appointment_title')['module'].' Baru',
            'post_url'=>config('global.appointment')['url'].'.store',
            'list_url'=>config('global.appointment')['url'].'.index',
            'update_url'=>config('global.appointment')['url'].'.update',
            'column'=>config('title.appointment_column'),
            'jadwal' => $jadwal
        ];
        return view(config('global.appointment')['dir'].'.form',compact('data','config'));
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
            'title' => 'required',
            'fullname' => 'required|max:100|min:10',
            'gender'=>'required',
            'date_of_birth' => 'required',
            'dokter_id' => 'required',
            'appointment_at' => 'required'
        ],[
            'title.required' => 'Panggilan wajib diisi',
            'fullname.required' => 'Nama Pasien wajib diisi',
            'fullname.max' => 'Nama Pasien maximal 100',
            'fullname.min' => 'Nama Pasien min 3',
            'gender.required'=>'gender wajib diisi',
            'date_of_birth.required' => 'Tanggal Lahir wajib diisi',
            'dokter_id.required' => 'Dokter wajib diisi',
            'appointment_at.required' => 'Tanggal Appointment wajib diisi',
        ]);
        $request['no_antrian'] = 1;
        $request['data_status'] = (!is_null($request['data_status'])?true:false);
        Appointment::create($request->all());
        return redirect()->route(config('global.appointment')['dir'].'.index')
                        ->with('success',config('title.appointment_title')['module'].' berhasil tersimpan');
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
