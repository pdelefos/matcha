"use strict";

const ageSlider = document.querySelector('#age-slider');

setSliderValues(ageSlider, 10, 80, 10, 80);

function sortAge(min, max, elem) {
    return elem.age >= min && elem.age <= max;
}

function go(e) {
    const ageSliderValues = getSliderValues(ageSlider);
    let min = ageSliderValues.min;
    let max = ageSliderValues.max;
    const array = usersList.filter(sortAge.bind(this, min, max));
    console.log(array);
}

ageSlider.addEventListener('change', go);

/**
* Get the distance in km between 2 users
* @param {object} userOrigin
* @param {object} userDest
* @return {Number} rounded distance
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
    console.log(usersList[0]);
    return Math.round(distance);
}

getDistance(usersList[0], usersList[1]);
/*----------------------------------------------------------*\
#Slider functions
\*----------------------------------------------------------*/

/**
* Return true if it's a slider
* @param {NodeElement} slider 
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
    inputs.forEach(input => {
        input.setAttribute('min', `${min}`);
        input.setAttribute('max', `${max}`);
    });
    inputs[0].value = defaultMin;
    inputs[1].value = defaultMax;
}

/**
* Get slider values
* @param {NodeElement} slider 
* @return {object} min and max value
*/
function getSliderValues(slider) {
    if(!isSlider(slider)) return ;
    const sliderInputs = slider.querySelectorAll('input[type=range]');
    let min = sliderInputs[0].value;
    let max = sliderInputs[1].value;
    if (min > max){ var tmp = max; max = min; min = tmp; }
    return {min: `${min}`, max: `${max}`};        
}