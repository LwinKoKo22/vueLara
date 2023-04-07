<?php

namespace App\Http\Controllers\Backend;

use datatables;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.company.index');
    }

    public function ssd(){
        $data = Company::query();
        if(request()->name){
           $data = $data->where('name','LIKE','%'.request()->name.'%');
        }

        if(request()->date){
            $date = explode("-",request()->date);
            $from = $date[0];
            $to = $date[1];
            $data = $data->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
        }
        return datatables($data)
        ->editColumn('website',function($each){
            return '<a  href="'.$each->website.'" target="_blank">'.$each->website.'</a>';
        })
        ->editColumn('logo',function($each){
            if($each->logo){
                return '<img src="'.$each->logo_path().'" width="100" height="100"/>';
            }
            return "-";
        })
        ->editColumn('video',function($each){
           if($each->video){
            return '<video class="video-js vjs-big-play-centered vjs-city-js"  data-setup="{}" controls width="320px" height="200px">
                        <source src="'.$each->video_path().'" type="video/mp4">
                    </video>';
           }
           return "-";
        })
        ->editColumn('created_at',function($each){
            return $each->created_at->format('Y-m-d');
        })
        ->addColumn('action',function($each){
            $edit_btn = '<button class="btn btn-warning edit px-3 my-2" value="'.$each->id.'">Edit</button>';
            $delete_btn = '<button class="btn btn-danger delete" value="'.$each->id.'">Delete</button>';
            return $edit_btn . $delete_btn; 
        })
        ->rawColumns(['website','logo','video','action'])
        ->toJson();
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $logo_name = null;
        if($request->logo){
            $logo_name = uniqid()."_" . uniqid() . "." . $request->logo->getClientOriginalExtension();
            Storage::disk('public')->put('companies/'.$logo_name, file_get_contents($request->logo));
        }

        $video_name = null;
        if($request->video){
            $video_name = uniqid()."_" . uniqid() . "." . $request->video->getClientOriginalExtension();
            Storage::disk('public')->put('companies/'.$video_name, file_get_contents($request->video));
        }

        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->logo = $logo_name;
        $company->video = $video_name;
        $company->url = asset('/storage/companies');
        $company->website = $request->website;
        $company->save();
        return response()->json('Successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return response()->json($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {       
       $company = Company::firstWhere('id',$id);
        $logo_name = $company->logo;
        if($request->logo){
            Storage::disk('public')->delete('companies/'.$company->logo);
            $logo_name = uniqid() ."_".uniqid().".".$request->logo->getClientOriginalExtension();
            Storage::disk('public')->put('companies/'.$logo_name, file_get_contents($request->logo));
        }

        $video_name = $company->video;
        if($request->video){
            Storage::disk('public')->delete('companies/'.$company->video);
            $video_name = uniqid() ."_".uniqid().".".$request->video->getClientOriginalExtension();
            Storage::disk('public')->put('companies/'.$video_name, file_get_contents($request->video));
        }
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;
        $company->logo = $logo_name;
        $company->video  = $video_name;
        $company->update();
        return response()->json('Successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::firstWhere('id',$id);
        $company->delete();
        if($company->logo){
            Storage::disk('public')->delete('companies/'.$company->logo);
        }

        if($company->video){
            Storage::disk('public')->delete('companies/'.$company->video);
        }

        return response()->json('Successfully Deleted');
    }

}
