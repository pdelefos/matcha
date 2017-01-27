"use strict";

const ageSlider = document.querySelector('#age-slider');
const locationSlider = document.querySelector('#location-slider');


setSliderValues(ageSlider, 10, 80, 10, 80);
setSliderValues(locationSlider, 10, 300, 10);

function go(e) {
    const ageSliderValues = getSliderValues(ageSlider);
    let ageMin = ageSliderValues.min;
    let ageMax = ageSliderValues.max;
    const arrayByAge = usersList.filter(sortAge.bind(this, ageMin, ageMax));
    const locationSliderValue = getSliderValues(locationSlider);
    let locMax = locationSliderValue.min;
    const arrayByLoc = arrayByAge.filter(sortDistance.bind(this, locMax));
    console.log(arrayByLoc);
}

ageSlider.addEventListener('change', go);
locationSlider.addEventListener('change', go);

/*----------------------------------------------------------*\
#Sorting functions
\*----------------------------------------------------------*/

function sortAge(min, max, elem) {
    return elem.age >= min && elem.age <= max;
}

function sortDistance(locMax, elem) {
    return getDistance(currUser, elem) <= locMax;
}

/*----------------------------------------------------------*\
#Geolocator functions
\*----------------------------------------------------------*/

/**
* Get the distance in km between 2 users
* @param {object} userOrigin - Origin User
* @param {object} userDest - Destination User
* @return {Number} distance - rounded distance in km
*/
function getDistance(origUser, destUser) {
    const orig = {
        lat: origUser.latitude,
        lng: origUser.longitude
    };
    const dest = {
        lat: destUser.latitude,
        lng: destUser.longitude
    };
    const distance = geolocator.calcDistance({
        from: {
            latitude: orig.lat,
            longitude: orig.lng
        },
        to: {
            latitude: dest.lat,
            longitude: dest.lng
        },
        formula: geolocator.DistanceFormula.HAVERSINE,
        unitSystem: geolocator.UnitSystem.METRIC
    });
    return Math.round(distance);
}

/*----------------------------------------------------------*\
#Slider functions
\*----------------------------------------------------------*/

/**
* Return true if it's a slider
* @param {NodeElement} slider - slider node element
* @return {boolean} 
*/
function isSlider(slider) {
    return (slider.classList.contains('range-slider')) ? true : false;
}

/**
* Set slider default values
* @param {NodeElement} slider 
* @param {Number} max - maximum value of the slider
* @param {Number} min - minimum value of the slider
* @param {Number} defaultMin - default minimum value of the slider
* @param {Number} defaultMax - default maximum value of the slider
*/
function setSliderValues(slider, min = 0, max = 0, defaultMin = 0,
                        defaultMax = 0) {
    if (!isSlider(slider)) return ;
    const inputs = slider.querySelectorAll('input[type=range]');
    const nbInputs = inputs.length;
    inputs.forEach(input => {
        input.setAttribute('min', `${min}`);
        input.setAttribute('max', `${max}`);
    });
    inputs[0].value = defaultMin;
    if (nbInputs == 2)
        inputs[1].value = defaultMax;
}

/**
* Get slider values
* @param {NodeElement} slider - slider node element
* @return {object} value - min and max value
*/
function getSliderValues(slider) {
    if(!isSlider(slider)) return ;
    const sliderInputs = slider.querySelectorAll('input[type=range]');
    const nbSliders = sliderInputs.length;
    let min = sliderInputs[0].value;
    if (nbSliders == 2) {
        let max = sliderInputs[1].value;
        if (min > max){ var tmp = max; max = min; min = tmp; }
        return {min: `${min}`, max: `${max}`};
    }
    return {min: `${min}`};
}