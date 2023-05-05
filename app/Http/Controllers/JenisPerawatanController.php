<?php

namespace App\Http\Controllers;

use App\Models\JenisPerawatan;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Gate;

class JenisPerawatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        if ($request->ajax()) {
            $data = JenisPerawatan::select('id','jenis_perawatan','data_status')->orderBy('id','ASC');
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
                           if (! Gate::allows('jenis-perawatan-edit',$row)) {
                           $btn .= '<a class="dropdown-item" href="'.route('jenisperawatans.edit',$row->id).'">Edit</a>';
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
        
        return view('jenis_perawatan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = null;
        return view('jenis_perawatan.form',compact('data'));
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
            'jenis_perawatan' => 'required|max:100|min:10'
        ],[
            'jenis_perawatan.required' => 'Jenis perawatan wajib diisi',
            'jenis_perawatan.min' => 'Jenis perawatan minimal 10 kharakter',
            'jenis_perawatan.max' => 'Jenis perawatan maksimal 100 kharakter'
        ]);
        $request['data_status'] = (!empty($request['data_status'])?true:false); 
        JenisPerawatan::create($request->all());
        return redirect()->route('jenisperawatans.index')
                        ->with('success','Jenis perawatan berhasil tersimpan');
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
    public function edit(Jenisperawatan $jenisperawatan)
    {
        $data = $jenisperawatan;
        return view('jenis_perawatan.form',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JenisPerawatan $jenisperawatan)
    {
        request()->validate([
            'jenis_perawatan' => 'required|max:100|min:10'
        ],[
            'jenis_perawatan.required' => 'Jenis perawatan wajib diisi',
            'jenis_perawatan.min' => 'Jenis perawatan minimal 10 kharakter',
            'jenis_perawatan.max' => 'Jenis perawatan maksimal 100 kharakter'
        ]);
        $request['data_status'] = (!is_null($request['data_status'])?true:false);
        $jenisperawatan->update($request->all());
        return redirect()->route('jenisperawatans.index')
                        ->with('success','Jenis perawatan berhasil terupdate');
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
