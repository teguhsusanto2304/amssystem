<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Gate;

class SpecialityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        if ($request->ajax()) {
            $data = Speciality::select('speciality','data_status','id')->orderBy('id','ASC');
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
                           //$btn .= '<a class="dropdown-item" href="'.route('users.show',$row->id).'">Show</a>';
                           if (! Gate::allows('spesialis-edit',$row)) {
                           $btn .= '<a class="dropdown-item" href="'.route('specialities.edit',$row->id).'">Edit</a>';
                           }
                           if (! Gate::allows('spesialis-edit',$row)) {
                            //$btn .= '<a class="dropdown-item" href="'.route('users.edit',$row->id).'">Non Aktif</a>';
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
        
        return view('spesialis.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = null;
        return view('spesialis.form',compact('data'));
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
            'speciality' => 'required|max:100|min:3'
        ],[
            'speciality.required' => 'Spesialis wajib diisi',
            'speciality.min' => 'Spesialis minimal 10 kharakter',
            'speciality.max' => 'Spesialis maksimal 100 kharakter'
        ]);
        $request['data_status'] = (!empty($request['data_status'])?true:false); 
        Speciality::create($request->all());
        return redirect()->route('specialities.index')
                        ->with('success','Spesialis berhasil tersimpan');
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
    public function edit(Speciality $speciality)
    {
        $data = $speciality;
        return view('spesialis.form',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Speciality $speciality)
    {
        request()->validate([
            'speciality' => 'required|max:100|min:3'
        ],[
            'speciality.required' => 'Spesialis wajib diisi',
            'speciality.min' => 'Spesialis minimal 10 kharakter',
            'speciality.max' => 'Spesialis maksimal 100 kharakter'
        ]);
        $request['data_status'] = (!is_null($request['data_status'])?true:false);
        $speciality->update($request->all());
        return redirect()->route('specialities.index')
                        ->with('success','Spesialis berhasil terupdate');
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
