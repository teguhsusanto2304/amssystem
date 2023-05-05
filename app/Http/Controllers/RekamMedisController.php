<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekamMedis;
use App\Models\Education;
use App\Models\Work;
use DataTables;
use Illuminate\Support\Facades\Gate;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RekamMedis::select('id','medical_record_no',
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
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){                        
                           $btn = '<div class="btn-group" role="group">
                           <button id="btnGroupVerticalDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               Menu <i class="mdi mdi-chevron-down"></i>
                           </button>';
                           $btn .= '<div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">';
                           $btn .= '<a class="dropdown-item" href="'.route('users.show',$row->id).'">Show</a>';
                           $btn .= '<a class="dropdown-item" href="'.route('users.show',$row->id).'">Pasangan</a>';
                           $btn .= '<a class="dropdown-item" href="'.route('medicalrecords.penanggungjawab',$row->id).'">Penanggung Jawab</a>';
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
        
        return view('medicalrecords.index');
    }
    public function index_lain(Request $request)
    {
        if ($request->ajax()) {
            $data = RekamMedis::select('id','medical_record_no',
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
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){                        
                           $btn = '<div class="btn-group" role="group">
                           <button id="btnGroupVerticalDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               Menu <i class="mdi mdi-chevron-down"></i>
                           </button>';
                           $btn .= '<div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">';
                           $btn .= '<a class="dropdown-item" href="'.route('users.show',$row->id).'">Show</a>';
                           $btn .= '<a class="dropdown-item" href="'.route('users.show',$row->id).'">Pasangan</a>';
                           $btn .= '<a class="dropdown-item" href="'.route('medicalrecords.penanggungjawab',$row->id).'">Penanggung Jawab</a>';
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
                    ->addColumn('address1', function($row){
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
                    ->rawColumns(['action','data_status','profile','address1'])
                    ->make(true);
        }
        
        return view('medicalrecords.index_lain');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $education = Education::pluck('education','id')->all();
        $work = Work::pluck('work','id')->all();
        return view('medicalrecords.create',compact('education','work'));
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

    }
    public function penanggung_jawab(Rekammedis $rekammedis)
    {
        echo $rekammedis->penanggung_jawab[0]->fullname;
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
