function savecookie() {
    Cookies.set('nom', $('#form_nom').value());
    Cookies.set('datedebut', $('#form_datedebut').value());
    Cookies.set('duree', $('#form_duree').value());
    Cookies.set('datecloture', $('#form_datecloture').value());
    Cookies.set('nbinscri', $('#form_nbinscri').value());
    Cookies.set('descri', $('#form_descri').value());
    Cookies.set('url', $('#form_url').value());
    Cookies.set('lieux', $('#form_lieux').value());
}

function displaycookie() {
    $('#form_nom').value(Cookies.get('nom'));
    $('#form_datedebut').value(Cookies.get('datedebut'));
    $('#form_duree').value(Cookies.get('duree'));
    $('#form_datecloture').value(Cookies.get('datecloture'));
    $('#form_nbinscri').value(Cookies.get('nbinscri'));
    $('#form_descri').value(Cookies.get('descri'));
    $('#form_url').value(Cookies.get('url'));
    $('#form_lieux').value(Cookies.get('lieux'));
}

function deletecookie() {
    Cookies.remove('nom');
    Cookies.remove('datedebut');
    Cookies.remove('duree');
    Cookies.remove('datecloture');
    Cookies.remove('nbinscri');
    Cookies.remove('descri');
    Cookies.remove('url');
    Cookies.remove('lieux');
}