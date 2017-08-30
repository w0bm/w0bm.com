<?php

namespace App;

class UserFavorite extends User implements Playable {
    /// Overwrite Playable methods
    public function baseurl() {
        return 'user/' . $this->username . '/favs';
    }

    public function displayName() {
        return 'Favorites (' . parent::displayName() . ')';
    }
    
    public function videos() {
        return $this->favs();
    }
}