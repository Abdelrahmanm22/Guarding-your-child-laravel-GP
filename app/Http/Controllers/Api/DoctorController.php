<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddKidRequest;
use App\Http\Requests\MedicalHistoryRequest;
use App\Http\Requests\UpdateKidRequest;
use App\Models\Kid;
use App\Services\GuardiansService;
use App\Services\KidsService;
use App\Trait\ApiResponseTrait;
use Illuminate\Http\Request;

class DoctorController extends Controller
{


    public $kidService;
    public $guardianService;

    public function __construct(KidsService $kidService,GuardiansService $guardianService)
    {
        $this->kidService=$kidService;
        $this->guardianService=$guardianService;
    }

    public function get($id)
    {
        return $this->kidService->getKid($id);
    }

    public function allKids()
    {
        $kids =$this->kidService->getKids() ;
        return $this->apiResponse($kids,"Get All Kids Successfully",200);
    }

    public function addKid(AddKidRequest $addKidRequest)
    {

        $kid = $this->kidService->addKid($addKidRequest);
        $this->guardianService->addGuardians($addKidRequest,$kid->id);

        // Fetch the kid with its guardian
        $kidWithGuardian = Kid::with('guardian')->find($kid->id);

        $this->kidService->addMedicalHistory($kid->id);

        if ($kidWithGuardian) {
            return $this->apiResponse($kidWithGuardian, 'Kid added successfully with guardian', 201);
        } else {
            return $this->apiResponse(null, 'There were some errors', 500);
        }
    }

    public function updateKid(UpdateKidRequest $updateKidRequest,$kid)
    {


        $message = $this->kidService->updateKid($updateKidRequest,$kid);

        $this->guardianService->updateGuardians($updateKidRequest,$kid);


        // Fetch the kid with its guardian
        $kidWithGuardian = Kid::with('guardian')->find($kid);


        if ($kidWithGuardian) {
            return $this->apiResponse($kidWithGuardian, $message, 201);
        } else {
            return $this->apiResponse(null, 'There were some errors', 500);
        }
    }

    ///live search to get kids by SSN
    public function search(Request $request)
    {
        $SSN = $request->SSN;
        $kids = $this->kidService->searchBySSN($SSN);
        return $this->apiResponse($kids,"Search Done Successfully",200);
    }


    public function searchMedicalHistory(Request $request)
    {
        if ($request->has('SSN')) {
            $kid = $this->kidService->getKidBySSN($request->SSN);
            if (is_null($kid)) {
                return $this->apiResponse(null, "Kid not found", 404);
            }
            return $this->apiResponse($kid, "Search Medical History by SSN Successfully", 200);
        } elseif ($request->hasFile('image')) {
            $image = $request->file('image');
            $kid = $this->kidService->search($image);
            // Load the medicalHistory relationship
            $kid->load('medicalHistory');
            return $this->apiResponse($kid, "Search Medical History by Image Successfully", 200);
        } else {
            return $this->apiResponse(null, "No SSN or Image Provided", 400);
        }
    }


    public function medicalHistory($kid)
    {
        $medicalKid = $this->kidService->getMedicalHistory($kid);
        return $this->apiResponse($medicalKid,'Get Medical History Successfully',200);
    }

    public function updateMedicalHistory(MedicalHistoryRequest $medicalHistoryRequest,$kid)
    {
        $medicalKid =  $this->kidService->updateMedicalHistory($medicalHistoryRequest,$kid);
        return $this->apiResponse($medicalKid,'Update Medical History Successfully',201);
    }
}
