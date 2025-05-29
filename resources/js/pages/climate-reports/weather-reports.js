// Aguarda o carregamento completo do DOM
document.addEventListener('DOMContentLoaded', function () {
    // Inicialização completa, chamar funções
    initInputs();
    initSelect2();
    handleInputSync();
    handleFormSubmission();
    closeSelectOnOutsideClick();
    handleSkeletonFormLoading();
    fetchWeatherData();
});

// Inicializa valores padrão nos inputs
function initInputs() {
    jQuery('#select-cidade').val('').change();
    jQuery('#other-city').val('');
}

// Aplica o Select2 ao campo de cidade
function initSelect2() {
    jQuery('#select-cidade').select2({
        theme: 'bootstrap-5',
        width: '100%',
        language: {
            noResults: () => "Nenhum registro encontrado!"
        }
    });
}

// Sincroniza os campos: limpa um ao preencher o outro
function handleInputSync() {
    let campo_alterado = false;

    jQuery('.input-change').change(function () {
        const campo_name = jQuery(this).attr('name');
    
        if (campo_name === 'select-cidade' && !campo_alterado) {
            campo_alterado = true;
            jQuery('#other-city').val('');
            campo_alterado = false;
        }
    
        if (campo_name === 'other-city' && !campo_alterado) {
            campo_alterado = true;
            jQuery('#select-cidade').val('').change();
            campo_alterado = false;
        }
    });
}

// Submissão do formulário via botão
function handleFormSubmission() {
    jQuery('#btn-consultar').click(async function (event) {
        event.preventDefault();

        const btn = jQuery(this);
        const originalText = btn.html();

        const cidadeSelecionada = jQuery('#select-cidade').val().trim();
        const cidadeDigitada = jQuery('#other-city').val().trim();

        if (cidadeSelecionada || cidadeDigitada) {
            btn.attr('disabled', true).addClass('d-flex align-items-center gap-2 justify-content-center').html(`
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span>Consultando...</span>
            `);

            await fetchNewWeatherData();

            btn.html(originalText).attr('disabled', false).removeClass('d-flex align-items-center gap-2 justify-content-center');
        } else {
            new bootstrap.Modal(document.getElementById('selectCityModal')).show();
        }
    });
}

// Fecha select2 ao clicar fora
function closeSelectOnOutsideClick() {
    document.addEventListener('click', function (event) {
        if (!event.target.closest('.select2-container')) {
            const select = document.querySelector('#select-cidade');
            if (select) jQuery(select).select2('close');
        }
    });
}

// Controla o skeleton de carregamento da seção de cidade
function handleSkeletonFormLoading() {
    const skeleton = document.getElementById('skeleton-form-select-city');
    const form = document.getElementById('form-select-city');

    setTimeout(() => {
        skeleton.classList.add('d-none');
        form.classList.remove('d-none');
    }, 2000);
}

// Função utilitária de espera
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

// Exibe um toast com Bootstrap
function showToast(title, message, type = 'danger') {
    const toastContainer = document.getElementById('toastContainer');

    const toastEl = document.createElement('div');
    toastEl.className = `toast align-items-center text-bg-${type} border-0 m-2`;
    toastEl.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <strong>${title}</strong>
                <hr class="m-0 p-0 bg-light">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;

    toastContainer.appendChild(toastEl);
    const bsToast = new bootstrap.Toast(toastEl, { delay: 7500 });
    bsToast.show();

    toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
}

// Cria card de skeleton
function createSkeletonCard() {
    const card = document.createElement('div');
    card.className = 'card text-white bg-primary mb-2 w-100 rounded-4';
    card.style.maxWidth = '350px';
    card.style.maxHeight = '350px';
    card.innerHTML = `
        <div class="card-body text-center">
            <h5 class="card-title"><span class="placeholder col-8 rounded-2"></span></h5>
            <hr class="bg-light">
            <h5 class="card-subtitle mb-2">
                <div><span class="placeholder col-6 rounded-2"></span></div>
                <div><span class="placeholder col-4 rounded-2"></span></div>
            </h5>
            <h3 class="my-2"><span class="placeholder col-3 rounded-2"></span></h3>
            <div class="d-flex justify-content-center align-items-center mb-3">
                <span class="placeholder col-4 me-2 rounded-2"></span>
                <span class="placeholder rounded-circle" style="width: 40px; height: 40px;"></span>
            </div>
            <div class="d-flex justify-content-around">
                <span class="placeholder col-2 rounded-2"></span>
                <span class="placeholder col-2 rounded-2"></span>
            </div>
            <div class="d-flex justify-content-around my-2">
                <span class="placeholder col-2 rounded-2"></span>
                <span class="placeholder col-1 rounded-2">/</span>
                <span class="placeholder col-2 rounded-2"></span>
            </div>
            <div class="d-flex justify-content-around">
                <span class="placeholder col-8 rounded-2"></span>
            </div>
        </div>`;
    return card;
}

// Cria card de previsão real
function createWeatherCard(item) {
    const card = document.createElement('div');
    card.className = 'card text-white bg-primary mb-2 w-100 rounded-4 shadow-lg';
    card.style.maxWidth = '350px';
    card.innerHTML = `
        <div class="card-body text-center">
            <h5 class="card-title">Previsão consultada</h5>
            <hr class="bg-light">
            <h5 class="card-subtitle mb-2">
                <div><span>${item.timestamp}</span></div>
                <div>
                    <i class="bi bi-geo-alt-fill"></i> ${item.nome_cidade}, ${item.pais}
                    <span class="ms-2">
                        <img src="https://flagcdn.com/${item.pais.toLowerCase()}.svg" width="20" alt="Flag">
                    </span>
                </div>
            </h5>
            <h3 class="my-2">${item.temperatura}</h3>
            <div class="d-flex justify-content-center align-items-center mb-3">
                <strong class="me-2">${item.descricao_condicao}</strong>
                <img src="http://openweathermap.org/img/wn/${item.icon_code_condicao}@2x.png" alt="Weather Icon" width="40">
            </div>
            <div class="d-flex justify-content-around">
                <div><i class="bi bi-droplet"></i> <span>${item.umidade}</span></div>
                <div><i class="bi bi-wind"></i> <span>${item.velocidade_vento}</span></div>
            </div>
            <div class="d-flex justify-content-around my-2">
                <div><i class="bi bi-arrow-up"></i> <span>${item.temp_maxima}</span></div>
                <span>/</span>
                <div><i class="bi bi-arrow-down"></i> <span>${item.temp_minima}</span></div>
            </div>
            <div class="d-flex justify-content-around">
                <div><i class="bi bi-snow"></i> <span>Sensação térmica de ${item.sensacao_termica}</span></div>
            </div>
        </div>`;
    return card;
}

// Consulta nova previsão
async function fetchNewWeatherData() {
    try {
        const selectValue = document.getElementById("select-cidade").value.trim();
        const inputValue = document.getElementById("other-city").value.trim();

        if (!inputValue && !selectValue) return;

        const param = inputValue
            ? `other-city=${encodeURIComponent(inputValue)}`
            : `select-cidade=${encodeURIComponent(selectValue)}`;

        const url = `http://openweather-app.local/fetchWeatherData?${param}`;
        const response = await fetch(url);
        const responseData = await response.json();

        if (!response.ok) {
            showToast('Erro', responseData.message || `Erro na requisição (${response.status})`, 'danger');
            return;
        }

        const weatherItems = Array.isArray(responseData) ? responseData : [responseData];
        if (weatherItems.length === 0) return;

        const newSkeletoTitle = document.getElementById("new-skeleto-title");
        const newH4Title = document.getElementById("new-h4-title");
        const divNewData = document.getElementById("divNewData");
        const divDivNewData = document.getElementById("divDivNewData");

        document.getElementById("hrNewData").classList.remove("d-none");
        divDivNewData.classList.remove("d-none");
        divNewData.innerHTML = "";

        newSkeletoTitle.classList.remove("d-none");
        newH4Title.classList.add("d-none");
        divNewData.appendChild(createSkeletonCard());

        await sleep(2000);

        newSkeletoTitle.classList.add("d-none");
        newH4Title.classList.remove("d-none");
        divNewData.innerHTML = "";
        divNewData.prepend(createWeatherCard(weatherItems[0]));

        showToast('Sucesso', 'Novo relatório do clima gerado com sucesso.', 'success');
        fetchWeatherData();
    } catch (error) {
        console.error('Erro ao buscar dados:', error);
        showToast('Erro', 'Erro interno do servidor.', 'danger');
    }
}

// Consulta previsões salvas
async function fetchWeatherData() {
    try {
        const response = await fetch('http://openweather-app.local/weatherData');
        const responseData = await response.json();

        if (!response.ok) {
            showToast('Erro', responseData.message || `Erro na requisição (${response.status})`, 'danger');
            return;
        }
 
        const weatherItems = Array.isArray(responseData) ? responseData : [responseData];
 
        const skeletoTitle = document.getElementById('skeleto-title');
        const h4Title = document.getElementById('h4-title');
        const containerDivData = document.getElementById('divData');

        containerDivData.innerHTML = '';
        h4Title.classList.add('d-none');

        if (weatherItems.length === 0) {
            await sleep(2000);
            skeletoTitle.classList.add('d-none');
            h4Title.textContent = 'Nenhuma informação climática registrada.';
            h4Title.classList.remove('d-none');
            showToast('Não encontrado', 'Nenhum relatório climático encontrado.', 'info');
            return;
        }

        skeletoTitle.classList.remove('d-none');
        for (let i = 0; i < weatherItems.length; i++) {
            containerDivData.appendChild(createSkeletonCard());
        }

        await sleep(2000);

        containerDivData.innerHTML = '';
        skeletoTitle.classList.add('d-none');
        h4Title.textContent = 'Últimas Previsões';
        h4Title.classList.remove('d-none');

        weatherItems.forEach(item => {
            containerDivData.appendChild(createWeatherCard(item));
        });

        showToast('Sucesso', 'Busca dos relatórios climáticos realizada com sucesso.', 'success');
    } catch (error) {
        console.error('Erro ao buscar dados:', error);
        showToast('Erro', 'Erro interno do servidor.', 'danger');
    }
}