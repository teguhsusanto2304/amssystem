@extends('layouts.backend.app')
@section('title', 'Pembayaran')
@section('subtitle', 'Halaman Pembayaran Tagihan Pasien')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <div class="invoice-title">
                            <h4 class="float-end font-size-16"><strong>No Kwitansi # KW2022010500001</strong></h4>
                            
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <address>
                                        <strong>Dibayarkan Oleh:</strong><br>
                                        {{ $request['pembayar'] }}<br>
                                        
                                    </address>
                            </div>
                            <div class="col-6 text-end">
                                <address>
                                        <strong>Kunjungan Pasien :</strong><br>
                                        <strong># {{ $dtkunjungan->no_registrasi }}</strong><br>
                                        No Rekam Medis : {{ $dtpasien->medical_record_no }}<br>
                                        {{ $dtpasien->fullname }}<br>
                                        {{ $dtpasien->alamat }}
                                        <strong>{{ $dtkunjungan->dokter }}</strong><br>
                                        {{ $dtkunjungan->service_unit }}<br>
                                    </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mt-4">
                                <address>
                                        <strong>Metode Pembayaran:</strong><br>
                                        @php
                                        $metode = ['Tunai','Transfer Bank','Virtual Account','Kartu Kredit'];
                                        @endphp
                                        {{  $metode[$request['metode']] }}<br>
                                    </address>
                            </div>
                            <div class="col-6 mt-4 text-end">
                                <address>
                                        <strong>Tanggal Kwitansi:</strong><br>
                                        {{ date('d M Y H:n:s') }}<br><br>
                                    </address>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div>
                            <div class="p-2">
                                <h3 class="font-size-16"><strong>Detail Tagihan</strong></h3>
                            </div>
                            <div class="">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td><strong>Unit</strong></td>
                                                <td class="text-end"><strong>Totals</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $gtotal=0; @endphp
                                            <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                            @foreach($transaksi as $row)
                                            <tr>
                                                <td>{{ $row['service_unit'] }}</td>
                                                <td class="text-end">Rp. {{ $row['total'] }}</td>
                                                @php $gtotal=$gtotal+$row['total']; @endphp
                                            </tr>
                                            @endforeach
                                            
                                            <tr>
                                                <td class="no-line"></td>
                                                    <strong>Total Rp.</strong></td>
                                                <td class="no-line text-end">
                                                    <h4 class="m-0">Rp. {{ $gtotal }}.00</h4></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-print-none">
                                    <div class="float-end">
                                        <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-2"><i class="fa fa-print"></i></a>
                                        <a href="#" class="btn btn-primary waves-effect waves-light">Send</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- end row -->

            </div>
        </div>
    </div>
    <!-- end col -->
</div>
<!-- end row -->
@endsection