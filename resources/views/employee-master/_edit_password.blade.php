<h5 class="card-title">
    Password Details 
    <a class="pass_type_add_btn">
        <i class="material-icons">add_circle_outline</i>
    </a>
</h5>
<div id="password_type">
    <?php foreach ($password_details as $key => $value) { ?>
        <div class="row">
            <div class="pass_type" style=" border: 0px solid red;">
                <div class="col">
                    <span class="material-icons rmv" data-id="{{ $value->id }}" data-name="password_details" style="margin-top: 13px;">delete</span>
                </div>
                <div class="col s3">
                    <label>Password Type *</label>
                    <select name="pass_type[]" id="pass_type" class="select"><option value="" disable>Password Type</option>
                        @foreach($PtypeDetails as $Pdetails)<option value="{{$Pdetails->id}}" {{$Pdetails->id == $value->pass_type ? 'selected' : ''}} >{{$Pdetails->name}}</option>@endforeach
                    </select>
                </div>
                <div class="col s4">
                    <label>Password *</label>
                    <input type="text" name="pass_name[]" id="pass_name" placeholder="Enter Password*" value="{{$value->password}}" required="" />
                </div>
                <div class="col s4">
                    <label>Note</label>
                    <input type="text" name="pass_note[]" id="pass_note" class="input-field" placeholder="Note" autofocus="off" autocomplete="off" value="{{$value->pass_note}}" />
                </div>
                <br>
            </div>
        </div>
    <?php } ?>
</div>    
