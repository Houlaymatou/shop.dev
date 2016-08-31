$('.delete').click(function(){
	var elem = $(this);//copie de la balise a
   var id = elem.attr('id');//récupèration de l'id

//console.log(id);
//requête ajax
$.ajax({
	type:"POST",
	url:'/admin/categories/' + id + '/delete',
	success: function(){
		//succès retire lélement tr du Dom 
		elem.parent().parent().remove();
		//affiche un message de succès
		$('#message')
		.html("<em>Suppression réussie</em>")
		.animate({opacity: 0.3}, 5000,
		function(){
			$('#message').html("");
		});//fais disparaitre le message au bout de 5s
	}
});

});