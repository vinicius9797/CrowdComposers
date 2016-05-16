<?php $this->start('nav-bar-blue'); ?>
<div id="custom-navbar" class="navbar navbar-default " role="navigation">
	<div class="container-fluid">
		<div class="navbar-header"><a class="navbar-brand" href="http://localhost:8080/projects">CrowdComposers</a>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse navbar-menubuilder">
			<ul class="nav navbar-nav navbar-custom navbar-left">
				<?php if(!isset($isLogged)) : ?>
				<li><a href="/projects"><?= $this->Html->icon('home');?> Página Inicial</a></li>
				<li><a href="/projects/uploads"><?= $this->Html->icon('search');?> Uploads</a></li>
				<?php else : ?>
				<li><a href="/projects"><?= $this->Html->icon('home');?> Página Inicial</a></li>
				<li><a href="/projects/add"><?= $this->Html->icon('upload');?> Adicionar</a></li>
				<li><a href="/projects/uploads"><?= $this->Html->icon('search');?> Uploads</a></li>
				<li><a href="/projects/midiplayer"><?= $this->Html->icon('music');?> MIDI Player</a></li>
				<?php endif; ?>
			</ul>
			<ul class="nav navbar-nav navbar-custom navbar-right">
				<?php if(!isset($isLogged)) : ?>
				<li><a href="/users/login">Login</a></li>
				<li><a href="/users/register">Register</a></li>
				<?php else : ?>
				<li class="active"><a href="#">Welcome, <?= $isLogged?></a></li>
				<li><a href="/users/logout">Logout</a></li>
				<?php endif; ?>
			</ul>

		</div>
	</div>
</div>
<?php $this->end(); ?>