<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;

class MarcaController extends Controller
{
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;       
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $marca = $this->marca->all();
        return response()->json($marca, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       

       

        $request->validate($this->marca->rules(), $this->marca->feedback());
        $brand = $this->marca->create($request->all());
        return response()->json($brand, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $brand = $this->marca->find($id);
       if($brand === null){
           return response()->json(['error' => "This brand doesn't extist"], 404); 
       }
       

        return response()->json($brand, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(['error' => "This brand doesn't extist"], 404); 
        }
        if($request->method() === 'PATCH'){
            // allows update register using patch method
            $dynamicRules = array();

            foreach ($marca->rules() as $input => $rule) {
                if(array_key_exists($input, $request->all())){
                    $dynamicRules[$input] = $rule;                    
                }                                    
            }
            $request->validate($dynamicRules, $marca->feedback());
        } else {
            $request->validate($marca->rules(), $marca->feedback());
        }        
        $marca->update($request->all());
        return response()->json($marca, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(['error' => "This brand doesn't extist"], 404); 
        }
        $marca->delete();
        return response()->json(['msg' => 'Marca removida com sucesso.'], 200);
    }
}
