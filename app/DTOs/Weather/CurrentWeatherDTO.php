<?php

namespace App\DTOs\Weather;

readonly class CurrentWeatherDTO
{
    public function __construct(
        public string $nomeCidade,
        public string $pais,
        public string $temperatura,
        public string $sensacaoTermica,
        public string $tempMinima,
        public string $tempMaxima,
        public string $umidade,
        public string $timestamp,
        public string $velocidadeVento,
        public string $descricaoCondicao,
        public string $iconCodeCondicao
    ) {}
    
    public function toArray(): array
    {
        return [
            'nome_cidade'        => $this->nomeCidade,
            'pais'               => $this->pais,
            'temperatura'        => $this->temperatura,
            'sensacao_termica'   => $this->sensacaoTermica,
            'temp_minima'        => $this->tempMinima,
            'temp_maxima'        => $this->tempMaxima,
            'umidade'            => $this->umidade,
            'timestamp'          => $this->timestamp,
            'velocidade_vento'   => $this->velocidadeVento,
            'descricao_condicao' => $this->descricaoCondicao,
            'icon_code_condicao' => $this->iconCodeCondicao,
        ];
    }
}