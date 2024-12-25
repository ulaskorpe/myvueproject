<?php


namespace App\Http\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\Helpers\GeneralHelper;
use App\Models\File;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;
class GoogleServices{

    public function token()
    {
        $client_id = \Config('services.google.client_id');
        $client_secret = \Config('services.google.client_secret');
        $refresh_token = \Config('services.google.refresh_token');

        $response = Http::post('https://oauth2.googleapis.com/token', [

            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'refresh_token' => $refresh_token,
            'grant_type' => 'refresh_token',

        ]);
        //dd($response);
        $accessToken = json_decode((string) $response->getBody(), true)['access_token'];

        return $accessToken;
    }


    public function deleteFile($fileId){

        Http::withToken($this->token())
       ->delete("https://www.googleapis.com/drive/v3/files/".$fileId);

       }

       public function createFileRecord($file, $folderId){
        $f =  new File();
        $f->name = $file['name'];
        $f->mime = $file['mimeType'];
        $f->size =round( $file['size']/1024, 2);
        $f->file_id = $file['id'];
        $f->webContentLink = str_replace('&export=download','', $file['webContentLink']);
        $f->folder_id = $folderId;
        $f->created_time = Carbon::parse( $file['createdTime'])->format('Y-m-d H:i:s');
        $f->save();

       }

       public function dirList( $folderId){
        $response = Http::withToken($this->token())
        ->get('https://www.googleapis.com/drive/v3/files', [
            'q' => "'" . $folderId . "' in parents", // Query to list files in the folder
            'fields' => 'files(id, name, mimeType, size, createdTime,webContentLink)', // Specify the fields you want
        ]);

        return $response->json()['files'];
       }


       public function fillFilesTable($folderId){

       //File::truncate();
        $files =  $this->dirList($folderId);

         foreach($files as $file){

                if($file['size']=='0'){
                    $this->deleteFile($file['id']);


                }
                $ch = File::where('file_id','=',$file['id'])->first();
                if(empty($ch)){

                $this->createFileRecord($file,$folderId);
                }
            }

       }


       public function renameFile(){
                    // $fileId = $response->json()['id'];

            // $renameResponse = Http::withToken($accessToken)
            // ->patch("https://www.googleapis.com/drive/v3/files/{$fileId}", [
            //     'name' => $request['file_name'],
            // ]);

       }

}
