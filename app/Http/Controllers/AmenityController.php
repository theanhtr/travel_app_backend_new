<?php

namespace App\Http\Controllers;

use App\Helper\GetRoleAmenityIdHelper;
use App\Models\Amenity;
use App\Http\Requests\StoreAmenityRequest;
use App\Http\Requests\UpdateAmenityRequest;
use App\Traits\HttpResponse;

class AmenityController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Amenity::class);

        return response()->json(Amenity::get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAmenityRequest $request)
    {
        $this->authorize('create', Amenity::class);

        $amenityExist = Amenity::where([
            ['name', '=', $request -> name],
            ['font_awesome_class', '=', $request -> font_awesome_class],
            ['description', '=', $request -> description],
            ['role_amenity_id', '=', $request -> role_amenity_id],
        ])->first();

        if($amenityExist) {
            return response()->json('amenity is exist', 400);
        }

        Amenity::create([
            'name' => $request->name,
            'font_awesome_class' => $request->font_awesome_class,
            'description' => $request->description ?? null,
            'role_amenity_id' => $request->role_amenity_id
        ]);

        return response()->json('create done', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Amenity $amenity)
    {
        $this->authorize('view', Amenity::class);

        return response()->json($amenity, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAmenityRequest $request, Amenity $amenity)
    {
        $this->authorize('update', Amenity::class);
        
        $oldAmenity = $amenity;

        $amenity->update([
            'name' => $request->name ?? $oldAmenity->name,
            'font_awesome_class' => $request->font_awesome_class ?? $oldAmenity->font_awesome_class,
            'description' => $request->description ?? $oldAmenity->description,
            'role_amenity_id' => $request->role_amenity_id ?? $oldAmenity->role_amenity_id
        ]);

        return response()->json('update complete', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Amenity $amenity)
    {
        $this->authorize('delete', Amenity::class);

        $amenity->delete();
        return response()->json('delete complete', 200);
    }

    public function showAmenitiesOfHotel() {
        $amenities = Amenity::where('role_amenity_id', GetRoleAmenityIdHelper::getHotelRoleAmenityId())->get();
        return $this->success('Get ok', $amenities);
    }
}