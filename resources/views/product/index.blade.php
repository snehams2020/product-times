
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Crud</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>

    <div class="row justify-content-center mt-5">
        <div class="col-6">
            <div class="d-flex justify-content-between mb-4">
                <h3>Products List</h3>
                <a class="btn btn-success btn-sm" href="{{ route('products.create') }}">Create New</a>
            </div>

            @if(session()->has('success'))
                <label class="alert alert-success w-100">{{session('success')}}</label>
            @elseif(session()->has('error'))
                <label class="alert alert-danger w-100">{{session('error')}}</label>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th> Name</th>
                        <th> Description</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($products) && count($products)>0)
                    @foreach ($products as $prod)
                        <tr>
                            <td>{{ $prod->id }}</td>
                            <td>{{ $prod->title }}</td>
                            <td>{!! $prod->description !!}</td>

                            <td>
                                <form action="{{ route('products.destroy',$prod->id) }}" method="Post">
                                    <a class="btn btn-primary" href="{{ route('products.edit',$prod->id) }}">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td  colspan="5">No Data Found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{-- <div class="d-flex justify-content-between">
                {{ $products->render() }}
            </div> --}}

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
</body>
</html>







