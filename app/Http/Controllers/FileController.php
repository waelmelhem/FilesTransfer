<?php

namespace App\Http\Controllers;
use App\Models\Files;
use App\Models\Files_groubs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use File;
use Illuminate\Validation\ValidationException as ValidationException;
use Illuminate\Support\Facades\Auth;

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
            'id' =>$group,
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
        $files_data=Files_groubs::select('*')->where('id',$id)->first();
        if(!isset($files_data)){
            abort(404);
        }
        if(date('Y-m-d')>$files_data->expire_date){
            Files_groubs::where('id',$id)->delete();
            abort(404);
        }
        if($files_data->password!=null){
            return redirect('password/' . $id);
        }
        
        return view('display',compact('files','files_data'));
    }
    function download($id){
        $files=Files::select('*')->where('file_id', $id)->first();
        if(!isset($files)){
            abort(404);
        }
        else{
            $a=explode(".",$files->name);
            $ext=strtolower($a[count($a)-1]);
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
                        'message' => 'max:1000',
                        'title' => 'required|min:5',
                    ]
                );
            }
            $group = uniqid();
            $filess = Files_groubs::insert([
                'id' =>$group,
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
        $files_data=Files_groubs::select('*')->where('id',$req->id)->first();;
        $files=Files::select('*')->where('file_groub', $req->id)->get();
            if (($files_data)==null) {
                abort(404, 'Page not found');
            } else {
                // echo "here";
                // exit;
                if ($files_data->password == null) {
                    return view('display',compact('files','files_data'));
                    } else {
                    if ($files_data->password === $req->password) {
                        return view('display',compact('files','files_data'));
                    } else {
                        return redirect()->back()->with('password_check', "Wrong password");
                    }
                }
            }
    }

}
