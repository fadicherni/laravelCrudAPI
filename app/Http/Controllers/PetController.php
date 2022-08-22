<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pet;
use Illuminate\Http\Request;

    /**
     * @OA\Get(
     *     path="/api/pet/{petId}",
     *     description="Get a pet by id",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="ID of pet to return",
     *         required=true,
     *      ),
     *     @OA\Response(response="default", description="Welcome page")
     *     
     * )
     * @OA\Get(
     *     path="/api/pet/findByStatus",
     *     description="Get pets by status Available values : available, pending, sold",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         @OA\Schema( 
     *              type="array", 
     *              @OA\Items(type="string", enum={"availble","pending","sold"}),
     *          ),
     *         description="status of pets to return",
     *         required=true,
     *      ),
     *     @OA\Response(response="default", description="success")
     *     
     * )
     * 
     * @OA\Get(
     *     path="/api/pets/",
     *     security={{"bearerAuth":{}}},
     *     description="Get all pets",
     *     @OA\Response(response="default", description="success")
     *     
     * )
     * 
     * @OA\Put(
     *     path="/api/pet",
     *     security={{"bearerAuth":{}}},
     *     description="add pet",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="pet name",
     *         required=true,
     *      ),
     * @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="status of the pet",
     *         required=true,
     *      ),
     * @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="Pet category_id",
     *         required=true,
     *      ),
     * @OA\Parameter(
     *         name="tags",
     *         in="query",
     *         description="pet tags",
     *         required=true,
     *      ),
     * @OA\Parameter(
     *         name="photos[added][]",
     *         in="query",
     *         description="pet image",
     *         required=false,
     *      ),
     *     @OA\Response(response="default", description="success")
     *     
     * )
     * @OA\Post(
     *     path="/api/pet",
     *     security={{"bearerAuth":{}}},
     *     description="add pet",
     *     
     *  @OA\RequestBody(
     *       @OA\JsonContent(
     *          @OA\Examples(
     *        summary="add pet",
     *        example = "add pet",
     *       value = {
     *              "name":"test",
     *              "status":"availble",
     *              "category":{
     *                  "id":"2",
     *                  "name":"pitbull"
     *               },
     *         },
     *      )
     * ),
     *       ),
     *     @OA\Response(response="204", description="Added succesfully"),
     *      @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\Schema(ref="#/components/schemas/ErrorModel")
     *     )
     *     
     * )
     * @OA\Delete(
     *     path="/api/pet/{id}",
     *     security={{"bearerAuth":{}}},
     *     description="deletes a single pet based on the ID supplied",
     *     operationId="deletePet",
     *     @OA\Parameter(
     *         description="ID of pet to delete",
     *         in="path",
     *         name="id",
     *         required=true,
     *        
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="pet deleted"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\Schema(ref="#/components/schemas/ErrorModel")
     *     )
     * )
     * 
     * @OA\Post(
     *     path="/login",
     *     description="Authenticate with email and password ",
     *           @OA\RequestBody(
     *       @OA\JsonContent(
     *          @OA\Examples(
     *        summary="test login",
     *        example = "test login",
     *       value = {
     *              "email": "xxxx@xxx.com",
     *              "password": "********"
     *         },
     *      )
     *       ),
     * ),
     *     @OA\Response(response="default", description="login success")
     *     
     * )
     *  @OA\Post(
     *     path="/register",
     *     description="register with email ,name and password ",
     *           @OA\RequestBody(
     *       @OA\JsonContent(
     *          @OA\Examples(
     *        summary="test register",
     *        example = "test register",
     *       value = {
     *              "email":"ffff@gmail.com",
     *              "password":"******",
     *              "name": "xxxxx",
     *              "password_confirmation":"******"
     *         },
     *      )
     *       ),
     * ),
     *     @OA\Response(response="default", description="user added ")
     *     
     * )
     * 
     * */
class PetController extends Controller
{
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        $pet = Pet::create([
            'name'=>$request->name,
            'status'=>$request->status,
            'category_id'=>$request->category['id']
        ]);


        $pet->tags()->attach(request('tags'));

        if (request('photos')) {
            $pet->attachPhotos(request('photos'));
        }

        return response()->json($pet)->setStatusCode(201);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadImage(Request $request, $petId)
    {
        $pet = Pet::whereId($petId)->first();

        if (request('photos')) {
            $pet->attachPhotos(request('photos'));
        }

        return response()->json($pet)->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  $petId
     * @return \Illuminate\Http\Response
     */
    public function show($petId)
    {
        $pet = Pet::with(['category','tags','photos'])->whereId($petId)->first();

        return response()->json($pet)->setStatusCode(200);

    }  

    /**
     * Display the specified resource.
     *
     * @param  $petId
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pet = Pet::with(['category','tags','photos'])->get();

        return response()->json($pet)->setStatusCode(200);

    }  
    
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findPetByStatus(Request $request)
    {
        $pets = Pet::whereIn('status',$request->status)->get();

        return response()->json($pets)->setStatusCode(200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $pet = Pet::find($request->id);

        $pet->update([
            'name'=>$request->name,
            'status'=>$request->status,
            'category_id'=>$request->category['id']
        ]);

        $pet->tags()->sync(request('tags'));

        if (request('photos')) {
            $pet->updatePhotos(request('photos'));
        }

        return response()->json($pet)->setStatusCode(200);
    } 
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $petId
     * @return \Illuminate\Http\Response
     */
    public function updatePet(Request $request,$petId)
    {
        $pet = Pet::find($petId);

        $pet->update([
            'name'=>$request->name,
            'status'=>$request->status,
        ]);

        return response()->json($pet)->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $petId
     * @return \Illuminate\Http\Response
     */
    public function destroy($petId)
    {
        $pet = Pet::find($petId);

        $pet->tags()->detach();

        foreach ($pet->photos as $file) {
            $file->delete();
        }

        $pet->delete();
    
    }
}
