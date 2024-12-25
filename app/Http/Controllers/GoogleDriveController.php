<?php

namespace App\Http\Controllers;

use App\Http\Services\GoogleServices;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
class GoogleDriveController extends Controller
{



    private $service ;
    public function __construct(GoogleServices $service){
        $this->service =  $service;
    }

    public function upload_form(){
        return view('google_drive.upload_form',['files'=>File::all()]);
    }


    public function readDir(){
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->service->token(),
            'Accept'        => 'application/json',
        ])->get('https://www.googleapis.com/drive/v3/files', [
            'q'       => "'" . \Config('services.google.folder_id'). "' in parents",
            'fields'  => 'files(id, name, mimeType)',
        ]);

    }


    public function list_files($delete_id=0){

        if($delete_id>0){
            $this->service->deleteFile($delete_id);
            File::where('file_id','=',$delete_id)->delete();

        }

        return view('google_drive.list_files',['files'=>File::orderBy('created_time','DESC')->get()]);
    }


    private function getCredentials(Request $request){
        return [
            'token'=>$this->service->token(),
            'name'=>(!empty($request['file_name'])) ? $request['file_name'] .".". $request->file->getClientOriginalExtension() : date('YmdHis').".".$request->file->getClientOriginalExtension(),
            'folder_id'=>config('services.google.folder_id'),
            'file_content'=>file_get_contents($request->file->getPathname()),
            'mime'=>$request->file->getClientMimeType()
        ];
    }

    private function getFileName(){
        //todo
    }

    public function upload_form_post(Request $request){
        $request->validate([
            'file' => 'file|required',
            'file_name' => 'required',
        ]);

        $credential_array = $this->getCredentials($request);
        $response = Http::withToken($credential_array['token'])
            ->asMultipart() // Ensures multipart request is sent
            ->post('https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart', [
                [
                    'name'     => 'metadata',
                    'contents' => json_encode([
                        'name'    =>$credential_array['name'],
                        'parents' => [$credential_array['folder_id']],
                    ]),
                    'headers'  => [
                        'Content-Type' => 'application/json; charset=UTF-8',
                    ],
                ],
                [
                    'name'     => 'file',
                    'contents' => $credential_array['file_content'],
                    'headers'  => [
                        'Content-Type' => $credential_array['mime'],
                    ],
                ],
            ]);



       if($response->successful()){

            $this->service->fillFilesTable($credential_array['folder_id']);
            return redirect()->route('upload-form');
       }else{
            return response('failed uploaded');
       }

    }


    public function show(File $file)
    {
        $ext=pathinfo($file->name,PATHINFO_EXTENSION);

        $response=Http::withHeaders([
            'Authorization'=> 'Bearer '.$this->service->token(),
        ])->get("https://www.googleapis.com/drive/v3/files/{$file->fileid}?alt=media");

        if($response->successful()){
            $filePath='/downloads/'.$file->file_name.'.'.$ext;

            Storage::put($filePath,$response->body());

            return Storage::download($filePath);
        }
    }
}
