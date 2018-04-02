let currentPlaylist = [];
let shuffledPlaylist = [];
let tempPlaylist = [];
let audioElement;
let mouseDown = false;
let currentIndex = 0;
let repeat = false;
let shuffle = false;
var userLoggedIn;
var timer;

$(document).click(function(click) {
  let target = $(click.target);

  if (!target.hasClass("item") && !target.hasClass("fa-ellipsis-h")) {
    hideOptionsMenu();
  }
});

$(window).scroll(function() {
  hideOptionsMenu();
});

$(document).on("change", "select.playlist", function() {
  let select = $(this);
  let playlistId = select.val();
  let songId = select.prev(".song-id").val();

  $.post("includes/handlers/ajax/addToPlaylist.php", { playlistId: playlistId, songId: songId })
  .done(function(error) {
    if (error !== "") {
      alert(error);
      return;
    }

    hideOptionsMenu();
    select.val("");
  });
})

function openPage(url) {
  // if page is changed before search.php queries
  if (timer !== null) clearTimeout(timer);

  if (url.indexOf("?") === -1) url = url + "?";
  var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
  $('.main-content').load(encodedUrl);
  $('body').scrollTop(0);

  // changes url in address bar when page is changed
  history.pushState(null, null, url);
}

function formatTime(seconds) {
  let time = Math.round(seconds);
  let minutes = Math.floor(time / 60);
  var seconds = time - (minutes * 60);
  let zero = seconds < 10 ? '0' : '';
  return `${minutes}:${zero}${seconds}`;
}

function updateTimeProgress(audio) {
  $('.progress-time.current').text(formatTime(audio.currentTime));
  $('.progress-time.remaining').text(formatTime(audio.duration - audio.currentTime));

  let progress = audio.currentTime / audio.duration * 100;
  $('.playback-bar .progress').css('width', progress + '%');
}

function updateVolumeBar(audio) {
  let progress = audio.volume * 100;
  $('.volume-bar .progress').css('width', progress + '%');
}

function playFirstSong() {
  setTrack(tempPlaylist[0], tempPlaylist, true);
}

function createPlaylist() {
  let playlistName = prompt("Please enter the name of your new playlist");

  if (playlistName !== null) {
    $.post("includes/handlers/ajax/createPlaylist.php", { name: playlistName, username: userLoggedIn }).done(function(error) {
      if (error !== "") {
        alert(error);
        return;
      }
      // refresh yourMusic.php with the new playlist included
      openPage("yourMusic.php");
    });
  }
}

function removeFromPlaylist(button, playlistId) {
  let songId = $(button).prevAll(".song-id").val();

  $.post("includes/handlers/ajax/removeFromPlaylist.php", { playlistId: playlistId, songId: songId }).done(function(error) {
    if (error !== "") {
      alert(error);
      return;
    }
    // refresh playlist.php with the song is removed
    openPage("playlist.php?id=" + playlistId);
  });
}

function deletePlaylist(playlistId) {
  let prompt = confirm("Are you sure you want to delete this playlist?");

  if (prompt) {
    $.post("includes/handlers/ajax/deletePlaylist.php", { playlistId: playlistId }).done(function(error) {
      if (error !== "") {
        alert(error);
        return;
      }
      // refresh yourMusic.php with the new playlist included
      openPage("yourMusic.php");
    });
  }
}

function hideOptionsMenu() {
  let menu = $(".options-menu");

  if (menu.css("display") !== "none") menu.css("display", "none");
}

function showOptionsMenu(button) {
  let songId = $(button).prevAll(".song-id").val(); // finds the id of the song the button belongs to
  let menu = $(".options-menu");
  menu.find(".song-id").val(songId); // sets the options menu song-id value to be that of the button's track id
  let menuWidth = menu.width();
  let scrollTop = $(window).scrollTop(); // distance from top of window (where it's been scrolled to) to top of document
  let elementOffset = $(button).offset().top; // distance from button to top of document
  let top = elementOffset - scrollTop;
  let left = $(button).position().left - menuWidth; // distance from button to left of document minus button width;

  menu.css({ "top": top + "px", "left": left + "px", "display": "inline" })
}

function updateEmail(emailClass) {
  let emailValue = $("." + emailClass).val();

  $.post("includes/handlers/ajax/updateEmail.php", { email: emailValue, username: userLoggedIn })
  .done(function(response) {
    $("." + emailClass).nextAll(".message").text(response);
  });
}

function updatePassword(oldPasswordClass, newPasswordClass, verifiedPasswordClass) {
  let oldPassword = $("." + oldPasswordClass).val();
  let newPassword = $("." + newPasswordClass).val();
  let verifiedPassword = $("." + verifiedPasswordClass).val();

  $.post("includes/handlers/ajax/updatePassword.php",
  { oldPassword: oldPassword, newPassword: newPassword, verifiedPassword: verifiedPassword, username: userLoggedIn })
  .done(function(response) {
    $("." + oldPasswordClass).nextAll(".message").text(response);
  });
}

function logout() {
  $.post("includes/handlers/ajax/logout.php", function() {
    location.reload();
  });
}

function Audio() {

  // currentlyPlaying is referenced when playSong() is called from nowPlayingBar.php
  this.currentlyPlaying;
  this.audio = document.createElement('audio');

  // progresses to next song once current song has ended
  this.audio.addEventListener('ended', function() {
    nextSong();
  });

  this.audio.addEventListener('canplay', function() {
    let duration = formatTime(this.duration);
    $('.progress-time.remaining').text(duration);
  });

  this.audio.addEventListener('timeupdate', function() {
    if (this.duration) {
      updateTimeProgress(this);
    }
  });

  this.audio.addEventListener('volumechange', function() {
    updateVolumeBar(this);
  });

  this.setTrack = function(track) {
    this.currentlyPlaying = track;
    this.audio.src = track.path;
  }

  this.play = function() {
    this.audio.play();
  }

  this.pause = function() {
    this.audio.pause();
  }

  this.setTime = function(seconds) {
    this.audio.currentTime = seconds;
  }

}
