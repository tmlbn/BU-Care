<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\UserStudent;
use App\Models\UserPersonnel;
use DB;

class ImportController extends Controller{
    public function importNew(Request $request){
        $file = $request->file('csv_new');
        $csvData = file_get_contents($file);
        $rows = array_map("str_getcsv", explode("\n", $csvData));
        $header = ['applicant_id_number', 'last_name', 'first_name', 'middle_name', 'birth_month', 'birth_date', 'birth_year'];
        // remove the header row from the $rows array
        array_shift($rows);
        foreach ($rows as $row) {
            try {
                if (empty($row)) {
                    // end of file
                    break;
                }
                if(count($row) !== count($header)){
                    continue; // skip this row if number of elements is different
                }
                $data = array_combine($header, $row);
                // Check for duplicate applicant ID
                $applicant = UserStudent::where('applicant_id_number', $data['applicant_id_number'])->first();
                if ($applicant) {
                    continue;
                }
                UserStudent::create($data);
            } catch (\ErrorException $e) {
                // Handle the exception here
                return redirect()->back()->with('fail', 'An error occurred while importing CSV.');
            }
        }
            return redirect()->back()->with('success', 'New Students - CSV imported successfully.');
    }

    public function importOld(Request $request){
        $file = $request->file('csv_old');
        $csvData = file_get_contents($file);
        $rows = array_map("str_getcsv", explode("\n", $csvData));
        $header = ['applicant_id_number', 'student_id_number', 'email', 'password'];
        // remove the header row from the $rows array
        array_shift($rows);
        foreach ($rows as $row) {
            try{
                if (empty($row)) {
                    // end of file
                    break;
                }
                if(count($row) !== count($header)){
                    continue; // skip this row if number of elements is different
                }
                $data = array_combine($header, $row);
                $applicant = UserStudent::where('applicant_id_number', $data['applicant_id_number'])->first();
                if ($applicant) {
                    $applicant->student_id_number = $data['student_id_number'];
                    $applicant->email = $data['email'];
                    $applicant->password = bcrypt($data['password']);
                    $applicant->save();
                }
            } catch (\ErrorException $e) {
                // Handle the exception here
                return redirect()->back()->with('fail', 'An error occurred while importing CSV.');
            }
        }
        return redirect()->back()->with('success', 'Old Students - CSV imported successfully.');
    }

    public function importPersonnel(Request $request){
        $file = $request->file('csv_personnel');
        $csvData = file_get_contents($file);
        $rows = array_map("str_getcsv", explode("\n", $csvData));
        $header = ['personnel_id_number', 'email', 'password', 'last_name', 'first_name', 'middle_name', 'date_of_birth'];
        // remove the header row from the $rows array
        array_shift($rows);
        foreach ($rows as $row) {
            try{
                /*if (empty($row)) {
                    // end of file
                    break;
                }
                if(count($row) !== count($header)){
                    continue; // skip this row if number of elements is different
                }*/
                $data = array_combine($header, $row);
                // Check for duplicate personnel ID
                $personnel = UserPersonnel::where('personnel_id_number', $data['personnel_id_number'])->first();
                if ($personnel) {
                    continue;
                }
                $data['password'] = bcrypt($data['password']);
                UserPersonnel::create($data);
            } catch (\ErrorException $e) {
                // Handle the exception here
                return redirect()->back()->with('fail', 'An error occurred while importing CSV.');
            }
        }
        return redirect()->back()->with('success', 'Personnel - CSV imported successfully.');
    }
}
