<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\City;
use App\Models\WeatherReport;
use App\Models\WeatherCondition;
use App\Models\Wind;
use App\Models\Cloud;
use Yajra\DataTables\Facades\DataTables;

class WeatherController extends Controller
{
    public function fetchWeatherData(Request $request)
    {
        // Comparando o campo que veio do formulário com o valor salvo na sessão
        if (session()->get('timestamp') === $request->input('timestamp')) {

            // Retornando para a view que lista as condições climáticas
            return redirect()->route('weather');

        }else{

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
                'Tornado' => 'Tornado',
            ];

            // CHAVE DE ACESSO A API 
            $apiKey = '4f3124d762673f41dd1032b718b0ea83';

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
                    'q' => $cityName,
                    'appid' => $apiKey,
                    'units' => 'metric',
                    'lang' => 'pt_br'
                ]);   
            }
            
            // Salvando o timestamp em uma sessão para comparação - impedir o reenvio do mesmo formulário
            session()->put('timestamp', $request->input('timestamp'));

            // VERIFICA SE TEVE SUCESSO NA REQUISIÇÃO
            if ($response->successful()) {
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

                return redirect()->route('weather')->with(['messageSuccess' => 'Dados salvos com sucesso!', 'weatherData' => $data]);            
            }

            return redirect()->route('weather')->with(['messageDanger' => 'Erro ao consultar a API.']);
        }
    }
    
    // Retorna para a view de listagem dos Dados climáticas
    public function weather(){
        
        // Retorna para a view com os dados acima
        return view('weather', ['data' => session('weatherData')]);
    }

    // FUNÇÃO QUE RETORNA OS DADOS DA VIEW 'weather' E RENDERIZA O DataTables
    public function weatherData(Request $request){    

        if ($request->ajax()) {
            
            // Buscando os dados que ira popular o DataTables
            $result_weather = WeatherReport::with(['city', 'wind', 'cloud', 'conditions'])
            ->get()
            ->flatMap(function($report) {
                return $report->conditions->map(function($condition) use ($report) {
                    return [
                        'nome_cidade' => $report->city->name,
                        'pais' => $report->city->country,
                        'temperatura' => $report->temperature .' °C',
                        'sensacao_termica' => $report->feels_like .' °C',
                        'temp_minima' => $report->temp_min . ' °C',
                        'temp_maxima' => $report->temp_max . ' °C',
                        'pressao' => $report->pressure . ' hPa',
                        'umidade' => $report->humidity . ' %',
                        'visibilidade' => $report->visibility . ' m',
                        'timestamp'     => date('d/m/Y H:i:s', strtotime($report->timestamp)),
                        'nascer_do_sol' => date('d/m/Y H:i:s', strtotime($report->sunrise)),
                        'por_do_sol'    => date('d/m/Y H:i:s', strtotime($report->sunset)),
                        'velocidade_vento' => optional($report->wind)->speed . ' m/s',
                        'direcao_vento' => optional($report->wind)->direction . ' °',
                        'nebulosidade' => optional($report->cloud)->cloudiness . ' %',
                        'condicao_principal' => $condition->main,
                        'descricao_condicao' => $condition->description,
                        'icon_code_condicao' => $condition->icon,
                    ];
                })->all();
            });

            // Retornando o componente populado
            return Datatables::of($result_weather)->make(true);
        }
    }
}