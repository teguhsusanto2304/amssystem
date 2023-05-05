<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\ServiceUnit;
use App\Models\JasaDokter;
use App\Models\DokterServiceUnit;
use App\Models\Speciality;
use DataTables;
use DB;
use Illuminate\Support\Facades\Gate;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Doctor::join('specialities','doctors.speciality_id','=','specialities.id')
            ->join('service_units','doctors.service_unit_id','=','service_units.id')
            ->select('doctors.id',
            'medic_code',
            'front_title',
            'fullname',
            'back_title',
            'date_of_birth',
            DB::raw("if(gender=1,'Perempuan','Lelaki') as gender"),
            'address',
            'phone_number',
            'service_unit',
            'speciality',
            'doctors.data_status',
            DB::raw("CONCAT(front_title,' ',fullname,' ',IFNULL(back_title,'')) as name"))
            ->orderBy('id','ASC');
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
                           $btn .= '<a class="dropdown-item" href="'.route('doctors.edit',$row->id).'">Edit</a>';
                           $btn .= '<a class="dropdown-item" href="'.route('doctor_schedules.index').'?id='.$row->id.'">Jadwal Praktek</a>';
                           $btn .= '<a class="dropdown-item" href="'.route('doctor_schedules.index').'?id='.$row->id.'">Jasa Medis</a>';
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
                            $btn = '<span class="badge badge-danger">Tidak Aktif</span>';
                        }
                        

                         return $btn;
                 })
                    ->rawColumns(['action','data_status'])
                    ->make(true);
        }
        
        return view('doctors.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($data=null)
    {
        $speciality = Speciality::pluck('speciality','id');
        $unit = ServiceUnit::pluck('service_unit','id');
        $serviceunit = ServiceUnit::where('tipe_service_unit','Medis')->get();
        $jasa = JasaDokter::get();
        return view('doctors.form',compact('speciality','unit','serviceunit','jasa','data'));
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
            'gelar_depan' => 'required',
            'nama'=>'required',
            'jenis_kelamin'=>'required',
            'tgl_lahir'=>'required',
            'no_handphone'=>'required',
            'NIP'=>'required',
            'alamat'=>'required',
            'spesialis'=>'required',
            'units'=>'required'
        ]);
        $data = [];
        $data['front_title'] = $request['gelar_depan'];
        $data['fullname'] = $request['nama'];
        $data['back_title'] = $request['gelar_belakang'];
        $data['gender'] = $request['jenis_kelamin'];
        $data['date_of_birth'] = $request['tgl_lahir'];
        $data['phone_number'] = $request['no_handphone'];
        $data['medic_code'] = $request['NIP'];
        $data['address'] = $request['alamat'];
        $data['speciality_id'] = $request['spesialis'];
        //$data['service_unit_id'] = $request['unit_kerja'];
        $data['service_unit_id'] = $request['units'][0];
        $data['data_status'] = 1;
        $dokter = Doctor::create($data);  
        foreach($request['units'] as $row) {
            DokterServiceUnit::create(['doctor_id'=>$dokter->id,'service_unit_id'=>$row]);
        } 
        return redirect()->route('doctors.index')
                        ->with('success','Doctor created successfully.');
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
    public function edit(Doctor $doctor)
    {
        $speciality = Speciality::pluck('speciality','id');
        $unit = ServiceUnit::pluck('service_unit','id');
        $serviceunit = ServiceUnit::where('tipe_service_unit','Medis')->get();
        $jasa = JasaDokter::get();
        $data = $doctor;
        return view('doctors.form',compact('speciality','unit','serviceunit','jasa','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Doctor $doctor)
    {
       request()->validate([
            'gelar_depan' => 'required',
            'nama'=>'required',
            'jenis_kelamin'=>'required',
            'tgl_lahir'=>'required',
            'no_handphone'=>'required',
            'NIP'=>'required',
            'alamat'=>'required',
            'spesialis'=>'required',
            'units'=>'required'
        ]);
        $data = [];
        $data['front_title'] = $request['gelar_depan'];
        $data['fullname'] = $request['nama'];
        $data['back_title'] = $request['gelar_belakang'];
        $data['gender'] = $request['jenis_kelamin'];
        $data['date_of_birth'] = $request['tgl_lahir'];
        $data['phone_number'] = $request['no_handphone'];
        $data['medic_code'] = $request['NIP'];
        $data['address'] = $request['alamat'];
        $data['speciality_id'] = $request['spesialis'];
        //$data['service_unit_id'] = $request['unit_kerja'];
        $data['service_unit_id'] = $request['units'][0];
        $data['data_status'] = 1;
        $doctor->update($data);  
        foreach($request['units'] as $row) {
            //DokterServiceUnit::create(['doctor_id'=>$dokter->id,'service_unit_id'=>$row]);
        } 
        $data = "";
        return redirect()->route('doctors.index')
                        ->with('success','Data Dokter berhasil diupdate');

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
