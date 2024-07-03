<?php

namespace App\Services;

use App\Models\Kid;
use App\Models\MedicalHistory;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
class KidsService
{
    public function getKids()
    {
        $page = request()->get('page', 1);

        $paginatedKids = Kid::with('guardian')->paginate(10, ['*'], 'page', $page);

        return [
            'kids' => $paginatedKids->values(),
            'last_page' => $paginatedKids->lastPage(),
            'per_page' => $paginatedKids->perPage(),
            'current_page' => $paginatedKids->currentPage(),
            'next_page_url'=>$paginatedKids->nextPageUrl(),
        ];
    }
    public function getKid($id)
    {
        return Kid::find($id);
    }
    public function addKid($data)
    {
        $last_index = Kid::max('index');
        $current_index = $last_index + 1;
        if ($data->gender=="male"){
            $gender = "M";
        }else if ($data->gender=="female"){
            $gender = "F";
        }

        // Create a Guzzle client instance
        $client = new Client();

        // Make a POST request to the external API
        $response = $client->post('https://machineapp.azurewebsites.net/Add', [
            'multipart' => [
                [
                    'name'     => 'image',
                    'contents' => fopen($data->image->getPathname(), 'r'), // Assuming $data->image is the image file
                ],
                [
                    'name'     => 'user_id',
                    'contents' => $current_index,
                ],
                [
                    'name'     =>'gender',
                    'contents' =>$gender,
                ],
            ],
            'verify' => false, // Disable SSL verification
        ]);

        // Get response body
        $responseBody = $response->getBody()->getContents();


        $responseData = json_decode($responseBody, true);

        $kid = Kid::create([
           'index'=>$current_index,
           'SSN'=>$data->SSN,
           'first_name'=>$data->first_name,
            'last_name'=>$data->last_name,
            'gender'=>$data->gender,
            'birthDate'=>$data->birthDate,
            'doctor_id'=>auth()->user()->id,
        ]);

        return $kid;
    }

    public function updateKid($data,$kidID)
    {


        // Create a Guzzle client instance
        $client = new Client();
        $message ="Kid Info updated successfully";
        if($data->image){

            $response = $client->post('https://machineapp.azurewebsites.net/Update', [
                'multipart' => [
                    [
                        'name'     => 'new_image',
                        'contents' => fopen($data->image->getPathname(), 'r'), // Assuming $data->image is the image file
                    ],
                    [
                        'name'     => 'user_id',
                        'contents' => $kidID,
                    ],
                ],
                'verify' => false, // Disable SSL verification
            ]);

            // Get response body
            $responseBody = $response->getBody()->getContents();

            $responseData = json_decode($responseBody, true);
            $message .= " and FootPrint updated in model";
        }


        $kid = $this->getKid($kidID);

        $kid->update([
            'SSN'=>$data->SSN,
            'first_name'=>$data->first_name,
            'last_name'=>$data->last_name,
            'gender'=>$data->gender,
            'birthDate'=>$data->birthDate,
            'doctor_id'=>auth()->user()->id,
        ]);
        return $message;
    }
    public function search($image)
    {

        // Create a Guzzle client instance
        $client = new Client();
        $response = $client->post('https://machineapp.azurewebsites.net/search', [
            'multipart' => [
                [
                    'name'     => 'image',
                    'contents' => fopen($image->getPathname(), 'r'),
                ],
            ],
            'verify' => false, // Disable SSL verification
        ]);



        $responseBody = $response->getBody()->getContents();
        $responseData = json_decode($responseBody, true);

        $index = $responseData['index'];
        $kid = Kid::where('index',$index)->with('guardian')->get();
        return $kid;
    }



    public function searchBySSN($SSN) ///search live
    {
        $kids = Kid::where('SSN', 'like', '%' . $SSN . '%')->with('guardian')->get();

        foreach ($kids as $kid) {
            $kid->similarity = levenshtein($SSN, $kid->SSN);
        }

        $sortedKids = $kids->sortBy('similarity');

        $page = request()->get('page', 1);
        $perPage = 10;
        $paginatedKids = new LengthAwarePaginator(
            $sortedKids->forPage($page, $perPage),
            $sortedKids->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return [
            'kids' => $paginatedKids->values(),
            'last_page' => $paginatedKids->lastPage(),
            'per_page' => $paginatedKids->perPage(),
            'current_page' => $paginatedKids->currentPage(),
            'next_page_url'=>$paginatedKids->nextPageUrl(),
        ];
    }

    public function getKidBySSN($SSN)
    {
        $kid = Kid::where('SSN', 'like', '%' . $SSN . '%')->with('medicalHistory')->first();
        return $kid;
    }

    public function addMedicalHistory($kidID)
    {
        MedicalHistory::create([
            'kid_id'=>$kidID
        ]);
    }

    public function getMedicalHistory($kidID)
    {
        $medicalKid = MedicalHistory::where('kid_id',$kidID)->first();
        return $medicalKid;
    }

    public function updateMedicalHistory($data,$kidID)
    {
        $medicalKid = MedicalHistory::where('kid_id',$kidID)->first();

        $medicalKid->update([
           'specialNeeds'=>$data->specialNeeds,
            'chronicConditions'=>$data->chronicConditions,
            'bloodType'=>$data->bloodType,
            'previousSurgeries'=>$data->previousSurgeries,
            'allergies'=>$data->allergies,
        ]);
        return $medicalKid;
    }
}
