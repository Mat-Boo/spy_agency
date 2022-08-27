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

let margins = 20;
let heightHeaderFilters = 68;
let heightApplyFiltersBtn = 64;

//Hauteur des filtres selon la taille de l'écran
if (personItem === 'agent') {
    if (window.matchMedia("(min-width: 923px)").matches) {
        heightFilters = 520;
    } else if (window.matchMedia("(min-width: 739px)").matches) {
        heightFilters = 720;
    } else if (window.matchMedia("(min-width: 560px)").matches) {
        heightFilters = 850;
    } else if (window.matchMedia("(min-width: 0)").matches) {
        heightFilters = 900;
    }
} else {
    if (window.matchMedia("(min-width: 923px)").matches) {
        heightFilters = 520;
    } else if (window.matchMedia("(min-width: 739px)").matches) {
        heightFilters = 590;
    } else if (window.matchMedia("(min-width: 560px)").matches) {
        heightFilters = 720;
    } else if (window.matchMedia("(min-width: 0)").matches) {
        heightFilters = 760;
    }
}

//Ouverture et fermeture des 1ers filtres
openFilters = () => {
    filtersBox.style.transition = 'width ' + timeTransition + 'ms';
    filtersAndApplyBtn.style.transition = 'height ' + timeTransition + 'ms';
    chevronDownFilters.style.transition = 'transform ' + timeTransition + 'ms';
    headerFilters.style.marginLeft= 0;
    filtersBox.style.width = '90%';
    setTimeout(() => {
        filtersAndApplyBtn.style.height = heightFilters + margins + heightApplyFiltersBtn + 'px';
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

if (!emptyGet) {
    filtersBox.style.transition = 'none';
    filtersAndApplyBtn.style.transition = 'none';
    chevronDownFilters.style.transition = 'none';
    timeTransition = 0;
    openFilters();
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