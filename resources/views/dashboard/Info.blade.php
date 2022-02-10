<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hi <b>{{ Auth::user()->name }}</b>
            {{-- <b style="float: right">Total links :
                <span style="color:red">
                    {{ count($files_data) }}
                </span></b> --}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="card" style="font-size:14pt">
                        <div class="card-header">
                            {{$files_data->title}}
                        </div>
                        <div class="card-body" style="padding: 16px">
                            <div class="form-group shadow-textarea">
                                <label for="exampleFormControlTextarea6"><h6>Message :</h6></label>
                                <textarea class="form-control z-depth-1" id="exampleFormControlTextarea6" rows="4" readonly placeholder="No message ..."style="font-family: 'Open Sans', sans-serif;font-family: 'Quintessential', cursive;font-family: 'Yellowtail', cursive;font-size:18pt;">{{$files_data->message}}</textarea>
                            </div>
                            <H6 style="display: inline">Created By : </H6><span style="font-size:10pt;" class='badge badge-info'>@if(isset($files_data->user_id))
                            {{Auth::user()->name}}
                            @else
                            {{'unknown'}}
                            @endif
                            </span>
                            &ensp;&ensp;
                            <H6 style="display: inline">Created : </H6> <span style="font-size:10pt;" class='badge badge-info'>
                                {{Carbon\Carbon::parse($files_data->created_at)->diffForHumans()}}
                                </span>
                                &ensp;&ensp;
                            <H6 style="display: inline">Available for : </H6> <span style="font-size:10pt;" class='badge badge-danger'>
                                {{Carbon\Carbon::parse($files_data->expire_date)->diffForHumans(Carbon\Carbon::now())}}
                            </span>                        
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card" style="font-size:14pt">
                                <div class="card-header">
                                    Download :
                                </div>
                                <div class="card-body text-info" style="padding: 16px ;font-size:24px;text-align:center">
                                    {{ $down_count}} times
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card" style="font-size:14pt">
                                <div class="card-header">
                                    Open :
                                </div>
                                <div class="card-body text-info" style="padding: 16px;font-size:24px;text-align:center">
                                   {{ $open_count}} times
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header" style="font-size:14pt">
                            files
                        </div>
                        <div class="card-body" style="padding: 16px">
                            @php($aa=0)
                            @php($sum=0)
                            @foreach($files as $file)
                            <i class="fa {{icon_link::FontAwesomeIcon($file->mime)}}" aria-hidden="true" style="font-size:24px; margin-bottom:10px;"><span id="name{{$aa}}" style="font-size:14px;"> {{$file->name}}</span></i>
                            <div class="btn-group" role="group" aria-label="Basic example" style="position: absolute;right:10px;">
                            <button  id="butt{{$aa}}"onclick="Function2(this.id)" class="btn btn-info" >
                                <i class="fas fa-edit"></i>
                            </button>
                            <input type="text" id="editId{{$aa}}" hidden value="{{ url('dashboard/editFile/' . $file->file_id) }}">
                                <a  id="editId{{$aa}}"class="btn btn-info" href="{{ url('dashboard/deleteFile/' . $file->file_id) }}">
                                    <i class="fas fa-trash-alt"></i>
                                    </a>
                            <a  id="downloadId{{$aa++}}"class="btn btn-info" href="{{ url('download/' . $file->file_id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                
                                </svg>
                                </a>
                                
                            </div>
                            <br>
                            <div class="text-info" style="position:relative;bottom:12px">{{round($arr[$file->file_id]/1024,2)}} KB</div>
                            @php($sum+=$arr[$file->file_id])
                            
                            @endforeach
                            <input id="count" value="{{$aa}}" hidden>
                            <div style="margin: auto"><button class="btn btn-info" onclick="myFunction()">Download All</button><span class="text-info">{{round($sum/1024/1024,4)}}MB</span></div>
                        
                        </div>

                    </div>
                    <br>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" style="font-size:14pt">
                                ADD file
                            </div>
                            <div class="card-body" style="padding: 16px">
                                <form method="post" action="{{route('file.add')}}"  enctype="multipart/form-data">
                                    @csrf
                                    <input name="file" type="file">
                                    <input name="groub_id" value="{{$files_data->groub_id}}" hidden>
                                    <br>
                                    <br>
                                    <input type="submit" value="Add" class="btn btn-primary">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <script>
        function sleep(milliseconds) {
        const start = Date.now();
        while (Date.now() - start < milliseconds);
        }
        function myFunction(id) {
            for(var i=0;i<document.getElementById('count').value;i++){
            // if(i%2){
                
                document.getElementById('downloadId'+i).click();
                // console.log(document.getElementById('downloadId'+i));
                sleep(1000);
            //    }
            //    else{
            //     window.open(document.getElementById('downloadId'+i).getAttribute("href"),'_blank');
            //     console.log(i); 
            //     sleep(2000);
            //    }
                
        }
        }
        function Function2(id){
            id=id.replace("butt","");
            var element=document.getElementById('name'+(id));
            var name=prompt("new name :", element.innerHTML.split(".")[0]);
            if(name){
                var herf=document.getElementById('editId'+(id)).value+"/"+name;
                console.log(herf);
                window.open(herf,'_self');
            }
        }
    </script>
</x-app-layout>
