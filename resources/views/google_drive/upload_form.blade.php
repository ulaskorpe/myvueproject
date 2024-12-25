<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Upload Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Upload File</h2>
    <form action="{{route('upload-form-post')}}" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="mb-3">
            <label for="file_name" class="form-label">file_name</label>
            <input type="text" class="form-control" id="file_name" name="file_name"  >
            @error('file_name')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="fileInput" class="form-label">Select File</label>
            <input type="file" class="form-control" id="file" name="file"  >
            @error('file')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>


    <div id="google_drive_files"></div>

</div>
<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    getFiles();
});


function getFiles(delete_id=0){
$.get( "/list-files/"+delete_id, function( data ) {
  $( "#google_drive_files" ).html( data );

});
}
</script>
</body>
</html>
