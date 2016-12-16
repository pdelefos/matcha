function locationComplete () {
    var address_input = document.getElementById("adresse-input")
    var autocomplete = new google.maps.places.Autocomplete(address_input)
}
google.maps.event.addDomListener(window, 'load', locationComplete)