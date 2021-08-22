<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companies;
use Redirect;
use Session;
use Response;
use Validator;
use Illuminate\Support\Facades\Storage;
use File;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Companies::paginate(10);
        return view('admin.company', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'Name' => ['required', 'string', 'max:255'],
            'Email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'Logo' => 'dimensions:min_width=200,min_height=200|dimensions:max_width=400,max_height=400',
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {


            $company = new Companies();
            $company->name = $request->Name;
            $company->email = $request->Email;
            $company->industry = $request->Industry;
            $company->website_url = $request->url;
            if ($request->file('Logo')) {
                $imagePath = $request->file('Logo');
                $imageName = $imagePath->getClientOriginalName();
                $image_path = $request->file('Logo')
                    ->storeAs('uploads', $imageName, 'public');
                $company->logo = $imageName;
            }


            try {

                $company->save();
                return response()->json(['status' => 1, 'msg' => 'Company Added successfully..!']);
            } catch (\Exception $e) {


                return response()->json(['error' => $e,]);
            }
        }
    }
    public function displayImage($filename)

    {

        $path = storage::disk('public')->path("uploads/$filename");

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Companies::where('id', $id)->first();

        return view('admin.view_company', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Companies::where('id', $id)->first();
        return response()->json(['success' => true, 'data' => $company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Name' => ['required', 'string', 'max:255'],
            'Email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'Logo' => 'dimensions:min_width=200,min_height=200|dimensions:max_width=400,max_height=400',
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $id = $request->id;

            if ($request->file('Logo')) {
                $imagePath = $request->file('Logo');
                $imageName = $imagePath->getClientOriginalName();
                $image_path = $request->file('Logo')
                    ->storeAs('uploads', $imageName, 'public');
                Companies::where('id', $id)->update(['logo' => $imageName,]);
            }


            Companies::where('id', $id)->update([
                'name' => $request->Name,
                'email' => $request->Email,
                'industry' => $request->Industry,
                'website_url' => $request->url,

            ]);
            return response()->json(['status' => 1, 'msg' => ' Company Updated successfull..!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Companies::where('id', $id)->delete();
        return response()->json(['status' => 1, 'msg' => ' Company deleted successfull..!']);
    }
}
