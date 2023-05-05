<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    function getTransactionNumber()
    {
        $last = Transaksi::where(\DB::raw("DATE_FORMAT(transaksi_at,'%Y%m%d')"),date('Ymd'))->get();
        $newNum=0;
        $maxDigit=4; //maximum digit of ur number
        $currentNumber=$last->count()+1;  //example this is your last number in database all we need to do is remove the zero before the number . i dont know how to remove it
        $count=strlen($currentNumber); //count the digit of number. example we already removed the zero before the number. the answer here is 2
        $numZero="";
        for($count;$count<=$maxDigit;$count++)
            $numZero=$numZero."0";
        $newNum="TR".date('Ymd')."$numZero$currentNumber";
        return $newNum;
    }
}
