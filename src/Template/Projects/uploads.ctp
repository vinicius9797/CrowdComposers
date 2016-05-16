<div class="content-1">
	<div class="content-2">
		<h1>Uploads</h1>
		<div class="content-2">
			<table class="table table-hover table-bordered">
				<?php foreach ($projects as $project): ?>
				<div class="content-2">
					<h3 class="upload"><?= $project->musicname ?> </h3><h4 class="upload">Uploader: <?=$project->uploader?></h4><br>
					<?= $this->Html->media($project->id.$project->title, $options = ['pathPrefix'=>'webroot/tracks/', 'controls'=>'true']); ?>
					<?= $this->Html->label($this->Html->link('Download', ['controller'=>'Projects', 'action'=>'downloads', $project->id]), 'success'); ?>
				</div>
				<?php endforeach; ?>
			</table>
		</div>
		<div class="content-2 text-center">
			<ul class="pagination">
				<?php 
				echo $this->Paginator->numbers();
				?>
			</ul>
		</div>
	</div>
</div>