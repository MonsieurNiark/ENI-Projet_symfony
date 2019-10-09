$(document).ready(function () {
    console.log("jQuery est prêt !");

    $(".villeclass").change(function () {
        mafonctionchange('lieux', 'ville');
    }).trigger('change');

    function mafonctionchange(selecteur, selecteurparent) {
        $.ajax({
            url: $("#pathajax").val(),
            type: 'POST',
            data:
                {
                    id: $("select." + selecteurparent + "class option:selected").val(),
                    select: selecteur
                },
            dataType: 'json',
            success: function (reponse) {
                console.log(reponse);
                $('.lieuxclass').empty();
                $.each(reponse, function (index, element) {
                    $('.lieuxclass').append('<option value="' + element.noLieu + '" selected="selected"> ' + element.nomLieu + ' </option>');
                });
            }
        });
    }
});