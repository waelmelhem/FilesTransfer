<?php

namespace App\Http\Controllers;
use App\Models\Files;
use App\Models\Files_groubs;
use App\Models\downloaded_Files;
use App\Models\opend_links;
use Carbon\Carbon;
use Illuminate\Http\Request;
use File;
use Illuminate\Validation\ValidationException as ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class FileController extends Controller
{
    function add(Request $req)
    {
        if(!$req->hasFile('files')&&!$req->hasFile('folder')){
            $validated = $req->validate(
                [
                    'files' => 'required',
                    'folder' => 'required',
                    'message' => 'max:1000',
                    'title' => 'required|min:5',
                ]
            );
        }
        else{
            $validated = $req->validate(
                [
                    'files' => 'max:10',
                    'message' => 'max:1000',
                    'title' => 'required|min:5',
                ],
                [
                    'files.max' => 'The files must not be greater than 10 files.',
                ]
            );
        }
        $group = uniqid();
        $filess = Files_groubs::insert([
            'groub_id' =>$group,
            'title' => $req->title,
            'message'=>$req->message,
            'expire_date'=>date('Y-m-d',strtotime("+7 Days")),
            'created_at' => Carbon::now()
        ]);
        
        if($req->hasFile('folder'))
        {
            $zip = new ZipArchive;
            $fileName = uniqid();
            if ($zip->open(storage_path('app/public/files/'.$fileName.".zip"), ZipArchive::CREATE) === TRUE)
            {
            $files = $req->folder;
            foreach ($files as $key => $value) {
                if($value->isValid()){
                $relativeNameInZipFile = $value->getClientOriginalName();
                $zip->addFile($value, $relativeNameInZipFile);
            }
            else{
                throw ValidationException::withMessages([
                    'folder'=>'Folder corrupted'
                ]);
            }
            }
            $zip->close();
        }
        $filess = Files::insert([
            'file_id' =>$fileName,
            'file_groub'=>$group,
            'name'=>$fileName.".zip",
            'mime'=>'application/zip',
        ]);
        
        }

        if(($req->hasFile('files'))){
            foreach($req->file('files') as $key=> $file){
                    $fileName=uniqid();
                    $file->storeAs('',$fileName.'.'.$file->getClientOriginalExtension());
                    $filess = Files::insert([
                        'file_id' =>$fileName,
                        'file_groub'=>$group,
                        'name'=>($file->getClientOriginalName()),
                        'mime'=>$file->getClientMimeType(),
                    ]);
                }
        }
        return redirect()->back()->with('link', $group);
    }
    function display($id){
        
        $files=Files::select('*')->where('file_groub', $id)->get();
        $files_data=Files_groubs::select('*')->where('groub_id',$id)->first();

        $name=Files_groubs::select('users.name')
        ->join('users', 'users.id', '=', 'Files_groubs.user_id')->first();
        if(!isset($files_data)){
            abort(404);
        }
        if(date('Y-m-d')>$files_data->expire_date){
            Files_groubs::where('groub_id',$id)->delete();
            abort(404);
        }
        if($files_data->password!=null){
            return redirect('password/' . $id);
        }
        opend_links::insert([
            "groub_id"=>$files_data->groub_id
        ]);
        return view('display',compact('files','files_data','name'));
    }
    function download($id){
        $files=Files::select('*')->where('file_id', $id)->first();
        if(!isset($files)){
            abort(404);
        }
        else{
            $a=explode(".",$files->name);
            $ext=strtolower($a[count($a)-1]);
            downloaded_Files::insert([
                "groub_id"=>$files->file_groub
            ]);
            return response()->download(storage_path("app/public/files/$files->file_id.$ext"),$files->name);
        }
    }
    function DashAdd(Request $req)
    {
        if(Auth::user()){
            if(!$req->hasFile('files')&&!$req->hasFile('folder')){
                $validated = $req->validate(
                    [
                        'files' => 'required',
                        'folder' => 'required',
                        'message' => 'max:1000',
                        'title' => 'required|min:5',
                        'date'=>'required|date|after:today'
                    ]
                );
            }
            else{
                $validated = $req->validate(
                    [
                        'files' => 'max:10',
                        'message' => 'max:1000',
                        'title' => 'required|min:5',
                    ]
                );
            }
            $group = uniqid();
            $filess = Files_groubs::insert([
                'groub_id' =>$group,
                'title' => $req->title,
                'message'=>$req->message,
                'password'=>$req->password,
                'expire_date'=>$req->date,
                'user_id'=>Auth::user()->id,
                'created_at' => Carbon::now()
            ]);
            
            if($req->hasFile('folder'))
            {
                $zip = new ZipArchive;
       
                $fileName = uniqid();
       
                if ($zip->open(storage_path('app/public/files/'.$fileName.".zip"), ZipArchive::CREATE) === TRUE)
                {
                $files = $req->folder;
       
                foreach ($files as $key => $value) {
                    if($value->isValid()){
                    $relativeNameInZipFile = $value->getClientOriginalName();
                    $zip->addFile($value, $relativeNameInZipFile);
                }
                else{
                    throw ValidationException::withMessages([
                        'folder'=>'Folder corrupted'
                    ]);
                }
                }
                 
                $zip->close();
            }
            $filess = Files::insert([
                'file_id' =>$fileName,
                'file_groub'=>$group,
                'name'=>$fileName.".zip",
                'mime'=>'application/zip',
            ]);
            
            }
    
            if(($req->hasFile('files'))){
                foreach($req->file('files') as $key=> $file){
                        $fileName=uniqid();
                        $file->storeAs('',$fileName.'.'.$file->getClientOriginalExtension());
                        $filess = Files::insert([
                            'file_id' =>$fileName,
                            'file_groub'=>$group,
                            'name'=>($file->getClientOriginalName()),
                            'mime'=>$file->getClientMimeType(),
                        ]);
                    }
            }
            return redirect()->back()->with('link', $group);

        }
        else{
            abort(404);
        }
    }
    public function password($id)
    {
        return view('password', compact('id'));
    }

    public function password_check(Request $req)
    {
        $req->validate(
            ['password' => 'required']
        );
        // echo $req->id;
        // exit;
        $files_data=Files_groubs::select('*')->where('groub_id',$req->id)->first();;
        $files=Files::select('*')->where('file_groub', $req->id)->get();
        $name=Files_groubs::select('users.name')
        ->join('users', 'users.id', '=', 'Files_groubs.user_id')->first();
        
            if (($files_data)==null) {
                abort(404, 'Page not found');
            } else {
                // echo "here";
                // exit;
                if ($files_data->password == null) {
                    opend_links::insert([
                        "groub_id"=>$files_data->groub_id
                    ]);
                    return view('display',compact('files','files_data','name'));
                    } else {
                    if ($files_data->password === $req->password) {
                        opend_links::insert([
                            "groub_id"=>$files_data->groub_id
                        ]);
                        return view('display',compact('files','files_data','name'));
                    } else {
                        return redirect()->back()->with('password_check', "Wrong password");
                    }
                }
            }
            
        
    }
    public function dashLink(){
        $files_data=Files_groubs::select('*')->where('user_id', Auth::user()->id)->get();
        $files=Files::select('*')->get();

        // foreach($files_data as $file)
        // {
        //     echo $file->groub_id;
        // }
        // exit;
        // dd($files_data);
        return view('dashboard.links',compact('files_data'));
    }
    public function dashInfo($id){
        $files=Files::select('*')->where('file_groub', $id)->get();
        $files_data=Files_groubs::select('*')->where('groub_id',$id)->first();
        $down_count=count(downloaded_Files::select('*')->where('groub_id', $id)->get());
        $open_count=count(opend_links::select('*')->where('groub_id', $id)->get());
        if(Auth::check()&&count($files)&&Auth::user()->id===$files_data->user_id){
            $arr=[];
            foreach($files as $file){
            $a=explode(".",$file->name);
            $ext=strtolower($a[count($a)-1]);
            $x=Storage::size(("$file->file_id.$ext"));
            $arr[$file->file_id]=$x;
        }
        return view('dashboard.info',compact('files','files_data','arr','down_count','open_count'));
        }else{
            abort(404);
        }
        
    }
    public function dashEdit($id){
        $files_data=Files_groubs::select('*')->where('groub_id',$id)->first();
        if(isset($files_data)&&Auth::check()&&Auth::user()->id===$files_data->user_id){
            return view('dashboard.edit',compact('files_data'));
        
        }else{
            abort(404);
        }
    }
    public function FileEdit($id,$name){
        $files=Files::select('*')->where('file_id', $id)->first();
        if(Auth::check()&&isset($files)){
            $files_data=Files_groubs::select('*')->where('groub_id',$files->file_groub)->first();
            if(Auth::user()->id===$files_data->user_id){
                $a=explode(".",$files->name);
                $ext=strtolower($a[count($a)-1]);
                Files::where('file_id', $id)->update([
                    'name'=>$name.".".$ext,
                ]);
                return redirect()->back();
            }else{
                abort(404);
            }
        }
        else{
            abort(404);
        }
    }
    public function fileDelete($id){
        $file=Files::select('*')->where('file_id', $id)->first();
        if(Auth::check()&&isset($file)){
            $files_data=Files_groubs::select('*')->where('groub_id',$file->file_groub)->first();
            if(Auth::user()->id===$files_data->user_id){
                $files=Files::select('*')->where('file_groub', $files_data->groub_id)->get();
                if(count($files)>=2){
                    $a=explode(".",$file->name);
                    $ext=strtolower($a[count($a)-1]);
                    Storage::delete("$file->file_id.$ext");
                    Files::where('file_id', $id)->delete();
                    return redirect()->back();
                }
                else{
                    $a=explode(".",$file->name);
                    $ext=strtolower($a[count($a)-1]);
                    Storage::delete("$file->file_id.$ext");
                    Files_groubs::where('groub_id',$files_data->groub_id)->delete();
                    return redirect()->route("dashboard.links");
                }
            }else{
                abort(404);
            }
        }
        else{
            abort(404);
        }
    }
    public function fileAdd(Request $req){
        if(!$req->hasFile('file')){
            $req->validate(
                [
                    'file' => 'required',
                ]
            );
        }
        $files_data=Files_groubs::select('*')->where('groub_id',$req->groub_id)->first();
        if(isset($files_data)&&$files_data->user_id==Auth::user()->id){
            $fileName=uniqid();
                    $req->file->storeAs('',$fileName.'.'.$req->file('file')->getClientOriginalExtension());
                    $filess = Files::insert([
                        'file_id' =>$fileName,
                        'file_groub'=>$req->groub_id,
                        'name'=>($req->file->getClientOriginalName()),
                        'mime'=>$req->file->getClientMimeType(),
                    ]);
        }
        return redirect()->back();
    }
    public function editlink(Request $req){
        $validated = $req->validate(
            [
                'message' => 'max:1000',
                'title' => 'required|min:5',
            ]
        );
        $files_data=Files_groubs::select('*')->where('groub_id',$req->groub_id)->first();
        if(isset($files_data)&&Auth::check()&&Auth::user()->id===$files_data->user_id){
        $filess = Files_groubs::where('groub_id',"$req->groub_id")->update([
            'title' => $req->title,
            'message'=>$req->message,
            "password"=>$req->password,
            'expire_date'=>$req->date,
            'updated_at' => Carbon::now()
        ]);
        return redirect()->route("dashboard.links");
    }
    else{
        abort(404);
    }
    }
    public function delete_groub(Request $req){
        $files_data=Files_groubs::select('*')->where('groub_id',$req->groub_id)->first();
        if(isset($files_data)&&Auth::check()&&Auth::user()->id===$files_data->user_id){
            $files=Files::select('*')->where('file_groub', $req->groub_id)->get();
            foreach($files as $file){
                
                $a=explode(".",$file->name);
                $ext=strtolower($a[count($a)-1]);
                Storage::delete("$file->file_id.$ext");
                Files::where('file_id', $file->file_id)->delete();
            }
            // exit;
        Files_groubs::where('groub_id',$files_data->groub_id)->delete();
        return redirect()->route("dashboard.links");
    }
    else{
        abort(404);
    }
    }

}
