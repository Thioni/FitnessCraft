let submitButton = document.getElementById('submitForm');
let storeIt = document.getElementById('features_list_structure').value;

function resetChoice() {
  document.getElementById('features_list_structure').value = storeIt;
}

submitButton.addEventListener('mouseenter', resetChoice);