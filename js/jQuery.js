$(document).ready(function() {
    $("#titleMainPage").slideDown(1000);
    $("#search").fadeIn(500);
    for (let i = 0; i < 5; i++)
        $("#"+ "suggestion" + (i+1).toString()).stop(true,true).delay(1500+i*300).fadeIn(2000);

    $('#showMore').click(function(){
        if($(this).text()=='Tampilkan lainnya')
            $(this).text('Menunjukkan kurang');
        else
            $(this).text('Tampilkan lainnya');
    });

});

function search(){
    $("#search").fadeOut(500);
}
