<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Auth;

class LocationController extends Controller
{

    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data= LocationResource::collection(
            Location::where('user_id',Auth::user()->id)->get()
           );

           return $this->success($data,'locations list',200);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request)
    {

         
        $request->validated($request->all());
        $location = Location::create([
            'user_id'=>Auth::user()->id,
            'name'=>$request->name,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
            'color'=>$request->color
        ]);

        $data=  new LocationResource($location);

        return $this->success($data,'location created',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
    
        if(Auth::user()->id === $location->user_id  ){
           return $this->success(new LocationResource($location),'location details',200);
        }else{
            return $this->isNotAuthorized($location);
        }
   
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        if ($this->isNotAuthorized($location)) {
            return ($this->isNotAuthorized($location)) ;
        }
 
        $location->name = (!empty($request->name))?$request->name:$location->name;
        $location->latitude = (!empty($request->latitude))?$request->latitude:$location->latitude;
        $location->longitude = (!empty($request->longitude))?$request->longitude:$location->longitude;
        $location->color = (!empty($request->color) && (in_array($request->color,['red','blue','green'])))?$request->color:$location->color;
        $location->save();
        
        $data= new LocationResource($location);

        return $this->success($data,'location updated',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location )
    {
        if ($this->isNotAuthorized($location)) {
            return ($this->isNotAuthorized($location)) ;
        }

         $location->delete();
           return  $this->success('','location deleted',204);
    }

    private function isNotAuthorized(Location $location){
      
        if(Auth::user()->id !== $location->user_id  ){
            return $this->error('','you have no power here!',403);
        }
    }
}
