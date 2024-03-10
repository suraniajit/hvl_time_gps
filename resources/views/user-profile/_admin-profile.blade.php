<div class="card-panel">

    @include('user-profile._header')
    <div class="row">

        <div class="col s4">
            <div class="input-field">
                <label for="uname" class="active">Name</label>
                <input type="text" id="uname" name="uname" value="{{ucfirst($user['name'])}}" data-error=".errorTxt1" readonly="">
                <small class="errorTxt1"></small>
            </div>
        </div>
        <div class="col s4">
            <div class="input-field">
                <label for="uname" class="active">Roles</label>
                <input type="text" id="uname" name="uname" value="{{ucfirst($users_roles_name[0]->user_role)}}" data-error=".errorTxt1" readonly="">
                <small class="errorTxt1"></small>
            </div>
        </div>

        <div class="col s4">
            <div class="input-field">
                <label for="email" class="active">E-mail</label>
                <input id="email" type="email" name="email" value="{{$user['email']}}" data-error=".errorTxt3" readonly="">
                <small class="errorTxt3"></small>
            </div>
        </div>
    </div>
   
    
</div>



