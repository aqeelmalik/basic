<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <b>All Categories</b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{session('success')}}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card-header"> All categories</div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Sr No</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
{{--                            @php( $i = 1 )--}}
                            @foreach($categories as $category)
                            <tr>
                                <th scope="row">{{ $categories->firstItem()+$loop->index }}</th>
                                <td>{{$category->category_name}}</td>
                                <td>{{$category->user->name}}</td>
                                <td>
                                @if( $category->created_at == Null)
                                    <span class="text-danger"> Date Not Set</span>
                                @else
                                {{ Carbon\Carbon::parse($category->created_at)->diffForHumans()}}
                                @endif
                                </td>
                                <td>
                                    <a href="{{url('category/edit/'.$category->id)}}" class="btn btn-info">Edit</a>
                                    <a href="{{url('category/softDelete/'.$category->id)}}" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $categories->links() }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header"> Add categories</div>
                        <div class="card-body">
                            <form action="{{ route('store.category') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Category Name</label>
                                    <input type="text" name="category_name" class="form-control" id="exampleInputEmail1"
                                           aria-describedby="emailHelp">
                                    @error('category_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

{{--   Trash Layout     --}}

        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">

                        <div class="card-header"> Trash List</div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Sr No</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--                            @php( $i = 1 )--}}
                            @foreach($trashData as $category)
                                <tr>
                                    <th scope="row">{{ $categories->firstItem()+$loop->index }}</th>
                                    <td>{{$category->category_name}}</td>
                                    <td>{{$category->user->name}}</td>
                                    <td>
                                        @if( $category->created_at == Null)
                                            <span class="text-danger"> Date Not Set</span>
                                        @else
                                            {{ Carbon\Carbon::parse($category->created_at)->diffForHumans()}}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('category/restore/'.$category->id)}}" class="btn btn-info">Restore</a>
                                        <a href="{{url('category/pdelete/'.$category->id)}}" class="btn btn-danger">P Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $trashData->links() }}
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>

{{--   End of trash layout     --}}
    </div>
</x-app-layout>
