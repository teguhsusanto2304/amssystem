<?php

namespace App\Http\Controllers;

use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Gate;

class ServiceUnitController extends Controller
{
    var $folder = "service_unit";
    var $title = "Unit Layanan";
    var $url = "serviceunits";
    var $subtitle = " Halaman Unit Layanan";
    var $subtitle_form = " Halaman Tambah/Edit Unit Layanan";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        if ($request->ajax()) {
            $data = ServiceUnit::select('id','tipe_service_unit','service_unit','speciality_id','data_status')->orderBy('id','ASC');
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
                           if (! Gate::allows('jenis-kunjungan-edit',$row)) {
                           $btn .= '<a class="dropdown-item" href="'.route($this->url.'.edit',$row->id).'">Edit</a>';
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
        $header = ['title'=>$this->title,'subtitle'=>$this->subtitle,'url'=>$this->url.".index"];
        return view($this->folder.".index",compact('header'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = null;
        $header = ['title'=>$this->title,'subtitle'=>$this->subtitle_form,'url'=>$this->url];
        $tipe = ['Umum'=>'Umum','Medis'=>'Medis'];
        return view($this->folder.".form",compact('data','header','tipe'));
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
            'service_unit' => 'required|max:100|min:3',
            'tipe_service_unit' => 'required'
        ],[
            'service_unit.required' => $this->title.' wajib diisi',
            'service_unit.min' => $this->title.' minimal 10 kharakter',
            'service_unit.max' => $this->title.' maksimal 100 kharakter',
            'tipe_service_unit.required' => 'Tipe '. $this->title.' wajib dipilih'
        ]);
        $request['data_status'] = (!empty($request['data_status'])?true:false); 
        ServiceUnit::create($request->all());
        return redirect()->route($this->url.'.index')
                        ->with('success',$this->title.' berhasil tersimpan');
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
    public function edit(ServiceUnit $serviceunit)
    {
        $data = $serviceunit;
        $header = ['title'=>$this->title,'subtitle'=>$this->subtitle_form,'url'=>$this->url];
        $tipe = ['Umum'=>'Umum','Medis'=>'Medis'];
        return view($this->folder.'.form',compact('data','header','tipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceUnit $serviceunit)
    {
        request()->validate([
            'service_unit' => 'required|max:100|min:3',
            'tipe_service_unit' => 'required'
        ],[
            'service_unit.required' => $this->title.' wajib diisi',
            'service_unit.min' => $this->title.' minimal 10 kharakter',
            'service_unit.max' => $this->title.' maksimal 100 kharakter',
            'tipe_service_unit.required' => 'Tipe '. $this->title.' wajib dipilih'
        ]);
        $request['data_status'] = (!is_null($request['data_status'])?true:false);
        $serviceunit->update($request->all());
        return redirect()->route($this->url.'.index')
                        ->with('success',$this->title.' berhasil terupdate');
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
