<h1>Posts</h1>

<div class="posts index">
	<table class="table table-hover table-bordered">
		<thead>
			<tr>
				<th><?= $this->Paginator->sort('id') ?></th>
				<th><?= $this->Paginator->sort('title') ?></th>
				<th><?= $this->Paginator->sort('created') ?></th>
				<th><?= $this->Paginator->sort('modified') ?></th>
				<th><?= __("Actions"); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($posts as $post): ?>
				<tr>
					<td><?= $post->id ?></td>
					<td><?= $this->Html->link($post->title, ['controller'=>'Posts', 'action'=> 'view', $post->id]); ?></td>
					<td><?= $post->created ?></td>
					<td><?= $post->modified ?></td>
					<td>
						<?= $this->Html->link(__('Edit'), ['action'=>'edit', $post->id], ['class'=>'btn btn-default glyphicon glyphicon-pencil']); ?>
						|
						<?= $this->Form->postLink(__("Delete"), ['action'=>'delete', $post->id], ['confirm'=>__("Delete this post?"), 'class'=>'btn btn-default glyphicon glyphicon-trash']);?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>

	</table>
</div>

<div class="paginator">
	<ul class="pagination">
		<?php 
			echo $this->Paginator->prev('< Previous');
			echo $this->Paginator->numbers();
			echo $this->Paginator->next('Next >');

		 ?>
	</ul>
</div>