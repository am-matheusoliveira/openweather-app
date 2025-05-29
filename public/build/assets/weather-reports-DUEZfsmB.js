document.addEventListener("DOMContentLoaded",function(){y(),g(),f(),b(),w(),E(),h()});function y(){jQuery("#select-cidade").val("").change(),jQuery("#other-city").val("")}function g(){jQuery("#select-cidade").select2({theme:"bootstrap-5",width:"100%",language:{noResults:()=>"Nenhum registro encontrado!"}})}function f(){let e=!1;jQuery(".input-change").change(function(){const t=jQuery(this).attr("name");t==="select-cidade"&&!e&&(e=!0,jQuery("#other-city").val(""),e=!1),t==="other-city"&&!e&&(e=!0,jQuery("#select-cidade").val("").change(),e=!1)})}function b(){jQuery("#btn-consultar").click(async function(e){e.preventDefault();const t=jQuery(this),o=t.html(),n=jQuery("#select-cidade").val().trim(),s=jQuery("#other-city").val().trim();n||s?(t.attr("disabled",!0).addClass("d-flex align-items-center gap-2 justify-content-center").html(`
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span>Consultando...</span>
            `),await x(),t.html(o).attr("disabled",!1).removeClass("d-flex align-items-center gap-2 justify-content-center")):new bootstrap.Modal(document.getElementById("selectCityModal")).show()})}function w(){document.addEventListener("click",function(e){if(!e.target.closest(".select2-container")){const t=document.querySelector("#select-cidade");t&&jQuery(t).select2("close")}})}function E(){const e=document.getElementById("skeleton-form-select-city"),t=document.getElementById("form-select-city");setTimeout(()=>{e.classList.add("d-none"),t.classList.remove("d-none")},2e3)}function r(e){return new Promise(t=>setTimeout(t,e))}function d(e,t,o="danger"){const n=document.getElementById("toastContainer"),s=document.createElement("div");s.className=`toast align-items-center text-bg-${o} border-0 m-2`,s.innerHTML=`
        <div class="d-flex">
            <div class="toast-body">
                <strong>${e}</strong>
                <hr class="m-0 p-0 bg-light">
                ${t}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `,n.appendChild(s),new bootstrap.Toast(s,{delay:7500}).show(),s.addEventListener("hidden.bs.toast",()=>s.remove())}function m(){const e=document.createElement("div");return e.className="card text-white bg-primary mb-2 w-100 rounded-4",e.style.maxWidth="350px",e.style.maxHeight="350px",e.innerHTML=`
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
        </div>`,e}function p(e){const t=document.createElement("div");return t.className="card text-white bg-primary mb-2 w-100 rounded-4 shadow-lg",t.style.maxWidth="350px",t.innerHTML=`
        <div class="card-body text-center">
            <h5 class="card-title">Previsão consultada</h5>
            <hr class="bg-light">
            <h5 class="card-subtitle mb-2">
                <div><span>${e.timestamp}</span></div>
                <div>
                    <i class="bi bi-geo-alt-fill"></i> ${e.nome_cidade}, ${e.pais}
                    <span class="ms-2">
                        <img src="https://flagcdn.com/${e.pais.toLowerCase()}.svg" width="20" alt="Flag">
                    </span>
                </div>
            </h5>
            <h3 class="my-2">${e.temperatura}</h3>
            <div class="d-flex justify-content-center align-items-center mb-3">
                <strong class="me-2">${e.descricao_condicao}</strong>
                <img src="http://openweathermap.org/img/wn/${e.icon_code_condicao}@2x.png" alt="Weather Icon" width="40">
            </div>
            <div class="d-flex justify-content-around">
                <div><i class="bi bi-droplet"></i> <span>${e.umidade}</span></div>
                <div><i class="bi bi-wind"></i> <span>${e.velocidade_vento}</span></div>
            </div>
            <div class="d-flex justify-content-around my-2">
                <div><i class="bi bi-arrow-up"></i> <span>${e.temp_maxima}</span></div>
                <span>/</span>
                <div><i class="bi bi-arrow-down"></i> <span>${e.temp_minima}</span></div>
            </div>
            <div class="d-flex justify-content-around">
                <div><i class="bi bi-snow"></i> <span>Sensação térmica de ${e.sensacao_termica}</span></div>
            </div>
        </div>`,t}async function x(){try{const e=document.getElementById("select-cidade").value.trim(),t=document.getElementById("other-city").value.trim();if(!t&&!e)return;const n=`http://openweather-app.local/fetchWeatherData?${t?`other-city=${encodeURIComponent(t)}`:`select-cidade=${encodeURIComponent(e)}`}`,s=await fetch(n),a=await s.json();if(!s.ok){d("Erro",a.message||`Erro na requisição (${s.status})`,"danger");return}const c=Array.isArray(a)?a:[a];if(c.length===0)return;const l=document.getElementById("new-skeleto-title"),u=document.getElementById("new-h4-title"),i=document.getElementById("divNewData"),v=document.getElementById("divDivNewData");document.getElementById("hrNewData").classList.remove("d-none"),v.classList.remove("d-none"),i.innerHTML="",l.classList.remove("d-none"),u.classList.add("d-none"),i.appendChild(m()),await r(2e3),l.classList.add("d-none"),u.classList.remove("d-none"),i.innerHTML="",i.prepend(p(c[0])),d("Sucesso","Novo relatório do clima gerado com sucesso.","success"),h()}catch(e){console.error("Erro ao buscar dados:",e),d("Erro","Erro interno do servidor.","danger")}}async function h(){try{const e=await fetch("http://openweather-app.local/weatherData"),t=await e.json();if(!e.ok){d("Erro",t.message||`Erro na requisição (${e.status})`,"danger");return}const o=Array.isArray(t)?t:[t],n=document.getElementById("skeleto-title"),s=document.getElementById("h4-title"),a=document.getElementById("divData");if(a.innerHTML="",s.classList.add("d-none"),o.length===0){await r(2e3),n.classList.add("d-none"),s.textContent="Nenhuma informação climática registrada.",s.classList.remove("d-none"),d("Não encontrado","Nenhum relatório climático encontrado.","info");return}n.classList.remove("d-none");for(let c=0;c<o.length;c++)a.appendChild(m());await r(2e3),a.innerHTML="",n.classList.add("d-none"),s.textContent="Últimas Previsões",s.classList.remove("d-none"),o.forEach(c=>{a.appendChild(p(c))}),d("Sucesso","Busca dos relatórios climáticos realizada com sucesso.","success")}catch(e){console.error("Erro ao buscar dados:",e),d("Erro","Erro interno do servidor.","danger")}}
