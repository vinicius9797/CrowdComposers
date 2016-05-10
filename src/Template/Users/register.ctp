<div class="content-1">
	<div class="content-2">
		<?= $this->Form->create($user) ?>
		<fieldset>
			<legend><?= __('Cadastrar') ?></legend>
			<?= $this->Form->input('username', [
			'label'=>'Usuário']) ?>
			<?= $this->Form->input('password', [
			'label'=>'Senha']) ?>
			</fieldset>
			<?= $this->Form->button(__('Submit')); ?>
			<?= $this->Form->end() ?>
	</div>
</div>