<?php

namespace App\Http\Controllers;

use App\Jobs\SaveDataJob;
use Illuminate\Http\Response;

class JobController extends Controller
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function runJob()
    {
        dispatch(new SaveDataJob('../challenge.json'));

        return response()->json([
            'message' => 'Data saved from JSON file.'
        ], Response::HTTP_OK);
    }
}
