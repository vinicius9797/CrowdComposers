    <script src="audiojs/audio.min.js"></script>
    <script>
      audiojs.events.ready(function() {
        audiojs.createAll();
      });
    </script>
<div class="content-1">
	<div class="content-2">
		<h1>Uploads</h1>
		<div class="content-2">
			<table class="table table-hover table-bordered">
					<?php foreach ($projects as $project): ?>
						<div class="content-2"><h3 class="upload"><?= $project->musicname ?></h3><br><?= $this->Html->media($project->id.$project->title, $options = ['pathPrefix'=>'webroot/tracks/', 'controls'=>'true']); ?> <?= $this->Html->link('Download', ['controller'=>'Projects', 'action'=>'downloads', $project->id]); ?></div>
						
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

<script>
// interface to download soundfont, then execute callback;
// MIDI.loadPlugin(onsuccess);
// // simple example to get started;
// MIDI.loadPlugin({
//     instrument: "acoustic_grand_piano", // or the instrument code 1 (aka the default)
//     instruments: [ "acoustic_grand_piano", "acoustic_guitar_nylon" ], // or multiple instruments
//     onsuccess: function() {
// $("audio").currentTime = integer; // time we are at now within the song.
// $("audio").endTime = integer; // time when song ends.
// $("audio").playing = boolean; // are we playing? yes or no.
// $("audio").loadFile(file, onsuccess); // load .MIDI from base64 or binary XML request.
// $("audio").start(); // start the MIDI track (you can put this in the loadFile callback)
// $("audio").resume(); // resume the MIDI track from pause.
// $("audio").pause(); // pause the MIDI track.
// $("audio").stop(); // stops all audio being played, and resets currentTime to 0.
//      }
// });


</script>