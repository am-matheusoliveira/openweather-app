@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="card">

                            <div class="row card-header m-0">
                                <div class="col-sm-2 text-center">
                                    <a href="{{ url('/') }}" class="w-100 btn btn-sm btn-primary">Retornar</a>
                                </div>

                                <div class="col-sm-10 text-center">
                                    <strong>{{ __('Condições climáticas') }}</strong>
                                </div>
                            </div>

                            <!-- Icones -->
                            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </symbol>

                                <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </symbol>
                            </svg>

                            <!-- Mostrando mensagem de Feedback para o usuário -->
                            <!-- Sucesso -->
                            @if (session()->has('messageSuccess'))
                                <div class="card rounded-0">
                                    <div class="m-2 alert alert-success alert-dismissible fade show" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>                                    
                                        {{ session()->get('messageSuccess') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>                                    
                                    </div>
                                </div>
                                <!-- Tabela com os dados que veio da API -->
                                <div class="table-responsive">
                                    <span class="h5 mx-2 fw-bolder">Registro da consulta da API</span>
                                    <table class="table">
                                        <thead>
                                            <th class="col-md-custom">Cidade</th>
                                            <th class="col-md-custom">Pais</th>
                                            <th class="col-md-custom">Data e Hora</th>
                                            <th class="col-md-custom">Temperatura</th>
                                            <th class="col-md-custom">Sensação térmica</th>
                                            <th class="col-md-custom">Temp mínima</th>
                                            <th class="col-md-custom">Temp máxima</th>
                                            <th class="col-md-custom">Pressão</th>
                                            <th class="col-md-custom">Umidade</th>
                                            <th class="col-md-custom">Visibilidade</th>                                            
                                            <th class="col-md-custom">Nascer do sol</th>
                                            <th class="col-md-custom">Por do sol</th>
                                            <th class="col-md-custom">Velocidade vento</th>
                                            <th class="col-md-custom">Direção do vento</th>
                                            <th class="col-md-custom">Nebulosidade</th>
                                            <th class="col-md-custom">condição principal</th>
                                            <th class="col-md-custom">Descrição condição</th>
                                            <th class="col-md-custom">Icone condição</th>
                                        </thead>
                                        <tbody>                           
                                            <tr>
                                                <td>{{ $data['name'] }}</td>
                                                <td>{{ $data['sys']['country'] }}</td>
                                                <td>{{ $data['dt'] }}</td>                                                
                                                <td>{{ $data['main']['temp'] }} °C</td>
                                                <td>{{ $data['main']['feels_like'] }} °C</td>
                                                <td>{{ $data['main']['temp_min'] }} °C</td>
                                                <td>{{ $data['main']['temp_max'] }} °C</td>
                                                <td>{{ $data['main']['pressure'] }} hPa</td>
                                                <td>{{ $data['main']['humidity'] }} %</td>
                                                <td>{{ $data['visibility'] }} m</td>                                                                                            
                                                <td>{{ $data['sys']['sunrise'] }}</td>
                                                <td>{{ $data['sys']['sunset'] }}</td>
                                                <td>{{ $data['wind']['speed'] }} m/s</td>
                                                <td>{{ $data['wind']['deg'] }}°</td>
                                                <td>{{ $data['clouds']['all'] }} %</td>
                                                <td>{{ $data['weather'][0]['main'] }}</td>
                                                <td>{{ $data['weather'][0]['description'] }}</td>
                                                <td>
                                                    <img src="http://openweathermap.org/img/wn/{{ $data['weather'][0]['icon'] }}.png" alt="Weather Icon">
                                                </td>
                                            </tr>            
                                        </tbody>
                                  </table>
                                </div>                                
                            @endif
                            
                            <!-- Erro -->
                            @if(session()->has('messageDanger'))
                                <div class="card rounded-0">
                                    <div class="m-2 alert alert-danger alert-dismissible fade show" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                        {{ session()->get('messageDanger') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif
                            <span class="h5 mx-2 fw-bolder">Registro(s) salvos no Banco de Dados</span>
                            <table class="table table-striped w-100" id="principal-table">
                                <thead>
                                    <th class="col-md-custom">Cidade</th>
                                    <th class="col-md-custom">Pais</th>
                                    <th class="col-md-custom">Data e Hora</th>
                                    <th class="col-md-custom">Temperatura</th>
                                    <th class="col-md-custom">Sensação térmica</th>
                                    <th class="col-md-custom">Temp mínima</th>
                                    <th class="col-md-custom">Temp máxima</th>
                                    <th class="col-md-custom">Pressão</th>
                                    <th class="col-md-custom">Umidade</th>
                                    <th class="col-md-custom">Visibilidade</th>                                    
                                    <th class="col-md-custom">Nascer do sol</th>
                                    <th class="col-md-custom">Por do sol</th>
                                    <th class="col-md-custom">Velocidade do vento</th>
                                    <th class="col-md-custom">Direção do vento</th>
                                    <th class="col-md-custom">Nebulosidade</th>
                                    <th class="col-md-custom">Condição principal</th>
                                    <th class="col-md-custom">Descrição da condição</th>
                                    <th class="col-md-custom">Icone condição</th>
                                </thead>
                                <tbody>                                       
                                </tbody>
                            </table>
                        </div>                                       
                    </div>                 
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function(event){

            // CONFIGURAÇÕES DO PLUGIN: DataTables
            new DataTable('#principal-table', {
                processing: true,
                serverSide: true,
                ajax: "{{ route('weatherData') }}",
                scrollY: "70vh",
                scrollX: true,       
                scrollCollapse: true,
                paging: true,
                bInfo : false,
                columns: [
                    {data: 'nome_cidade',        name: 'nome_cidade'},
                    {data: 'pais',               name: 'pais'},
                    {data: 'timestamp',          name: 'timestamp'},
                    {data: 'temperatura',        name: 'temperatura'},
                    {data: 'sensacao_termica',   name: 'sensacao_termica'},
                    {data: 'temp_minima',        name: 'temp_minima'},
                    {data: 'temp_maxima',        name: 'temp_maxima'},
                    {data: 'pressao',            name: 'pressao'},
                    {data: 'umidade',            name: 'umidade'},
                    {data: 'visibilidade',       name: 'visibilidade'},                    
                    {data: 'nascer_do_sol',      name: 'nascer_do_sol'},
                    {data: 'por_do_sol',         name: 'por_do_sol'},
                    {data: 'velocidade_vento',   name: 'velocidade_vento'},
                    {data: 'direcao_vento',      name: 'direcao_vento'},
                    {data: 'nebulosidade',       name: 'nebulosidade'},
                    {data: 'condicao_principal', name: 'condicao_principal'},
                    {data: 'descricao_condicao', name: 'descricao_condicao'},
                    {data: 'icon_code_condicao', name: 'icon_code_condicao', 
                        render: function(data, type, row) { 
                            return '<img src="http://openweathermap.org/img/wn/'+data+'.png" alt="Weather Icon">'; }
                    },
                ],
                language: {
                    url: "{{ asset('resources/js/language-pt-br-datatables.json') }}"
                }
            });
        });
        
        // Tratamento de erros para a versão mobile
        window.addEventListener('beforeunload', function() {
            sessionStorage.setItem('lastVisited', window.location.href);
        });
        
        // Carregando o estado anterior ao dar um refresh na página 
        window.addEventListener('load', function() {
            var lastVisited = sessionStorage.getItem('lastVisited');
            if (lastVisited) {
                sessionStorage.removeItem('lastVisited');
                if (lastVisited.includes('fetchWeatherData')) {
                    window.location.href = '/openweather-app/weather';
                }
            }
        });        
    </script>   
@endsection