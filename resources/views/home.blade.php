@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <!-- OPÇÕES DO SISTEMA  -->
                <div class="card-header">
                    <strong>{{ __('Menu do sistema') }}</strong>
                </div>
                
                <div class="card-body">
                    <div class="card">
                        <div class="card-header">
                            <strong>Consultar previsão do tempo por cidade</strong>
                        </div>

                        <div class="container">
                            <div class="row align-items-center">                                
                                <form id="form-consult" method="GET" action="{{ route('fetchWeatherData') }}">
                                    @csrf
                                    <input type="hidden" name="timestamp" id="timestamp">
                                    <div class="col-md-12 col-sm-12 my-2">
                                        <label for="select-cidade">Cidade(Cidades Brasileiras)</label>
                                        <select class="form-control input-change" id="select-cidade" name="select-cidade" required>                                        
                                            <option value="">Escolha uma Cidade</option>    
                                            @if (count($result_cidade) > 0)
                                                @foreach ($result_cidade as $cidade)
                                                    <option value="{{ $cidade->id }}">{{ $cidade->id }} - {{ $cidade->name }} - {{ $cidade->country }}</option>
                                                @endforeach
                                            @endif                                            
                                        </select>                                        
                                    </div>
                                    
                                    <div class="col-md-12 col-sm-12 my-2">
                                        <label for="select-cidade">Não encontrou sua Cidade ?</label>
                                        <input type="text" class="form-control bg-white input-change" id="other-city" name="other-city" placeholder="Digite o nome da Cidade">
                                    </div>
    
                                    <div class="col-md-5 col-sm-12 my-2">
                                        <button class="btn btn-primary w-100" id="btn-consultar">Consultar</button>
                                    </div>
                                </form>        
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary visually-hidden" id="btn-open-modal" data-bs-toggle="modal" data-bs-target="#exampleModal">Launch demo modal</button>
                
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Atenção</h5>
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

            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')

<script>
    $(document).ready(function(event){

        // DEFINIR PRIMEIRA POSIÇÃO OU VAZIO NO REFRESH PAGE
        $('#select-cidade').val('').change();
        $('#other-city').val('');

        // CONFIGURAÇÃO DO PLUGIN SELECT2
        $('#select-cidade').select2({            
            theme: 'bootstrap-5',
            width: '100%',
            "language": {
                "noResults": function(){
                    return "Nenhum registro encontrado!";

                }
            }
        });

        // VARIAVEL AUXILIAR - DEFINE SE UM CAMPO FOI ALTERADO OU NÃO
        var campo_alterado = false; 

        // MONITORA MUDANÇAS NOS INPUTS
        $('.input-change').change(function(event){
            
            // CAMPO VINDO DO EVENTO ON-CHANGE
            let campo_name = $(this).attr('name');

            if(campo_name === 'select-cidade' && !campo_alterado){
                campo_alterado = true;
                $('#other-city').val('');
                campo_alterado = false;

            };

            if(campo_name === 'other-city' && !campo_alterado){
                campo_alterado = true;
                $('#select-cidade').val('').change();
                campo_alterado = false;
            }
            
        });

        // BOTÃO PARA CONSULTAR A API
        $('#btn-consultar').click(function(event){
            event.preventDefault();

            // VERIFICA SE A CIDADE SELECIONADA OU DIGITADA E VAZIO
            if($('#select-cidade').val() != '' || $('#other-city').val() != '')
                $('#form-consult').submit();
            else                
                $('#btn-open-modal').click();
        });
        
        // Atualização do timestamp a cada 1 segundo (1000 milissegundos)
        setInterval(function(){
            $('#timestamp').val(Math.floor(Date.now() / 1000));
        }, 1000);        
    });
</script>
@endsection