<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajax Todo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

</head>
<body>
<div class="container">
    <div class="row">
        <div class="offset-3 col-lg-6 pt-3">
            <div class="card">
                <div class="card-header">

                        <form class="form-inline">
                             <div class="card-title"> <h3>jQuery Ajax Todo List
                            <input type="text" class="form-control"
                      style="width: 30%; margin-left: 10px "placeholder="Search Here" name="item" id="searchItem">
                      <a href="" id="addNew" class="pull-right" data-toggle="modal" data-target="#addNewItem"><i class="fa fa-plus"></i> </a></h3></div>
                      </form>
                    </div>
                {{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">--}}
                    {{--Launch demo modal--}}
                {{--</button> --}}
                    <div class="card-body" >
                        <div id="list-example" class="list-group">
                            @foreach($items as $item)
                            <a class="list-group-item list-group-item-action outItem" href="#list-item-1" data-toggle="modal" data-target="#addNewItem">{{$item->item}}
                                <input type="hidden" id="itemId" value="{{$item->id}}">
                            </a>
                            @endforeach
                                <div class="mt-3">
                                    {{$items->links()}}
                                </div>
                        </div>

                    </div>



                <div class="modal" tabindex="-1" role="dialog" id="addNewItem">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="title">Add New Item</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="id">
                                <input type="text" class="form-control" placeholder="Write Item Here" id="addItem">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="delete" data-dismiss="modal" style="display: none">Delete</button>
                                <button type="button" class="btn btn-info" id="saveChanges" data-dismiss="modal" style="display: none">Save Changes</button>
                                <button type="button" class="btn btn-primary" id="AddButton" data-dismiss="modal" >Add New</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <!--  <div class="col-lg-2 pt-3 sear">
            <input type="text" class="form-control" placeholder="Search Here" name="item" id="searchItem">
        </div> -->
    </div>
</div>

</body>
{{csrf_field()}}
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" ></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.outItem', function () {
                var text = $.trim($(this).text());
                var id = $(this).find('#itemId').val();
                $('#title').text('Edit Item');
                $('#delete').show();
                $('#saveChanges').show();
                $('#addItem').val(text);
                $('#AddButton').hide();
                $('#id').val(id);
                // console.log(text);
        });
        $(document).on('click', '#addNew', function(event) {
            $('#title').text('Add New Item');
            $('#addItem').val("");
            $('#delete').hide();
            $('#saveChanges').hide();
            $('#AddButton').show();
        });
        $('#AddButton').click(function (event) {
            var text = $('#addItem').val();
            if(text == ""){
                alert('Shut Up & type Anything');
            }else{
                $.post('list', {'text': text, '_token': $('input[name=_token]').val()}, function(data) {
                    console.log(data);
                    $('#list-example').load(location.href + ' #list-example');
                });
            }

        });
        $('#delete').click(function(event) {
            var id = $('#id').val();
            $.post('delete', {'id': id, '_token': $('input[name=_token]').val()}, function(data) {
                $('#list-example').load(location.href + ' #list-example');
                console.log(data);
            });
        });
        $('#saveChanges').click(function(event) {
            var id = $('#id').val();
            var text = $('#addItem').val();
            if(text == ""){
                alert('Shut Up & type Anything');
            }else{
                $.post('update', {'id': id, 'text': text, '_token': $('input[name=_token]').val()}, function(data) {
                    console.log(data);
                    $('#list-example').load(location.href + ' #list-example');

                });
            }

        });

        $( function() {
            $( "#searchItem" ).autocomplete({
                source: 'http://ajaxtodo.test/search'
            });
        });

    });
    $(document).on('click', '.pagination a', function (e) {
        // var text = $.trim($(this).text());
        e.preventDefault();
        // console.log($(this).attr('href').split('page=')[0]);
        var page = $(this).attr('href').split('page=')[1];
        getItem(page);
    });
    function getItem(page) {
        // console.log('Getting Item For Page = ' + page);
        $.ajax({
            url: '/ajax/list?page='+ page
        }).done(function (data) {
            // console.log(data);
            $('#list-example').html(data);
            location.hash = page;
        });
    }
</script>
</html>
