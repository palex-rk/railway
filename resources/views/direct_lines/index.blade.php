<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://code.jquery.com/jquery-3.6.3.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" ></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <title>Railroad task</title>
    <style>
        .select2-results__option { background-color: aqua;}
        .navbar {
            background-color: #333;
            color: #fff;
            display: flex;
            justify-content: start;
            align-items: center;
            height: 60px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        .select {
            width: 100%;
            height: 40px;
            font-size: 16px;
        }

        table {
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        @media (max-width: 768px) {
            .select {
                width: 80%;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding: 10px;
            }
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark mb-2">
        <a class="navbar-brand text-light" href="{{ route('index') }}">HOMEPAGE</a>
        <a class="navbar-brand text-light" href="https://www.zwebb.rs" target="blank">ZWEBB</a>
    </nav>
    <div class="container float-start">
        <h4>TRAIN SCHEDULE:</h4>
        
        <form action="{{ route('results') }}" method="POST" id="results-form">
            @csrf
            <p class="mb-3">
                <span>FROM:</span>
                <select class="col-md-3 select" id="source_city" style="width:500px;" name="source_city"></select>
                <span>TO:</span>
                <select class="col-md-3 select" id="destination_city" style="width:500px;" name="destination_city"></select>
            </p>
            <button type="button" id="form-btn" class="btn btn-info">Show data</button>
        </form>
        <table class="table table-striped">
            <th>Start</th>
            <th>Destination</th>
            <th>Termin</th>
            <tbody id="data-container">

            </tbody>
        </table>
        
    </div>
    

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}
    <script>
        $('document').ready(function () {

            let url1 = 'ajax/source-cities';
            let url2 = 'ajax/destination-cities';

            $('#source_city').select2({
       
                placeholder: 'Select starting point',
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    type: "POST",
                    url: url1,
                    dataType: 'json',
                    delay: 250,
                    minimumInputLength: 3,
                    data: function (params) {
                            var queryParameters = {
                            term: params.term
                        }

                        return queryParameters;
                    },
                    processResults: function (data) {

                        return {
                            results:  $.map(data.cities, function (city) {
                                // console.log(data, ' --> ', city);
                                return {
                                    text: city.name,
                                    id: city.id
                                }
                            })
                        }
                    },
                    // error: function () {
                    //     console.log('Call not resolved');
                    // },
                    cache: true,
                }
            });

            $('#destination_city').select2({
                placeholder: 'Select destination point',
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: url2,
                    dataType: 'json',
                    type: 'POST',
                    delay: 250,
                    data: function (params) {
                            var queryParameters = {
                            term: params.term,
                            starting_point: $("#select2-source_city-container").text()
                        }

                        return queryParameters;
                    },
                    processResults: function (data) {
                        
                        return {
                            results: $.map(data.cities, function (city) {
                        
                                return {
                                    text: city.name,
                                    id: city.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
            
            $('#form-btn').on('click', function(e) {
                e.preventDefault();
                let source_city = $('#source_city').val();
                let destination_city = $('#destination_city').val();
                console.log(source_city, destination_city);

                $.ajax({
                    url: "/results",
                    type:"POST",
                    data: {
                        _token:'{{ csrf_token() }}', 
                        "source_city": source_city, 
                        "destination_city": destination_city    
                    },
                    success:function(response){
                        var start_point = response.start_point;
                        var dest_point = response.dest_point;
                        var termins = response.termins;

                        var table = "";
                        for (var i = 0; i < termins.length; i++) {
                        table += "<tr><td>" + start_point + "</td><td>" + dest_point + "</td><td>" + termins[i].termin + "</td></tr>";
                        }

                        $('#data-container').html(table);
                    },
                    error: function(response) {
                        console.log('errors', response);
                        // $('#nameErrorMsg').text(response.responseJSON.errors.source_city);
                        // $('#emailErrorMsg').text(response.responseJSON.errors.destination_city);
                    },
                });

                console.log('after submit');
            });
        });
    </script>
</body>
</html>