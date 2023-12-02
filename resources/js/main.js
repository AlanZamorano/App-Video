import $ from 'jquery';

var url = 'http://www.videos.local/';

$(document).ready(function() {
    $('.bi-hand-thumbs-up, .bi-hand-thumbs-up-fill').css('cursor', 'pointer');
    $('.bi-hand-thumbs-down, .bi-hand-thumbs-down-fill').css('cursor', 'pointer');

    function like() {
        $('.bi-hand-thumbs-up').unbind('click').click(function() {
            console.log('Like');
            $(this).removeClass('bi-hand-thumbs-up').addClass('bi-hand-thumbs-up-fill click-b');

            $.ajax({
                url: url+'reaccion/like/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    console.log(response);
                }
            });

            // Elimina el evento click de "No me gusta"
            $('.bi-hand-thumbs-up-fill.click-b').unbind('click');
            // Vuelve a agregar el evento click de "No me gusta"
            borrarLike();
        });
    }
    like();

    // Cambiar color de botón No me gusta al hacer clic
    function borrarLike() {
        $('.bi-hand-thumbs-up-fill.click-b').unbind('click').click(function() {
            console.log('Like borrado');
            $(this).removeClass('bi-hand-thumbs-up-fill click-b').addClass('bi-hand-thumbs-up');

            $.ajax({
                url: url+'reaccion/borrar-like/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    console.log(response);
                }
            });

            // Elimina el evento click de "Me gusta"
            $('.bi-hand-thumbs-up').unbind('click');
            // Vuelve a agregar el evento click de "Me gusta"
            like();
        });
    }
    borrarLike();


    // no me gusta
    function dislike() {
        $('.bi-hand-thumbs-down').unbind('click').click(function() {
            console.log('Dislike');
            $(this).removeClass('bi-hand-thumbs-down').addClass('bi-hand-thumbs-down-fill click');

            $.ajax({
                url: url+'reaccion/dislike/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    console.log(response);
                }
            });

            // Elimina el evento click de "No me gusta"
            $('.bi-hand-thumbs-down-fill.click').unbind('click');
            // Vuelve a agregar el evento click de "No me gusta"
            borrarDislike();
        });
    }
    dislike();

    // Cambiar color de botón No me gusta al hacer clic
    function borrarDislike() {
        $('.bi-hand-thumbs-down-fill.click').unbind('click').click(function() {
            console.log('dislike');
            $(this).removeClass('bi-hand-thumbs-down-fill click').addClass('bi-hand-thumbs-down');

            $.ajax({
                url: url+'reaccion/borrar-dislike/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    console.log(response);
                }
            });

            // Elimina el evento click de "Me gusta"
            $('.bi-hand-thumbs-down').unbind('click');
            // Vuelve a agregar el evento click de "Me gusta"
            dislike();
        });
    }
    borrarDislike();


    $('#buscador').submit(function(){
      $(this).attr('action', url+'canales/'+$('#buscador #search').val());
    });
});



