<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Trait\ApiResponseTrait;
use Illuminate\Http\Request;
use App\Services\KidsService;
class PoliceController extends Controller
{

    public $kidService;

    public function __construct(KidsService $kidService)
    {
        $this->kidService=$kidService;
    }

    public function search(Request $request)
    {
        $image = $request->file('image');

        $kid = $this->kidService->search($image);
        if ($kid){
            // Load the guardian relationship
            $kid->load('guardian');
            return $this->apiResponse($kid,"Search Done Successfully",200);
        }else{
            return $this->apiResponse(null,"Found Errors",404);
        }
    }
}
