
var playWebTracks = function(filename) {
	tracks.push({
                "track": 3,
                "name": filename,
                "length": "",
                "file": filename
            });

	playTrack(tracks.length-1);
}

var pusher  = new Pusher(pusher_key);
var channel = pusher.subscribe(pusher_channel);

channel.bind(pusher_event, function(data) {
	playWebTracks(data.song);
});