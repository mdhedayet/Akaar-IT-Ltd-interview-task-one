<?php

namespace App\Http\Controllers;

use App\Jobs\SaveCustomer;
use App\Jobs\SendEmail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class CustomerController extends Controller
{
    public function datatables(Request $request) {


        $branch_id = (!empty($_GET["branch_id"])) ? ($_GET["branch_id"]) : ('');
        $first_name = (!empty($_GET["first_name"])) ? ($_GET["first_name"]) : ('');
        $last_name = (!empty($_GET["last_name"])) ? ($_GET["last_name"]) : ('');
        $email = (!empty($_GET["email"])) ? ($_GET["email"]) : ('');
        $phone = (!empty($_GET["phone"])) ? ($_GET["phone"]) : ('');
        $gender = (!empty($_GET["gender"])) ? ($_GET["gender"]) : ('');


        $search = $request->input('search.value');

        $pageSize = ($request->length) ? $request->length : 10;

        $itemQuery = Customer::orderBy("id","desc");

        // $itemQuery->orderBy('id', 'asc');
        $itemCounter = $itemQuery->get();
        $count_total = $itemCounter->count();

        $count_filter = 0;

        if($branch_id != ''){
            $itemQuery->where(function($q) use ($branch_id){
                return $q->where('branch_id', 'like', '%' .$branch_id. '%');
                    });
            $count_filter = $itemQuery->count();
        }
        if($first_name != ''){
            $itemQuery->where(function($q) use ($first_name){
                return $q->where('first_name', 'like', '%' .$first_name. '%');
                    });
            $count_filter = $itemQuery->count();
        }
        if($last_name != ''){
            $itemQuery->where(function($q) use ($last_name){
                return $q->where('last_name', 'like', '%' .$last_name. '%');
                    });
            $count_filter = $itemQuery->count();
        }
        if($email != ''){
            $itemQuery->where(function($q) use ($email){
                return $q->where('email', 'like', '%' .$email. '%');
                    });
            $count_filter = $itemQuery->count();
        }
        if($phone != ''){
            $itemQuery->where(function($q) use ($phone){
                return $q->where('phone', 'like', '%' .$phone. '%');
                    });
            $count_filter = $itemQuery->count();
        }
        if($gender != ''){
            $itemQuery->where(function($q) use ($gender){
                return $q->where('gender', 'like', '%' .$gender. '%');
                    });
            $count_filter = $itemQuery->count();
        }



        if($search != ''){
            $itemQuery->where(function($q) use ($search){
                return $q->where('branch_id', 'like', '%' .$search . '%')
                ->orWhere('first_name', 'like', '%' .$search . '%')
                ->orWhere('last_name', 'like', '%' .$search . '%')
                ->orWhere('email', 'like', '%' .$search . '%')
                ->orWhere('phone', 'like', '%' .$search . '%')
                ->orWhere('gender', 'like', '%' .$search . '%');
                    });
            $count_filter = $itemQuery->count();
        }

        $start = ($request->start) ? $request->start : 0;
        $itemQuery->skip($start)->take($pageSize);
        $items = $itemQuery->get();

        if($count_filter == 0){
            $count_filter = $count_total;
        }

        return Datatables::of($items)
            ->skipPaging()
            ->with([
                "recordsTotal" => $count_total,
                "recordsFiltered" => $count_filter,
                ])
            ->addIndexColumn()
            ->setRowId(function ($items) {
                return $items->id;
            })
            ->addColumn('branch_id', function ($items) {
                return $items->branch_id;
            })
            ->addColumn('first_name', function ($items) {
                return $items->first_name;
            })
            ->addColumn('last_name', function ($items) {
                return $items->last_name;
            })
            ->addColumn('email', function ($items) {
                return $items->email;
            })
            ->addColumn('phone', function ($items) {
                return $items->phone;
            })
            ->addColumn('gender', function ($items) {
                return $items->gender;
            })
            ->rawColumns(['branch_id','first_name','last_name','email','phone','gender'])
            ->make(true);

    }

    public function index(){
        return view('table');
    }

    public function importCustomer(Request $request){

        set_time_limit(0);

        $rules = [
            'file' => 'required|mimes:csv,txt'
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];

        $this->validate($request, $rules, $customMessages);


        $path = Storage::putFile('excelFile', $request->file('file'));
        $file = Storage::path($path);

        dispatch(new SaveCustomer($file))->delay(now()->addSeconds(2));

        return redirect()->back()->with('message', 'Queue Start done we are working with your csv file.If, we save it successfully.we will email you.If You received the email than refresh the page.Thank You!');
   }


   public function sentMail(){

    dispatch(new SendEmail())->delay(now()->addSeconds(30));

   }


   public function totalCustomer(Request $request){
    $total = Customer::count();
        return response()->json([
            'total' => $total,
        ]);
   }

   public function totalMaleCustomer(Request $request){
    $total = Customer::where("gender", "M")->count();
        return response()->json([
            'total' => $total,
        ]);
   }

   public function totalFemaleCustomer(Request $request){
    $total = Customer::where("gender", "F")->count();
        return response()->json([
            'total' => $total,
        ]);
   }


}
