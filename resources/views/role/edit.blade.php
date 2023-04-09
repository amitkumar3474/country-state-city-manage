<!-- @php
    echo "<pre>";
        print_r($permissions->toArray());
@endphp -->
@extends('layouts.admin')
@section('section_data')
    <div class="section">
        <div class="banner">
            <div class="country">
                <form action="{{ route('roles.update', $role->id) }}" method="post">
                    @method('PUT')
                    @csrf
                    <table  cellspacing=0>
                        <tr>
                            <th><label for="">Name</label></th>
                            <td>
                                <input type="text" name="name" value="{{ $role->name }}">
                                <span class="text-danger">
                                    @error('name')
                                        {{$message}};
                                    @enderror
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th><label for="">Permissions Name</label></th>
                            <td>
                                @foreach($permissions as $_permission)
                                    <div>
                                        <input type="checkbox" id="<?=$_permission->name?>" name="permissions[]" value="<?=$_permission->name?>" {{($role->hasPermissionTo($_permission->name))?'checked':''}}>
                                        <label for="<?= $_permission->name?>"><?= $_permission->name?></label>
                                    </div>
                                @endforeach
                                <span class="text-danger">
                                    @error('name')
                                        {{$message}};
                                    @enderror
                                </span>
                            </td>
                        </tr>    
                        <tr>
                            <th colspan="2">
                                <button id="submit1" name="submit" value ="submit">Submit</button>
                                <!-- <button id="submit1" name="save-new" value ="submit">Save & new</button> -->
                            </th>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection