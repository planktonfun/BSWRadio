
var playWebTracks = function(filename, username) {
	tracks.push({
                "track": 3,
                "name": filename + ' - ' + username,
                "length": "",
                "file": filename
            });

	playTrack(tracks.length-1);

	$.get('/api/play/' + filename);
}

var pusher  = new Pusher(pusher_key);
var channel = pusher.subscribe(pusher_channel);

channel.bind(pusher_event, function(data) {
	playWebTracks(data.song, data.username);
});