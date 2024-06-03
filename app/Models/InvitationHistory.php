<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvitationHistory extends Model
{
    use HasFactory;
    protected $table = 'invitation_history';
    protected $fillable = [
      'user_id',
      'parrain_id',
      'points',
    ];

    public function user(): BelongsTo
    {
      return $this->belongsTo(User::class, 'user_id');
    }
    public function parrain(): BelongsTo
    {
      return $this->belongsTo(User::class, 'parrain_id');
    }
}
