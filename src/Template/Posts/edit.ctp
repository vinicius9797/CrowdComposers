<div class="columns medium-6 content">
	<?= $this->form->create($post) ?>
	<fieldset>
		<legend>Edit Post</legend>
		<?php 
			echo $this->Form->input('title',['type'=>'text','rows'=>'2']);
			echo $this->Form->input('body', ['type'=>'textarea','rows'=>'4']);
		 ?>
	</fieldset>
	<?= $this->Form->button(__('Edit Post')); ?>
	<?= $this->Form->end(); ?>
</div>