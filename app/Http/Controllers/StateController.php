<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Country;
use App\Models\City;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('state_list'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $states = State::with('country')->paginate(5);
        return view('state.index', compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('state_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $countries = Country::select('id', 'name')->where('status', 1)->get();
        return view('state.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('state_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'country_id' => 'required',
            'name' => 'required',
            'status' => 'required'
        ]);
        $statedata = $request->all();
        $data = [
            'country_id' => $statedata['country_id'],
            'name'       => $statedata['name'],
            'status'     => $statedata['status']
        ];
        $satateid = State::create($data); 

        if(isset($request['city_name'])){
            foreach($statedata['city_name'] as $key=>$_city){
                $_status = $statedata['city_status'][$key];

                if($_city){
                    $data1 = [
                        'country_id' => $statedata['country_id'],
                        'state_id'   => $satateid->id,
                        'name'       => $_city,
                        'status'     => $_status
                    ];
                    City::create($data1);
                }
            }
        }
        return redirect()->route('state.index')->with('success', "State created successfully...");
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
        abort_if(Gate::denies('state_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $cities = City::select('id', 'name', 'status')->where('state_id', $id)->get();
        $countries = Country::select('id', 'name')->where('status', 1)->get();
        $state = State::where('id', $id)->first();
        return view('state.edit', compact('state', 'countries', 'cities'));
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
        abort_if(Gate::denies('state_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'country_id' => 'required',
            'name' => 'required',
            'status' => 'required'
        ]);
        $updatedata = $request->all();

        $statedata = $updatedata->only('country_id', 'name', 'status');
        State::where('id', $id)->update($statedata);
        
        if(isset($updatedata['city_name'])){
            $city_id = array_filter($updatedata['city_id']);
            City::whereNotIn('id', $city_id)->where('state_id', $id)->delete();

            foreach($updatedata['city_name'] as $key=>$_city){
                $_status = $updatedata['city_status'][$key];
                $_id = $updatedata['city_id'][$key];
            
                if($_id){
                    $citydata = [
                        'country_id' => $statedata['country_id'],              
                        'name'       => $_city, 
                        'status'     => $_status
                    ];
                    City::where('id', $_id)->update($citydata);
                }else{
                    $data1 = [
                        'country_id' => $statedata['country_id'],
                        'state_id'   => $id,
                        'name'       => $_city,
                        'status'     => $_status
                    ];
                    City::create($data1);
                }
            }
        }else{
            City::where('state_id', $id)->delete();
        }
        return redirect()->route('state.index')->with('success', "Record Updated successfully....");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('state_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        city::where('state_id', $id)->delete();
        State::where('id', $id)->delete();
        return redirect()->route('state.index')->with('success', "Record deleted successfully....");
    }


    public function getstate(Request $request)
    {
        $html = '<option value="">--Select State--</option>';
        if($request->country_id){
            $states = State::where('country_id', $request->country_id)->get();

            foreach($states as $_state){
                $id = $_state->id;
                $stateName = $_state->name;
                $html .= '<option value="'.$id.'">'.$stateName.'</option>';
            }
        }
        echo $html;
    }
}
