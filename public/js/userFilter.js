"use strict";

const spooky = document.querySelector('#spooky');
spooky.remove();




/*----------------------------------------------------------*\
#Filter User
\*----------------------------------------------------------*/

const ageSlider = document.querySelector('#age-slider');
const locationSlider = document.querySelector('#location-slider');
const scoreSlider = document.querySelector('#score-slider');
const interetSlider = document.querySelector('#interet-slider');
const sortBySelect = document.querySelector('.sort');

setSliderValues(ageSlider, 10, 80, 10, 80);
setSliderValues(locationSlider, 10, 300, 10);
setSliderValues(scoreSlider, 0, 100, 0, 100);
setSliderValues(interetSlider, 0, 5, 0);

function filterSort(e) {
    //age
    const ageSliderValues = getSliderValues(ageSlider);
    let ageMin = ageSliderValues.min;
    let ageMax = ageSliderValues.max;
    const arrayByAge = usersList.filter(filterAge.bind(this, ageMin, ageMax));

    //distance
    const locationSliderValue = getSliderValues(locationSlider);
    let locMax = locationSliderValue.min;
    const arrayByLoc = arrayByAge.filter(filterDistance.bind(this, locMax));

    //score
    const scoreSliderValues = getSliderValues(scoreSlider);
    let scoreMin = scoreSliderValues.min;
    let scoreMax = scoreSliderValues.max;
    const arrayByScore = arrayByLoc.filter(filterScore.bind(this, scoreMin, 
        scoreMax));

    //interets
    const interetSliderValue = getSliderValues(interetSlider);
    let interetsMax = interetSliderValue.min;
    const arrayByInterets = arrayByScore.filter(filterInterets.bind(this, 
        interetsMax))

    const sortBy = sortBySelect.value.toString();
    var paka;
    switch (sortBy) {
        case 'age':
            paka = arrayByInterets.sort(sortAgeAsc);
            break;
        case 'distance':
            paka = arrayByInterets.sort(sortDistanceAsc);
            break;
        case 'score':
            paka = arrayByInterets.sort(sortScoreAsc);
            break;
        case 'interets':
            paka = arrayByInterets.sort(sortInterestAsc);
            break;
        default:
            break;
    }
    console.log(paka);
}

ageSlider.addEventListener('change', filterSort);
locationSlider.addEventListener('change', filterSort);
scoreSlider.addEventListener('change', filterSort);
interetSlider.addEventListener('change', filterSort);
sortBySelect.addEventListener('change', filterSort);

/*----------------------------------------------------------*\
#Sort functions
\*----------------------------------------------------------*/

function sortAgeAsc(elemA, elemB) {
    return elemA.age > elemB.age ? 1 : -1;
}

function sortAgeDesc(elemA, elemB) {
    return elemA.age > elemB.age ? -1 : 1;
}

function sortDistanceAsc(elemA, elemB) {
    return elemA.distance > elemB.distance ? 1 : -1;
}

function sortDistanceDesc(elemA, elemB) {
    return elemA.distance > elemB.distance ? -1 : 1;
}

function sortScoreAsc(elemA, elemB) {
    return elemA.score > elemB.score ? 1 : -1;
}

function sortScoreDesc(elemA, elemB) {
    return elemA.score > elemB.score ? -1 : 1;
}

function sortInterestAsc(elemA, elemB) {
    return elemA.nbInteretsCom > elemB.getNbInteretsCom ? 1 : -1;
}

function sortInterestDesc(elemA, elemB) {
    return elemA.nbInteretsCom > elemB.getNbInteretsCom ? -1 : 1;
}

/*----------------------------------------------------------*\
#Filter functions
\*----------------------------------------------------------*/

function filterAge(min, max, elem) {
    return elem.age >= min && elem.age <= max;
}

function filterDistance(locMax, elem) {
    return getDistance(currUser, elem) <= locMax;
}

function filterScore(min, max, elem) {
    return elem.score >= min && elem.score <= max;
}

function filterInterets(nbInteretsMax, elem) {
    return getNbInteretsCom(currUser, elem) >= nbInteretsMax;
}

/*----------------------------------------------------------*\
#Interests functions
\*----------------------------------------------------------*/

/**
* Get the number of interest in common between 2 users
* @param {object} userOrigin - Origin User
* @param {object} userDest - Destination User
* @return {Number} distance - rounded distance in km
*/
function getNbInteretsCom(origUser, destUser) {
    var nbInteretsCom = 0;
    origUser.interets.forEach(origInteret => {
        destUser.interets.forEach(destInteret => {
            if (origInteret === destInteret)
                nbInteretsCom++;
        });
    });
    destUser.nbInteretsCom = nbInteretsCom;
    return nbInteretsCom;
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
    const distance = Math.round(geolocator.calcDistance({
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
    }));
    destUser.distance = distance;
    return distance;
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