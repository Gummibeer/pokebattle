<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Fenos\Notifynder\Models\NotificationCategory;

class AddNotifications extends Migration
{
    protected $categories = [
        [
            'name' => 'fight.won',
            'text' => 'Du hast den Kampf gegen **{extra.trainer}** ({extra.pokemon}) nach {extra.rounds} Runden gewonnen.',
        ],[
            'name' => 'fight.loss',
            'text' => 'Du hast den Kampf gegen **{extra.trainer}** ({extra.pokemon}) nach {extra.rounds} Runden verloren.',
        ],
    ];

    public function up()
    {
        foreach($this->categories as $category) {
            NotificationCategory::create($category);
        }
    }

    public function down()
    {
    }
}
