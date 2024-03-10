<?php

use App\User;
use App\Module;
use App\Permission;
use App\Role;

$user = auth()->user();

$user_role_name = App\Http\Controllers\UserProfileController::find_user_role($user['id']);
 ?>