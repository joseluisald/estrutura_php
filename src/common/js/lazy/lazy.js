$(document).ready(function()
{
    function lazyLoadImages() {
        $('.lazy').each(function() {
            var $img = $(this);
            if ($img.data('src')) {
                $img.attr('src', $img.data('src'));
                $img.removeAttr('data-src');
            }
        });
    }

    var options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    var imageObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                var lazyImage = entry.target;
                $(lazyImage).attr('src', $(lazyImage).data('src'));
                imageObserver.unobserve(lazyImage);
            }
        });
    }, options);

    $('.lazy').each(function() {
        imageObserver.observe(this);
    });

    lazyLoadImages();

});
