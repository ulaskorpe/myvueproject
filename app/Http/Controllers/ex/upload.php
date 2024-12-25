<?php

/////////////////// upload thing

$accessToken = $this->token();
//dd($accessToken);
$name = $request->file->getClientOriginalName();

//  $name = Str::slug( $request->file->getClientOriginalName());
$mime=$request->file->getClientMimeType();

$path=$request->file->getRealPath();
//  $ext=pathinfo($request->file->name,PATHINFO_EXTENSION);

// $response=Http::withToken($accessToken)
// ->attach('data',file_get_contents($path),$name)
// ->post('https://www.googleapis.com/upload/drive/v3/files',
//     [
//         'name'=>$name,
//       //   'parents'=>[\Config('services.google.folder_id')],

//     ],
//     [
//         'Content-Type'=>'application/octet-stream',
//     ]
//     );


$response = Http::withHeaders([
    'Authorization'=> 'Bearer '.$accessToken,
    'Content-Type'=>'Application/json'
])->attach('data',file_get_contents($path),$name)
->post('https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart', [

//     //->post('https://www.googleapis.com/drive/v3/files/',[
    'data'=>$name,
    'mimeType'=>$mime,
 //   'uploadType'=>'resumable', /// resumable, multipart
  'parents'=>[\Config('services.google.folder_id')],


]);

$fileContent = file_get_contents($path);

$response = Http::withHeaders([
'Authorization' => 'Bearer ' . $accessToken,
'Content-Type'  => 'application/json'
])->post('https://www.googleapis.com/upload/drive/v3/files?uploadType=resumable', [
'name' => $name,
'mimeType' => $mime,
  'parents' => [config('services.google.folder_id')],
]);
/////////////////// upload thing
