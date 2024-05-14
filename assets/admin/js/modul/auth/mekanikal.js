$(function () {
    var login_page = document.getElementById('login_page');
    var regis_page = document.getElementById('regis_page');
    var forgot_page = document.getElementById('forgot_page');
    var vector_login = document.getElementById('vector_login');
    var vector_regis = document.getElementById('vector_regis');
    var vector_forgot = document.getElementById('vector_forgot');

    var get = url_get();

    $('.to_regis').on('click', function () {
        params = '';
        if (get.length > 0) {
            if (get[0].split('=')[0] == 'fcm_key') {
                params += '?' + get[0].split('=')[0] + '=' + get[0].split('=')[1];
                params += '&';
            } else {
                params += '?';
            }

        } else {
            params += '?';
        }
        params += 'tab=regis';
        window.history.pushState('regis_page', 'Pendaftaran Relawan', BASE_URL + 'auth' + params);
        login_page.classList.remove('showing');
        login_page.classList.add('hiding');
        forgot_page.classList.remove('showing');
        forgot_page.classList.add('hiding');
        regis_page.classList.add('showing');
        regis_page.classList.remove('hiding');
        vector_login.classList.add('hidin');
        vector_login.classList.remove('showin');
        vector_forgot.classList.add('hidin');
        vector_forgot.classList.remove('showin');
        vector_regis.classList.add('showin');
        vector_regis.classList.remove('hidin');
    })

    $('.to_login').on('click', function () {
        params = '';
        if (get.length > 0) {
            if (get[0].split('=')[0] == 'fcm_key') {
                params += '?' + get[0].split('=')[0] + '=' + get[0].split('=')[1];
                params += '&';
            } else {
                params += '?';
            }

        } else {
            params += '?';
        }
        params += 'tab=login';
        window.history.pushState('login_page', 'Masuk', BASE_URL + 'auth' + params);
        login_page.classList.add('showing');
        login_page.classList.remove('hiding');
        forgot_page.classList.remove('showing');
        forgot_page.classList.add('hiding');
        regis_page.classList.remove('showing');
        regis_page.classList.add('hiding');
        vector_login.classList.remove('hidin');
        vector_login.classList.add('showin');
        vector_forgot.classList.add('hidin');
        vector_forgot.classList.remove('showin');
        vector_regis.classList.remove('showin');
        vector_regis.classList.add('hidin');
    })

    $('.to_forgot').on('click', function () {
        params = '';
        if (get.length > 0) {
            if (get[0].split('=')[0] == 'fcm_key') {
                params += '?' + get[0].split('=')[0] + '=' + get[0].split('=')[1];
                params += '&';
            } else {
                params += '?';
            }

        } else {
            params += '?';
        }
        params += 'tab=forgot';
        window.history.pushState('forgot_page', 'Lupa kata sandi', BASE_URL + 'auth' + params);
        login_page.classList.remove('showing');
        login_page.classList.add('hiding');
        forgot_page.classList.add('showing');
        forgot_page.classList.remove('hiding');
        regis_page.classList.remove('showing');
        regis_page.classList.add('hiding');
        vector_login.classList.add('hidin');
        vector_login.classList.remove('showin');
        vector_forgot.classList.remove('hidin');
        vector_forgot.classList.add('showin');
        vector_regis.classList.remove('showin');
        vector_regis.classList.add('hidin');
    })



})
