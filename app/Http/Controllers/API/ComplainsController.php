<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Complains;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ComplainsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Complains::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'category' => 'required|string',
        'ward' => 'required|string',
        'description' => 'required|string',
        'user_id' => 'required|string',
        'pictures' => 'mimes:jpg,jpeg,png,bmp|max:20000',
    ]);

    $data = $request->all();
    $data['uuid'] = Str::uuid();

    if ($request->hasFile('pictures')) {
        $file = $request->file('pictures');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $filePath = $request->file('pictures')->storeAs('pictures', $filename, 'public');

        $data['pictures'] = '/storage/' . $filePath;
    }

    $complain = Complains::create($data);

    return response()->json(['message' => 'Complain added successfully', 'complain' => $complain], Response::HTTP_CREATED);
}


        /**
     * Display the specified resource.
     */
    public function show(Complains $complain)
    {
        return $complain;
    }


        /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => 'sometimes|required|string',
            'ward' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'user_id' => 'sometimes|required|string',
            'pictures' => 'sometimes|mimes:jpg,jpeg,png,bmp|max:20000',
        ]);

        $complain = Complains::findOrFail($id);
        
        if ($request->hasFile('pictures')) {
            // Remove the old picture
            Storage::disk('public')->delete(str_replace('/storage/', '', $complain->pictures));
            
            $file = $request->file('pictures');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $request->file('pictures')->storeAs('pictures', $filename, 'public');

            $request['pictures'] = '/storage/' . $filePath;
        }

        $complain->update($request->all());

        return response()->json(['message' => 'Complain updated successfully', 'complain' => $complain], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $complain = Complains::findOrFail($id);
        
        // Delete the complain picture
        Storage::disk('public')->delete(str_replace('/storage/', '', $complain->pictures));

        $complain->delete();

        return response()->json(['message' => 'Complain deleted successfully'], Response::HTTP_NO_CONTENT);
    }

}
