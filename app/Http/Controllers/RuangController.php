<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruang;
use App\Models\ServiceUnit;
use DB;
use DataTables;
use Illuminate\Support\Facades\Gate;

class RuangController extends Controller
{
    private $serviceunit;
    public function __construct()
    {
        $this->serviceunit = ServiceUnit::pluck('service_unit','id');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        if ($request->ajax()) {
            $data = Ruang::join('service_units','ruangs.service_unit_id','=','service_units.id')
            ->select('ruangs.id','kode_ruang','nama_ruang','service_units.service_unit','ruangs.data_status')->orderBy('ruangs.id','ASC');
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
                           if (! Gate::allows(config('global.layanan_permission').'-edit',$row)) {
                           $btn .= '<a class="dropdown-item" href="'.route(config('global.ruang')['url'].'.edit',$row->id).'">Edit</a>';
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
        return view(config('global.ruang')['dir'].".index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($data=null)
    {
        $unit = $this->serviceunit;
        return view(config('global.ruang')['dir'].'.form',compact('data','unit'));
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
            'nama_ruang' => 'required|max:100|min:3',
            'kode_ruang' => 'required|max:5|min:5',
            'service_unit_id' => 'required',
        ],[
            'nama_ruang.required' => config('title.ruang_title')['name'].' wajib diisi',
            'nama_ruang.min' => config('title.ruang_title')['name'].' minimal 10 kharakter',
            'nama_ruang.max' => config('title.ruang_title')['name'].' maksimal 100 kharakter',
            'kode_ruang.required' => config('title.ruang_title')['kode'].' wajib diisi',
            'kode_ruang.min' => config('title.ruang_title')['kode'].' minimal 5 kharakter',
            'kode_ruang.max' => config('title.ruang_title')['kode'].' maksimal 5 kharakter',
            'service_unit_id.required' => config('title.ruang_title')['unit'].' wajib dipilih',
        ]);
        $request['data_status'] = (!empty($request['data_status'])?true:false); 
        Ruang::create($request->all());
        return redirect()->route(config('global.ruang')['url'].'.index')
                        ->with('success',config('title.ruang').' berhasil tersimpan');
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
