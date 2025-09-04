<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class MenuItem extends Model {
    use HasFactory, HasRecursiveRelationships;

    protected $guarded = [];


    /**
     * Get the menu_item of the menu.
     */
    public function menu() {
        return $this->belongsTo(Menu::class);
    }
}
