<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Wind;
use App\Models\Cloud;
use Illuminate\Http\Request;
use App\Models\WeatherReport;
use App\Models\WeatherCondition;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class WeatherController extends Controller
{
    public function __construct(){
        Carbon::setLocale('pt_BR');
    }

    public function fetchWeatherData(Request $request){
        try{                            
            // TRADUÇÃO DAS CONDIÇÕES CLIMATICAS
            $translations = [
                'Clear' => 'Céu limpo',
                'Clouds' => 'Nuvens',
                'Rain' => 'Chuva',
                'Snow' => 'Neve',
                'Drizzle' => 'Garoa',
                'Thunderstorm' => 'Trovoada',
                'Mist' => 'Névoa',
                'Smoke' => 'Fumaça',
                'Haze' => 'Neblina',
                'Dust' => 'Poeira',
                'Fog' => 'Nevoeiro',
                'Sand' => 'Areia',
                'Ash' => 'Cinzas',
                'Squall' => 'Tempestade',
                'Tornado' => 'Tornado'
            ];
            
            $erros = [
                404 => 'Cidade informada não foi encontrada.',
                401 => 'Chave de API inválida. Consulte https://openweathermap.org/faq#error401 para mais informações.'
            ];
            
            // CHAVE DE ACESSO A API 
            $apiKey = config('app.OPENWEATHERMAP_API_KEY');
            
            // VARIAVEL QUE RECEBE-RA A RESPOSTA JSON
            $response = '';
            
            // SE O USUÁRIO ESCOLHEU UMA CIDADE
            if($request->filled('select-cidade')){
                $cityId = $request->input('select-cidade');
                $response = Http::get("http://api.openweathermap.org/data/2.5/weather", [
                    'id' => $cityId,
                    'appid' => $apiKey,
                    'units' => 'metric',
                    'lang' => 'pt_br'
                ]);
            }
                
            // SE O USUÁRIO DIGITOU UMA CIDADE
            if($request->filled('other-city')){
                $cityName = $request->input('other-city');
                $response = Http::get("http://api.openweathermap.org/data/2.5/weather", [
                    'q' => ($cityName . ', BR'),
                    'appid' => $apiKey,
                    'units' => 'metric',
                    'lang' => 'pt_br'
                ]);
            }
            
            // $response->successful();  // status 2xx
            // $response->failed();      // status 4xx ou 5xx
            // $response->clientError(); // status 4xx
            // $response->serverError(); // status 5xx
            // $response->status();      // código numérico (ex: 404)
            // $response->json();        // acessa o corpo da resposta JSON
            // $response->body();        // pega o conteúdo bruto (string)
            
            if($response->clientError()){
                $status = $response->status();
                $message = $erros[$status];
                
                $arrayResponse = [
                    'message' => $message
                ];
                
                return response()->json($arrayResponse, $status);
            }
            
            // VERIFICA SE TEVE SUCESSO NA REQUISIÇÃO
            if($response->successful()){
                $data = $response->json();

                // Salvar cidade
                $city = City::updateOrCreate(
                    ['id' => $data['id']],
                    [
                        'name'      => $data['name'],
                        'country'   => $data['sys']['country'],
                        'longitude' => $data['coord']['lon'],
                        'latitude'  => $data['coord']['lat']
                    ]
                );
                
                // Salvar relatório de clima
                $report = WeatherReport::create([
                    'city_id'     => $city->id,
                    'timezone'    => $data['timezone'],
                    'temperature' => $data['main']['temp'],
                    'feels_like'  => $data['main']['feels_like'],
                    'temp_min'    => $data['main']['temp_min'],
                    'temp_max'    => $data['main']['temp_max'],
                    'pressure'    => $data['main']['pressure'],
                    'humidity'    => $data['main']['humidity'],
                    'visibility'  => $data['visibility'],
                    'timestamp'   => date('Y-m-d H:i:s', ($data['dt'] + $data['timezone'])),
                    'sunrise'     => date('Y-m-d H:i:s', ($data['sys']['sunrise'] + $data['timezone'])),
                    'sunset'      => date('Y-m-d H:i:s', ($data['sys']['sunset']  + $data['timezone'])),
                ]);

                // Salvar condições climáticas
                foreach ($data['weather'] as $key => $condition) {
                    WeatherCondition::create([
                        'report_id'    => $report->id,
                        'condition_id' => $condition['id'],
                        'main'         => $translations[$condition['main']] ?? $condition['main'],
                        'description'  => $condition['description'],
                        'icon'         => $condition['icon']
                    ]);
                    
                    // Configurando os campos que seram apresentados na View a partir do JSON da API
                    $data['dt']                    = date('d/m/Y H:i:s', ($data['dt']             + $data['timezone']));
                    $data['sys']['sunset']         = date('d/m/Y H:i:s', ($data['sys']['sunset']  + $data['timezone']));
                    $data['sys']['sunrise']        = date('d/m/Y H:i:s', ($data['sys']['sunrise'] + $data['timezone']));
                    $data['weather'][$key]['main'] = $translations[$condition['main']] ?? $condition['main'];
                }

                // Salvar vento
                Wind::create([
                    'report_id' => $report->id,
                    'speed'     => $data['wind']['speed'],
                    'direction' => $data['wind']['deg']
                ]);
                
                // Salvar nuvens
                Cloud::create([
                    'report_id'  => $report->id,
                    'cloudiness' => $data['clouds']['all']
                ]);
                
                $resultado = [
                    'nome_cidade'        => $data['name'],
                    'pais'               => $data['sys']['country'],
                    'temperatura'        => number_format($data['main']['temp'], 2) . ' °C',
                    'sensacao_termica'   => number_format($data['main']['feels_like'], 2) . ' °C',
                    'temp_minima'        => number_format($data['main']['temp_min'], 2) . ' °C',
                    'temp_maxima'        => number_format($data['main']['temp_max'], 2) . ' °C',
                    'umidade'            => $data['main']['humidity'] . ' %',
                    'timestamp'          => Carbon::createFromFormat('d/m/Y H:i:s', $data['dt'])->translatedFormat('d \d\e F \d\e Y, H:i'),
                    'velocidade_vento'   => number_format($data['wind']['speed'], 2) . ' m/s',
                    'descricao_condicao' => ucfirst($data['weather'][0]['description']),
                    'icon_code_condicao' => $data['weather'][0]['icon']
                ];
                
                return response()->json($resultado, $data['cod']);
            }
        }catch(\Throwable $th){
            return response()->json(['message' => 'Falha na requisição.'], 400);
        }
    }
    
    // FUNÇÃO QUE RETORNA OS DADOS DA VIEW 'weather' E RENDERIZA O DataTables
    public function weatherData(){
        // Buscando os dados que ira popular o DataTables
        $climateReportData = WeatherReport::with(['city', 'wind', 'cloud', 'conditions'])
        ->get()
        ->sortByDesc('timestamp')
        ->flatMap(function($report){
            return $report->conditions->map(function($condition) use ($report){
                return [
                    'nome_cidade'        => $report->city->name,
                    'pais'               => $report->city->country,
                    'temperatura'        => $report->temperature .' °C',
                    'sensacao_termica'   => $report->feels_like .' °C',
                    'temp_minima'        => $report->temp_min . ' °C',
                    'temp_maxima'        => $report->temp_max . ' °C',
                    'umidade'            => $report->humidity . ' %',
                    'timestamp'          => Carbon::parse($report->timestamp)->translatedFormat('d \d\e F \d\e Y, H:i'),
                    'velocidade_vento'   => optional($report->wind)->speed . ' m/s',
                    'descricao_condicao' => ucfirst($condition->description),
                    'icon_code_condicao' => $condition->icon
                ];
            })
            ->values()
            ->all();
        });
        
        return response()->json($climateReportData, 200);
    }
}