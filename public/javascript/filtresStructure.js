const activeStructures = () => {
  
  let active = document.getElementsByClassName('active')
  
  for (i = 0; i < active.length; i++) {
    if (active[i].classList.contains('d-none')) {
        active[i].classList.remove('d-none');
    } else {
        active[i].classList.add('d-none');
    }
}
};


const inactiveStructures = () => {
  
  let inactive = document.getElementsByClassName('inactive')
  
  for (i = 0; i < inactive.length; i++) {
    if (inactive[i].classList.contains('d-none')) {
        inactive[i].classList.remove('d-none');
    } else {
        inactive[i].classList.add('d-none');
    }
}
};


let activeButton = document.getElementById('toggleActiveStructures');
activeButton.addEventListener('click', activeStructures);

let inactiveButton = document.getElementById('toggleInactiveStructures');
inactiveButton.addEventListener('click', inactiveStructures);