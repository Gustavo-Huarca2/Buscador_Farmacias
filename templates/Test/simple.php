<!-- templates/Tests/simple.php -->
<h2>Simple AJAX</h2>
<label for="edit">Show me:</label>
<input type="text" id="edit" value="!pirt dnuor">
<button id="button" data-rel="<?= $this->Url->build(['_ext' => 'json']) ?>">Reverse text</button>
<div id="result-container" style="font-size: 200%;"></div>

<script src="//code.jquery.com/jquery-3.5.0.min.js"></script>
<script>
$(function() {
	$('#button').click(function() {
    $('#result-container').html('Pending...');
		var targeturl = $(this).data('rel');
    var data = 'csrfToken=<?= $csrfToken ?>&edit=' + $('#edit').val();
    console.log(data);
		$.ajax({
			type: 'get',
			url: targeturl,
			data: data,
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response) {
				if (response.result) {
					var result = response.result;
          if (result.csrfToken !== '<?= $csrfToken ?>') //Admittedly if a hacker got this far
            $('#result-container').html('Invalid CSRF Token, try refreshing the page'); // he has his data in result.edit anyway
          else
            $('#result-container').html(result.edit);
				}
			},
			error: function(e) {
				alert("An error occurred: " + e.responseText.message);
				console.log(e);
			}
		});
	});

});
</script>