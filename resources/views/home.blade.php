@extends('layouts.app')

@section('content')
    {{-- Skeleton Form - Pre Carregador do Form Real --}}
    <div id="skeleton-form-select-city" class="placeholder-glow d-flex justify-content-center align-items-center p-4 mt-5 border border-primary rounded-2 shadow-lg mx-auto w-100" style="max-width: 750px;">
        <div class="w-100">
            <div class="mb-2">
                <span class="placeholder rounded-2 w-25"></span>
                <span class="mt-1 placeholder placeholder-lg rounded-2 w-100"></span>
            </div>
            
            <div class="mb-2">
                <span class="placeholder rounded-2 w-25"></span>
                <div class="mt-1 d-flex gap-2">
                    <span class="placeholder placeholder-lg rounded-2 w-75"></span>
                    <span class="placeholder placeholder-lg rounded-2 w-25"></button>
                </div>                
            </div>
        </div>
    </div>
    
    {{-- Form para consulta da previsão do tempo --}}
    <div id="form-select-city" class="d-none d-flex justify-content-center align-items-center p-4 mt-5 border border-primary rounded-2 shadow-lg mx-auto w-100" style="max-width: 750px;">
        <form action="{{ route('fetchWeatherData') }}" method="GET" id="form-consult" class="w-100">
            @csrf
            <div class="mb-2">
                <label for="select-cidade">Cidade(Cidades Brasileiras)</label>
                <select class="form-control input-change" id="select-cidade" name="select-cidade">
                    <option value="">Selecione uma cidade</option>
                    @if (count($result_cidade) > 0)
                        @foreach ($result_cidade as $cidade)
                            <option value="{{ $cidade->id }}">{{ $cidade->name }} - {{ $cidade->country }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="mb-2">
                <label for="other-city">Não encontrou sua Cidade ?</label>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control bg-white input-change w-100" id="other-city" name="other-city" placeholder="Pesquise uma cidade">
                    <button class="btn btn-primary w-md-25" id="btn-consultar">Consultar</button>
                </div>
            </div>
        </form>
    </div>
    
    {{-- Linha mais Card com a nova previsão consultada --}}
    <hr id="hrNewData" class="d-flex flex-column flex-md-row justify-content-center align-items-center mx-auto my-4 w-100 bg-light d-none">
    <div id="divDivNewData" class="d-flex flex-column p-4 m-2 gap-2 border border-primary rounded-2 shadow-lg mx-auto w-100 placeholder-glow d-none">
        
        <div class="d-flex justify-content-center align-items-center p-0 m-0">
            <span id="new-skeleto-title" class="placeholder placeholder-lg rounded-2 w-25"></span>            
            <h4 id="new-h4-title" class="text-center d-none">Clima em Tempo Real</h4>
        </div>        
        
        <div id="divNewData" class="d-flex flex-wrap justify-content-around align-items-center gap-2"></div>
    </div>
    
    {{-- Linha mais Card com os previsões anteriores --}}
    <hr id="hrData" class="d-flex flex-column flex-md-row justify-content-center align-items-center mx-auto my-4 w-100 bg-light">    
    <div id="divDivData" class="d-flex flex-column p-4 m-2 gap-2 border border-primary rounded-2 shadow-lg mx-auto w-100 placeholder-glow">
        <div class="d-flex justify-content-center align-items-center p-0 m-0">
            <span id="skeleto-title" class="placeholder placeholder-lg rounded-2 w-50"></span>
            <h4 id="h4-title" class="d-none"></h4>
        </div>
        
        <div id="divData" class="d-flex flex-wrap justify-content-around align-items-center gap-2"></div>
    </div>
    
    {{-- Modal de alerta para o usuário selecionar uma cidade --}}
    <div class="modal fade" id="selectCityModal" tabindex="-1" aria-labelledby="selectCityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectCityModalLabel">Atenção</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Selecione ou digite o nome de uma Cidade!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Toast Container --}}
    <div class="toast-container position-fixed bottom-0 start-0 p-2">
        <div id="toastContainer" class="toast fade show bg-white" role="alert" aria-live="assertive" aria-atomic="true"></div>
    </div>
@endsection

@section('footer')
    @vite(['resources/js/pages/climate-reports/weather-reports.js'])
@endsection