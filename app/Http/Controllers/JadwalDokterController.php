<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\ServiceUnit;
use App\Models\Speciality;
use App\Models\JadwalDokter;
use DataTables;
use DB;
use Illuminate\Support\Facades\Gate;

class JadwalDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->get('id');
        if ($request->ajax()) {
            if(!empty($id)){
                $data = JadwalDokter::where('doctor_id',$id)->join('doctors','jadwal_dokters.doctor_id','=','doctors.id')
                ->join('specialities','doctors.speciality_id','=','specialities.id')
                ->join('service_units','doctors.service_unit_id','=','service_units.id')
                ->select('jadwal_dokters.id',
                'hari',
                'jam_mulai',
                'jam_akhir',
                'service_unit',
                'speciality',
                DB::raw("CONCAT(front_title,' ',fullname,' ',IFNULL(back_title,'')) as name"))
                ->orderBy('fullname','ASC')
                ->orderBy('index_hari','ASC');
            } else {
                $data = JadwalDokter::join('doctors','jadwal_dokters.doctor_id','=','doctors.id')
                ->join('specialities','doctors.speciality_id','=','specialities.id')
                ->join('service_units','doctors.service_unit_id','=','service_units.id')
                ->select('jadwal_dokters.id',
                'hari',
                'jam_mulai',
                'jam_akhir',
                'service_unit',
                'speciality',
                DB::raw("CONCAT(front_title,' ',fullname,' ',IFNULL(back_title,'')) as name"))
                ->orderBy('fullname','ASC')
                ->orderBy('index_hari','ASC');
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
                           if (! Gate::allows('user-edit',$row)) {
                           $btn .= '<a class="dropdown-item" href="'.route('users.edit',$row->id).'">Edit</a>';
                           }
                           if (! Gate::allows('user-edit',$row)) {
                            $btn .= '<a class="dropdown-item" href="'.route('users.edit',$row->id).'">Non Aktif</a>';
                            }
                           $btn .= '</div></div>';
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
        
        return view('doctor_schedules.index',compact('id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doctors = Doctor::select(DB::raw("CONCAT(front_title,' ',fullname,' ',IFNULL(back_title,'')) as name"),'id')->pluck('name','id');
        $days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        return view('doctor_schedules.create',compact('doctors','days'));
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
            'dokter' => 'required',
            'hari'=>'required',
            'jam_mulai'=>'required',
            'jam_selesai'=>'required'
        ]);
        $data = [];
        $days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $data['doctor_id'] = $request['dokter'];
        $data['hari'] = $days[$request['hari']];
        $data['index_hari'] = $request['hari'];
        $data['jam_mulai'] = $request['jam_mulai'];
        $data['jam_akhir'] = $request['jam_selesai'];
        $data['data_status'] = 1;
        JadwalDokter::create($data);
    
        return redirect()->route('doctor_schedules.index')
                        ->with('success','Doctor Schedules created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bydoctor($id,Request $request)
    {
        if ($request->ajax()) {
            $data = JadwalDokter::where('doctor_id',$id)->join('doctors','jadwal_dokters.doctor_id','=','doctors.id')
            ->join('specialities','doctors.speciality_id','=','specialities.id')
            ->join('service_units','doctors.service_unit_id','=','service_units.id')
            ->select('jadwal_dokters.id',
            'hari',
            'jam_mulai',
            'jam_akhir',
            'service_unit',
            'speciality',
            DB::raw("CONCAT(front_title,' ',fullname,' ',IFNULL(back_title,'')) as name"))
            ->orderBy('fullname','ASC')
            ->orderBy('index_hari','ASC');
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
                           if (! Gate::allows('user-edit',$row)) {
                           $btn .= '<a class="dropdown-item" href="'.route('users.edit',$row->id).'">Edit</a>';
                           }
                           if (! Gate::allows('user-edit',$row)) {
                            $btn .= '<a class="dropdown-item" href="'.route('users.edit',$row->id).'">Non Aktif</a>';
                            }
                           $btn .= '</div></div>';
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
        
        return view('doctor_schedules.show');
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
