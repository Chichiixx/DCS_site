function openTab(evt, tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}
function afficherGraphique(graphiqueId) {
  // Cacher tous les graphiques
  document.querySelectorAll('.graph-container').forEach(function (container) {
    container.style.display = 'none';
  });

  // Afficher le graphique correspondant
  var graphique = document.getElementById(graphiqueId);
  if (graphique) {
    graphique.style.display = 'block';
  }
}