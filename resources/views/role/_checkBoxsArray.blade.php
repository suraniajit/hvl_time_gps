 <div class="col-sm-12 col-md-6">
            <div class="i-checks">
                <input type="checkbox" id="{{ $premission->name }}" name="permissions[]" value="{{ $premission->name }}"
                       @if(isset($role)) @if($role->hasPermissionTo($premission->name)) checked @endif @endif
                onclick="if(document.getElementById('Access {{ $name[1] }}').checked === false){
                document.getElementById('Access {{ $name[1] }}').checked = this.checked
                }" >
                <label for="checkboxCustom1">{{ ucfirst($premission->name) }}</label>

        </div>
        <br>
    </div>
