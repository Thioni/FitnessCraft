
const editionMode = () => {

  let append = document.getElementsByClassName('append')

  for (i = 0; i < append.length; i++) {
    if (append[i].classList.contains('d-none')) {
        append[i].classList.remove('d-none');
    } else {
        append[i].classList.add('d-none');
    }
  }
};

const activeEntities = () => {
  
  let active = document.getElementsByClassName('active')
  
  for (i = 0; i < active.length; i++) {
    if (active[i].classList.contains('d-none')) {
        active[i].classList.remove('d-none');
    } else {
        active[i].classList.add('d-none');
    }
  }
};

const inactiveEntities = () => {
  
  let inactive = document.getElementsByClassName('inactive')
  
  for (i = 0; i < inactive.length; i++) {
    if (inactive[i].classList.contains('d-none')) {
        inactive[i].classList.remove('d-none');
    } else {
        inactive[i].classList.add('d-none');
    }
  }
};

let hover = document.getElementById('toggleEdition')
hover.addEventListener('click', editionMode);

let activeButton = document.getElementById('toggleActiveEntities');
activeButton.addEventListener('click', activeEntities);

let inactiveButton = document.getElementById('toggleInactiveEntities');
inactiveButton.addEventListener('click', inactiveEntities);