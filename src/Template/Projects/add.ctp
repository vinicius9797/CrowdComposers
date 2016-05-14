<script src="//code.jquery.com/jquery.js"></script>   
<div class="content-1">
	<div class="content-2">
		<div class="columns medium-8 content-2">
			<?= $this->form->create($project, ['enctype'=>'multipart/form-data']) ?>

			<fieldset>
				<legend>Faça o upload da sua faixa!</legend>
				<?php 
				echo $this->Form->input('title', [
					'placeholder'=>'Opcional, caso esteja vazio, o arquivo será salvo com o nome atual.',
					'label'=>'Nome do Arquivo']);
				?>

				<?= $this->Form->input('MAX_FILE_SIZE', ['type'=>'hidden', 'value'=>'‪90000000‬']) ?>

				<?php 
				echo $this->Form->input('audiofile', [
				'type'=>'file',
				 'label'=>'Arquivo',
				 'button-label'=>'Procurar...',
				 'required' => 'true',
				 ]);?>
				<?php echo $this->Html->label('Só são aceitos arquivos nos formatos MP3, WAV e MIDI.', 'info') ; ?>

			</fieldset><br>
			<?= $this->Form->button(__('Upload!')); ?>
			<?= $this->Form->end(); ?><br>

		</div>
	</div>
</div>
