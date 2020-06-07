<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="#">
    <title>Almacenamiento de Herramientas</title>

    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="{{asset('css/materialize.min.css')}}" media="screen,projection" />

    <style>
        body {
            background-image: linear-gradient(to left bottom, #ffa000, #ff8353, #f3767e, #ca7797, #9c7a97, #907198, #806a99, #6c649b, #6256b6, #5445d0, #4130e8, #2200ff);
            color: #e0e0e0;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .myFlex {
            align-items: center;
            display: flex;
            justify-content: center;
            position: relative;
            height: 100vh;
        }
    </style>
</head>

<body>
    <div class="myFlex">
        <div style="text-align: center">
            @if($error != "")
            <div style="font-size:1.5vw; margin-bottom: 30px; color: yellow">
                Hubo un error dando de alta al id: {{ $error }}. Se está
            </div>
            @endif
            <div style="font-size:4vw; margin-bottom: 30px;">
                Esperando lectura del EPC
            </div>
            @if($waiting != "")
            <div style="font-size:2vw; margin-bottom: 30px;">
                Para el id: {{ $waiting }}
            </div>
            @endif
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-yellow-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <!-- <script src="{{asset('js/materialize.min.js')}}"></script> -->
    <script>
        $(document).ready(function() {
            ajaxSubmit();

            function ajaxSubmit() {
                $.ajax({
                    url: "{{ route('loading') }}",
                    method: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: '{{ $waiting }}',
                    },
                    success: function(result) {
                        if (result.success == 'WAITING')
                            setTimeout(ajaxSubmit, 1000)
                        else
                            location.href = '{{ url("") }}' + '/{{ $type }}/{{ $waiting }}';
                    },
                    error: function(result) {
                        alert(result.error);
                        location.href = '{{ url("") }}' + '/home';
                    }
                });
            }
        });
    </script>
</body>

</html>