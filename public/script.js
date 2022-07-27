let filtersTitle = document.querySelector('.filtersTitle');
let filtersAndApplyBtn = document.querySelector('.filtersAndApplyBtn');
let filtersBox = document.querySelector('.filtersBox');
let chevronDownFilters = document.querySelector('.chevronDownFilters');
let filtersOpened = false;
let cancelFilters = document.querySelector('.cancelFilters');
let filtersForm = document.querySelectorAll('.filter');

filtersTitle.addEventListener('click', () => {
    if (!filtersOpened) {
        filtersBox.style.width = 'calc(100% - 140px)';
        setTimeout(() => {
            filtersAndApplyBtn.style.height = '440px';
            chevronDownFilters.style.transform = 'rotate(-180deg)';
            cancelFilters.style.display = 'flex';
        }, 500);
        filtersOpened = true;
    } else {
        filtersAndApplyBtn.style.height = 0;
        setTimeout(() => {
            cancelFilters.style.display = 'none';
            filtersBox.style.width = '125px';           
            chevronDownFilters.style.transform = 'rotate(0)';
        }, 500);
        filtersOpened = false;
    }
})

cancelFilters.addEventListener('click', () => {
    console.log(filtersForm);
    filtersForm.forEach((filterForm) => {
        if (filterForm.localName = 'input') {
            filterForm.value = '';
            filterForm.checked = false;
        } else if (filterForm.localName = 'select') {
            filterForm.value = 'Assassinat';
            filterForm.value = '';
        }
    })
})


let detailsBtn = document.querySelectorAll('.detailsBtn');
let detailsInfos = document.querySelectorAll('.detailsInfos');
let chevronDownDetails = document.querySelectorAll('.chevronDownDetails');
let missionOpened = [];

for (let i = 0 ; i < detailsBtn.length ; i++) {
    detailsBtn[i].addEventListener('click', (e) => {
        if (!missionOpened[i]) {
            detailsBtn[i].parentNode.style.width = '610px';
            let heightDetails = 0;
            setTimeout(() => {
                for (let child of detailsInfos[i].children) {
                    heightDetails += child.offsetHeight;
                }
                detailsInfos[i].style.height = heightDetails + detailsInfos[i].children.length * 10 + 10 +'px';
                detailsBtn[i].style.borderBottom = 'solid 1px white'
                chevronDownDetails[i].style.transform = 'rotate(-180deg)';
            }, 500);
            missionOpened[i] = true
        } else {
            detailsInfos[i].style.height = '0';
            setTimeout(() => {
                detailsBtn[i].style.width = '100%';
                detailsBtn[i].parentNode.style.width = '100px';
                detailsBtn[i].style.borderBottom = 'none';
                chevronDownDetails[i].style.transform = 'rotate(0)';
            }, 500);
            missionOpened[i] = false;
        }
    })
}