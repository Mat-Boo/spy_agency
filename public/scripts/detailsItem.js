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