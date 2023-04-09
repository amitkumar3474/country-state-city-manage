@extends('layouts.admin')
@section('section_data')
    <div class="section">
        <div class="banner">
            <div class="country">
                <form action="{{ route('city.store') }}" method="post">
                    @csrf
                    <table  cellspacing=0>
                        <tr>
                            <th><label for="">Country Id*</label></th>
                            <td>
                                <select name="country_id" id="country_id">
                                    <option value="">--Select Country--</option>
                                    @foreach($countries as $_country)
                                        <option value="{{ $_country->id }}" {{($_country->id==old('country_id'))?'selected':''}}>{{ $_country->name }}</option>
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
                            <th><label for="">State Id*</label></th>
                            <td>
                                <select name="state_id" id="state_id">
                                    <option value="">--State Name--</option>
                                </select>
                                <span class="text-danger">
                                    @error('state_id')
                                        {{$message}};
                                    @enderror
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th><label for="">City Name</label></th>
                            <td><input type="text" name = "name" placeholder = "city name" value="">
                                <span class="text-danger">
                                    @error('name')
                                        {{$message}};
                                    @enderror
                                </span>
                            </td>
                        </tr>
                        
                        <tr>
                            <th><label for="">City Status*</label></th>
                            <td>
                                <select name="status" id="">
                                    <option value="1">Enable</option>
                                    <option value="2">Disable</option>
                                </select>
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
            $('#country_id').change(function(){
                var countryId = $(this).val();
                $.ajax({
                    'url': '{{route('getstate')}}',
                    'method': 'post',
                    'data': {'country_id': countryId, '_token': '{{csrf_token()}}'},
                    success:function(response){
                        $('#state_id').html(response);
                    }
                });
            });
        });
    </script>

@endsection