@extends('layouts.master')
@section('title', 'Edit User')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#clean_permissions").click(function(){
    $('#permissions').val([]);
    return false;
  });
  $("#clean_roles").click(function(){
    $('#roles').val([]);
    return false;
  });
});
</script>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit User Profile</h4>
                </div>
                <div class="card-body">
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="bi bi-exclamation-triangle-fill me-2"></i>Error!</strong> {{$error}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endforeach

                    <form action="{{route('users_save', $user->id)}}" method="post">
                        {{ csrf_field() }}
                        
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Name:</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control" placeholder="Enter user's name" name="name" required value="{{$user->name}}">
                            </div>
                        </div>
                        
                        @can('admin_users')
                        <hr class="my-4">
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="roles" class="form-label fw-bold">Roles:</label>
                                <a href='#' id='clean_roles' class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Clear selection
                                </a>
                            </div>
                            <select multiple class="form-select" id='roles' name="roles[]" size="5">
                                @foreach($roles as $role)
                                <option value='{{$role->name}}' {{$role->taken?'selected':''}}>
                                    {{$role->name}}
                                </option>
                                @endforeach
                            </select>
                            <div class="form-text text-muted">Hold Ctrl (or Cmd on Mac) to select multiple roles</div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="permissions" class="form-label fw-bold">Direct Permissions:</label>
                                <a href='#' id='clean_permissions' class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Clear selection
                                </a>
                            </div>
                            <select multiple class="form-select" id='permissions' name="permissions[]" size="8">
                            @foreach($permissions as $permission)
                                <option value='{{$permission->name}}' {{$permission->taken?'selected':''}}>
                                    {{$permission->display_name}}
                                </option>
                                @endforeach
                            </select>
                            <div class="form-text text-muted">These permissions will be added in addition to role permissions</div>
                        </div>
                        @endcan

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
