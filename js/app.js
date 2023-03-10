  /**
     * Codons un chat en HTML/CSS/Javascript avec nos amis PHP et MySQL
     */

    /**
     * Il nous faut une fonction pour récupérer le JSON des
     * messages et les afficher correctement
     */
     function getMessages(){
      // 1. Elle doit créer une requête AJAX pour se connecter au serveur, et notamment au fichier handler.php
      const requeteAjax = new XMLHttpRequest();
      requeteAjax.open("GET", "server/handler.php");

      // 2. Quand elle reçoit les données, il faut qu'elle les traite (en exploitant le JSON) et il faut qu'elle affiche ces données au format HTML
      requeteAjax.onload = function(){
        const resultat = JSON.parse(requeteAjax.responseText);
        const html = resultat.reverse().map(function(message){
          
            
            
          return `<div class="card p-3 mt-2">
              <div class="d-flex justify-content-between align-items-center">
                  <div class="user d-flex flex-row align-items-center"> <img src="Avatar_masculin_3.png" width="30" class="user-img rounded-circle mr-2"> <span><small class="font-weight-bold text-primary">${message.author}</small> <small class="font-weight-bold">${message.created_at.substring(11, 16)} </small></span> </div> <small> ${message.content} </small>
              </div>
            </div>
          `
        }).join('');
        const messages = document.querySelector('.messages');

        messages.innerHTML = html;
        messages.scrollTop = messages.scrollHeight;
      }

      // 3. On envoie la requête
      requeteAjax.send();
    }

    /**
     * Il nous faut une fonction pour envoyer le nouveau
     * message au serveur et rafraichir les messages
     */

    function postMessage(event){
      // 1. Elle doit stoper le submit du formulaire
      event.preventDefault();

      // 2. Elle doit récupérer les données du formulaire
      const author = document.querySelector('#author');
      const content = document.querySelector('#content');

      // 3. Elle doit conditionner les données
      const data = new FormData();
      data.append('author', author.value);
      data.append('content', content.value);

      // 4. Elle doit configurer une requête ajax en POST et envoyer les données
      const requeteAjax = new XMLHttpRequest();
      requeteAjax.open('POST', 'server/handler.php?task=write');
      
      requeteAjax.onload = function(){
        content.value = '';
        content.focus();
        getMessages();
      }

      requeteAjax.send(data);

      requeteAjax.onload = function () {
        const result = requeteAjax.responseText;
        const M = document.querySelector('#result');

        M.innerHTML += result;
      }
    }

    document.querySelector('form').addEventListener('submit', postMessage);

    /**
     * Il nous faut une intervale qui demande le rafraichissement
     * des messages toutes les 3 secondes et qui donne 
     * l'illusion du temps réel.
     */
    const interval = window.setInterval(getMessages, 3000);

    getMessages();