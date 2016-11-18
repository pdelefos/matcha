var text = "Matcha";

for(var i in text) { 
    $(".wavetext").append( $("<span>").text(text[i]) );
}