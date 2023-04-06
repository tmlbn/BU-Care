<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserStudent;
use DB;

class ImportController extends Controller
{
    public function import(Request $request){
        $file = $request->file('csv_file');
        $csvData = file_get_contents($file);
        $rows = array_map("str_getcsv", explode("\n", $csvData));
        $header = ['applicant_id_number', 'last_name', 'first_name', 'middle_name', 'birth_month', 'birth_date', 'birth_year'];
        // remove the header row from the $rows array
        array_shift($rows);
        foreach ($rows as $row) {
            $data = array_combine($header, $row);
            UserStudent::create($data);
        }
  
      return redirect()->back()->with('success', 'CSV imported successfully.');
  }
  
}

