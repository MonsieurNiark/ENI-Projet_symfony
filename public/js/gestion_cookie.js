function savecookie() {
    Cookies.set('nom', $('#sortie_nom').val());
    Cookies.set('datedebut', $('#sortie_datedebut').val());
    Cookies.set('duree', $('#sortie_duree').val());
    Cookies.set('datecloture', $('#sortie_datecloture').val());
    Cookies.set('nbinscri', $('#sortie_nbinscriptionsmax').val());
    Cookies.set('descri', $('#sortie_descriptioninfos').val());
    Cookies.set('url', $('#sortie_urlphoto').val());
}

function displaycookie() {
    $('#sortie_nom').val(Cookies.get('nom'));
    $('#sortie_datedebut').val(Cookies.get('datedebut'));
    $('#sortie_duree').val(Cookies.get('duree'));
    $('#sortie_datecloture').val(Cookies.get('datecloture'));
    $('#sortie_nbinscriptionsmax').val(Cookies.get('nbinscri'));
    $('#sortie_descriptioninfos').val(Cookies.get('descri'));
    $('#sortie_urlphoto').val(Cookies.get('url'));
}

function deletecookie() {
    Cookies.remove('nom');
    Cookies.remove('datedebut');
    Cookies.remove('duree');
    Cookies.remove('datecloture');
    Cookies.remove('nbinscri');
    Cookies.remove('descri');
    Cookies.remove('url');
}