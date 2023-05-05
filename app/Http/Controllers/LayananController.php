<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LayananTarif;
use App\Models\Layanan;
use App\Models\GroupLayanan;
use App\Models\JasaDokter;
use App\Models\KodeRekening;
use DB;
use App\Models\ServiceUnit;
use DataTables;
use Illuminate\Support\Facades\Gate;

class LayananController extends Controller
{
    private $group;
    private $jasadokter;
    private $rekening;
    public function __construct()
    {
        $this->jasadokter = JasaDokter::pluck('nama_jasa_dokter','id');
        $this->group = GroupLayanan::pluck('group_layanan','id');
        $this->rekening = KodeRekening::select(DB::raw("CONCAT(nama_rekening,'-',kode_rekening) as nama"),'id')->get()->pluck('nama','id');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        if ($request->ajax()) {
            $data = Layanan::leftJoin('jasa_dokters','layanans.jasa_dokter_id','=','jasa_dokters.id')
            ->join('group_layanans','layanans.group_layanan_id','=','group_layanans.id')
            ->join('kode_rekenings','layanans.kode_rekening_id','=','kode_rekenings.id')
            ->join('layanan_tarifs','layanans.id','=','layanan_tarifs.layanan_id')
            ->leftJoin(DB::RAW('layanan_tarifs as layanan_tarif_online'), function($join) {
                $join->on('layanans.id', '=', 'layanan_tarif_online.layanan_id'); 
                $join->where('layanan_tarif_online.kelas_id',2);
            })
            ->select(DB::raw("CONCAT(kode_rekening,'-',nama_rekening) as nama_rekening"),'layanan_tarifs.tarif','layanan_tarifs.diskon',DB::RAW('layanan_tarif_online.tarif as tarif_online'),DB::RAW('layanan_tarif_online.diskon as diskon_online'),'layanans.id','kode_layanan','nama_layanan','group_layanan','layanans.data_status','jasa_dokters.nama_jasa_dokter','jasa_dokters.prosentase_jasa_dokter','jasa_dokters.prosentase_rumah_sakit')
            ->where(['layanan_tarifs.kelas_id'=>1])
            ->orderBy('layanans.id','DESC');
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
                           $btn .= '<a class="dropdown-item" href="'.route(config('global.layanan')['url'].'.edit',$row->id).'">Edit</a>';
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
        return view(config('global.layanan')['dir'].".index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($data=null,$data_tarif=null)
    {
        $group = $this->group;
        $jasadokter = $this->jasadokter;
        $rekening = $this->rekening;
        $data_tarif_online = null;
       
        $merger = Layanan::pluck('nama_layanan','id');
        return view(config('global.layanan')['dir'].'.form',compact('data','group','rekening','data_tarif','data_tarif_online','jasadokter','merger'));
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
            'nama_layanan' => 'required|max:100|min:10',
            'kode_layanan' => 'required|max:5|min:5',
            'group_layanan_id' => 'required',
            'kode_rekening_id' => 'required'
        ],[
            'nama_layanan.required' => config('title.layanan_title')['name'].' wajib diisi',
            'nama_layanan.min' => config('title.layanan_title')['name'].' minimal 10 kharakter',
            'nama_layanan.max' => config('title.layanan_title')['name'].' maksimal 100 kharakter',
            'kode_layanan.required' => config('title.layanan_title')['kode'].' wajib diisi',
            'kode_layanan.min' => config('title.layanan_title')['kode'].' minimal 5 kharakter',
            'kode_layanan.max' => config('title.layanan_title')['kode'].' maksimal 5 kharakter',
            'group_layanan_id.required' => config('title.layanan_title')['group'].' wajib dipilih',
            'kode_rekening_id.required' => config('title.layanan_title')['rekening'].' wajib dipilih',
        ]);
        $request['data_status'] = (!empty($request['data_status'])?true:false); 
        $layanan = Layanan::create($request->all());
        $layanan_tarif_onsite = LayananTarif::where(['layanan_id'=>$layanan->id,'kelas_id'=>1])->get()->first();
        $layanan_tarif_online = LayananTarif::where(['layanan_id'=>$layanan->id,'kelas_id'=>2])->get()->first();
        if(is_null($layanan_tarif_onsite)):
            LayananTarif::create([
                'layanan_id'=>$layanan->id,
                'tarif'=>$request['tarif'],
                'kelas_id'=>1,
                'diskon'=>$request['diskon']]);
            else:
                $layanan_tarif->update([
                    'layanan_id'=>$layanan->id,
                    'tarif'=>$request['tarif'],
                    'kelas_id'=>1,
                    'diskon'=>$request['diskon']]);
                endif;
            if(is_null($layanan_tarif_online)):
                    LayananTarif::create([
                        'layanan_id'=>$layanan->id,
                        'tarif'=>$request['tarif_online'],
                        'kelas_id'=>2,
                        'diskon'=>$request['diskon_online']]);
                    else:
                        $layanan_tarif->update([
                            'layanan_id'=>$layanan->id,
                            'tarif'=>$request['tarif_online'],
                            'kelas_id'=>2,
                            'diskon'=>$request['diskon_online']]);
                        endif;
        return redirect()->route(config('global.layanan')['url'].'.index')
                        ->with('success',config('title.layanan').' berhasil tersimpan');
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
    public function edit(Layanan $layanan)
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
    public function update(Request $request,Layanan $layanan)
    {
        request()->validate([
            'nama_layanan' => 'required|max:100|min:10',
            'kode_layanan' => 'required|max:5|min:5',
            'group_layanan_id' => 'required',
            'kode_rekening_id' => 'required'
        ],[
            'nama_layanan.required' => config('title.layanan_title')['name'].' wajib diisi',
            'nama_layanan.min' => config('title.layanan_title')['name'].' minimal 10 kharakter',
            'nama_layanan.max' => config('title.layanan_title')['name'].' maksimal 100 kharakter',
            'kode_layanan.required' => config('title.layanan_title')['kode'].' wajib diisi',
            'kode_layanan.min' => config('title.layanan_title')['kode'].' minimal 5 kharakter',
            'kode_layanan.max' => config('title.layanan_title')['kode'].' maksimal 5 kharakter',
            'group_layanan_id.required' => config('title.layanan_title')['group'].' wajib dipilih',
            'kode_rekening_id.required' => config('title.layanan_title')['rekening'].' wajib dipilih',
        ]);
        $request['data_status'] = (!empty($request['data_status'])?true:false); 
        $layanan->update($request->all());
        $layanan_tarif_onsite = LayananTarif::where(['layanan_id'=>$layanan->id,'kelas_id'=>1])->get()->first();
        $layanan_tarif_online = LayananTarif::where(['layanan_id'=>$layanan->id,'kelas_id'=>2])->get()->first();
        if(is_null($layanan_tarif_onsite)):
            LayananTarif::create([
                'layanan_id'=>$layanan->id,
                'tarif'=>$request['tarif'],
                'kelas_id'=>1,
                'diskon'=>$request['diskon']]);
            else:
                $layanan_tarif_onsite->update([
                    'layanan_id'=>$layanan->id,
                    'tarif'=>$request['tarif'],
                    'kelas_id'=>1,
                    'diskon'=>$request['diskon']]);
                endif;
            if(is_null($layanan_tarif_online)):
                    LayananTarif::create([
                        'layanan_id'=>$layanan->id,
                        'tarif'=>$request['tarif_online'],
                        'kelas_id'=>2,
                        'diskon'=>$request['diskon_online']]);
                    else:
                        $layanan_tarif_online->update([
                            'layanan_id'=>$layanan->id,
                            'tarif'=>$request['tarif_online'],
                            'kelas_id'=>2,
                            'diskon'=>$request['diskon_online']]);
                        endif;
        return redirect()->route(config('global.layanan')['url'].'.index')
                        ->with('success',config('title.layanan').' berhasil tersimpan');
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
    public function getTarifLayanan($id,$qty)
    {
        return LayananTarif::select('tarif',DB::RAW("tarif * $qty as sub_total"))->where('layanan_id',$id)->first();
    }
}
