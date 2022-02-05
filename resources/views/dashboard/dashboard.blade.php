<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Hi <b>{{ Auth::user()->name }}</b>
            </h2>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <div class="row">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header">
                                <h4>Generate new Link</h4>
                            </div>
                            <div class="card-body" style="padding: 16px">
    
                                <form action="{{route('dashboard.add')}}"  method="POST" autocomplete="off" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="formFile" class="form-label">Select Folder :</label>
                                            <input class="form-control" type="file" name="folder[]" id="folder" multiple directory="" webkitdirectory="" mozdirectory="">
                                            @error('folder')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="formFile" class="form-label">Select Files :</label>
                                            <input class="form-control" type="file" id="formFile" name='files[]' multiple>
                                            @error('files')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="title"  class="form-label">Title :</label>
                                          <input type="text" id="title" name='title' class="form-control" placeholder="title" aria-label="title">
                                          @error('title')
                                          <span class="text-danger">{{ $message }}</span>
                                          @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message">Messages</label>
                                        <textarea class="form-control" name='message' id="message" rows="4"></textarea>
                                        @error('message')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="date" class="form-label">Expire Date :</label>
                                            <input class="form-control" type="date" name="date" id="date" min="{{date('Y-m-d')}}" value="{{date('Y-m-d',strtotime("+1 week"))}}">
                                            @error('date')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Password :</label>
                                            <input class="form-control" type="password" id="password" name='password'>
                                            @error('pas')

                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row g-3">
                                        <div class='col-md-6'>
                                            <button type="submit" class="btn btn-primary">Transfer</button>
                                        </div>
                                    </div>
                                </form>
                                @if(session('link'))
                                            <br>
                                            <h5>The Link:</h5>
                                            <!-- The text field -->
                                            <div class="input-group w-50">
                                                
                                                
                                                
                                                <span class="input-group-text" id="basic-addon1">
                                                    <button type="button" class="btn btn-outline-dark" onclick="myFunction()">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard" viewBox="0 0 16 16">
                                                        <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"></path>
                                                        <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"></path>
                                                        </svg>
                                                         
                                                    </button>
                                                     
                                                    <input type="text" value="{{config('app.url').':8000'."/display/".session('link')}}" id="myInput"
                                                style="width:420px;height:50px; background-color: #ffffff"
                                                aria-label="Input group example" aria-describedby="basic-addon1" class="form-control"
                                                readonly>
                                                </span>
                                                
                                                
                                              </div>
                                            <script>
                                                function myFunction() {
                                                /* Get the text field */
                                                var copyText = document.getElementById("myInput");
    
                                                /* Select the text field */
                                                copyText.select();
                                                copyText.setSelectionRange(0, 99999); /* For mobile devices */
    
                                                /* Copy the text inside the text field */
                                                navigator.clipboard.writeText(copyText.value);
    
                                                /* Alert the copied text */
                                                alert("Copied the text: " + copyText.value);
                                                }
                                                </script>
                                @endif
                            </div>
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
