$(document).ready(function()
{
    const systemPrefer = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    const theme = localStorage.getItem('theme') || systemPrefer;

    $('.loading').fadeOut();
    $('html').css('overflow-y', 'auto');
    $('html').attr('data-theme', theme);

    if(theme == 'dark') {
        $('#switchTheme').prop('checked', true);
        $('.iconTheme').addClass('fas fa-sun');
    }
    if(theme == 'light') {
        $('#switchTheme').prop('checked', true);
        $('.iconTheme').addClass('fas fa-moon');
    }

    $('#switchTheme').on('change', function () {
        const selectedTheme = $(this).prop('checked') ? 'dark' : 'light';
        $('html').attr('data-theme', selectedTheme);
        localStorage.setItem('theme', selectedTheme);

        if(selectedTheme == 'dark') {
            $('.iconTheme').addClass('fa-sun');
            $('.iconTheme').removeClass('fa-moon');
        }
        if(selectedTheme == 'light') {
            $('.iconTheme').addClass('fa-moon');
            $('.iconTheme').removeClass('fa-sun');
        }
    });

});

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
[...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

const openMenu = () =>
{
    $('.header--links-mobile').addClass('show');
    $('.overlay').addClass('show');
};

const closeMenu = () =>
{
    $('.header--links-mobile').removeClass('show');
    $('.overlay').removeClass('show');
};