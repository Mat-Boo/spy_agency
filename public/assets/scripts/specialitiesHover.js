let optionAgentList = document.querySelectorAll('.optionAgent');
let specialitiesHoverLists = document.querySelectorAll('.specialitiesHover');

console.dir(optionAgentList);
console.dir(specialitiesHoverLists);

optionAgentList.forEach((optionAgent) => {
    let idAgentHover;
    optionAgent.addEventListener('mouseenter', (e) => {
        specialitiesHoverLists.forEach((specialitiesHover) => {
            if (e.target.id.substring(7) === specialitiesHover.id.substring(18)) {
                specialitiesHover.style.display = 'block';
            }
        })
    })
    optionAgent.addEventListener('mouseleave', (e) => {
        specialitiesHoverLists.forEach((specialitiesHover) => {
            if (e.target.id.substring(7) === specialitiesHover.id.substring(18)) {
                specialitiesHover.style.display = 'none';
            }
        })
    })
})