<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Repository;

class MatchController extends Controller
{

    protected $rep;
    public function __construct(Repository $repository){
        $this->rep = $repository;
    }


    public function createList()
    {
        $obj = $this->rep->getCreateList();
        return response()->json($obj, 200);
    }

    public function search(Request $request)
    {
        $obj= $this->rep->searchGame($request);
        return response()->json($obj, 200);
    }
}
