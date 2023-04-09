<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('city_list'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $cities = City::with('state', 'country')->paginate(5);
        return view('city.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('city_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $countries = Country::select('id', 'name')->where('status', 1)->get();
        return view('city.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('city_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'country_id' => 'required',
            'state_id' => 'required',
            'name' => 'required',
            'status' => 'required',
        ]);
        $citydata = $request->all();
        $data = [
            'country_id' => $citydata['country_id'],
            'state_id' => $citydata['state_id'],
            'name' => $citydata['name'],
            'status' => $citydata['status']
        ];
        City::create($data);
        return redirect()->route('city.index')->with('success', "City created successfully...");
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
        abort_if(Gate::denies('city_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $countries = Country::select('id', 'name')->where('status', 1)->get();
        $states = State::select('id', 'name')->where('status', 1)->get();
        $cities = City::where('id', $id)->first();
        return view('city.edit', compact('cities', 'countries', 'states'));
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
        // echo "<pre>";
        // print_r($request->all());
        // die;
        // abort_if(Gate::denies('city_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'country_id' => 'required',
            'state_id' => 'required',
            'name' => 'required',
            'status' => 'required',
        ]);

        $updatedata = $request->all();

        $citydata = $request->only('country_id', 'state_id', 'name', 'status');
        City::where('id', $id)->update($citydata);
        return redirect()->route('city.index')->with('success', "Record Updated successfully....");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('city_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        City::where('id', $id)->delete();
        return redirect()->route('city.index')->with('success', "Record deleted successfully....");
    }
}
