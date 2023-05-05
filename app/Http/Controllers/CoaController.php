<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\coa;
use DB;
use DataTables;
use Illuminate\Support\Facades\Gate;

class CoaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = coa::leftJoin('coas as induk','coas.parent','=','induk.id')
            ->select(DB::RAW('induk.nama_rekening as nama_induk'),DB::RAW('coas.id as coa_id'),DB::RAW("CONCAT(REPEAT(' ',LENGTH(REPLACE(coas.kode_rekening,'0',''))),coas.nama_rekening) as account_name"),'coas.nama_rekening','coas.kode_rekening','coas.data_status')
            ->orderBy('coas.id','ASC');
            return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function($row){
                   $btn = '<div class="row"><a href="javascript:void(0)" id="'.$row->id.'" class="btn btn-primary btn-sm ml-2 btn-edit">Edit</a>';
                   $btn .= '<a href="javascript:void(0)" id="'.$row->id.'" class="btn btn-danger btn-sm ml-2 btn-delete">Delete</a></div>';
                   $btn = '<div class="btn-group" role="group">
                   <button id="btnGroupVerticalDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       Menu <i class="mdi mdi-chevron-down"></i>
                   </button>';
                   $btn .= '<div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">';
                   if (! Gate::allows(config('global.layanan_permission').'-edit',$row)) {
                   $btn .= '<a class="dropdown-item" href="'.route(config('global.koderekening')['url'].'.edit',$row->id).'">Edit</a>';
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
         ->addColumn('rekening', function($row){
            $arrCode = str_split($row->kode_rekening);   
           
             return $arrCode[0].''.(empty($arrCode[1])?null:'.'.$arrCode[1]).''.(empty($arrCode[2])?null:'.'.$arrCode[2]).''.(empty($arrCode[3])?null:'.'.$arrCode[3]).''.(empty($arrCode[4])?null:'.'.$arrCode[4]).''.(empty($arrCode[5])?null:'.'.$arrCode[5]);
     })
            ->rawColumns(['action','data_status','rekening'])
            ->make(true);
                    
        }
        return view(config('global.koderekening')['dir'].".index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(coa $coas)
    {
        $data = $layanan;
        $data_tarif = LayananTarif::where(['layanan_id'=>$layanan->id,'data_status'=>1,'kelas_id'=>1])->get()->first();
        $data_tarif_online = LayananTarif::where(['layanan_id'=>$layanan->id,'data_status'=>1,'kelas_id'=>2])->get()->first();
        $group = $this->group;
        $rekening = $this->rekening;
        $jasadokter = $this->jasadokter;
        $merger = Layanan::pluck('nama_layanan','id');
        return view(config('global.layanan')['dir'].'.form',compact('data','group','rekening','data_tarif','jasadokter','data_tarif_online','merger'));
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
