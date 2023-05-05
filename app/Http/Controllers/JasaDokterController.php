<?php

namespace App\Http\Controllers;

use App\Models\JasaDokter;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Gate;

class JasaDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JasaDokter::select('id','nama_jasa_dokter','prosentase_jasa_dokter','prosentase_rumah_sakit','data_status')->orderBy('nama_jasa_dokter','ASC');
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
                           if (! Gate::allows(config('global.jasa')['permission'].'-edit',$row)) {
                           $btn .= '<a class="dropdown-item" href="'.route(config('global.jasa')['url'].'.edit',$row->id).'">Edit</a>';
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
        $config = [
            'title'=>config('title.jasa_title')['module'],
            'subtitle'=>'Halaman '.config('title.jasa_title')['module'],
            'create_url'=>config('global.jasa')['url'].'.create',
            'list_url'=>config('global.jasa')['url'].'.index',
            'create_label'=>'Tambah '.config('title.jasa_title')['module'],
            'column'=>config('title.jasa_column'),
            'field'=>config('title.jasa_column_field')
        ];
        return view(config('global.jasa')['dir'].".index",compact('config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($data=null)
    {
        $config = [
            'title'=>config('title.jasa_title')['module'],
            'subtitle'=>'Halaman Tambah '.config('title.jasa_title')['module'].' Baru',
            'post_url'=>config('global.jasa')['url'].'.store',
            'list_url'=>config('global.jasa')['url'].'.index',
            'update_url'=>config('global.jasa')['url'].'.update',
            'column'=>config('title.jasa_column')
        ];
        return view(config('global.jasa')['dir'].'.form',compact('data','config'));
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
            'nama_jasa_dokter' => 'required|max:100|min:10',
            'prosentase_jasa_dokter' => 'numeric|max:100|min:0',
            'prosentase_rumah_sakit' => 'numeric|max:100|min:0'
        ],[
            'nama_jasa_dokter.required' => config('title.jasa_column')[1].' wajib diisi',
            'nama_jasa_dokter.min' => config('title.jasa_column')[1].' minimal 10 digit',
            'nama_jasa_dokter.max' => config('title.jasa_column')[1].' minimal 100 digit',
            'prosentase_jasa_dokter.min' => config('title.jasa_column')[2].' minimal 0 %',
            'prosentase_jasa_dokter.max' => config('title.jasa_column')[2].' maximal 100 %',
        ]);
        $request['data_status'] = (!is_null($request['data_status'])?true:false);
        JasaDokter::create($request->all());
        return redirect()->route(config('global.jasa')['dir'].'.index')
                        ->with('success',config('title.jasa_title')['module'].' berhasil tersimpan');
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
    public function edit(JasaDokter $doctorfee)
    {
        $data = $doctorfee;
        $config = [
            'title'=>config('title.jasa_title')['module'],
            'subtitle'=>'Halaman Tambah '.config('title.jasa_title')['module'].' Baru',
            'post_url'=>config('global.jasa')['url'].'.store',
            'list_url'=>config('global.jasa')['url'].'.index',
            'update_url'=>config('global.jasa')['url'].'.update',
            'column'=>config('title.jasa_column')
        ];
        return view(config('global.jasa')['dir'].'.form',compact('data','config'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JasaDokter $doctorfee)
    {
        request()->validate([
            'nama_jasa_dokter' => 'required|max:100|min:10',
            'prosentase_jasa_dokter' => 'numeric|max:100|min:0',
            'prosentase_rumah_sakit' => 'numeric|max:100|min:0'
        ],[
            'nama_jasa_dokter.required' => config('title.jasa_column')[1].' wajib diisi',
            'nama_jasa_dokter.min' => config('title.jasa_column')[1].' minimal 10 digit',
            'nama_jasa_dokter.max' => config('title.jasa_column')[1].' minimal 100 digit',
            'prosentase_jasa_dokter.min' => config('title.jasa_column')[2].' minimal 0 %',
            'prosentase_jasa_dokter.max' => config('title.jasa_column')[2].' maximal 100 %',
        ]);
        $request['data_status'] = (!is_null($request['data_status'])?true:false);
        $doctorfee->update($request->all());
        return redirect()->route(config('global.jasa')['dir'].'.index')
                        ->with('success',config('title.jasa_title')['module'].' berhasil terupdate');
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
