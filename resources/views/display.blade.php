<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Quintessential&family=Yellowtail&display=swap" rel="stylesheet">
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:#6b7280;color:rgba(107,114,128,var(--tw-text-opacity))}}

    </style>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

    </style>
    <script src="https://kit.fontawesome.com/98132d6d9d.js" crossorigin="anonymous"></script>
</head>

<body class="antialiased">
    <div class="site-name can-hide" style="margin:20px 20px"><h4>Files Transfer</h4></div>
    <div class="relative flex items-top  min-h-screen bg-gray-100 dark:bg-gray-900  py-4 sm:pt-0">
        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                    @endif
                @endauth
            </div>
        @endif
            <br>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
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
                            {{$files_data->user_id}}
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
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header" style="font-size:14pt">
                            files
                        </div>
                        <div class="card-body" style="padding: 16px">
                            @php($aa=0)
                            @foreach($files as $file)
                            <i class="fa {{icon_link::FontAwesomeIcon($file->mime)}}" aria-hidden="true" style="font-size:24px; margin-bottom:10px;"><span style="font-size:14px;"> {{$file->name}}</span></i>
                            <a  id="downloadId{{$aa++}}"class="btn btn-info" href="{{ url('download/' . $file->file_id) }}" style="position: absolute;right:10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                 </svg>
                                </a>
                            <br>
                            
                            
                            @endforeach
                            <input id="count" value="{{$aa}}" hidden>
                            <div style="margin: auto"><button class="btn btn-info" onclick="myFunction()">Download All</button></div>
                        
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
<script>
    function sleep(milliseconds) {
        const start = Date.now();
        while (Date.now() - start < milliseconds);
        }

    function myFunction() {
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
</script>
</html>
