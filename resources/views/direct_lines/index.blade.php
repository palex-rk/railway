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
    </style>
</head>
<body>
    <nav class="navbar">

    </nav>
    <div class="container float-start">
        <h4>RELATIONS:</h4>
        
        <form action="{{ route('results') }}" method="POST" id="results-form">
        <p class="mb-3">
            FROM:
            <select class="col-md-3 select" id="source_city" style="width:500px;" name="source_city"></select>
            TO:
            <select class="col-md-3 select" id="destination_city" style="width:500px;" name="destination_city"></select>
        </p>
            @csrf
            <button type="submit" id="form-btn" class="btn btn-info">Show data</button>
        </form>
        
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
            
            $('#form-btn').on('click', function() {
                $source = $('#source_city').value;
                $dest = $('#destination_city').value;
                $('#results-form').submit();
            });
        });
    </script>
</body>
</html>