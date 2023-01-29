<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Railroad task</title>
</head>
<body>
    <nav class="navbar">

    </nav>
    <div class="container float-start">
        <h4>RELACIJA:</h4>
        <p class="mb-3">
            OD:<input type="text" id="source_city" class="col-md-4">
            DO:<input type="text" id="destination_city" class="col-md-4">
        </p>
        <table>
            
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script>
        $('document').ready(function () {
            $("#source_city").on('input', function() {
                let term = $("#source_city").val();
                let url = 'source-cities';
                console.log(source_city);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: url,
                    type: "POST",
                    data: { term },
                    success: function (res) {
                        console.log(res);
                    }
                
            });

            $("#destination_city").on('input', function() {
                let term = $("#destination_city").val();
                let source_city = $("#source_city").val();
                let url = 'source-cities';
                console.log(source_city);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: url,
                    type: "POST",
                    data: { term, source_city },
                    success: function (res) {
                        console.log(res);
                    }
                
                });

            });
            
        });
    </script>
</body>
</html>