let filtersTitle = document.querySelector('.filtersTitle');
let filters = document.querySelector('.filters');
let filtersBox = document.querySelector('.filtersBox');
let chevronDownFilters = document.querySelector('.chevronDownFilters');
let filtersOpened = false;

filtersTitle.addEventListener('click', () => {
    if (!filtersOpened) {
        filtersBox.style.width = 'calc(100% - 140px)';
        setTimeout(() => {
            filters.style.height = '350px';
            chevronDownFilters.style.transform = 'rotate(-180deg)';
        }, 500);
        filtersOpened = true;
    } else {
        filters.style.height = 0;
        setTimeout(() => {
            filtersBox.style.width = '150px';           
            chevronDownFilters.style.transform = 'rotate(0)';
        }, 500);
        filtersOpened = false;
    }
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