  // Bouton de retour en haut de page

const scrollUp = () => {
  location.href = "#navbar"
};

let returnToTheTop = document.getElementById('toTheTop');
returnToTheTop.addEventListener('click', scrollUp);

// let deleteModal = document.querySelector(.{{ structure.id }}).href=`{{ path('delete_structure', {'id': structure.${this.dataset.id}}) }}`