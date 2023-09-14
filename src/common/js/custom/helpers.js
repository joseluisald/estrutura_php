'use strict';

jQuery.event.special.touchstart = {
    setup: function( _, ns, handle ) {
        this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
    }
};
jQuery.event.special.touchmove = {
    setup: function( _, ns, handle ) {
        this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
    }
};
jQuery.event.special.wheel = {
    setup: function( _, ns, handle ){
        this.addEventListener("wheel", handle, { passive: true });
    }
};
jQuery.event.special.mousewheel = {
    setup: function( _, ns, handle ){
        this.addEventListener("mousewheel", handle, { passive: true });
    }
};

/**
 * ajaxLoad
 * @var action
 */
const ajaxLoad = (action) =>
{
    if (action === "open") {
        $(".contLoader").removeClass('off');
    }
    if (action === "close") {
        $(".contLoader").addClass('off');
    }
};

/**
 * boxLoad
 * @var action
 */
const boxLoad = (action) =>
{
    if (action === "open") {
        $(".boxLoader").addClass('ON');
    }
    if (action === "close") {
        $(".boxLoader").removeClass('ON');
    }
};

/**
 * dd
 *
 * @var param
 */
const dd = (param) =>
{
    return console.log(param);
};

/**
 * setSession
 *
 * @var param
 * @var values
 */
const setSession = (param, values) =>
{
    localStorage.setItem(param, JSON.stringify(values));
};

/**
 * getSession
 *
 * @var param
 */
const getSession = (param) => 
{
    if(localStorage.getItem(param))
        return localStorage.getItem(param);
    else
        return false;
};

/**
 * showNotify
 *
 * @var type Tipo
 * @var msg Mensagem
 * @var from De onde
 * @var align Alinhamento
 */
const showNotify = (type, msg, from = 'top', align = 'right') =>
{
    $.notify({
        icon: "fas fa-bell",
        message: msg
    }, {
        type: type,
        timer: 2000,
        placement: {
            from: from,
            align: align
        }
    });
};

/**
 * cPage
 */
const cPage = _ =>
{
    var pageNow = window.location.pathname;
    var paths = pageNow.split("/");

    if (paths.length > 1) {
        return paths[1]
    } else {
        return '';
    }
};

/**
 * cUrl
 */
const cUrl = param =>
{
    if(!isEmpty(param)) {
        return `${siteUrl}/${param}`;
    }
    return `${siteUrl}`;
}

/**
 * redirect
 *
 * @var page
 */
const redirect = page =>
{
    window.location.href = page;
    return;
};

/**
 * isEmpty
 * @var value
 */
const isEmpty = (value) =>
{
    return value === null || value === [] || value === undefined || value === "" || Object.values(value).length === 0 || value.length === 0;
}

/**
 * dateBrToUs
 * @var data
 */
function dateBrToUs(data)
{
    const parts = data.split('/');

    if (parts.length !== 3) {
        return "Formato de data inválido. Use dd/mm/yyyy.";
    }

    const day = parts[0];
    const month = parts[1];
    const year = parts[2];

    if (isNaN(day) || isNaN(month) || isNaN(year)) {
        return "Os elementos de dia, mês e ano devem ser números.";
    }

    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
}

/**
 * dateUsToBr
 * @var data
 */
function dateUsToBr(data)
{
    const parts = data.split('-');

    if (parts.length !== 3) {
        return "Formato de data inválido. Use yyyy-mm-dd.";
    }

    const day = parts[2];
    const month = parts[1];
    const year = parts[0];

    if (isNaN(day) || isNaN(month) || isNaN(year)) {
        return "Os elementos de dia, mês e ano devem ser números.";
    }

    return `${day.padStart(2, '0')}\/${month.padStart(2, '0')}\/${year}`;
}

dd('Page: '+cPage());
dd('Url: '+cUrl());
