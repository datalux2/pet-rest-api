$(document).ready(function() {
    $('#add-tag-button').click(function() {
		var tags_length = $('#list-tags input[type="text"]').length;
		
		tags_length++;
		$(this).before('<div class="row"><div class="col-10">' + 
			'<strong>Nazwa tagu ' + tags_length.toString() + 
			':</strong><input type="text" name="tag_names[]" class="form-control mb-3" value=""/></div>' + 
			'<div class="col-2 d-flex align-items-end pb-3">' + 
			'<input type="button" class="del-tag-button" value="Usuń tag"/></div></div>');
		del_tag_button_event_click();
	});
	
	del_tag_button_event_click();
	
	$('.del-pet-link').click(function() {
		var answer = confirm('Czy usunąć dany element PET z zasobu REST API');
		var id = $(this).attr('id');
		const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
		
		if(answer)
		{
			$.ajax({
		  		url: '/api/pet/delete',
			  	method: 'POST',
		  		headers: {
			    	'X-CSRF-TOKEN': token
			  	},
			  	data: {id: id},
			  	success: function(response) {
			   		window.location.reload();
			  	},
			  	error: function(err) {
					console.error('Błąd:', err);
			  	}
			});
		}
	});
	
	$('#show-list-by-status').on('click', function() {
        const status = $('#status').val().trim();

        if (status !== '')
		{
            // Zakoduj status do URI
            const encodedStatus = encodeURIComponent(status);
            window.location.href = '/list-by-status/' + encodedStatus;
        }
		else
		{
            alert('Wpisz status.');
        }
    });
});

function del_tag_button_event_click()
{
	$('.del-tag-button').click(function() {
		$(this).closest('.row').remove();
		$('#list-tags .row').each(function(index, elem) {
			$(elem).find('div').eq(0).find('strong').eq(0).text('Nazwa tagu ' + (index + 1)  + ':');
		});
	});
}
