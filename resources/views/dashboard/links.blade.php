<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hi <b>{{ Auth::user()->name }}</b>
            <b style="float: right">Total links :
                <span style="color:red">
                    {{ count($files_data) }}
                </span></b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            All Links
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Col num</th>
                                    <th scope="col">title</th>
                                    <th scope='col'>password</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Expire_Date</th>
                                    <th scope='col'>New_Path</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($ida = 1)
                                @foreach ($files_data as $file)
                                
                                    <tr>
                                        <th scope="row">{{ $ida++ }}</th>
                                        <td>{{ $file->title }}</td>

                                        <td>{{ $file->password }}</td>

                                        <td>
                                            @if ($file->created_at == null)
                                                <span class="text-danger">No Data Set</span>
                                            @else
                                                {{ Carbon\Carbon::parse($file->created_at)->diffForHumans() }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($file->created_at == null)
                                            <span class="text-danger">No Data Set</span>
                                            @else
                                            {{ Carbon\Carbon::parse($file->expire_date)->diffForHumans() }}
                                            @endif
                                        </td>
                                        <td>
                                            
                                            <input value='{{config('app.url').':8000'."/display/".$file->groub_id}}' id="input_{{ $ida }}" hidden>
                                            <button type="button" id="{{ $ida }}" class="btn btn-outline-dark"
                                                onclick="myFunction(this.id)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-clipboard" viewBox="0 0 16 16">
                                                    <path
                                                        d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z">
                                                    </path>
                                                    <path
                                                        d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z">
                                                    </path>
                                                </svg>
                                                
                                            </button>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{url('dashboard/MoreInfo/' . $file->groub_id)}}" class="btn btn-secondary">Info</a>
                                            <a href="{{url('dashboard/edit/' . $file->groub_id)}}"
                                                class="btn btn-secondary">Edit</a>
                                            <span style="inline">
                                                <form style="display: inline;"
                                                    action="{{route("dashboard.groub.delete")}}" method="POST">
                                                    @csrf
                                                    <input type="text" value="{{$file->groub_id}}" hidden name="groub_id"
                                                        value="#" />
                                                    <button class="btn btn-secondary"
                                                        onclick="return confirm('Are you sure ?')">Delete</button>
                                                </form>
                                            </span>
                                            </div>
                                            {{-- <a href='#' class="btn btn-danger"
                                            onclick="return confirm('Are you sure ?')">Delete</a>  --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>

                </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function myFunction(id) {
            /* Get the text field */
            var copyText = document.getElementById(`input_${id}`);

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            navigator.clipboard.writeText(copyText.value);

            /* Alert the copied text */
            alert("Copied the text: " + copyText.value);
        }
    </script>
</x-app-layout>
