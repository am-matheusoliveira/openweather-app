import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import jQuery from "jquery";
window.jQuery = jQuery;

import select2 from 'select2';
select2();
/*
    O select2 precisa ser invocado (select2()) para inicializar no elemento, assim:
        jQuery('#meuSelect').select2();
    Isso porque select2 é um plugin do jQuery que adiciona a função select2() dentro do jQuery.fn.
    
    Quando você faz:
        import select2 from 'select2';
    E depois executa:
        select2();
    Isso registra o plugin no jQuery globalmente.
    
    Ou seja:
    Não é para usar window.select2() → ele não inicializa nada assim.
    
    O correto é: chame select2 uma vez para “ligar” no jQuery, depois só use jQuery('#elem').select2().
*/
// ou
// window.select2 = select2(); 