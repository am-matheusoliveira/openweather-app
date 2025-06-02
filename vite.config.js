// Importando modulos
import laravel from 'laravel-vite-plugin';
import {defineConfig, loadEnv} from 'vite';

export default defineConfig( (mode) => {
    // Carregando variáveis de ambiente com base no modo atual
    const env = loadEnv(mode, process.cwd());
    
    // Configurando e retornando o objeto de configuração
    return {
        base: env.VITE_APP_URL,
        plugins: [
            laravel({
                input: [
                    'resources/css/app.css',
                    'resources/css/globalcss/globalcss.css',
                    'resources/js/app.js',
                    'resources/js/pages/climate-reports/weather-reports.js'
                ],
                refresh: true,
            }),
        ]
    };
});