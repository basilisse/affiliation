<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
      'username',
      'email',
      'password',
      'parrain_id',
      'points',
      'role',
      'niveau',
      'enabled',
      'banned',
      'invitation_code',
      'role',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
      'password',
      'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
  }

  /**
   * Get the parrain that owns the user.
   */
  public function parrain(): BelongsTo
  {
    return $this->belongsTo(User::class, 'parrain_id');
  }

  public function parraines()
  {
    $sql = "WITH RECURSIVE all_descendants AS (
            SELECT
                id AS object_id,
                id AS descendant_id,
                niveau AS descendant_level,
                0 AS generation
            FROM
                users
            UNION ALL
            SELECT
                ad.object_id,
                u.id AS descendant_id,
                u.niveau AS descendant_level,
                ad.generation + 1 AS generation
            FROM
                all_descendants ad
            JOIN
                users u ON ad.descendant_id = u.parrain_id
        )
        SELECT
            descendant_level as niveau,
            COUNT(DISTINCT descendant_id) AS number
        FROM
            all_descendants
        WHERE
            generation > 0 and object_id = :id
        GROUP BY
            descendant_level
        ORDER BY
            descendant_level";
    $liste = DB::select($sql, [
      'id' => $this->id
    ]);
    return array_map(function ($value) {
      return (array)$value;
    }, $liste);
  }
  public function parrainesList()
  {
    $query = "WITH RECURSIVE all_descendants AS (
              -- Base case: each object as its own descendant
              SELECT
                  id AS user_id,
                  id AS descendant_id,
                  niveau,
                  username,
                  created_at
              FROM
                  users
              UNION ALL
              -- Recursive case: find children of the current level of descendants
              SELECT
                  ad.user_id,
                  u.id AS descendant_id,
                  u.niveau,
                  u.username,
                  u.created_at
              FROM
                  all_descendants ad
              JOIN
                  users u ON ad.descendant_id = u.parrain_id
          )
          SELECT
              user_id,
              descendant_id as id,
              niveau,
              username,
              created_at
          FROM
              all_descendants
          WHERE
              niveau > :user_niveau and user_id = :id
          ORDER BY
              user_id,
              niveau,
              id";
    $liste = DB::select($query, [
        'id' => $this->id,
        'user_niveau' => $this->niveau
    ]);
    return array_map(function ($value) {
      return (array)$value;
    }, $liste);
  }
}
