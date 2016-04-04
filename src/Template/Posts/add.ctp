<div class="columns medium-8 content">
	<?= $this->form->create($post) ?>

		<script></script>
		<script>
		function countChar(val){
			$('#title').keyup(function () {
			  var max = 155;
			  var len = $(this).val().length;
			  if (len >= max) {
			    $('#charNum').text(' You have reached the limit.').css({
			    	color: 'red',
			    	fontFamily: 'Georgia',
			    	fontSize: '16px',
			    	margin: '5px',
			    	fontWeight: 'bold'
			    });
			  } else {
			    var char = max - len;
			    $('#charNum').text(char + ' characters left.').css({
			    	color: 'black',
			    	fontFamily: 'Georgia',
			    	fontSize: '16px',
			    	margin: '5px',
			    	fontWeight: 'normal'
			    });
			  }
			});
		}

		function countCharBody(val){
			$('#body').keyup(function () {
			  var max = 2000;
			  var len = $(this).val().length;
			  if (len >= max) {
			    $('#charNumBody').text(' You have reached the limit.').css({
			    	color: 'red',
			    	fontFamily: 'Georgia',
			    	fontSize: '16px',
			    	margin: '5px',
			    	fontWeight: 'bold'
			    });
			  } else {
			    var char = max - len;
			    $('#charNumBody').text(char + ' characters left.').css({
			    	color: 'black',
			    	fontFamily: 'Georgia',
			    	fontSize: '16px',
			    	margin: '5px',
			    	fontWeight: 'normal'
			    });
			  }
			});
		}
		</script>

	<fieldset>
		<legend>Create a new Post</legend>
		<?php 
			echo $this->Form->input('title', ['maxlength'=>'155', 'onkeyup'=>'countChar(this)']);
		?>
		<div id="charNum"></div>

		<?php 
			echo $this->Form->input('body', ['rows' => '10', 'maxlength'=>'2000', 'onkeyup'=>'countCharBody(this)']);
		?>
		<div id="charNumBody"></div>
	</fieldset>
	<?= $this->Form->button(__('Save Post')); ?>
	<?= $this->Form->end(); ?>
</div>