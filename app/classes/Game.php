<?php

    class Game {

        private $id;
        private $title;
        private $developer;
        private $publisher;
        private $genre;
        private $platform;
        private $release_date;
        private $rating;
        private $image;

        public function __construct($id, $title, $developer, $publisher, $genre, $platform, $release_date, $rating, $image) {
            $this->id = $id;
            $this->title = $title;
            $this->developer = $developer;
            $this->publisher = $publisher;
            $this->genre = $genre;
            $this->platform = $platform;
            $this->release_year = $release_date;
            $this->rating = $rating;
            $this->image = $image;
        }

        public function getId() {
            return $this->id;
        }

        public function getTitle() {
            return $this->title;
        }

        public function getDeveloper() {    
            return $this->developer;
        }

        public function getPublisher() {
            return $this->publisher;
        }

        public function getGenre() {
            return $this->genre;
        }

        public function getPlatform() {
            return $this->platform;
        }

        public function getRelease_date() {
            return $this->release_date;
        }

        public function getRating() {
            return $this->rating;
        }

        public function getImage() {
            return $this->image;
        }


    }