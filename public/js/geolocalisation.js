const geo = navigator.geolocation

function setAdresse(adresse) {
    document.getElementById("adresse-input").value = adresse
}

function getAdresse(latitude, longitude) {
    latlng = latitude + "," + longitude
    const googleapi = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + latlng
    $.getJSON(googleapi, function(data, textStatus) {
        const adresse = data['results'][0].formatted_address
        setAdresse(adresse)
    })
}

function getLatLng() {
    $.getJSON('//freegeoip.net/json/?callback=?', function(data) {
        const adresse = data.city + ", " + data.region_name + ", " + data.country_name
        setAdresse(adresse)
    });
}

function success(objPosition) {
    const lat = objPosition.coords.latitude
    const lng = objPosition.coords.longitude
    getAdresse(lat, lng)
}

function error(objErreur) {
    var strErreur = ''
    switch(objErreur.code) {
        case objErreur.PERMISSION_DENIED:
            getLatLng()
            break
        case objErreur.TIMEOUT:
        case objErreur.POSITION_UNAVAILABLE:
            strErreur = "Votre position n'a pas pu être déterminé."
            break
        default:
            strErreur = "Erreur inconnue."
            break
    }
    console.log(strErreur)
}

var options = {
    timeout: 5000,
    enableHighAccuracy: true,
    maximumAge: 0
}

$('#localize-me').click(function () {
    geo.getCurrentPosition(success, error, options)   
})