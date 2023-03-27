<?php

namespace App\Http\Controllers;

use App\Models\Main;
use App\Http\Requests\StoreMainRequest;
use App\Http\Requests\UpdateMainRequest;
use Inertia\Inertia;


class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $Main = Main::all();
        return Inertia::render('Task/Index', [
            'tasks' => $Main

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMainRequest $request)
    {
        //
        return 1;
    }

    /**
     * Display the specified resource.
     */
    public function show(Main $main)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Main $main)
    {
        //
        dd($main);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMainRequest $request, Main $main)
    {
        //
        $main = Main::find($request->id);
        $main->name = $request->name;
        $main->priority = $request->priority;
        if ($main->save())
            return $main;
            // return response('Hello World');
          
        else
            return null;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Main $main)
    {
        //
    }
}