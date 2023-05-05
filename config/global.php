<?php
return [
    'title_app'=>'SIKUAT',
    'title_address'=>'embuh',
    'button'=>['save'=>'Simpan','cancel'=>'Batal'],
    'medicalrecord_url'=>'medicalrecords',
    'grouplayanan'=>['url'=>'grouplayanans','dir'=>'group_layanan','permission'=>'group-layanan'],
    'grouplayanan_field'=>['group'=>'group_layanan','unit'=>'service_unit_id','status'=>'data_status'],
    'layanan'=>['url'=>'layanans','dir'=>'layanan','permission'=>'layanan'],
    'layanan_field'=>['name'=>'nama_layanan','group'=>'group_layanan_id','kode'=>'kode_layanan','rekening'=>'kode_rekening_id','jasa'=>'jasa_dokter_id','status'=>'data_status'],
    'layanan_tarif_field'=>['tarif'=>'tarif','diskon'=>'diskon','status'=>'data_status','layanan_id'=>'layanan_id'],
    'ruang'=>['url'=>'rooms','dir'=>'ruang','permission'=>'ruang'],
    'ruang_field'=>['name'=>'nama_ruang','service_unit'=>'service_unit_id','kode'=>'kode_ruang','status'=>'data_status'],
    'jasa'=>['url'=>'doctorfees','dir'=>'doctorfees','permission'=>'jasa-dokter'],
    'jasa_field'=>['name'=>'nama_jasa_dokter','prosen_dokter'=>'prosentase_jasa_dokter','prosen_rumah_sakit'=>'prosentase_rumah_sakit','status'=>'data_status'],
    'appointment'=>['url'=>'appointments','dir'=>'appointments','permission'=>'appointment'],
    'appointment_field'=>[
        'title'=>'title',
        'fullname'=>'fullname',
        'dob'=>'date_of_birth',
        'tgl'=>'appointment_at',
        'gender'=>'gender',
        'phone_number'=>'phone_number',
        'dokter_id'=>'dokter_id',
        'service_unit_id'=>'service_unit_id',
        'no_antrian'=>'no_antrian',
        'keterangan'=>'keterangan',
        'status'=>'data_status'],
    'koderekening'=>['url'=>'koderekenings','dir'=>'coa','permission'=>'coa'],
];