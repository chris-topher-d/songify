<?php

  class Song {
    private $con;
    private $id;
    private $mysqli_data;
    private $title;
    private $artistId;
    private $albumId;
    private $genre;
    private $duration;
    private $path;

    public function __construct($con, $id) {
      $this->con = $con;
      $this->id = $id;

      $songQuery = mysqli_query($this->con, "SELECT * FROM songs WHERE id={$this->id}");
      $this->mysqli_data = mysqli_fetch_array($songQuery);

      $this->title = $this->mysqli_data['title'];
      $this->artistId = $this->mysqli_data['artist'];
      $this->albumId = $this->mysqli_data['album'];
      $this->genre = $this->mysqli_data['genre'];
      $this->duration = $this->mysqli_data['duration'];
      $this->path = $this->mysqli_data['path'];
    }

    public function getMysqliData() {
      return $this->mysqli_data;
    }

    public function getTitle() {
      return $this->title;
    }

    public function getId() {
      return $this->id;
    }

    public function getArtist() {
      return new Artist($this->con, $this->artistId);
    }

    public function getAlbum() {
      return new Album($this->con, $this->albumId);
    }

    public function getAlbumId() {
      return $this->albumId;
    }

    public function getGenre() {
      return $this->genre;
    }

    public function getDuration() {
      return $this->duration;
    }

    public function getPath() {
      return $this->path;
    }
  }

?>
