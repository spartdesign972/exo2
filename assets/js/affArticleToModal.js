$(function(){

		//modal pass idArt
		$('#myModal').on('show.bs.modal', function (event) {
		  var modal = $(this)
		  // j'efface les element pouvant deja etre dans la fentre
		  modal.find('.thumbnail img').remove()
		  modal.find('.caption').empty()
		  modal.find('.modal-footer a').remove()

		  // on determine qu'elle bouton a ete cliqué
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var key = button.data('idart') // Extract info from data-* attributes
		  
		  // la fonction $.get appel un script php avec la methode GET (ajax) en envoyant des parametres et ecoute le retour sous format json dans mon cas (pour avoir les elements sous forme de tableau)
		  $.get('./inc/articleById.php', {idarticle : key}, function(data){
					  
					  modal.find('.modal-title').text(data.libelle)

					  modal.find('.thumbnail').prepend('<img src="assets/img/imgArticles/'+data.photo_url+'" alt="'+data.photo_url+'">')

					  modal.find('.caption').append('<h3>'+data.libelle+'</h3><p class="desc">'+data.description+'</p><p>Prix HT : <strong>'+data.tarifht+'€</strong></p><p>Prix TTC : <strong>'+data.prixttc+'€</strong></p>')

					  // Je rajoute un btn en passant l'id pour mettre en variable de session si clic
					  modal.find('.modal-footer').append('<a href="?idproduit='+data.id+'" class="btn btn-primary">Ajouter au panier</a>')
					},"json");
		});
	});
