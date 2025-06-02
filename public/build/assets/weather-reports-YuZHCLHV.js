document.addEventListener("DOMContentLoaded",function(){v(),y(),g(),f(),b(),w(),p()});function v(){jQuery("#select-cidade").val("").change(),jQuery("#other-city").val("")}function y(){jQuery("#select-cidade").select2({theme:"bootstrap-5",width:"100%",placeholder:"Busque por uma cidade brasileira..",language:{errorLoading:()=>"Erro ao carregar os resultados.",noResults:()=>"Nenhum resultado encontrado",searching:()=>"Buscando..."},ajax:{url:`${APP_URL}/api/fetch/cities`,delay:150,dataType:"json",data:e=>({q:e.term}),processResults:e=>({results:e})}})}function g(){let e=!1;jQuery(".input-change").change(function(){const t=jQuery(this).attr("name");t==="select-cidade"&&!e&&(e=!0,jQuery("#other-city").val(""),e=!1),t==="other-city"&&!e&&(e=!0,jQuery("#select-cidade").val("").change(),e=!1)})}function f(){jQuery("#btn-consultar").click(async function(e){e.preventDefault();const t=jQuery(this),n=t.html(),a=(jQuery("#select-cidade").val()||"").trim(),s=(jQuery("#other-city").val()||"").trim();a||s?(t.attr("disabled",!0).addClass("d-flex align-items-center gap-2 justify-content-center").html(`
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span>Consultando...</span>
            `),await E(),t.html(n).attr("disabled",!1).removeClass("d-flex align-items-center gap-2 justify-content-center")):new bootstrap.Modal(document.getElementById("selectCityModal")).show()})}function b(){document.addEventListener("click",function(e){if(!e.target.closest(".select2-container")){const t=document.querySelector("#select-cidade");t&&jQuery(t).select2("close")}})}function w(){const e=document.getElementById("skeleton-form-select-city"),t=document.getElementById("form-select-city");setTimeout(()=>{e.classList.add("d-none"),t.classList.remove("d-none")},2e3)}function i(e){return new Promise(t=>setTimeout(t,e))}function r(e,t,n="danger"){const a=document.getElementById("toastContainer"),s=document.createElement("div");s.className=`toast align-items-center text-bg-${n} border-0 m-2`,s.innerHTML=`
        <div class="d-flex">
            <div class="toast-body">
                <strong>${e}</strong>
                <hr class="m-0 p-0 bg-light">
                ${t}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `,a.appendChild(s),new bootstrap.Toast(s,{delay:7500}).show(),s.addEventListener("hidden.bs.toast",()=>s.remove())}function u(){const e=document.createElement("div");return e.className="card text-white bg-primary mb-2 w-100 rounded-4",e.style.maxWidth="350px",e.style.maxHeight="350px",e.innerHTML=`
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
        </div>`,e}function m(e){const t=document.createElement("div");return t.className="card text-white bg-primary mb-2 w-100 rounded-4 shadow-lg",t.style.maxWidth="350px",t.innerHTML=`
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
        </div>`,t}async function E(){try{const e=document.getElementById("select-cidade").value.trim(),t=document.getElementById("other-city").value.trim();if(!t&&!e)return;const n=t?`other-city=${encodeURIComponent(t)}`:`select-cidade=${encodeURIComponent(e)}`,a=await fetch(`${APP_URL}/api/fetch/weather/current?${n}`),s=await a.json();if(!a.ok){r("Erro",s.message||`Erro na requisição (${a.status})`,"danger");return}const o=Array.isArray(s)?s:[s];if(o.length===0)return;const c=document.getElementById("new-skeleto-title"),l=document.getElementById("new-h4-title"),d=document.getElementById("divNewData"),h=document.getElementById("divDivNewData");document.getElementById("hrNewData").classList.remove("d-none"),h.classList.remove("d-none"),d.innerHTML="",c.classList.remove("d-none"),l.classList.add("d-none"),d.appendChild(u()),await i(2e3),c.classList.add("d-none"),l.classList.remove("d-none"),d.innerHTML="",d.prepend(m(o[0])),r("Sucesso","Novo relatório do clima gerado com sucesso.","success"),p()}catch(e){console.error("Erro ao buscar dados:",e),r("Erro","Erro interno do servidor.","danger")}}async function p(){try{const e=await fetch(`${APP_URL}/api/fetch/weather/reports`),t=await e.json();if(!e.ok){r("Erro",t.message||`Erro na requisição (${e.status})`,"danger");return}const n=Array.isArray(t)?t:[t],a=document.getElementById("skeleto-title"),s=document.getElementById("h4-title"),o=document.getElementById("divData");if(o.innerHTML="",s.classList.add("d-none"),n.length===0){await i(2e3),a.classList.add("d-none"),s.textContent="Nenhuma informação climática registrada.",s.classList.remove("d-none"),r("Não encontrado","Nenhum relatório climático encontrado.","info");return}a.classList.remove("d-none");for(let c=0;c<n.length;c++)o.appendChild(u());await i(2e3),o.innerHTML="",a.classList.add("d-none"),s.textContent="Últimas Previsões",s.classList.remove("d-none"),n.forEach(c=>{o.appendChild(m(c))}),r("Sucesso","Busca dos relatórios climáticos realizada com sucesso.","success")}catch(e){console.error("Erro ao buscar dados:",e),r("Erro","Erro interno do servidor.","danger")}}
