<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>BSW Radio</title>
    <link rel="stylesheet" type="text/css" href="./assets/plugin/css/style.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/demo.css">
    <script type="text/javascript" src="./assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="./assets/plugin/jquery-jplayer/jquery.jplayer.js"></script>
    <script type="text/javascript" src="./assets/plugin/ttw-music-player-min.js"></script>    
    <script type="text/javascript" src="./assets/js/fancywebsocket.js"></script>
    <script type="text/javascript" src="./assets/js/webrtc.js"></script>

    <?php require_once "./assets/php/config.php"; ?>
    <?php require_once "./assets/php/songList.php"; ?>
    <?php require_once "./assets/php/djupdate.php"; ?>

    <script type="text/javascript">

        // Configs
        var server_name = 'ws://' + location.href + ':9301';
        var pusher_config = { key: '<?= $app_key ?>',  channel: '<?= $app_channel ?>' };
        var dj_ip = '<?= $dj_ip; ?>';
        var myPlaylist = [];

        <?php 
            
        foreach ( $playlist as $key => $value) {

            ?>

            myPlaylist.push({
                mp3:"<?php echo $value['mp3'] ?>",
                oga:'mix/1.ogg',
                title:"<?php echo $value['title'] ?>",
                artist:"<?php echo $value['artist'] ?>",
                rating:4,
                buy:'#',
                price:'1.00',
                duration:'0:30',
                cover:"<?php echo $value['png'] ?>"
            });

            <?php
     
        }

        ?>        

    </script>
    <script src="//js.pusher.com/2.2/pusher.min.js"></script>   
</head>
<body>

    <div id="title">BSW Web Radio</div>
    <script src="./assets/js/script.js"></script>

</body>
</html>