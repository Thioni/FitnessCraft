
const searchResult = document.getElementsByClassName('card').length > 0;

  // Si suite à la recherche aucun élément n'est trouvé
if (searchResult == false) {
    
    // Une nouvelle div est créée
  const resultDiv = document.createElement("div");
  resultDiv.className = "text-center"

    // Un message à y afficher est généré
  const noResultMessage = document.createTextNode("Aucun résultat à votre recherche");

    // On place ce message dans la nouvelle div
  resultDiv.appendChild(noResultMessage);

    // La div est placé à la suite de l'élément marqué par l'id "noResult"
  const messageLocation = document.getElementById("noResult");
  messageLocation.appendChild(resultDiv);

}