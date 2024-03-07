<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\LazyCollection;

use App\Models\BcastNumbers;

use App\Jobs\BcastNumbersCSVJob;

use App\Imports\BcastImport;

use App\Jobs\QueuedImport;

use Maatwebsite\Excel\Facades\Excel;


class Managelist extends Controller
{
    public function index($status = null)
    {
        
        $lists = \App\Models\Bcastlist::paginate(5);
        $contacts = \App\Models\BcastNumbers::paginate(5);

        return view('lists.managelist', ['lists' => $lists])->with(['status' => $status])->with(['contacts' => $contacts]);
        
    }

    public function editlist(Request $request)
    {

    }

    public function showuploadform(Request $request, $id){

        //$id = $request->id;
        $name = $request->name;

        return view('lists.uploadlist',compact('id','name'));

    }

    public function show($id)
    {

        $lists = DB::table('bcast_list_maps')
            ->crossJoin('bcastlists')
            ->crossJoin('bcast_numbers')
            ->select('bcast_numbers.id', 'bcast_numbers.msisdn', 'bcast_numbers.field1 as string_field1', 'bcast_numbers.field2 as string_field2', 'bcast_numbers.field3 as string_field3', 'bcast_numbers.field4 as string_field4', 'bcast_numbers.field5 as string_field5', 'bcastlists.name as list_name')
            ->where('bcast_list_maps.num_id', '=', DB::raw('bcast_numbers.id'))
            ->where('bcastlists.id', '=', DB::raw('bcast_list_maps.list_id'))
            ->where('bcast_list_maps.list_id', '=', $id)
            ->paginate(5);

        return view('lists.viewnums')->with('lists', $lists);
    }

    public function import_with_queue(Request $request) {

        if( $request->has('csv') ) {

            $file = $request->file('csv');
            $list_name = $request->list_name;
            $list_id = $request->list_id;
            $j=0;

            //get the csv file for counting rows
            $fh = fopen($request->csv,'rb') or die("ERROR OPENING DATA");

            //count the numbers in the file
            while (fgets($fh) !== false) $j++;   

            $import = new BcastImport($list_id);

            $y= Excel::import($import,$file);

            $list_id = $request->list_id;

            $list_name = $request->name;

            $msg = $j . " numbers uploaded successfully to list " . $list_name;           

            return redirect()->back()->with('id',$list_id)->with('name',$list_name)->with('status', $msg);

        }else{

            $list_id = $request->list_id;

            $list_name = $request->name;

            $status = "please upload csv file";
            return redirect()->back()->with('id',$list_id)->with('name',$list_name)->with('status', $status);

        }
    }

    public function upload_csv_file(Request $request)
    {
        

        if( $request->has('csv') ) {

            $file = $request->file('csv');
            $list_name = $request->list_name;
            $list_id = $request->list_id;

            //get the csv file for counting rows
            $fh = fopen($request->csv,'rb') or die("ERROR OPENING DATA");

            $csv    = file($request->csv);
            $chunks = array_chunk($csv,1000);
            $header = [];
            $data =[];
            $j=0;

            $filename = $file->getClientOriginalName();
            $location = 'uploads';
            $filepath = public_path($location . "/" . $filename);
            
            $file->move($location, $filename);

            //count the numbers in the file
            while (fgets($fh) !== false) $j++;

            foreach ($chunks as $key => $chunk) {

                //$j++;
                $data = array_map('str_getcsv', $chunk);

                if($key == 0){
                    $header = $data[0];
                    unset($data[0]);
                }

                BcastNumbersCSVJob::dispatch($data, $header, $request->list_id);                
            }

            $list_id = $request->list_id;

            $list_name = $request->name;

            $msg = $j . " numbers uploaded successfully to list " . $list_name;           

            return redirect()->back()->with('id',$list_id)->with('name',$list_name)->with('status', $msg);

        }else{

            $list_id = $request->list_id;

            $list_name = $request->name;

            $status = "please upload csv file";
            return redirect()->back()->with('id',$list_id)->with('name',$list_name)->with('status', $status);

        }

        
    }
    function purgeList($list_id) {
        
        DB::table('bcast_list_maps')->where('list_id', $list_id)->delete();
        
    }

    function getListID($name,$user_id) {

        $sqlb = DB::select("SELECT id FROM bcast_lists WHERE lower(name) = '.$name.' AND created_by = '.$user_id");
        
        return $sqlb['id'];
    }

    public function deletelist($id)
    {
        DB::table('bcast_list_maps')->where('list_id', $id)->delete();

        DB::table('bcastlists')->where('id', $id)->delete();

        $msg = "List has been deleted successfully";

        return $this->index($msg);
    }

    public function deleteContacts($id)
    {

        DB::table('bcast_list_maps')->where('num_id', $id)->delete();

        DB::table('bcast_numbers')->where('id', $id)->delete();

        $msg = "Contact deletion successful";

        return $this->index($msg);

    }

    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = array("csv", "xlsx"); //Only want csv and excel files
        $maxFileSize = 128450000; // Uploaded file size limit is 2mb

        if (in_array(strtolower($extension), $valid_extension)) {

            if ($fileSize <= $maxFileSize) {

            } else {

                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
            }

        } else {

            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error

        }

    }
}
