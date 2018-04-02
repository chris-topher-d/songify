<?php

  $songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
  $songIdArray = array();

  while ($row = mysqli_fetch_array($songQuery)) {
    array_push($songIdArray, $row['id']);
  }

  $jsonArray = json_encode($songIdArray);

?>

<script>
  $(document).ready(function() {
    let newPlaylist = <?php echo $jsonArray; ?>;
    audioElement = new Audio();
    setTrack(newPlaylist[0], newPlaylist, false);
    updateVolumeBar(audioElement.audio);

    $('.controls-footer').on('mousedown touchstart mousemove touchmove', function(e) {
      e.preventDefault();
    });

    // playback progress bar control
    $('.playback-bar .progress-bar').mousedown(function() {
      mouseDown = true;
    });

    $('.playback-bar .progress-bar').mousemove(function(e) {
      if (mouseDown === true) {
        // sets time of song, depending on position of mouse
        timeFromOffset(e, this);
      }
    });

    $('.playback-bar .progress-bar').mouseup(function(e) {
      timeFromOffset(e, this);
    });

    // volume bar control
    $('.volume-bar .progress-bar').mousedown(function() {
      mouseDown = true;
    });

    $('.volume-bar .progress-bar').mousemove(function(e) {
      if (mouseDown === true) {
        let percentage = e.offsetX / $(this).width();
        if (percentage >= 0 && percentage <= 1) {
          audioElement.audio.volume = percentage;
        }
      }
    });

    $('.volume-bar .progress-bar').mouseup(function(e) {
      let percentage = e.offsetX / $(this).width();
      if (percentage >= 0 && percentage <= 1) {
        audioElement.audio.volume = percentage;
      }
    });

    $(document).mouseup(function() {
        mouseDown = false;
    });
  });

  // calculates how much playback and volume bar should progress on mouse events
  function timeFromOffset(mouse, progressBar) {
    let percentage = (mouse.offsetX / $(progressBar).width()) * 100;
    let seconds = audioElement.audio.duration * (percentage / 100);
    audioElement.setTime(seconds);
  }

  function previousSong() {
    if (audioElement.audio.currentTime >= 3 || currentIndex === 0) {
      audioElement.setTime(0);
    } else {
      currentIndex--;
      setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
    }
  }

  function nextSong() {
    if (repeat === true) {
      audioElement.setTime(0);
      playSong();
      return;
    }

    if (currentIndex === currentPlaylist.length - 1) {
      currentIndex = 0;
    } else {
      console.log(currentIndex);
      currentIndex++;
      console.log(currentIndex);
    }

    let trackToPlay = shuffle ? shuffledPlaylist[currentIndex] : currentPlaylist[currentIndex];
    /* console.log(currentPlaylist);
    console.log(currentIndex);
    console.log(currentPlaylist[currentIndex]); */
    setTrack(trackToPlay, currentPlaylist, true);
  }

  function setRepeat() {
    repeat = !repeat;
    if (repeat === true) {
      $('.fa-redo-alt').attr('color', 'orange');
    } else {
      $('.fa-redo-alt').attr('color', '#909090');
    }
  }

  function setMute() {
    audioElement.audio.muted = !audioElement.audio.muted;
    if (audioElement.audio.muted) {
      $('.fa-volume-up').hide();
      $('.fa-volume-off').show();
    } else {
      $('.fa-volume-off').hide();
      $('.fa-volume-up').show();
    }
  }

  function setShuffle() {
    shuffle = !shuffle;
    if (shuffle === true) {
      $('.fa-random').attr('color', 'orange');
    } else {
      $('.fa-random').attr('color', '#909090');
    }

    if (shuffle) {
      // randomize playlist
      shufflePlaylist(shuffledPlaylist);
      currentIndex = shuffledPlaylist.indexOf(audioElement.currentlyPlaying.id);
    } else {
      // shuffle has been turned off; return to regular playlist
      currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
    }
  }

  // creates a randomly rearranged array
  function shufflePlaylist(array) {
    for (let i = array.length; i; i--) {
      let j = Math.floor(Math.random() * i);
      [array[i - 1], array[j]] = [array[j], array[i - 1]];
    }
  }

  function setTrack(trackId, newPlaylist, play) {
    if (newPlaylist != currentPlaylist) {
      currentPlaylist = newPlaylist;
      shuffledPlaylist = currentPlaylist.slice();
      shufflePlaylist(shuffledPlaylist);
    }

    if (shuffle) {
      currentIndex = shuffledPlaylist.indexOf(trackId);
    } else {
      currentIndex = currentPlaylist.indexOf(trackId);
    }

    pauseSong();

    // retrieves track information from songs table
    $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {
      let track = JSON.parse(data);
      $('.track').text(track.title);

      // retrieves artist information from artists table
      $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {
        let artist = JSON.parse(data);
        $('.artist').text(artist.name);
        $('.artist').attr("onClick", "openPage('artist.php?id=" + artist.id + "')");
      });

      // retrieves album information from albums table
      $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
        let album = JSON.parse(data);
        $('.album-cover').attr('src', album.artwork);
        $('.album-cover').attr("onClick", "openPage('album.php?id=" + album.id + "')");
        $('.track').attr("onClick", "openPage('album.php?id=" + album.id + "')");
      });

      audioElement.setTrack(track);

      if (play) playSong();
    });
  }

  function playSong() {
    // if a song is playing from the beginning, update play count in songs table
    if (audioElement.audio.currentTime === 0) {
      $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
    }

    $('.fa-play-circle').hide();
    $('.fa-pause-circle').show();
    audioElement.play();
  }

  function pauseSong() {
    $('.fa-pause-circle').hide();
    $('.fa-play-circle').show();
    audioElement.pause();
  }
</script>

<div class="controls-footer">
  <div class="controller-bar">
    <div class="now-playing">
      <div class="content">
        <span class="album">
          <img src="" alt="album cover" class="album-cover" role="link" tabindex="0">
        </span>
        <div class="track-info">
          <span class="track" role="link" tabindex="0"></span>
          <span class="artist" role="link" tabindex="0"></span>
        </div>
      </div>
    </div>
    <div class="center-controls">
      <div class="content controls">
        <div class="buttons">
          <i class="fas fa-step-backward" title="backward" onClick="previousSong()"></i>
          <i class="far fa-play-circle" title="play" onClick="playSong()"></i>
          <i class="fas fa-pause-circle" title="pause" style="display: none" onClick="pauseSong()"></i>
          <i class="fas fa-step-forward" title="forward" onClick="nextSong()"></i>
          <i class="fas fa-random" title="shuffle" onClick="setShuffle()"></i>
          <i class="fas fa-redo-alt" title="repeat" onClick="setRepeat()"></i>
        </div>
        <div class="playback-bar">
          <span class="progress-time current">0.00</span>
          <div class="progress-bar">
            <div class="progress-bar-bg">
              <div class="progress"></div>
            </div>
          </div>
          <span class="progress-time remaining">0.00</span>
        </div>
      </div>
    </div>
    <div class="volume-control">
      <div class="volume-bar">
        <i class="fas fa-volume-up" title="volume" onClick="setMute()"></i>
        <i class="fas fa-volume-off" title="volume muted" style="display: none" onClick="setMute()"></i>
        <div class="progress-bar">
          <div class="progress-bar-bg">
            <div class="progress"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
