<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Type</th>
        <th scope="col">Size</th>

        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        @foreach($files as $file)
        <tr>
            <td>{{$loop->index+1}}</td>
            <td>
            <a href="https://drive.usercontent.google.com/download?id={{$file['file_id']}}&authuser=0" target="_blank">
            {{$file['name']}}

        </a></td>

                <td>{{$file['mime']}}</td>

                <td>{{$file['size']}}KB</td>
                <td> <a href="#" onclick="if(confirm('file will be deleted?')){getFiles(delete_id='{{$file['file_id']}}')}"> delete</a></td>
        </tr>
      @endforeach
    </tbody>
</table>
