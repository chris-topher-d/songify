<?php

  class Album {
    private $con;
    private $id;
    private $title;
    private $artistId;
    private $genre;
    private $artwork;

    public function __construct($con, $id) {
      $this->con = $con;
      $this->id = $id;

      $albumQuery = mysqli_query($this->con, "SELECT * FROM albums WHERE id={$this->id}");
      $album = mysqli_fetch_array($albumQuery);

      $this->title = $album['title'];
      $this->artistId = $album['artist'];
      $this->genre = $album['genre'];
      $this->artwork = $album['artwork'];
    }

    public function getTitle() {
      return $this->title;
    }

    public function getArtist() {
      return new Artist ($this->con, $this->artistId);
    }

    public function getGenre() {
      return $this->genre;
    }

    public function getArtwork() {
      return $this->artwork;
    }

    public function getTrackCount() {
      $query = mysqli_query($this->con, "SELECT id FROM songs WHERE album={$this->id}");
      return mysqli_num_rows($query);
    }

    public function getSongIds() {
      $query = mysqli_query($this->con, "SELECT id FROM songs WHERE album={$this->id} ORDER BY albumOrder ASC");
      $songIds = array();

      while ($row = mysqli_fetch_array($query)) {
        array_push($songIds, $row['id']);
      }
      
      return $songIds;
    }
  }

?>
