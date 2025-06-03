<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matchup extends Model {
    use HasFactory;
    protected $fillable = [
        'tournament_id', 'round_number', 'match_in_round',
        'team1_id', 'team2_id', 'winner_id',
        'team1_score', 'team2_score', 'status', 'scheduled_time'
    ];

    public function tournament() { return $this->belongsTo(Tournament::class); }
    public function team1() { return $this->belongsTo(Team::class, 'team1_id'); }
    public function team2() { return $this->belongsTo(Team::class, 'team2_id'); }
    public function winner() { return $this->belongsTo(Team::class, 'winner_id'); }
}
