@extends('layouts.backend.app')
@section('title', 'Jurnal')
@section('subtitle', 'Halaman Jurnal')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Jurnal</h4>
                <div class="row">
                    <section id="MsnContainer">    
                        <section class="text-center">    
                            <label class="font-weight-bold text-danger" id="Msn"></label>    
                        </section>    
                    </section>    
                    <div class="col-lg-8">
                        <div class="mt-4">
                            <div class="mb-3">
                                <label class="form-label" for="formrow-firstname-input">Account</label>
                                {!! Form::select('source_kode_rekening_id',$coa,(!is_null($data)?$data->kode_rekening_id:null), array('placeholder' => 'Pilih Kode Rekening','class' => 'form-control','id'=>'Account')) !!}
                            </div>
                            <div class="col-md-4">
                                        <h5 class="font-size-14 mb-4">Type Jurnal</h5>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="TypeJurnal"
                                                id="TypeJurnal" checked value="D">
                                            <label class="form-check-label" for="TypeJurnal">
                                                Debit
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="TypeJurnal"
                                                id="TypeJurnal" value="K">
                                            <label class="form-check-label" for="TypeJurnal">
                                                Kredit
                                            </label>
                                        </div>
                                    </div>
                            </div>
                            <br>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-password-input">Jumlah Rp.</label>
                                        {!! Form::number('Amount', (!is_null($data)?$data->jumlah:null), array('placeholder' => 'Jumlah','class' => 'form-control','id'=>'Amount')) !!}
                                    </div>
                                </div> <!-- end col -->
                                <div class="mt-4">
                                    <button type="button" class="btn btn-primary w-md" id="AddTempJurnal">Submit</button>
                                    <a href="{{ route('jurnals.index') }}" type="reset" class="btn btn-danger w-md">
                                        Cancel
                                    </a>
                                </div>
                                <br>
                                <div id="table-container">    
                                    <table class="table table-bordered table-striped" id="table-information">    
                                        <thead>    
                                            <tr class="bg-info text-light font-weight-bold text-center">    
                                                <td>Account</td>    
                                                <td>Debit</td>    
                                                <td>Kredit</td>    
                                                <td>Actions</td>    
                                            </tr>
                                            <tr class="bg-primary text-light font-weight-bold text-end">    
                                                <td>&nbsp;</td>    
                                                <td id="totDebit">0</td>    
                                                <td id="totKredit">0</td>    
                                                <td>&nbsp;</td>      
                                            </tr>    
                                        </thead>    
                                        <tbody id="table-body"></tbody>    
                                    </table>    
                                    
                                </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Form Layout -->
{!! Form::close() !!}
<script src="{{ asset('template/backend') }}/libs/jquery/jquery.min.js"></script>
<script>
    var TotKredit = 0;
    var TotDebit = 0;
    $(document).ready(function () {  

        $('#AddTempJurnal').click(function () { AddTempJurnal(); });  
    });  
function AddTempJurnal() {
    var Jurnal = {};  
      Jurnal.Account = $('#Account').val();  
      Jurnal.Amount = $('#Amount').val(); 
      if($('#TypeJurnal:checked').val()=="D"){
      Jurnal.Debit = $('#Amount').val();  
      TotDebit = TotDebit + Number(Jurnal.Debit);
      Jurnal.Kredit = 0;  
      }
      if($('#TypeJurnal:checked').val()=="K"){
        Jurnal.Kredit = $('#Amount').val();  
        TotKredit = TotKredit + Number(Jurnal.Kredit);
        Jurnal.Debit = 0; 
      }
      var Errors = "";
      if (Jurnal.Account.trim().length == 0) {  
          Errors += "Account is required.<br>";  
          $('#Account').addClass("border-danger");  
      } else {  
          $('#Account').removeClass("border-danger");  
      } 
      if (Jurnal.Amount.trim().length == 0) {  
          Errors += "Ammount is required.<br>";  
          $('#Ammount').addClass("border-danger");  
      } else {  
          $('#Ammount').removeClass("border-danger");  
      }  
      if (Errors.length > 0) {//if errors detected then notify user and cancel transaction  
          ShowMsn(Errors);  
          return false; //exit function  
      }  
      var ExistTitle = false; // < -- Main indicator  
      $('#table-information > tbody  > tr').each(function () {  
          var Account = $(this).find('.AccountCol').text(); // get text of current row by class selector  
          if (Jurnal.Account.toLowerCase() == Account.toLowerCase()) { //Compare provided and existing title  
              ExistTitle = true;  
              return false; 
          }  
      });  
    
      //Add movie if title is not duplicated otherwise show error  
      if (ExistTitle === false) {  
          ClearMsn();  
          //Create Row element with provided data  
          var Row = $('<tr class="text-end">');  
          $('<td>').html(Jurnal.Account).addClass("AccountCol").appendTo(Row);  
          $('<td>').html(new Intl.NumberFormat('en-ID').format(Jurnal.Debit)).appendTo(Row);  
          $('<td>').html(new Intl.NumberFormat('en-ID').format(Jurnal.Kredit)).appendTo(Row);  
          $('<td>').html("<div class='text-center'><button class='btn btn-danger btn-sm' onclick='Delete($(this))'>Remove</button></div>").appendTo(Row);  
    
          //Append row to table's body  
          $('#table-body').append(Row); 
          $('#totDebit').html(new Intl.NumberFormat('en-ID').format(TotDebit));
          $('#totKredit').html(new Intl.NumberFormat('en-ID').format(TotKredit)); 
          CheckSubmitBtn(); // Enable submit button  
          ClearForm();
      }  
      else {  
          ShowMsn("Account can not be duplicated.");  
      }  
    
}
    // clear all textboxes inside form  
function ClearForm() {  
    $('#form-container input[type="text"]').val(''); 
    $('#kode_rekening_id').val('');   
}  
  
//Msn label for notifications  
function ShowMsn(message) {  
    $('#Msn').html(message);  
}  
//Clear text of Msn label  
function ClearMsn() {  
    $('#Msn').html("");  
}  
  
//Delete selected row  
function Delete(row) { // remove row from table 
    var DelAmount = row.closest('tr')[0];
    var cells = DelAmount.cells;
    var DelDebit = cells[1].textContent;
    var DelKredit = cells[2].textContent;
    if(TotKredit>0){
        //TotKredit = Number(TotKredit) -  Number(DelKredit);
        TotKredit = Number(TotKredit) - Number(DelKredit.replace(/,/g, ""));
    }
    if(TotDebit>0){
        TotDebit = Number(TotDebit) -  Number(DelDebit.replace(/,/g, ""));
    }
    $('#totDebit').html(new Intl.NumberFormat('en-ID').format(TotDebit));
    $('#totKredit').html(new Intl.NumberFormat('en-ID').format(TotKredit)); 
    row.closest('tr').remove();  
    CheckSubmitBtn();  
}  
//Enable or disabled submit button  
function CheckSubmitBtn() {  
    if ($('#table-information > tbody  > tr').length > 0) { // count items in table if at least 1 item is found then enable button  
        $('#SubmitMoviesBtn').removeAttr("disabled");  
    } else {  
        $('#SubmitMoviesBtn').attr("disabled", "disabled");  
    }  
} 
    </script>
@endsection
