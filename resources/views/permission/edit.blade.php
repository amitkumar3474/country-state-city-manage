
@extends('layouts.admin')
@section('section_data')
    <div class="section">
        <div class="banner">
            <div class="country">
                <form action="{{ route('permissions.update', $permission->id) }}" method="post">
                    @method('PUT')
                    @csrf
                    <table  cellspacing=0>
                        <tr>
                            <th><label for="">Name</label></th>
                            <td>
                                <input type="text" name="name" value="{{ $permission->name }}">
                                <span class="text-danger">
                                    @error('name')
                                        {{$message}};
                                    @enderror
                                </span>
                            </td>
                        </tr>

                        <!-- <tr>
                            <th><label for="">Guard Name</label></th>
                            <td>
                                <input type="text" name="guard_name" value="{{ $permission->guard_name }}">
                                <span class="text-danger">
                                    @error('guard_name')
                                        {{$message}};
                                    @enderror
                                </span>
                            </td>
                        </tr>     -->
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