<div class="content-1">
	<div class="content-2">
		<?= $this->Flash->render('auth') ?>
		<?= $this->Form->create() ?>
		<fieldset>
			<legend><?= __('Por favor informe seu usuário e senha') ?></legend>
			<?= $this->Form->input('username') ?>
			<?= $this->Form->input('password') ?>
		</fieldset>
		<?= $this->Form->button(__('Login')); ?>
		<?= $this->Form->end() ?>
	</div>
</div>