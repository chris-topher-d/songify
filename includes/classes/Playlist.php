<?php
  class Playlist {
    private $con;
    private $id;
    private $name;
    private $owner;

    public function __construct($con, $data) {

      if (!is_array($data)) {
        // if data is an id string
        $query = mysqli_query($con, "SELECT * FROM playlists WHERE id='$data'");
        $data = mysqli_fetch_array($query);
      }

      $this->con = $con;
      $this->id = $data['id'];
      $this->name = $data['name'];
      $this->owner = $data['owner'];
    }

    public function getId() {
      return $this->id;
    }

    public function getName() {
      return $this->name;
    }

    public function getOwner() {
      return $this->owner;
    }

    public function getSongCount() {
      $query = mysqli_query($this->con, "SELECT song_id FROM playlist_songs WHERE playlist_id='$this->id'");
      return mysqli_num_rows($query);
    }

    public function getSongIds() {
      $query = mysqli_query($this->con, "SELECT song_id FROM playlist_songs WHERE playlist_id={$this->id} ORDER BY playlist_order ASC");
      $songIds = array();

      while ($row = mysqli_fetch_array($query)) {
        array_push($songIds, $row['song_id']);
      }

      return $songIds;
    }

    public static function getPlaylistDropdown($con, $username) {
      $dropdown = "<select class='item playlist'>
                    <option value=''>Add to playlist</option>";

      $query = mysqli_query($con, "SELECT id, name FROM playlists WHERE owner='$username'");
      while ($row = mysqli_fetch_array($query)) {
        $id = $row['id'];
        $name = $row['name'];
        $dropdown = $dropdown ."<option value={$id}>{$name}</option>";
      }

      return $dropdown . "</select>";
    }
  }
?>