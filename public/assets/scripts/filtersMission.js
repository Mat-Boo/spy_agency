let filtersTitle = document.querySelector('.filtersTitle');
let filtersAndApplyBtn = document.querySelector('.filtersAndApplyBtn');
let filtersBox = document.querySelector('.filtersBox');
let headerFilters = document.querySelector('.headerFilters');
let chevronDownFilters = document.querySelector('.chevronDownFilters');
let filtersOpened = false;
let cancelFiltersBtn = document.querySelector('.cancelFiltersBtn');
let applyFiltersBtn = document.querySelector('.applyFiltersBtn');
let filtersForm = document.querySelectorAll('.filter');
let timeTransition = 500;
let heightFilters = 0;
let heightFiltersSup = 0;
let filtersSupOpened = false;

let morefiltersBtn = document.querySelector('.morefiltersBtn');
let filtersSup = document.querySelector('.filtersSup');
let chevronDownMoreFilters = document.querySelector('.chevronDownMoreFilters');
let filterSupSelects = document.querySelectorAll('.filterSup');

let margins = 20;
let heightHeaderFilters = 68;
let heightMoreFiltersBtn = 42;
let heightApplyFiltersBtn = 64;

//Hauteur des filtres selon la taille de l'écran
if (window.matchMedia("(min-width: 1255px)").matches) {
    heightFilters = 400;
    heightFiltersSup = 203;
} else if (window.matchMedia("(min-width: 911px)").matches) {
    heightFilters = 400;
    heightFiltersSup = 420;
} else if (window.matchMedia("(min-width: 738px)").matches) {
    heightFilters = 540;
    heightFiltersSup = 420;
} else if (window.matchMedia("(min-width: 700px)").matches) {
    heightFilters = 670;
    heightFiltersSup = 420;
} else if (window.matchMedia("(min-width: 560px)").matches) {
    heightFilters = 790;
    heightFiltersSup = 870;
} else if (window.matchMedia("(min-width: 351px)").matches) {
    heightFilters = 840;
    heightFiltersSup = 870;
} else if (window.matchMedia("(min-width: 0)").matches) {
    heightFilters = 920;
    heightFiltersSup = 840;
}

//Ouverture et fermeture des 1ers filtres
openFilters = () => {
    filtersBox.style.transition = 'width ' + timeTransition + 'ms';
    filtersAndApplyBtn.style.transition = 'height ' + timeTransition + 'ms';
    chevronDownFilters.style.transition = 'transform ' + timeTransition + 'ms';
    headerFilters.style.marginLeft= 0;
    filtersBox.style.width = '90%';
    setTimeout(() => {
        filtersAndApplyBtn.style.height = heightFilters + margins + heightMoreFiltersBtn + heightApplyFiltersBtn + 'px';
        chevronDownFilters.style.transform = 'rotate(-180deg)';
        cancelFiltersBtn.style.display = 'flex';
    }, timeTransition);
    filtersOpened = true;
}

closeFilters = () => {
    filtersBox.style.transition = 'width ' + timeTransition + 'ms';
    filtersAndApplyBtn.style.transition = 'height ' + timeTransition + 'ms';
    chevronDownFilters.style.transition = 'transform ' + timeTransition + 'ms';
    filtersAndApplyBtn.style.height = 0;
    filtersSup.style.height = 0;
    chevronDownMoreFilters.style.transform = 'rotate(0)';
    filtersSupOpened = false;
    setTimeout(() => {
        cancelFiltersBtn.style.display = 'none';
        headerFilters.style.marginLeft= '35px';
        filtersBox.style.width = '150px';           
        chevronDownFilters.style.transform = 'rotate(0)';
    }, timeTransition);
    filtersOpened = false;
}

filtersTitle.addEventListener('click', () => {
    if (!filtersOpened) {
        openFilters();
    } else {
        closeFilters();
    }
})

//Ouverture et fermeture des filtres supplémentaires
openMoreFilters = () => {
    filtersSup.style.transition = 'height ' + timeTransition + 'ms';
    chevronDownMoreFilters.style.transition = 'transform ' + timeTransition + 'ms';
    filtersAndApplyBtn.style.transition = 'height ' + timeTransition + 'ms';
    filtersAndApplyBtn.style.height = heightFilters + margins + heightMoreFiltersBtn + heightApplyFiltersBtn + heightFiltersSup + 'px';
    filtersSup.style.height = heightFiltersSup + 'px';
    chevronDownMoreFilters.style.transform = 'rotate(-180deg)';
    filtersSupOpened = true;
}

closeMoreFilters = () => {
    filtersSup.style.height = 0;
    filtersAndApplyBtn.style.height = heightFilters + margins + heightMoreFiltersBtn + heightApplyFiltersBtn + 'px';
    chevronDownMoreFilters.style.transform = 'rotate(0)';
    filtersSupOpened = false;
}

morefiltersBtn.addEventListener('click', () => {
    if (!filtersSupOpened) {
        openMoreFilters();
    } else {
        closeMoreFilters();
    }
})


if (!emptyGet) {
    filtersBox.style.transition = 'none';
    filtersAndApplyBtn.style.transition = 'none';
    chevronDownFilters.style.transition = 'none';
    timeTransition = 0;
    headerFilters.style.marginLeft= 0;
    filtersBox.style.width = '90%';
    filtersAndApplyBtn.style.height = heightFilters + margins + heightMoreFiltersBtn + heightApplyFiltersBtn + 'px';
    chevronDownFilters.style.transform = 'rotate(-180deg)';
    cancelFiltersBtn.style.display = 'flex';

    filtersOpened = true;
    filterSupSelects.forEach((select) => {
        if (select.value !== '') {
            openMoreFilters();
        }
    })
    timeTransition = 500;
}


cancelFiltersBtn.addEventListener('click', () => {
    let appliedFilters = false;
    filtersForm.forEach((filterForm) => {
        if (filterForm.nodeName === 'INPUT') {
            if (filterForm.defaultChecked === true) {
                filterForm.defaultChecked = false;
                appliedFilters = true;
            }
            if (filterForm !== '') {
                filterForm.defaultValue = '';
            }

        } else if (filterForm.nodeName === 'SELECT') {
            for (let i = 0 ; i < filterForm.length ; i++) {
                if (filterForm[i].defaultSelected === true) {
                    filterForm[i].defaultSelected = false;
                    appliedFilters = true;
                }
            }
        }
    })
    if (appliedFilters) {
        filtersBox.reset();
        applyFiltersBtn.click();
    }
})