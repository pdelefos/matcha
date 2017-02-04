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
const orderRadioList = document.querySelectorAll('.custom-radio ul input');
const displayUsers = document.querySelector('.user-list');

init();

function init() {
    // Order default value
    setOrderDefault(orderRadioList, 'asc');
    // Age init
    const initAgeValues = initAge(usersList);
    setSliderValues(ageSlider, initAgeValues.min, initAgeValues.max, 
        initAgeValues.min, initAgeValues.max);
    // Location init
    const initLocValues = initLocation(usersList);
    setSliderValues(locationSlider, initLocValues.min, initLocValues.max, 
        initLocValues.max);
    // Score init
    const initScoreValues = initScore(usersList);
    setSliderValues(scoreSlider, initScoreValues.min, initScoreValues.max,
        initScoreValues.min, initScoreValues.max);
    // Interets init
    const initInteretsValues = initInterets(usersList);
    setSliderValues(interetSlider, interetSlider.min, initInteretsValues.max, 
        initInteretsValues.min);
    // sort init
    let finalArray = usersList;
    const sortBy = sortBySelect.value.toString();
    const sortOrder = getOrderValue(orderRadioList);
    if (sortOrder == 'desc')
        finalArray = sortDesc(usersList, sortBy);
    else
        finalArray = sortAsc(usersList, sortBy);
    
    if (mmr == 1) 
        finalArray = mmrSort(finalArray);

    populateList(finalArray, displayUsers);
}

function mmrSort(array = []) {
    array.forEach(user => {
        user.mmr = Math.round((user.distance * -5 + user.score * 4 + user.nbInteretsCom * 3) / 12);
    })
    array.sort((elemA, elemB) => {
        if (elemA.mmr > elemB.mmr)
            return -1;
        else
            return 1;
    });
    return array;
}



function filterSort(e) {
    //age
    const ageSliderValues = getSliderValues(ageSlider);
    let ageMin = ageSliderValues.min;
    let ageMax = ageSliderValues.max;
    const arrayByAge = usersList.filter(filterAge
        .bind(this, ageMin, ageMax));

    //distance
    const locationSliderValue = getSliderValues(locationSlider);
    let locMax = locationSliderValue.min;
    const arrayByLoc = arrayByAge.filter(filterDistance
        .bind(this, locMax));

    //score
    const scoreSliderValues = getSliderValues(scoreSlider);
    let scoreMin = scoreSliderValues.min;
    let scoreMax = scoreSliderValues.max;
    const arrayByScore = arrayByLoc.filter(filterScore
        .bind(this, scoreMin, scoreMax));

    //interets
    const interetSliderValue = getSliderValues(interetSlider);
    let interetsMax = interetSliderValue.min;
    const arrayByInterets = arrayByScore.filter(filterInterets
        .bind(this, interetsMax))

    let finalArray = arrayByInterets;
    const sortBy = sortBySelect.value.toString();
    const sortOrder = getOrderValue(orderRadioList);
    if (sortOrder == 'desc')
        finalArray = sortDesc(arrayByInterets, sortBy);
    else
        finalArray = sortAsc(arrayByInterets, sortBy);
    populateList(finalArray, displayUsers);
}

ageSlider.addEventListener('change', filterSort);
locationSlider.addEventListener('change', filterSort);
scoreSlider.addEventListener('change', filterSort);
interetSlider.addEventListener('change', filterSort);
sortBySelect.addEventListener('change', filterSort);
orderRadioList.forEach(elem => elem.addEventListener('change', filterSort));
// ageSlider.addEventListener('mousemove', filterSort);
// locationSlider.addEventListener('mousemove', filterSort);
// scoreSlider.addEventListener('mousemove', filterSort);
// interetSlider.addEventListener('mousemove', filterSort);
// sortBySelect.addEventListener('mousemove', filterSort);
// orderRadioList.forEach(elem => elem.addEventListener('mousemove',
    // filterSort));

function populateList(users = [], usersList) {
    if (users.length == 0){
        usersList.innerHTML = 'aucun résultat';
        return;
    }
    usersList.innerHTML = users.map((user, i) => {
        if (user.avatar == null) user.avatar = '';
        return `
            <a href="${rootPath}/profil/user/${user.login}" class="user-link">
            <li class="user-item">
                <img src="${user.avatar}" alt="" class="user-item__pic">
                <div class="user-item__login">${user.login}</div>
                 <div class="user-item__row">
                    <div class="user-item-age user-item-info">
                        Age : ${user.age} ans
                    </div>
                    <div class="user-item-loca user-item-info">
                        Distance : ${user.distance} km
                    </div>
                 </div>
                 <div class="user-item__row">
                     <div class="user-item-score user-item-info">
                        Score : ${user.score} pts
                     </div>
                     <div class="user-item-interets user-item-info">
                        Interets en commun : ${user.nbInteretsCom} 
                     </div>
                 </div>
            </li>
            </a>
        `;
    }).join('');
}

/*----------------------------------------------------------*\
#Init functions
\*----------------------------------------------------------*/

function initAge(array = []) {
    let ageMin = parseFloat(Math.min.apply(null, array.map(elem => elem.age)));
    let ageMax = parseFloat(Math.max.apply(null, array.map(elem => elem.age)));
    ageMin =  (ageMin == Infinity) ? 0 : ageMin;
    ageMax =  (ageMax == -Infinity) ? 0 : ageMax;
    return {min: `${ageMin}`, max: `${ageMax}`};
}

function initLocation(array = []) {
    array.forEach(elem => {
        getDistance(currUser, elem);
    });
    let ageMin = parseFloat(Math.min.apply(null, array
        .map(elem => elem.distance)));
    let ageMax = parseFloat(Math.max.apply(null, array
        .map(elem => elem.distance)));
    ageMin =  (ageMin == Infinity) ? 0 : ageMin;
    ageMax =  (ageMax == -Infinity) ? 0 : ageMax;
    return {min: `${ageMin}`, max: `${ageMax}`};
}

function initScore(array = []) {
    let scoreMin = parseFloat(Math.min.apply(null, array
        .map(elem => elem.score)));
    let scoreMax = parseFloat(Math.max.apply(null, array
        .map(elem => elem.score)));
    scoreMin =  (scoreMin == Infinity) ? 0 : scoreMin;
    scoreMax =  (scoreMax == -Infinity) ? 0 : scoreMax;
    return {min: `${scoreMin}`, max: `${scoreMax}`};
}

function initInterets(array = []) {
    array.forEach(elem => {
        getNbInteretsCom(currUser, elem);
    });
    let interetsMin = parseFloat(Math.min.apply(null, array
        .map(elem => elem.nbInteretsCom)));
    let interetsMax = parseFloat(Math.max.apply(null, array
        .map(elem => elem.nbInteretsCom)));
    interetsMin =  (interetsMin == Infinity) ? 0 : interetsMin;
    interetsMax =  (interetsMax == -Infinity) ? 0 : interetsMax;
    return {min: `${interetsMin}`, max: `${interetsMax}`};
}

/*----------------------------------------------------------*\
#Sort functions
\*----------------------------------------------------------*/

function sortAsc(array = [], sortBy) {
    switch (sortBy) {
        case 'age':
            return (array.sort(sortAgeAsc));
        case 'distance':
            return (array.sort(sortDistanceAsc));
        case 'score':
            return (array.sort(sortScoreAsc));
        case 'interets':
            return (array.sort(sortInterestAsc));
        default:
            break;
    }
}

function sortDesc(array = [], sortBy) {
    switch (sortBy) {
        case 'age':
            return (array.sort(sortAgeDesc));
        case 'distance':
            return (array.sort(sortDistanceDesc));
        case 'score':
            return (array.sort(sortScoreDesc));
        case 'interets':
            return (array.sort(sortInterestDesc));
        default:
            break;
    }
}

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

function setOrderDefault(radioList = [], defaultValue = '') {
    radioList.forEach(elem => {
        if (elem.value == defaultValue)
            elem.checked = true;
    });
}

function getOrderValue(radioList = []) {
    let value;
    radioList.forEach(elem => {
        if (elem.checked)
            value = elem.value;
    });
    return value;
};

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