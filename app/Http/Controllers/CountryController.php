<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class CountryController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware(['permission:country_list|country_create|country_edit||country_delete']);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('country_list'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::paginate(5);
        return view('country.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('country_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('country.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('country_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'name'   => 'required',
            'status' => 'required', 
        ]);
        $countrydata = $request->all();
        $data = [
            'name'   => $countrydata['name'],
            'status' => $countrydata['status']
        ];
        $countryid = Country::create($data);
        
        if(isset($request['state_name'])){
            foreach($countrydata['state_name'] as $key => $_state){
                if($_state){
                    $_status = $countrydata['state_status'][$key];
                    $data1 = [
                        'country_id' => $countryid->id,
                        'name'       => $_state,
                        'status'     => $_status
                    ];
                    State::create($data1);
                }
            }
        }
        return redirect()->route('country.index')->with('success', "Country created successfully...");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('country_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $country = Country::where('id', $id)->with('state')->first();
        return view('country.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('country_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'name'   => 'required',
            'status' => 'required'
        ]);
        
        $updateData = $request->only('name', 'status');
        Country::where('id', $id)->update($updateData);

        if(isset($request['state_name'])){
            $state_id = array_filter($request['state_id']);
            State::whereNotIn('id', $state_id)->where('country_id', $id)->delete();
            City::whereNotIn('state_id', $state_id)->where('country_id', $id)->delete();

            foreach($request['state_name'] as $key=>$_state){
                $_status = $request['state_status'][$key];
                $_id = $request['state_id'][$key];

                if($_id){
                    $updateState = [
                        'name'       => $_state, 
                        'status'     => $_status
                    ];
                   State::where('id', $_id)->update($updateState);
                }elseif($_state){
                    $data1 = [
                        'country_id' => $id,
                        'name'       => $_state,
                        'status'     => $_status
                    ];
                    State::create($data1);
                }
            }
        }else{
            State::where('country_id', $id)->delete(); 
            City::where('country_id', $id)->delete(); 
        }
        return redirect()->route('country.index')->with('success', "Record Updated successfully....");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('country_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        City::where('country_id', $id)->delete();
        State::where('country_id', $id)->delete();
        Country::where('id', $id)->delete();
        return redirect()->route('country.index')->with('success', "Record deleted successfully....");
    }
}
