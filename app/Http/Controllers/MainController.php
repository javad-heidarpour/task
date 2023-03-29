<?php

namespace App\Http\Controllers;

use App\Models\Main;
use App\Http\Requests\StoreMainRequest;
use App\Http\Requests\UpdateMainRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;


class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $Main = Main::orderby('priority')->get();
        return Inertia::render('Task/Drag', [
            'tasks' => $Main

        ]);
    }
    public function load()
    {

        $Main = Main::orderby('priority')->get();
        return $Main;
    }

    public function changePriority(Request $request, Main $main)
    {
        //
        // return $request[0]['name'];
        $i = 0;
        // return count($request->all());
        for ($i = 0; $i < count($request->all()); $i++) {
            // foreach ($request->all() as $req) {
            // echo $request[$i]->;
            $main = Main::find($request[$i]['id']);

            $main->priority = $i + 1;
            echo $main->priority;

            $main->save();
            // $i++;
        }

        // if ($main->save())
        //     return $main;
        // // return response('Hello World');
        // else
        //     return null;

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
        $main = new Main;
        $main->name = $request->name;
        $main->priority = $request->priority;
        if ($main->save())
            return $main;
        // return response('Hello World');
        else
            return null;

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