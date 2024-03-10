<h5 class="card-title">
    Bank Details 
    <a class="bank_type_add_btn">
        <i class="material-icons">add_circle_outline</i>
    </a>
</h5>
<div class="row">
    <div id="upload_bank_type">
        <?php
        foreach ($bank_details as $key => $value) {
            ?>
            <div class="input-field col s4 m3 l3 bank_type" style=" border: 0px solid red">
                <input type="text"  value="{{$value->bank_name}}" name="bank_name[]" id="bank_name" class="input-field" placeholder="Bank Name" autocomplete="off" autofocus="off" />
                <select name="bank_type[]" class="select" required>
                    <option value="" disable>Account Type</option>
                    <option value="0" {{$value->bank_type == 0 ? 'selected' : ''}} >Saving</option>
                    <option value="1" {{$value->bank_type == 1 ? 'selected' : ''}} >Current</option>
                </select>
                <input type="number" value="{{$value->bank_account_number}}" name="bank_account_number[]" id="bank_account_number" class="input-field" placeholder="Account Number" autocomplete="off" autofocus="off" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"/>
                <input type="text" value="{{$value->bank_customer_name}}" name="bank_customer_name[]" id="bank_customer_name" class="input-field" placeholder="Account Holder Name" autocomplete="off" autofocus="off" />
                <input type="text" value="{{$value->IBAN}}" name="IBAN[]"  id="IBAN" class="input-field" placeholder="IBAN*" autocomplete="off" autofocus="off" minlength="23" maxlength="23" required=""/> 
                <input type="text" value="{{$value->bank_note}}" name="bank_note[]" id="bank_note" placeholder="Note" autofocus="off" autocomplete="off" />
                <center> 
                    <span class="material-icons remove_bank rmv" data-id="{{ $value->id }}" data-name="bank_details"  style="margin-top: 13px">delete</span>
                </center>
            </div>
        <?php } ?>
    </div>    
</div>