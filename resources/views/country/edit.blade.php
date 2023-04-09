@extends('layouts.admin')
@section('section_data')
    <div class="section">
        <div class="banner">
            <div class="country">
                <form action="{{ route('country.update', $country->id) }}" method="post">
                @method('PUT')
                @csrf
                    <table border cellspacing=0>
                        <tr>
                            <th><label for="">Country Name*</label></th>
                            <td><input type="text" name = "name" placeholder = "country-name" value="{{ $country->name}}"></td>
                        </tr>
                        
                        <tr>
                            <th><label for="">Country Status*</label></th>
                            <td>
                                <select name="status" id="">
                                    <option value="1" {{ $country->status === "1"?'selected':''}}>Enable</option>
                                    <option value="2" {{ $country->status === "2"?'selected':''}}>Disable</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th>Add state</th>
                            <td>
                                <table id="inner-table">
                                    <tr>
                                        <th><label for="state_name">State Name</label></th>
                                        <th><label for="">State_status</label></th>
                                        <th><button type="button" id="add1" class='addmore'>Add</button></th>
                                    </tr>
                                    @foreach($country['state'] as $_state)
                                    <tr id="add-tr">
                                        <input type="hidden" name="state_id[]" value="{{ $_state->id }}">
                                        <td><input type="text" id="state-name" name="state_name[]" value="{{ $_state->name}}"></td>
                                        <td>
                                            <select id="" name="state_status[]">
                                                <option value="1" {{ $_state->status == "1"?'selected':'' }}>Enable</option>
                                                <option value="2" {{ $_state->status == "2"?'selected':'' }}>Disable</option>
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
                    <input type="hidden" name="state_id[]" value=""> 
                     <td>
                        <input type="text" id="state-nameR${++rowindex}" name="state_name[]"></td>
                     <td>
                        <select  name="state_status[]">
                            <option value="1">Enable</option>
                            <option value="2">Disable</option>
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