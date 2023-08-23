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
 *
 * @var action
 */
const ajaxLoad = (action) => 
{
    let ajax_load_div = $(".loading");

    if (action === "open") {
        ajax_load_div.fadeIn(200).css("display", "flex");
    }

    if (action === "close") {
        ajax_load_div.fadeOut(200);
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
 * redirect
 *
 * @var page
 */
const redirect = page =>
{
    window.location.href = page;
    return;
};

dd('Page: '+cPage());
