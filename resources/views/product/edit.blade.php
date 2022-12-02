<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Product Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit Product</h2>
                </div>
                <div class="pull-right" align="right">
                    <a class="btn btn-primary" href="{{ route('products.index') }}" enctype="multipart/form-data">
                        Back</a>
                </div>
            </div>
        </div>
        <div class="alert" id="message" style="display: none"></div>
         @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <form id="upload_form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong> Title:</strong>
                        <input type="hidden" name="id" value="{{$products->id}}">
                        <input type="text" name="title" value="{{$products->title}}" class="form-control" placeholder="title">
                        @error('title')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Description:</strong>
                    <textarea class="form-control" name="description" rows="2" cols="2">{!! $products->description !!}</textarea>
                    @error('description')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                 <label>Variants</label>
                 <table class="table table-bordered" id="dynamicAddRemove">
                    <tr>
                        <th>Name</th>
                        <th>Value</th>

                        <th>Action</th>
                    </tr>
                    @if(!empty($products->variants))
                    @foreach ( $products->variants  as $key=>$var)

                    <tr>
                        <td><input type="text" name="addMoreInputFields[{{$key}}][name]" value="{{$var->title}}" placeholder="Enter Name" class="form-control" />
                        </td>
                        <td><input type="text" name="addMoreInputFields[{{$key}}][value]"value="{{$var->value}}" placeholder="Enter Value" class="form-control" />
                        </td>
                        <td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td>
                    </tr>
                    @endforeach
                    @endif
                    @php
                    $newKey=$key+1;
                    @endphp

                    <tr>
                        <td><input type="text" name="addMoreInputFields[{{$newKey}}][name]" placeholder="Enter Name" class="form-control" />
                        </td>
                        <td><input type="text" name="addMoreInputFields[{{$newKey}}][value]" placeholder="Enter Value" class="form-control" />
                        </td>
                        <td>
                    <button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Add Variants</button></td>
                    </tr>

                </table>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Image:</strong>
                        <div id="here">
                        <img src="{{ asset('images/'.$products->main_image) }}" alt="tag" width="100" height="100">
                        </div>
                        <input type="file" name="main_image"  id="main_image" class="form-control" placeholder="Main Image">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ml-3">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        var i = {{$newKey}};
    $("#dynamic-ar").click(function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td><input type="text" name="addMoreInputFields[' + i +
            '][name]" placeholder="Enter name" class="form-control" /></td><td><input type="text" name="addMoreInputFields[' + i +
            '][value]" placeholder="Enter value" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
            );
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });

     $('#upload_form').on('submit', function(event){
      event.preventDefault();
      $.ajax({
       url:"{{ route('update_data') }}",
       method:"POST",
       data:new FormData(this),
       dataType:'JSON',
       contentType: false,
       cache: false,
       processData: false,
       success:function(data)
       {
        $('#message').css('display', 'block');
        $('#message').html(data.message);
        $('#message').addClass(data.class_name);
        $('#uploaded_image').html(data.uploaded_image);
        $( "#here" ).load(window.location.href + " #here" );

        $('html, body').animate({
        scrollTop: $("#message").offset().top
    }, 5000);
            setTimeout(function () {
            location.reload(true);

            }, 5000);

       }
      })
     });

    });
    </script>



