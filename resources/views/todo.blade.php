<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Todo App</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  </head>
  <style>
        li.list-group-item{
            display: inline-block;
            width: 100%;
        }
  </style>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
                <h1 class="text-center">Todo App</h1>
                <div id="addFrm" role="form">
                    <div class="form-group">
                        <input type="text" class="form-control"  id="title" required="required" placeholder="Enter title">
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" id="AddItem">Add</a>
                    </div>
                </div>
                <hr>
                <div id="itemsList">
                    <ul class="list-group" >
                        @foreach($items as $item)
                            <li class="list-group-item"  idtitle="{{ $item->id }}">
                                <a class="badge delete_Item" href="#">
                                    <span class=" glyphicon glyphicon-remove"></span>
                                </a>
                                <span class="pull-left" id="li-title">{{ $item->title }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>                
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="//js.pusher.com/2.2/pusher.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#AddItem').click(function(e){
                e.preventDefault();
                var title = $('#title').val();
                $.ajax({
                    url:"/additem/"+title,
                    success:function(data){
                        var html = '<li class="list-group-item" idtitle="'+data+'"><a class="badge delete_Item" href="#" ><span class="glyphicon glyphicon-remove" ></span></a><span class="pull-left" id="li-title" >'+title+'</span></li>';
                        $('#itemsList').children().append(html);
                    }
                });
            });
            $( ".delete_Item" ).on("click", function(e) {
                e.preventDefault();
                var t =$(this).parent();
                $.ajax({
                    url:"/deleteitem/"+t.attr('idtitle'),
                    success:function(data){
                        t.remove();
                    }
                });
            });
            var pusher = new Pusher('537a019b559f4fed1e18', {
              cluster: 'ap1',
              encrypted: true
            });
             var channel = pusher.subscribe('todo-channel');
            channel.bind('App\\Events\\ItemCreated', function(data) {
                var html = '<li class="list-group-item" idtitle="'+data.id+'"><a class="badge delete_Item" href="#" ><span class="glyphicon glyphicon-remove" ></span></a><span class="pull-left" id="li-title" >'+data.title+'</span></li>';
                $('#itemsList').children().append(html);
            });
            channel.bind('App\\Events\\ItemDeleted', function(data) {
                  $( 'li[idtitle="' + data.id + '"' ).remove();
            });
        });
    </script>
  </body>
</html>
