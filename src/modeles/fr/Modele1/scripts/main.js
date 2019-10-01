/**
 * Exécute les scripts lorsque le DOM est prêt pour l'exécution de code Javascript
 */
jQuery(document).ready(function($) {
  // Activation du mode strict ECMAScript
  "use strict";
  // Gestion des grilles pour les éléments en bloc de saytup
  gridManager();
  // Gestion des champs de formulaires de type Date
  datePickerManager()
});

/**
 * Associe une librairie javascript au champ de type date pour améliorer l'expérience utilisateur
 * 
 * @note    La librairie flatpickr est automatiquement injectée dans le fichier
 * @return  void
 */
function datePickerManager() {
  $('input[type="date"]').flatpickr({
    dateFormat: "d/m/Y"
  });
}

/**
 * Détermine les grilles pour les éléments en bloc de saytup
 * @return void
 */
function gridManager() {
  // Le type de grille de départ
  var startGrid = 2;
  // Le type de grille de fin
  var endGrid = 13;
  // Parcourt l'ensemble des grilles possibles
  for (startGrid; startGrid < endGrid; startGrid++) {
    // Grille pour les écrans intermédiaires
    var smallGrid = Math.floor(startGrid/2);
    // Le type de grille est appliqué à l'élément parent des blocs
    $('.size1_'+startGrid).parent().addClass('grid-'+startGrid+'-small-'+smallGrid+' has-gutter');
  }
}

/**
 * Gère le bouton burger du menu
 * @return void
 */
(function() {

  // old browser or not ?
  if ( !('querySelector' in document && 'addEventListener' in window) ) {
    return;
  }
  window.document.documentElement.className += ' js-enabled';

  function toggleNav() {
    // Define targets by their class or id
    var button = document.querySelector('.nav-button');
    var target = document.querySelector('.main-menu');

    // click-touch event
    if ( button ) {
      button.addEventListener('click', function (e) {
        button.classList.toggle('is-active');
        target.classList.toggle('is-opened');
        e.preventDefault();
      }, false );
    }
  } // end toggleNav()

  toggleNav();
}());
