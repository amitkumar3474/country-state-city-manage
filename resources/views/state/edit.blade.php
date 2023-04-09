@extends('layouts.admin')
@section('section_data')
    <div class="section">
        <div class="banner">
            <div class="country">
                <form action="{{ route('state.update', $state->id) }}" method="post">
                @method('PUT')
                @csrf
                    <table border cellspacing=0>
                    <tr>
                            <th><label for="">Country Id</label></th>
                            <td>
                            <select name="country_id" id="country_id">
                                    <option value="">--Select Country--</option>
                                    @foreach($countries as $_country)
                                        <option value="{{ ($_country->id)}}" {{($state->country_id == $_country->id)?'selected':''}}>{{ $_country->name }}</option>
                                    @endforeach    
                                </select> 
                            </td>
                        </tr>
                        <tr>
                            <th><label for="">State Name*</label></th>
                            <td><input type="text" name = "name" placeholder = "state-name" value="{{ $state->name}}"></td>
                        </tr>
                        
                        <tr>
                            <th><label for="">State Status*</label></th>
                            <td>
                                <select name="status" id="">
                                    <option value="1" {{ $state->status === "1"?'selected':''}}>Enable</option>
                                    <option value="2" {{ $state->status === "2"?'selected':''}}>Disable</option>
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
                                    @foreach($cities as $_city)
                                    <tr id="add-tr">
                                        <input type="hidden" name="city_id[]" value="{{ $_city->id }}">
                                        <td><input type="text" id="state-name" name="city_name[]" value="{{ $_city->name }}"></td>
                                        <td>
                                            <select id="" name="city_status[]">
                                                <option value="1" {{ $_city->status === "1"?'selected':''}}>Enable</option>
                                                <option value="2" {{ $_city->status === "2"?'selected':''}}>Disable</option>
                                            </select>
                                        </td>
                                        <td><button type="button" id="" class='remove'>Remove</button></td>
                                    </tr>
                                    @endforeach
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
                    <input type="hidden" name="city_id[]" value="">
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