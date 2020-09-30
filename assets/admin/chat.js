$(document).ready(function(){
	const chatbox = $('.chatBox');
	const closeChat = $('.chatBox .close');
	const form = $('.chatBox form');
	const btnSend = $('.chatBox .button');
	$(closeChat).click(function(){
		$(chatbox).fadeOut();
		$(form).validate().resetForm();
	});
	$('.flyChat').click(function(){
		$(chatbox).fadeToggle('slow');
	});
	
	$(form).validate({
		rules: {
			nama: {
				required: true
			},
			email:{
				required:true,
				email:true
			},
			pesan:{
				required:true
			}
		},
		messages: {
			nama: {
				required: 'Nama tidak boleh kosong...'
			},
			email: {
				required: 'Email tidak boleh kosong...',
				email: 'Format email tidak valid!'
			},
			pesan: {
				required: 'Pesan tidak boleh kosong...'
			}
		},
		submitHandler: function(form)
		{
			$.ajax({
				url: form.action,
				method: form.method,
				dataType: 'text',
				data: $(form).serialize(),
				beforeSend: function(){
					btnSend.attr('disabled', 'true');
					btnSend.text('Mengirim Pesan...');
				},
				success: function(response)
				{
					if( response == 1 )
					{
						form.reset();
						btnSend.removeAttr('disabled');
						btnSend.text('Kirim');
						const showInfo = $('.chatBox .info').text('Terima Kasih, Pesan anda berhasil dikirim...');
						setTimeout(function () {
							showInfo.text('');
					    }, 5000);
						// ues.fadeOut(5000);
					}
				}
			});
		},
	});
});