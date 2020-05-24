$(document).ready(function () {

    //Plugins slideNav
    new SlideNav({
        activeClass: "active",
        toggleButtonSelector: false,
        toggleBoxSelector: false,
        hideAfterSelect: true,
        speed: 100,
        changeHash: false,
        navBoxToggleClass: false
    });

    //Fixed menu
    const nav = document.querySelector('.header');
    function fixNav() {
        if (window.scrollY > 0) {
            nav.classList.add('active');
        } else {
            nav.classList.remove('active');
        }
    }
    fixNav();
    window.addEventListener('scroll', fixNav);

    //Hamburger menu
    const hamburger = document.querySelector('.header__hamburger');

    hamburger.addEventListener('click', function () {
        document.querySelector('.header__nav').classList.toggle('expand');
        this.classList.toggle('active');
    });


    // Typing text in banner
    var string = "Całodobowe pogotowie bramowe 24h";
    var str = string.split("");
    var el = document.querySelector('.typing');
    (function animate() {
        str.length > 0 ? el.innerHTML += str.shift() : clearTimeout(running);
        var running = setTimeout(animate, 100);
    })();


    // Validate form
    $("#contact-form").validate({
        errorElement: 'span',
        errorPlacement: function (error, element) {
            if (element.is(":checkbox")) {
                element.closest('.form-group').append(error);
                console.log(error)
            } else {
                error.insertAfter(element);
            }
        },
        rules: {
            name: {
                required: true
            },
            email: {
                required: true
            },
            phone: {
                required: true
            },
            message: {
                required: true
            },
            check: {
                required: true
            }
        },
        messages: {
            name: 'To pole jest wymagane',
            email: 'To pole jest wymagane',
            phone: 'To pole jest wymagane',
            message: 'To pole jest wymagane',
            check: 'Proszę zaznaczyć aby kontynuować',
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    // Dynamic copyright date
    $('#year').html(new Date().getFullYear());
});