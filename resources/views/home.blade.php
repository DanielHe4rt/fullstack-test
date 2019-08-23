@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form>
                            <fieldset>
                                <legend>Pesquisar CEP</legend>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="cep" class="form-control">
                                    </div>
                                </div>
                            </fieldset>

                            <table class="table table-bordered d-none" id="cepInfo">
                                <thead>
                                <tr>
                                    <td>Chave</td>
                                    <td>Valor</td>
                                </tr>
                                </thead>
                                <tbody id="cepInfoData">

                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        function generateRow(key, value) {
            return `
                <tr>
                    <td>${key}</td>
                    <td>${value}</td>
                </tr>
            `
        }

        $(document).ready(function () {
            $("#cep").on('keyup', function () {
                let data = $(this).val();
                if (data.length < 8) {
                    return false;
                }

                $.ajax({
                    url: '{{route('cep')}}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'cep': data,
                    },
                    success: function (data) {
                        console.log(data)
                        $("#cepInfo").removeClass('d-none');
                        $("#cepInfoData").html('')
                        for (let key in data.address) {
                            $("#cepInfoData").append(generateRow(key,data.address[key]))
                        }
                        $("#cepInfoData").append(generateRow('Temperatura',data.weather.results.temp + " graus"))
                        $("#cepInfoData").append(generateRow('Status',data.weather.results.description))
                        $("#cepInfoData").append(generateRow('Velocidade do Vento',data.weather.results.wind_speedy))
                        $("#cepInfoData").append(generateRow('Umidade',data.weather.results.humidity + "%"))
                    },
                    error: function (err, xhr) {
                        $("#cepInfo").addClass('d-none');
                        console.log(err)
                    }
                });
            })
        })

    </script>
@endsection
