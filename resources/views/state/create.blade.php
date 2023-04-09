@extends('layouts.admin')
@section('section_data')
<div class="section">
        <div class="banner">
            <div class="country">
                <form action="{{ route('state.store') }}" method="post">
                    @csrf
                    <table border cellspacing=0>
                        <tr>
                            <th><label for="">Country Id</label></th>
                            <td>
                                <select name="country_id" id="">
                                    <option value="">--Select Country--</option>
                                    @foreach($countries as $_country)
                                        <option value="{{ $_country->id }}">{{ $_country->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    @error('country_id')
                                        {{$message}};
                                    @enderror
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="">State Name*</label></th>
                            <td><input type="text" name = "name" placeholder = "state name" value="">
                                <span class="text-danger">
                                    @error('name')
                                        {{$message}};
                                    @enderror
                                </span>
                            </td>
                        </tr>
                        
                        <tr>
                            <th><label for="">State Status*</label></th>
                            <td>
                                <select name="status" id="">
                                    <option value="1">Enable</option>
                                    <option value="2">Disable</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th>Add city</th>
                            <td>
                                <table id="inner-table">
                                    <tr>
                                        <th><label for="state-name">City Name</label></th>
                                        <th><label for="">Status</label></th>
                                        <th><button type="button" id="add1" class='addmore'>Add</button></th>
                                    </tr>
                                    
                                    <tr id="add-tr">
                                        <td><input type="text" id="state-name" name="city_name[]" value=""></td>
                                        <td>
                                            <select id="" name="city_status[]">
                                                <option value="1">Enable</option>
                                                <option value="2">Disable</option>
                                            </select>
                                        </td>
                                        <td><button type="button" id="" class='remove'>Remove</button></td>
                                    </tr>

                                </table>
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

    <script>
            $(document).ready(function(){
                var rowindex = 2;
                $('#add1').on('click', function(){
                    $('#inner-table').append(`<tr id="R${++rowindex}"> 
                     <td><input type="text" id="state-nameR${++rowindex}" name="city_name[]"></td>
                     <td>
                        <select id="" name="city_status[]">
                            <option value="1">Enable</option>
                            <option value="2">Desable</option>
                        </select>
                    </td>
                    <td>
                    <button type="button" class="remove">Remove</button>
                    </td>
                     </tr>`);
                });
                $('#inner-table').on('click', '.remove', function(){
                    $(this).closest('tr').remove();
                    rowindex--;
                });
            });
        </script>
@endsection