<div class="content">
<iframe id="sc-widget" width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F1848538&show_artwork=true"></iframe>
<script src="https://w.soundcloud.com/player/api.js" type="text/javascript"></script>
<script type="text/javascript">
  (function(){
    var widgetIframe = document.getElementById('sc-widget'),
        widget       = SC.Widget(widgetIframe),
        newSoundUrl = 'http://api.soundcloud.com/tracks/339';

    widget.bind(SC.Widget.Events.READY, function() {
      // load new widget
      widget.bind(SC.Widget.Events.FINISH, function() {
        widget.load(newSoundUrl, {
          show_artwork: false
        });
      });
    });

  }());
</script>
</div>