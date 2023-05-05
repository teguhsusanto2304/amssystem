<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\KodeRekening;
use DB;
use DataTables;
use Illuminate\Support\Facades\Gate;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        if ($request->ajax()) {
            $data = Jurnal::select(
                'id',
                'reg_no',
                DB::raw("DATE_FORMAT(created_at,'%d-%M-%Y %H:%i:%s') as created_time"),
                DB::raw("DATE_FORMAT(created_at,'%M') as created_month"),
                DB::raw("DATE_FORMAT(created_at,'%Y') as created_year"),
                'source_nama_rekening',
                'dest_nama_rekening',
                'description',
                'remark1',
                'remark2',
                'remark3',
                'position',
                'debit',
                'kredit',
                'balance',
                'data_status')->orderBy('id','ASC');
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
                           $btn .= '<a class="dropdown-item" href="'.route('jeniskunjungans.edit',$row->id).'">Edit</a>';
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
        
        return view('jurnal.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = null;
        $coa = KodeRekening::select(DB::RAW("CONCAT(REPEAT('&nbsp;&nbsp;',LENGTH(REPLACE(kode_rekening,'0',''))),CONCAT(kode_rekening,' ',nama_rekening)) as rek"),DB::RAW('nama_rekening as id'))->pluck('rek','id');
        $jenis = array('Debit','Kredit');
        return view('jurnal.form',compact('data','coa','jenis'));
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
            'source_kode_rekening_id' => 'required',
            'dest_kode_rekening_id' => 'required',
            'position' => 'required',
            'jenis' => 'required',
            'jumlah' => 'required|max:15',
            'deskripsi' => 'required|max:100',
        ],[
            'source_kode_rekening_id.required' => 'Rekening Asal wajib diisi',
            'dest_kode_rekening_id.required' => 'Rekening Tujuan wajib diisi',
            'position.required' => 'Position wajib diisi',
            'jenis.required' => 'Jenis wajib diisi',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.max' => 'Nilai Jumlah uang maximal 15 digit',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'deskripsi.max' => 'Deskripsi maximal 100 karakter',
        ]);
        $request['data_status'] = (!empty($request['data_status'])?true:false); 
        $count = Jurnal::where(DB::RAW("DATE_FORMAT(created_at,'%Y%m%d')"),date('Ymd'))->get();
        $source = KodeRekening::where('id',$request['source_kode_rekening_id'])->first();
        $dest = KodeRekening::where('id',$request['dest_kode_rekening_id'])->first();
        $debit=0;
        $kredit=0;
        $balance=0;
        if($request['jenis']=='Debit'){
            $debit=$request['jumlah'];
        } else {
            $kredit = $request['jumlah'];
        }
        $data = [ 
            'reg_no'=>'R'.date('Ymd').str_pad((count($count)+1),3,"0",STR_PAD_LEFT),
            'source_kode_rekening_id'=>$request['source_kode_rekening_id'],
            'source_nama_rekening'=>$source['nama_rekening'],
            'dest_kode_rekening_id'=>$request['dest_kode_rekening_id'],
            'dest_nama_rekening'=>$dest['nama_rekening'],
            'description'=>$request['deskripsi'],
            'position'=>($request['position']==0?'BS':'IS'),
            'debit'=>$debit,
            'kredit'=>$kredit,
            'balance'=>$balance,
            'created_by'=>1
            
        ]; 
        Jurnal::create($data);
        return redirect()->route('jurnals.index')
                        ->with('success','Jenis Kunjungan berhasil tersimpan');
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
